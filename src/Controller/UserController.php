<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
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
     * @Route("/user/register", name="app_register")
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

            return $this->redirectToRoute('home');

        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
            'title' => 'Sign in',
            'header' => 'Registrate'
        ]);
    }
}
