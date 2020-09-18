<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AntennaController extends AbstractController
{
    /**
     * @Route("/antenna", name="antenna")
     */
    public function index()
    {
        return $this->render('antenna/index.html.twig', [
            'controller_name' => 'AntennaController',
        ]);
    }
}
