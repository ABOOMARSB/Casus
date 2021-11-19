<?php

namespace App\Controller;

use Knp\Component\Pager\PaginatorInterface;
use App\Repository\DealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DealController extends AbstractController
{
    private const DEALS_AMOUNT_PER_PAGE = 15;

    /**
     * @Route("/", name="deal")
     */
    public function index(DealRepository $dealRepository,PaginatorInterface $paginator, Request $request): Response
    {
//        $deals = (new ImportController())->index();
        $deals = $paginator->paginate(
            $dealRepository->findAll(),
            $request->query->getInt(
                'page', 1
            ),
            self::DEALS_AMOUNT_PER_PAGE
            );

        return $this->render
        (
            'deal/index.html.twig', ['deals' => $deals]
        );

    }
}
/*Control if exist do nothing if not insert*/
