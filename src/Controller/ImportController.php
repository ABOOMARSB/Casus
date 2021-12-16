<?php

namespace App\Controller;

use App\Entity\City;
use App\Repository\DealRepository;
use App\Repository\CompanyRepository;
use App\Repository\CityRepository;
use Faker\Factory;
use Faker\Provider\Address;
use MercurySeries\FlashyBundle\FlashyNotifier;
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
    public function index(FlashyNotifier $flashy): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $dealJson = json_decode(file_get_contents(self::API), true);
        $dealdetail = json_decode(file_get_contents(self::API_details), true);
        $faker = Factory::create('nl_NL');

        foreach ($dealJson['deals'] as $index => $data) {
            $description = new Deal($data);
            $companyObject = Company::fromJsonToDB($data, $dealdetail);
            $cityObject = new City($data);
            $detailCompanySlug = $dealdetail['_embedded']['company']['slug'];
            $dealCompanySlug = $dealJson['deals'][$index]['company_slug'];

            $resultDeal = $this
                ->getDoctrine()
                ->getRepository('App:Deal')
                ->findOneBy(['deal_unique' => $data['unique']]);
            $resultCompany = $this
                ->getDoctrine()
                ->getRepository('App:Company')
                ->findOneBy(['name' => $data['company_name']]);
            $resultCity = $this
                ->getDoctrine()
                ->getRepository('App:City')
                ->findOneBy(['name' => $data['city_name']]);

            //Trying section

          #  var_dump(empty($resultDeal and $resultCompany));
//
//
//            $resultDeal2 = $this
//                ->getDoctrine()
//                ->getRepository('App:Deal')
//                ->findBy(['deal_unique' => $data['unique']]);
//            $resultCompany2 = $this
//                ->getDoctrine()
//                ->getRepository('App:Company')
//                ->findBy(['name' => $data['company_name']]);
//           var_dump($resultDeal2 instanceof Deal);
//           var_dump($resultCompany2 instanceof Company);
//
//           echo "<Br />\n";

            //End Trying Section

            if ($resultCompany OR $resultDeal OR $resultCity === NULL) {

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

                $description->setCreatedAt($faker->dateTimeBetween('- 5months'))
                    ->setCompany($companyObject)
                    ->setCity($cityObject);
;

                if ($dealCompanySlug == $detailCompanySlug) {
                    $description->setCompany($companyObject);
                }

                if ($dealdetail['list_unique'] == $data['unique']) {
                    $description->setDescription($dealdetail['description']);
                } else {
                    $description->setDescription($faker->realText(300));
                }
                $flashy->success("Jouw data is toegevoegd!");
                $entityManager->persist($description);
                $entityManager->persist($cityObject);

                $entityManager->flush();
            }
            else {
                $flashy->success("Data bestaat al in de database!");
            }

        }

        return $this->render('import/index.html.twig', [
            'controller_name' => 'ImportController',
        ]);
    }
}
