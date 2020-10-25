<?php

namespace App\Controller;

use App\Entity\Antenna;
use App\Entity\Payment;
use App\Entity\User;
use App\Repository\AntennaRepository;
use App\Repository\PaymentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payments", name="all_payments")
     */
    public function allPayments()
    {
        $pageData = array(
            'title' => 'Pagos clientes',
            'header' => 'Pagos clientes',
            'years' => '',
            'payments' => ''
        );

        if ($this->getUser()->getRoles()[0] !== 'ROLE_ADMIN') {
            return $this->redirectToRoute('home');
        }

        $connection = $this->getDoctrine()->getConnection();
        $payments = PaymentRepository::getAllPayments($connection);
        $pageData['payments'] = $payments;

        return $this->render('payment/all_payments.html.twig', $pageData);
    }
    /**
     * @Route("/payments/{id}", name="my_payments")
     */
    public function paymentsByUserId($id)
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
        $years = PaymentRepository::findAllYearsOfUser($connection, $userId);
        $pageData['years'] = $years;

        return $this->render('payment/index.html.twig', $pageData);
    }

    /**
     * @Route("/payment/create", name="create_payment")
     */
    public function create(Request $request)
    {
        return $this->render('payment/create.html.twig', [
            'title' => 'Create payment',
            'header' => 'Crear pago'
        ]);
    }

    /**
     * @Route("/payment/save", name="save_payment")
     */
    public function save(Request $request)
    {
        $payment = new Payment();
        if ($request) {
            // var_dump($request);
            $antennaId = $request->get('antenna');
            $userId = $request->get('user');
            $month = $request->get('month');
            $year = $request->get('year');
            $amount = $request->get('amount');
            $token = $request->get('token');
            // var_dump($antennaId);
            // var_dump($userId);
            // var_dump($month);
            // var_dump($year);
            // var_dump($amount);
            // var_dump($token);
            if($this->isCsrfTokenValid('save-payment', $token)) {
                if (
                    !is_null($antennaId) && 
                    !is_null($userId) && 
                    !is_null($month) && 
                    !is_null($year) && 
                    !is_null($amount)
                ) {
                    $antennaRepo = new AntennaRepository($this->getDoctrine());
                    $antenna = $antennaRepo->findById($antennaId);
                    $payment->setAntenna($antenna);
                    // var_dump($antenna);
                    $userRepo = new UserRepository($this->getDoctrine());
                    $user = $userRepo->findById($userId);
                    $payment->setUser($user);
                    // var_dump($user);die();
                    $payment->setMonth($month);
                    $payment->setYear($year);
                    $payment->setAmount($amount);
                    $payment->setCreatedAt(new \DateTime());
                    $payment->setUpdatedAt(new \DateTime());
                    
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($payment);
                    $em->flush();

                } else {
                    $this->addFlash('danger', 'Error al guardar el pago');
                }
            } else {
                $this->addFlash('danger', 'Error al guardar el pago');
            }
        } else {
            $this->addFlash('danger', 'Error al guardar el pago');
        }
        // die();
        return $this->redirectToRoute('home');
    }
}