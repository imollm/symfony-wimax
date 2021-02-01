<?php

namespace App\Controller;

use App\Entity\Antenna;
use App\Entity\Payment;
use App\Entity\User;
use App\Repository\AntennaRepository;
use App\Repository\PaymentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payments/{id}", defaults={"id" = null}, name="list_payments")
     * @param Request $request
     * @return Response
     */
    public function list(Request $request): Response
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

        if ($role == 'ROLE_ADMIN' && $request->get('id') !== NULL) {
            $userId = $request->get('id');
        }elseif ($role == 'ROLE_ADMIN' && $request->get('id') == NULL) {
            $userId = NULL;
        }

        $filters = array(
            'role' => $role,
            'userId' => $userId,
            'year' => NULL,
            'user' => NULL
        );

        if ($request) {
            $filters['year'] = ($request->get('year') !== 'Choose...') ? $request->get('year') : NULL;
            $filters['user'] = ($request->get('user_id') !== 'Choose...') ? $request->get('user_id') : NULL;
        }

        $connection = $this->getDoctrine()->getConnection();

        if ($role == 'ROLE_ADMIN') {
            if ($request->get('id') !== NULL) {
                $userRepo = new UserRepository($this->getDoctrine());
                $user = $userRepo->findById($request->get('id'));
                $pageData['header'] = 'Pagos de ' . $user->getName() . ' ' . $user->getSurname();
            }else {
                $pageData['header'] = 'Pagos clientes';
            }
            $pageData['users'] = PaymentRepository::findUsers($connection);
            
        } elseif ($role == 'ROLE_USER') {
            $pageData['header'] = 'Mis pagos';
        }

        $pageData['title'] = 'Listado pagos';
        $pageData['years'] = PaymentRepository::findYears($connection, $role, $userId);
        $pageData['payments'] = PaymentRepository::getPayments($connection, $filters);

        return $this->render('payment/list.html.twig', $pageData);
    }

    /**
     * @Route("/payment/create", name="create_payment")
     * @return Response
     */
    public function create(): Response
    {
        return $this->render('payment/create.html.twig', [
            'title' => 'Create payment',
            'header' => 'Crear pago'
        ]);
    }

    /**
     * @Route("/payment/save", name="save_payment")
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Request $request): RedirectResponse
    {
        $payment = new Payment();
        if ($request) {
            $antennaId = $request->get('antenna');
            $userId = $request->get('user_id');
            $month = $request->get('month');
            $year = $request->get('year');
            $amount = $request->get('amount');
            $token = $request->get('token');
            if ($this->isCsrfTokenValid('save-payment', $token))
            {
                if (
                    !is_null($antennaId) &&
                    !is_null($userId) &&
                    !is_null($month) &&
                    !is_null($year) &&
                    !is_null($amount)
                ) {
                    if (! PaymentRepository::isAlreadyPaid($userId, $antennaId, $month, $year, $this->getDoctrine()->getConnection()))
                    {
                        $antennaRepo = new AntennaRepository($this->getDoctrine());
                        $antenna = $antennaRepo->findById($antennaId);
                        $payment->setAntenna($antenna);

                        $userRepo = new UserRepository($this->getDoctrine());
                        $user = $userRepo->findById($userId);
                        $payment->setUser($user);
                        $payment->setMonth($month);
                        $payment->setYear($year);
                        $payment->setAmount($amount);
                        $payment->setCreatedAt(new \DateTime());
                        $payment->setUpdatedAt(new \DateTime());

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($payment);
                        $em->flush();

                        return $this->redirectToRoute('sendEmailPayment', [
                            'user' => $user->getName() . ' ' . $user->getSurname(),
                            'email' => $user->getEmail(),
                            'paymentMonth' => $payment->getMonth(),
                            'paymentYear' => $payment->getYear(),
                            'paymentAmount' => $payment->getAmount()
                        ]);

                    } else {
                     $this->addFlash('warning', 'Cuidado, el pago ya existe');
                    }
                } else {
                    $this->addFlash('danger', 'Error al guardar el pago, error params');
                }
            } else {
                $this->addFlash('danger', 'Error al guardar el pago, error form token');
            }
        } else {
            $this->addFlash('danger', 'Error al guardar el pago, error request');
        }
        return $this->redirectToRoute('home');
    }
}
