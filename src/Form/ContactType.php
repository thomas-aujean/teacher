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
                    'class' => 'fv-row mb-5'
                ],
                'label_attr' => [
                    'class' => 'fw-bold fs-5'
                ],
                'attr' => [
                    'value' => '',
                    'class' => 'form-control form-control-lg form-control-solid form-field'
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom du parent',
                'row_attr' => [
                    'class' => 'fv-row mb-5'
                ],
                'label_attr' => [
                    'class' => 'fw-bold fs-5'
                ],
                'attr' => [
                    'value' => '',
                    'class' => 'form-control form-control-lg form-control-solid form-field'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email du parent',
                'row_attr' => [
                    'class' => 'fv-row mb-5'
                ],
                'label_attr' => [
                    'class' => 'fw-bold fs-5'
                ],
                'attr' => [
                    'value' => '',
                    'class' => 'form-control form-control-lg form-control-solid form-field'
                ]
                ]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
