<?php

namespace ObservationBundle\Form\Observation;

use ObservationBundle\Form\Location\LocationType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AddObservationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('observation', TextareaType::class, array(

            'label' => 'Observation',
            'attr' => array('rows' => '5')
        ))

                ->add( 'seeAt', DateTimeType::class, array(
                    'label' => 'Observé le: ',
                    'widget' => 'single_text',
                    'date_format' => 'yyyy-MM-dd  HH:i'
                ))
                ->add('location', LocationType::class, array(
                    'label' => false
                ))
                ->add( 'save', SubmitType::class, array(
                    'label' => 'Enregistrer',
                    'attr' => array(
                        'class' => 'btn btn-success'
                    )
                ))



        ;
    }
}