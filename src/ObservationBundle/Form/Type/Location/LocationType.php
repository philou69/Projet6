<?php

namespace ObservationBundle\Form\Type\Location;

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
                                    'required' => true)
                ))

                ->add('longitude', NumberType::class, array(
                  'label' => 'Longitude',
                  'label_attr' => array('class' => 'hidden'),
                  'attr' => array('class' => 'hidden',
                                  'required' => true)
                ))
                ->add('lieu', TextType::class, array(
                  'label' => 'Lieu de l\'observation',
                    'required' => true
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
