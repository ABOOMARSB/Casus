<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\DealRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DealController extends AbstractController
{
    private const DEALS_PER_PAGE = 25;

    /**
     * @Route("/", name="deal")
     */
    public function index(DealRepository $dealRepository, CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $deals = $paginator->paginate(
            $dealRepository->findAll()->getDealsSortedByCity(),
            $request->query->getInt(
                'page', 1
            ),
            self::DEALS_PER_PAGE
            );

        $categories = $categoryRepository->findAll();

        return $this->render
        (
            'deal/index.html.twig', [
                'deals' => $deals,
                'categories' => $categories,
            ],
        );

    }
}