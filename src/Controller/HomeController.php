<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
   
    #[Route('/minprice/{minPrice}', name:'app_minPrice')]
    public function booksByMinPrice(BookRepository $bookRepository, float $minPrice): Response
    {
        $books = $bookRepository->findBooksByMinPrice($minPrice);
        return $this->render('home/index.html.twig', [
            'booksminprices'=>$books
        ]);
    }

    #[Route('/recentbook', name:'app_recentbook')]
    public function recentBooks(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findRecentBooks();
        return $this->render('home/index.html.twig', [
            'recentbooks'=>$books
        ]);
    }

    #[Route('/title/{title}', name:'app_bookbyTitle')]
    public function booksByTitle(BookRepository $bookRepository, string $title): Response
    {
        $books = $bookRepository->findBooksByTitle($title);
        return $this->render('home/index.html.twig', [
            'bookbytitles'=>$books
        ]);
    }
}
