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
        ->add('nombre', IntegerType::class, array(
            'attr' => array('min' => 1, 'max' => 25)
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