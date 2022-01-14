<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrollBuyController extends AbstractController
{
    /**
     * @Route("/troll/buy", name="troll_buy")
     */
    public function index(): Response
    {
        return $this->render('troll_buy/index.html.twig', [
            'controller_name' => 'TrollBuyController',
        ]);
    }
}
