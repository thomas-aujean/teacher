<?php

namespace App\Form;

use App\Entity\Workshop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class WorkshopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('name')
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    "Little Ones" => Workshop::TYPE_LITTLE,
                    "Cycle 2" => Workshop::TYPE_CYCLE2,
                    "Cycle 3" => Workshop::TYPE_CYCLE3,
                    "Middle School" => Workshop::TYPE_MIDDLE,
                    "Spoken English" => Workshop::TYPE_SPOKEN,
                ]
            ])
            ->add('start')
            ->add('end')
            ->add('maximum', NumberType::class, [
                'data' => 10,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workshop::class,
        ]);
    }
}