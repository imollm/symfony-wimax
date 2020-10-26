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
     * @Route("/payments/{id}", defaults={"id" = null}, name="list_payments")
     */
    public function list(Request $request)
    {   
        $pageData = array(
            'title' => '',
            'header' => '',
            'years' => '',
            'users' => '',
            'payments' => ''
        );

        $role = $this->getUser()->getRoles()[0];
        $userId = $this->getUser()->getId();

        $filters = array(
            'role' => $role,
            'userId' => $userId,
            'year' => NULL,
            'user' => NULL
        );

        if ($request) {
            $filters['year'] = 
                ($request->get('year') !== 'Choose...') ? 
                    $request->get('year') : NULL;
            $filters['user'] = 
                ($request->get('user_id') !== 'Choose...') ? 
                    $request->get('user_id') : NULL;
        }

        $connection = $this->getDoctrine()->getConnection();

        if ($role == 'ROLE_ADMIN') {
            $pageData['title'] = 'Listado pagos';
            $pageData['header'] = 'Pagos clientes';
            $pageData['users'] = PaymentRepository::findUsers($connection);
            
        } elseif ($role == 'ROLE_USER') {
            $pageData['title'] = 'Listado pagos';
            $pageData['header'] = 'Mis pagos';
        }

        $pageData['years'] = PaymentRepository::findYears($connection, $role, $userId);
        $pageData['payments'] = PaymentRepository::getPayments($connection, $filters);

        return $this->render('payment/list.html.twig', $pageData);
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
            if ($this->isCsrfTokenValid('save-payment', $token)) {
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
