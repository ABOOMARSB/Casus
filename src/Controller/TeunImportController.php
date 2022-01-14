<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\City;
use App\Repository\CategoryRepository;
use App\Repository\CityRepository;
use App\Repository\CompanyRepository;
use App\Repository\DealRepository;
use Faker\Factory;
use Faker\Provider\Address;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Deal;
use App\Entity\Company;

class TeunImportController extends Command
{
    protected static $defaultName = 'app:cron:import';
    private const API = "https://media.socialdeal.nl/demo/deals.json";
    private const API_details = "https://media.socialdeal.nl/demo/details.json";

    public function __construct(CompanyRepository $companies, CategoryRepository $categories, CityRepository $cities, DealRepository $deals)
    {
        $this->companies = $companies;
        $this->categories = $categories;
        $this->cities = $cities;
        $this->deals = $deals;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        /* Start Category Import To DB */
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
            $dbCategory = $this->categories->findOneBy(['sort' => $category->getSort()]);
            if (!$dbCategory) {
                $this->categories->add($category);
            }
        }
        /* End Category Import To DB */

        $dealJson = json_decode(file_get_contents(self::API), true);
        $dealdetail = json_decode(file_get_contents(self::API_details), true);
        $faker = Factory::create('nl_NL');
        $companyArray = [];

        foreach ($dealJson['deals'] as $index => $data) {
            // start van import data $unique.
            $company = $this->companies->findOneBy(['name' => $data['company_name']]);
            $city = $this->cities->findOneBy(['name' => $data['city_name']]);
            $deal = $this->deals->findOneBy(['deal_unique' => $data['unique']]);
            $category = $this->categories->findOneBy(['sort' => $data['category']]);


            if ($category === null) {
                $output->writeln(sprintf('Could not find category %d for deal %s', $data['category'], $data['unique']));
                continue;
            }

            /* Start Company Import To DB */
            if (!isset($company)) {

                $companyF = Company::fromJsonToDB($data, $dealdetail);

                $detailCompanySlug = $dealdetail['_embedded']['company']['slug'];
                $dealCompanySlug = $dealJson['deals'][$index]['company_slug'];

                if ($dealCompanySlug === $detailCompanySlug) {
                    $companyF->setCheckCompanySlug($detailCompanySlug);
                } else {
                    $companyF->setCheckCompanySlug($faker->slug);
                }

                if ($detailCompanySlug === $dealCompanySlug) {
                    $companyF->setStreet($dealdetail['_embedded']['company']['locations'][0]['street'])
                        ->setZip($dealdetail['_embedded']['company']['locations'][0]['zip'])
                        ->setWebsite($dealdetail['_embedded']['company']['website']);
                } else {
                    $companyF->setStreet($faker->streetName)
                        ->setZip(Address::postcode())
                        ->setWebsite($faker->url);
                }
                $companyF->setNumber($faker->phoneNumber);

                $this->companies->add($companyF);
                $companyArray[$data['company_name']] = $companyF;
            }
            /* End Company Import To DB */

            /* Start City Import To DB */

            $detailCompanySlug = $dealdetail['_embedded']['company']['slug'];
            $dealCompanySlug = $dealJson['deals'][$index]['company_slug'];

            if (!array_key_exists($data['company_name'], $companyArray)) {
                $companyObject = $company;
            } else {
                $companyObject = $companyArray[$data['company_name']];
            }

            if (!isset($city)) {
                $newCity = new City($data);
                $this->cities->add($newCity);

                $city = $newCity;
            }
            $resultCity = $city;
            /* End City Import To DB */

            /* Start Deal Import To DB */
            $newDeal = new Deal($data);
            if (!isset($deal)) {
                $newDeal->setCompany($companyObject);
                $newDeal->setCity($resultCity);
                $newDeal->setCategory($category);

                $newDeal->setCreatedAt($faker->dateTimeBetween('- 5months'));

                if ($dealCompanySlug == $detailCompanySlug) {
                    $newDeal->setCompany($companyObject);
                }

                if ($dealdetail['list_unique'] == $data['unique']) {
                    $newDeal->setDescription($dealdetail['description']);
                } else {
                    $newDeal->setDescription($faker->realText(300));
                }

                $this->deals->add($newDeal);

            }
            /* End Deal Import To DB */
        }

        $dea = $this->deals->findAll();
        foreach ($dea as $key => $dea1) {
            $output->writeln(sprintf("%d -> %s ", $key, $dea1->gettitle()));
        }
        return 0;
    }
}
