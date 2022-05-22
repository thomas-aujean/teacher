<?php

namespace App\Form;

use App\Entity\Workshop;
use App\Entity\WorkshopChoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkshopChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('workshops', EntityType::class, [
            'label' => 'Atelier',
            'class' => Workshop::class,
            'multiple' => true,
            'choice_label' => fn (Workshop $workshop) => Workshop::TYPES_NAMES[$workshop->getType()] . ' : du ' . ucfirst($workshop->getStart()->format('d/m/Y')) . ' au ' . mb_strtoupper($workshop->getEnd()->format('d/m/Y')),
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkshopChoice::class,
        ]);
    }
}