<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\User;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payments/{id}", name="my_payments")
     */
    public function index($id)
    {
        $userId = $id;
        $pageData = array(
            'title' => '',
            'header' => '',
            'years' => '',
            'payments' => ''
        );

        $userRepo = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepo->find($userId);

        if ($this->getUser()->getRole() == 'ROLE_USER') {
            $pageData['title'] = 'Mis Pagos';
            $pageData['header'] = 'Detalle de mis pagos';
        } elseif ($this->getUser()->getRole() == 'ROLE_ADMIN') {
            $pageData['title'] = 'Detalle pagos';
            $pageData['header'] = 'Pagos de ' . $user->getName() . ' ' . $user->getSurname();
        }

        $pageData['payments'] = $user->getPayments();

        $connection = $this->getDoctrine()->getConnection();
        $years = PaymentRepository::findAllYearsOfUser($userId, $connection);
        $pageData['years'] = $years;

        return $this->render('payment/index.html.twig', $pageData);
    }
}
