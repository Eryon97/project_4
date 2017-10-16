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
use Symfony\Component\OptionsResolver\OptionsResolver;



class FormulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('date', TextType::class)
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
        ->add('billets', CollectionType::class, array(
            'entry_type' => BilletType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'label_attr' => array('class' => 'totalBillets'),
        ))
        ->add('save', SubmitType::class, array(
            'label' => 'Paiement'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data-class' => 'P4\BilletBundle\Entity\Formulaire'
        ));
    }
}