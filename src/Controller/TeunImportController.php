<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\City;
use App\Repository\CompanyRepository;
use Faker\Factory;
use Faker\Provider\Address;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Deal;
use App\Entity\Company;

class ImportController extends Command
{
    protected static $defaultName = 'app:cron:import';
    private const API = "https://media.socialdeal.nl/demo/deals.json";
    private const API_details = "https://media.socialdeal.nl/demo/details.json";

    public function __construct(CompanyRepository $companies)
    {
        $this->companies = $companies;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dealJson = json_decode(file_get_contents(self::API), true);
        $dealdetail = json_decode(file_get_contents(self::API_details), true);
        $faker = Factory::create('nl_NL');
        $companies = [];

        foreach ($dealJson['deals'] as $index => $data) {
            $company = $this->companies->findOneBy(['name' => $data['company_name']]);

            if ($company !== null) {
                continue;
            }

            $company = Company::fromJsonToDB($data, $dealdetail);
            $this->companies->add($company);
        }


        $companies = $this->companies->findAll();
        foreach ($companies as $company) {
            $output->writeln($company->getName());
        }

        return 0;
        $entityManager = $this->getDoctrine()->getManager();
        $dealJson = json_decode(file_get_contents(self::API), true);
        $dealdetail = json_decode(file_get_contents(self::API_details), true);
        $faker = Factory::create('nl_NL');
        $companies = [];

        foreach ($dealJson['deals'] as $index => $data) {
            $resultCompany = $this
                ->getDoctrine()
                ->getRepository('App:Company')
                ->findOneBy(['name' => $data['company_name']]);

            if ($resultCompany !== null) {
                continue;
            }

            $companyObject = Company::fromJsonToDB($data, $dealdetail);
            $detailCompanySlug = $dealdetail['_embedded']['company']['slug'];
            $dealCompanySlug = $dealJson['deals'][$index]['company_slug'];

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
            $companyObject->setNumber($faker->phoneNumber);

            $entityManager->persist($companyObject);
            $entityManager->flush();

            $companies[$data['company_name']] = $companyObject;
        }

        foreach ($dealJson['deals'] as $index => $data) {
            $description = new Deal($data);
            $cityObject = new City($data);

            $detailCompanySlug = $dealdetail['_embedded']['company']['slug'];
            $dealCompanySlug = $dealJson['deals'][$index]['company_slug'];

            $resultDeal = $this
                ->getDoctrine()
                ->getRepository('App:Deal')
                ->findOneBy(['deal_unique' => $data['unique']]);

            if (!array_key_exists($data['company_name'], $companies)) {
                $companyObject = $this
                    ->getDoctrine()
                    ->getRepository('App:Company')
                    ->findOneBy(['name' => $data['company_name']]);
            } else {
                $companyObject = $companies[$data['company_name']];
            }

            $resultCity = $this
                ->getDoctrine()
                ->getRepository('App:City')
                ->findOneBy(['name' => $data['city_name']]);

            if ($resultCity === NULL) {
                $entityManager->persist($cityObject);

                $entityManager->flush();

                $resultCity = $cityObject;
            }

            $resultCategory = $this
                ->getDoctrine()
                ->getRepository('App:Category')
                ->findOneBy(['sort' => $data['category']]);

//            if ($resultCategory !== null) {
//                continue;
//            }

            if ($resultCategory === NULL) {

                $categories = [];
                $categories[] = new Category('Populair', 0, 'grade');
                $categories[] = new Category('Eten & Drinken', 7, 'restaurant');
                $categories[] = new Category('Uitjes', 9, 'confirmation_number');
                $categories[] = new Category('Overnachten', 6, 'hotel');
                $categories[] = new Category('Wellness & Beauty', 8, 'spa',);
                $categories[] = new Category("Speciaalzaken & Auto's", 11, 'store');
                $categories[] = new Category('Sport', 12, 'pool');
                $categories[] = new Category('Cursussen & Workshops', 14, 'local_library');

                foreach ($categories as $category) {
                    $entityManager->persist($category);
                    $entityManager->flush();
                }
            }

            if ($resultDeal === null) {
                $description->setCategory($resultCategory);
                $description->setCity($resultCity);

                $description->setCreatedAt($faker->dateTimeBetween('- 5months'));
                $description->setCompany($companyObject);

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
                $entityManager->flush();
            } else {
                $flashy->success("Data bestaat al in de database!");
            }

        }

        return $this->render('import/index.html.twig', [
            'controller_name' => 'ImportController',
        ]);
    }
}
