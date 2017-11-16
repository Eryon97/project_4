<?php

namespace P4\BilletBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class BilletType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class)
        ->add('prenom', TextType::class)
        ->add('pays', CountryType::class, array(
            'placeholder' => 'Choisir un pays',
        ))
        ->add('naissance', DateType::class, array(
            'label' => 'Date de naissance',
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
        ))
        ->add('tarif', CheckBoxType::class, array(
            'required' => false,
            'label' => 'Tarif réduit, un justificatif peut vous être demandé à l\'entrée du Musée (étudiant, employé du musée, d’un service du Ministère de la Culture, militaire…)',
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'P4\BilletBundle\Entity\Billets'
        ));
    }
}
