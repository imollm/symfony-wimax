<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailController extends AbstractController
{
    private static string $name = 'Ivan Moll Moll';
    private static string $from = 'ivanmoll07@gmail.com';
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/email/payment", name="sendEmailPayment")
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendEmailPayment(Request $request): RedirectResponse
    {
        if ($request)
        {
            $subject = 'Pago realizado';

            $data = [
                'subject' => $subject,
                'user' => $request->get('user'),
                'userEmail' => $request->get('email'),
                'paymentMonth' => $request->get('paymentMonth'),
                'paymentYear' => $request->get('paymentYear'),
                'paymentAmount' => $request->get('paymentAmount'),
                'today' => new \DateTime('now'),
                'template' => 'email/payment.html.twig'
            ];

            $this->send($data);

            $this->addFlash('success', 'Pago guardado correctamente');
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/email/registeredUser", name="sendEmailRegisteredUser")
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendEmailRegisteredUser(Request $request): RedirectResponse
    {
        if($request)
        {
            $subject = 'Usuario registrado';

            $data = [
                'subject' => $subject,
                'user' => $request->get('user'),
                'userEmail' => $request->get('email'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
                'template' => 'email/user_registration.html.twig'
            ];

            $this->send($data);

            $this->addFlash('success', 'Usuario agregado correctamente');

            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route ("/email/payment/template", name="emailPaymentTemplate")
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function sendTemplate(): Response
    {
        $email = (new TemplatedEmail())
            ->from(self::$from)
            ->to(new Address(self::$from))
            ->subject('Wimax Template Test')

            // path of the Twig template to render
            ->htmlTemplate('email/index.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'date' => new \DateTime('now'),
                'username' => 'foo',
            ]);

        $this->mailer->send($email);

        return new Response('Email was send!!');
    }

    private function send(array $data): void
    {
        $emailToSend = (new TemplatedEmail())
            ->from(Address::fromString(sprintf('%s <%s>', self::$name, self::$from)))
            ->to(Address::fromString(sprintf('%s <%s>', $data['user'], $data['userEmail'])))
            ->subject($data['subject'])
            ->htmlTemplate($data['template'])
            ->context($data);

        $this->mailer->send($emailToSend);

        $this->sendACopy($data);
    }

    private function sendACopy(array $data): void
    {
        $emailCopy = (new TemplatedEmail())
            ->from(Address::fromString(sprintf('%s <%s>', self::$name, self::$from)))
            ->to(Address::fromString(sprintf('%s <%s>', self::$name, self::$from)))
            ->subject($data['subject'])
            ->htmlTemplate($data['template'])
            ->context($data);

        $this->mailer->send($emailCopy);
    }
}
