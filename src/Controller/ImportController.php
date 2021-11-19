<?php

namespace App\Controller;

use App\Repository\DealRepository;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Deal;

class ImportController extends AbstractController
    {
        private const API = "http://media.socialdeal.nl/demo/deals.json";
        private const API_details = "http://media.socialdeal.nl/demo/details.json";


        /** 
         * @Route("/import", name="import")
         */
        public function index(DealRepository $dealRepository): Response
        {
            $entityManager = $this->getDoctrine()->getManager();
            $dealJson = json_decode(file_get_contents(self::API), true);
            $faker = Factory::create('nl_NL');


            foreach ($dealJson['deals'] as $deal)
            {
                $dealdetail = json_decode(file_get_contents(self::API_details), true);
                $description = new Deal($deal);
                $d = '';
                $description->setCreatedAt($faker->dateTimeBetween('- 5months'));

//                if($doctrine->getRepository('App\Entity\Deal')->findBy(array('unique' => $this->$deal->getDealUnique())))
//                {
                    if ($dealdetail['list_unique'] == $deal['unique'])
                    {
                        $description->setDescription($dealdetail['description']);
                    }
                    else
                    {
                        $description->setDescription($faker->realText(300, 2));
                    }

                $entityManager->persist($description);
            }


            $entityManager->flush();

            return $this->render('import/index.html.twig', [
                'controller_name' => 'ImportController',
            ]);
        }
    }
