<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrollBuyController extends AbstractController
{
    /**
     * @Route("/buy", name="buy")
     */
    public function index(): Response
    {
        return $this->render('buy/index.html.twig', [
            'controller_name' => 'TrollBuyController',
        ]);
    }
}
