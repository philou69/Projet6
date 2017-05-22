<?php

namespace ObservationBundle\Form\Location;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                ->add('latitude', NumberType::class, array(
                    'label' => 'Latitude',
                    'label_attr' => array('class' => 'hidden'),
                    'attr' => array('class' => 'hidden',
                                    'required' => false)
                ))

                ->add('longitude', NumberType::class, array(
                  'label' => 'Longitude',
                  'label_attr' => array('class' => 'hidden'),
                  'attr' => array('class' => 'hidden',
                                  'required' => false)
                ))
                ->add('lieu', TextType::class, array(
                  'label' => 'Lieu de l\'observation'
                ))
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Location'
        ));
    }
}