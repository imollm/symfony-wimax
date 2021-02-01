<?php

namespace App\Controller;

use App\Entity\Antenna;
use App\Entity\User;
use App\Form\RegisterUserType;
use App\Form\UpdateUserType;
use App\Repository\AntennaRepository;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Throwable;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/register", name="user_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse|Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepo = $this->getDoctrine()->getRepository(User::class);
            $userEmail = $request->request->get('register_user')['email'];
            $userPhone = $request->request->get('register_user')['phone'];
            $emailExists = is_object($userRepo->findOneBy(['email' => $userEmail]));
            $phoneExists = is_object($userRepo->findOneBy(['phone' => $userPhone]));

            // Check if email and phone exists
            if (!$emailExists && !$phoneExists) {
                $user->setRole('ROLE_USER');
                $user->setCreatedAt(new \DateTime('now'));
                $user->setUpdatedAt(new \DateTime('now'));

                $encoded = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($encoded);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('sendEmailRegisteredUser', [
                    'user' => $user->getName() . ' ' . $user->getSurname(),
                    'email' => $user->getEmail(),
                    'phone' => $user->getPhone(),
                    'address' => $user->getAddress()
                ]);
            } else {
                $this->addFlash('danger', 'El usuario ya esta registrado, email o telefono ya registrado');
                return $this->redirectToRoute('home');
            }
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'title' => 'Sign in',
            'header' => 'Registrate'
        ]);
    }

    /**
     * @Route("/user/edit/{id}/", name="user_edit")
     * @param Request $request
     * @param User $user
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, User $user): RedirectResponse
    {
        if (!$this->getUser() || $this->getUser()->getId() != $user->getId()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user->setUpdatedAt(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('notice', 'Cambios actualizados correctamente');
            $this->addFlash('class', 'success');

            return $this->redirectToRoute('user_edit', [
                'id' => $user->getId()
            ]);

        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'title' => 'Edit',
            'header' => 'Edita tus datos'
        ]);
    }

    /**
     * @Route("/users", name="list_users")
     * @param Request $request
     * @return Response
     */
    public function listAllUsers(Request $request): Response
    {
        $role = $request->query->get('role');
        $users = $this->getDoctrine()
                        ->getRepository(User::class)
                        ->findByRole($role);

        return $this->render('user/list.html.twig', [
            'title' => 'Users',
            'header' => 'Listado de usuarios',
            'users' => $users
        ]);
    }

    /**
     * @Route("/getUsers", name="get_users")
     */
    public function getUsers(): JsonResponse
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $json = [];
        foreach ($users as $user)
        {
            $json[] = $user->jsonSerialize();
        }
        return $this->json(json_encode($json));
    }

    /**
     * @Route("/user/{id}/details", name="user_details")
     * @param $id
     * @return Response
     */
    public function details($id): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $connection = $this->getDoctrine()->getConnection();
        $totalPaid = PaymentRepository::getTotalPaidByUserId($connection, $user->getId());

        return $this->render('user/details.html.twig', [
            'title' => 'User Details',
            'header' => 'Detalles del usuario',
            'user' => $user,
            'totalPaid' => $totalPaid
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete")
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     * @throws Throwable
     */
    public function delete(Request $request, User $user): RedirectResponse
    {
        if (!$user) {
            $this->addFlash('notice', 'Error al borrar el usuario');
            $this->addFlash('class', 'danger');
            return $this->redirectToRoute('home');
        }

        // When a ADMIN remove a user, system delete her payments and set NULL antennas he/she have.
        try {
            $connection = $this->getDoctrine()->getConnection();

            PaymentRepository::deleteAllPaymentsByUserId($connection, $user);
            AntennaRepository::setNullUserId($connection, $user);

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        } catch (Throwable $th) {
            throw $th;
        }

        $this->addFlash('notice', 'Usuario borrado correctamente');
        $this->addFlash('class', 'success');

        return $this->redirectToRoute('list_users', [
            'role' => 'ROLE_USER'
        ]);
    }

    /**
     * @Route("/user/{id}/antennas", name="user_have_these_antennas")
     * @param $id
     * @return JsonResponse
     */
    public function myAntennas($id): JsonResponse
    {
        $antennaRepo = $this->getDoctrine()->getRepository(Antenna::class);
        $userRepo = $this->getDoctrine()->getRepository(User::class);

        $user = $userRepo->find($id);
        $antennas = $antennaRepo->findBy(array('user' => $user));

        $jsonAntennas = array();

        foreach ($antennas as $key => $antenna) {
            $jsonAntennas[$key] = array();
            $jsonAntennas[$key]['id'] = $antenna->getId();
            $jsonAntennas[$key]['name'] = $antenna->getName();
        }

        return $this->json(array(
            'antennas' => $jsonAntennas
        ));
    }
}
