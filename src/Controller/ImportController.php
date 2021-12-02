<?php

namespace App\Controller;

use App\Repository\DealRepository;
use App\Repository\CompanyRepository;
use App\Repository\CityRepository;
use Faker\Factory;
use Faker\Provider\Address;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Deal;
use App\Entity\Company;

class ImportController extends AbstractController
    {
        private const API = "https://media.socialdeal.nl/demo/deals.json";
        private const API_details = "https://media.socialdeal.nl/demo/details.json";

        /** 
         * @Route("/import", name="import")
         */
        public function index(DealRepository $dealRepository, CompanyRepository $companyRepository, CityRepository $cityRepository): Response
        {
            $entityManager = $this->getDoctrine()->getManager();
            $dealJson = json_decode(file_get_contents(self::API), true);
            $dealdetail = json_decode(file_get_contents(self::API_details), true);
            $faker = Factory::create('nl_NL');



            foreach ($dealJson['deals'] as $index=>$data) {
                $companyObject = Company::fromJsonToDB($data, $dealdetail);
                $detailCompanySlug = $dealdetail['_embedded']['company']['slug'];
                $dealCompanySlug = $dealJson['deals'][$index]['company_slug'];

                $resultDeal = $this
                    ->getDoctrine()
                    ->getRepository('App:Deal')
                    ->findBy(['deal_unique' => $data['unique']]);
//                $resultCompany = $this
//                    ->getDoctrine()
//                    ->getRepository('App:Company')
//                    ->find(['name']);

                if (empty($resultDeal)) {

//                    if ($resultCompany) {

                        if ($dealCompanySlug === $detailCompanySlug) {
                            $companyObject->setCheckCompanySlug($detailCompanySlug);
                        } else {
                            $companyObject->setCheckCompanySlug($faker->slug);
                        }

                        if ($detailCompanySlug === $dealCompanySlug) {
                            $companyObject->setStreet($dealdetail['_embedded']['company']['locations'][0]['street'])
                                ->setZip($dealdetail['_embedded']['company']['locations'][0]['zip'])
                                ->setWebsite($dealdetail['_embedded']['company']['website']);
                        } else {
                            $companyObject->setStreet($faker->streetName)
                                ->setZip(Address::postcode())
                                ->setWebsite($faker->url);
                        }

                        $entityManager->persist($companyObject);
                    }
                    $description = new Deal($data);
                    $description->setCreatedAt($faker->dateTimeBetween('- 5months'))
                        ->setCompany($companyObject);

                    if ($dealCompanySlug == $detailCompanySlug) {
                        echo $dealCompanySlug;
                        $description->setCompany($companyObject);
                    }

                    if ($dealdetail['list_unique'] == $data['unique']) {
                        $description->setDescription($dealdetail['description']);
                    } else {
                        $description->setDescription($faker->realText(300));
                    }

                    $entityManager->persist($description);
                }

                //            foreach ($dealJson['deals'] as $deal)
                //            {
                //                $description = new Deal($deal);
                //                $description->setCreatedAt($faker->dateTimeBetween('- 5months'))
                //                            ->setCompany($companyObject);
                ////                if ($dealCompanySlug == $detailCompanySlug)
                ////                {
                ////                    echo $dealCompanySlug;
                //////                    $description->setCompany($companyObject);
                //////                    dd($echo);
                ////
                ////                }
                ////                else {
                ////                    dd("Ya kalb!");
                ////                }
                //
                //
                ////                if($doctrine->getRepository('App\Entity\Deal')->findBy(array('unique' => $this->$deal->getDealUnique())))
                ////                {
                //                if ($dealdetail['list_unique'] == $deal['unique'])
                //                {
                //                    $description->setDescription($dealdetail['description']);
                //                }
                //                else
                //                {
                //                    $description->setDescription($faker->realText(300));
                //                }
                //
                //                $entityManager->persist($description);
//            }
            $entityManager->flush();

            return $this->render('import/index.html.twig', [
                'controller_name' => 'ImportController',
            ]);
        }
    }
