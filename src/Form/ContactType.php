<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du parent',
                'row_attr' => [
                    'class' => 'col'
                ],
            
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom du parent',
                'row_attr' => [
                    'class' => 'col'
                ],
            
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email du parent',
                'row_attr' => [
                    'class' => 'col'
                ],
            
            ])
            ->add('phone', TextType::class, [
                'label' => 'Numéro de téléphone',
                'row_attr' => [
                    'class' => 'col'
                ],
            
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'row_attr' => [
                    'class' => 'col'
                ],
            
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Code postal',
                'row_attr' => [
                    'class' => 'col'
                ],
            ])    
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'row_attr' => [
                    'class' => 'col'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}