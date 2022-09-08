<?php

namespace App\Form;

use App\Entity\Workshop;
use App\Entity\Inscription;
use App\Entity\WorkshopChoice;
use Doctrine\Inflector\Rules\Word;
use App\Repository\WorkshopRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\WorkshopChoiceRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'enfant",
                'row_attr' => [
                    'class' => 'col'
                ],

            ])
            ->add('firstName', TextType::class, [
                'label' => "Prénom de l'enfant",
                'row_attr' => [
                    'class' => 'col'
                ],

            ])
            ->add('age')
            // ->add('level')
            // ->add('twoWeeks')


            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'mapped' => false,
                'choices' => [
                    "Little Ones" => Workshop::TYPE_LITTLE,
                    "Cycle 2" => Workshop::TYPE_CYCLE2,
                    "Cycle 3" => Workshop::TYPE_CYCLE3,
//                    "Middle School" => Workshop::TYPE_MIDDLE,
                    "Spoken English" => Workshop::TYPE_SPOKEN,
                    "Adults" => Workshop::TYPE_ADULTS,
                    "Excursions" => Workshop::TYPE_EXCURSION,
                ]
            ])
//            ->add('weeks', ChoiceType::class, [
//                'label' => 'Durée',
//                'mapped' => false,
//                'required' => true,
//                'empty_data' => null,
//                'choices' => [
//                    // "Merci de choisir une date" => null,
//                    "1 semaine" => 1,
//                    "2 semaines" => 2,
//                ]
//            ])

            ->add('workshopChoice', EntityType::class, [
                'label' => 'Atelier',
                'class' => WorkshopChoice::class,
                'choice_label' => function (WorkshopChoice $workshopChoice) {
                    if (count($workshopChoice->getWorkshops()) > 1) {
                        return 'Deux semaines - ' . Workshop::TYPES_NAMES[($workshopChoice->getFirstWorkshop()->getType())];
                    } else {
                        return Workshop::TYPES_NAMES[($workshopChoice->getFirstWorkshop()->getType())] . ' - Du ' . $workshopChoice->getFirstWorkshop()->getStart()->format('d/m/Y') . ' au ' . $workshopChoice->getFirstWorkshop()->getEnd()->format('d/m/Y');
                    }
                },
                'query_builder' => function (WorkshopChoiceRepository $repository) use ($options) {
                    $repository->findOrdered();
                },

            ])
            ->add('contact', ContactType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}