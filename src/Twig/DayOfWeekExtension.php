<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class DayOfWeekExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('day', [$this, 'calculateDay']),
        ];
    }

    public function calculateDay($value)
    {
        if ($value == 1) {
            return 'Enero';
        }elseif($value == 2){
            return 'Febrero';
        }elseif($value == 3){
            return 'Marzo';
        }elseif($value == 4){
            return 'Abril';
        }elseif($value == 5){
            return 'Mayo';
        }elseif($value == 6){
            return 'Junio';
        }elseif($value == 7){
            return 'Julio';
        }elseif($value == 8){
            return 'Agosto';
        }elseif($value == 9){
            return 'Septiembre';
        }elseif($value == 10){
            return 'Octubre';
        }elseif($value == 11){
            return 'Noviembre';
        }else{
            return 'Diciembre';
        }
    }
}
