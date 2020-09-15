<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use App\Form\UpdateUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/register", name="user_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user->setRole('ROLE_USER');
            $user->setCreatedAt(new \DateTime('now'));
            $user->setUpdatedAt(new \DateTime('now'));

            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('notice', 'Usuario agregado correctamente');
            $this->addFlash('class', 'success');

            return $this->redirectToRoute('home');

        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'title' => 'Sign in',
            'header' => 'Registrate'
        ]);
    }

    /**
     * @Route("/user/edit/{id}/", name="user_edit")
     */
    public function edit(Request $request, User $user)
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
     */
    public function listAllUsers(Request $request)
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
}
