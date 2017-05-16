<?php

namespace ObservationBundle\Form\Bird;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class BirdType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {



        $builder
           ->add('nomVern', ChoiceType::class, array(
               'choices' => array(
                   'Test 1' => 'test',
                   'test 2' => 'test',
                   'test3' => 'test'),
               'label' => 'Nom de l\'espèce observée'

           ))
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Bird'
        ));
    }
}