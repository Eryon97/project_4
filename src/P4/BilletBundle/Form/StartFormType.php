<?php

namespace P4\BilletBundle\Form;

use P4\BilletBundle\Repository\BilletRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;



class StartFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('date', DateType::class, array(
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
        ))
        ->add('nombre', ChoiceType::class, array(
            'choices' => array(
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6,
                '7' => 7,
                '8' => 8,
                '9' => 9,
                '10' => 10,
                '11' => 11,
                '12' => 12,
                '13' => 13,
                '14' => 14,
                '15' => 15,
                '16' => 16,
                '17' => 17,
                '18' => 18,
                '19' => 19,
                '20' => 20,
            )
        ))
        ->add('type', ChoiceType::class, array(
            'choices' => array(
                'Journée' => 'journee',
                'Demi-Journée' => 'demi_journee',
            )
        ))
        ->add('email', EmailType::class)
        ->add('save', SubmitType::class, array(
            'label' => 'Continuer'
        ));
    }
}