<?php

namespace App\Twig;

use App\Entity\Payment;
use phpDocumentor\Reflection\Types\Iterable_;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class GetLastUserPaymentExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('lastPayment', [$this, 'getLastPayment']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('lastPayment', [$this, 'getLastPayment']),
        ];
    }

    public function getLastPayment($payments)
    {   
        $payments->getIterator();
        $newestYear = 0;
        $newestMonth = 0;

        while($payment = $payments->current()){

            if($payment->getYear() > $newestYear){
                
                $newestYear = $payment->getYear();
                $newestMonth = $payment->getMonth();

            }elseif($payment->getYear() == $newestYear){

                if($payment->getMonth() > $newestMonth){

                    $newestYear = $payment->getYear();
                    $newestMonth = $payment->getMonth();

                }
            }
            $payments->next();
        }
        
        return ($newestYear == 0 || $newestMonth == 0) ? '-' : $newestMonth . " / " . $newestYear;

    }
}
