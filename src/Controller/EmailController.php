<?php

namespace App\Controller;

use App\Repository\UserRepository;
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
    private static $name = 'Ivan Moll Moll';
    private static $from = 'ivanmoll07@gmail.com';
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/email/payment", name="sendEmailPayment")
     * @param Request $request
     * @return RedirectResponse
     * @throws TransportExceptionInterface
     */
    public function paymentDoIt(Request $request): RedirectResponse
    {
        if ($request)
        {
            $userName = $request->get('userName');
            $userSurname = $request->get('userSurname');
            $userEmail = $request->get('userEmail');
            $paymentMonth = $request->get('paymentMonth');
            $paymentYear = $request->get('paymentYear');
            $paymentAmount = $request->get('paymentAmount');

            $subject = 'Pago realizado';

            $email = (new TemplatedEmail())
                ->from(Address::fromString(sprintf('%s <%s>', self::$name, self::$from)))
                ->to(Address::fromString(sprintf('%s <%s>', $userName, $userEmail)))
                ->subject($subject)
                ->htmlTemplate('email/payment.html.twig')
                ->context([
                    'userName' => $userName . ' ' . $userSurname,
                    'paymentMonth' => $paymentMonth,
                    'paymentYear' => $paymentYear,
                    'paymentAmount' => $paymentAmount,
                    'today' => new \DateTime('now')
                ]);

            $this->mailer->send($email);

            $this->addFlash('success', 'Pago guardado correctamente');
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route ("/email/payment/template", name="emailPaymentTemplate")
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
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
            ]);

        $this->mailer->send($email);

        return new Response('Email was send!!');
    }
}
