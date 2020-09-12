<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payments", name="my_payments")
     */
    public function index()
    {
        return $this->render('payment/index.html.twig', [
            'title' => 'Payments',
            'header' => 'Mis pagos'
        ]);
    }
}
