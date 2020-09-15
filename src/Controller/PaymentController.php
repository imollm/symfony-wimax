<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payments", name="my_payments")
     */
    public function index()
    {
        $user_id = $this->getUser()->getId();
        $connection = $this->getDoctrine()->getConnection();
        $years = PaymentRepository::findAllYearsOfUser($user_id, $connection);

        return $this->render('payment/index.html.twig', [
            'title' => 'Payments',
            'header' => 'Mis pagos',
            'years' => $years
        ]);
    }
}
