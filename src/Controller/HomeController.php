<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $title = 'Home Page';
    private $header  = 'Welcome to Wimax Manager';

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'title' => $this->title,
            'header' => $this->header
        ]);
    }
}
