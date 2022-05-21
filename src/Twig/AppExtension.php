<?php

// src/Twig/AppExtension.php
namespace App\Twig;

use App\Entity\Customer;
use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('md5', [$this, 'md5'])
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('available', [$this, 'available'])
        ];
    }



    /**
     * @param $number
     * retourne md5 dans une vue
     */
    public function md5($number): string
    {
        return md5($number);
    }

    /**
     * @param $number
     */
    public function available($max, $actual): string
    {
        $number = $max - $actual;
        if ($number < 3){
            return'red'; 
        } else{
            return 'green';
        }
    }


}