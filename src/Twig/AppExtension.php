<?php

// src/Twig/AppExtension.php
namespace App\Twig;

use App\Entity\Customer;
use App\Entity\User;
use App\Entity\WorkshopChoice;
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
            new TwigFunction('available', [$this, 'available']),
            new TwigFunction('displayWorkshop', [$this, 'displayWorkshop']),
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

    public function displayWorkshop(WorkshopChoice $workshopChoice)
    {
        if(count($workshopChoice->getWorkshops()) == 2){
            $str = "";
            foreach($workshopChoice->getWorkshops() as $w){
                $str .=  <<<HTML
                Classe {$w->getType()} <br>
                Du {$w->getStart()->format('d/m/Y')} au {$w->getEnd()->format('d/m/Y')} <br>
           HTML;
            }

            return $str;
            
        } else{
            return <<<HTML
                 Classe {$workshopChoice->getFirstWorkshop()->getType()} <br>
                 Du {$workshopChoice->getFirstWorkshop()->getStart()->format('d/m/Y')} au {$workshopChoice->getFirstWorkshop()->getEnd()->format('d/m/Y')}
            HTML;
            
        }
    }

}