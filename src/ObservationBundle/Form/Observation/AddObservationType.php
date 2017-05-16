<?php

namespace ObservationBundle\Form\Observation;

use ObservationBundle\Form\Bird\BirdType;
use ObservationBundle\Form\Location\LocationType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddObservationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('observation', TextareaType::class, array(

            'label' => 'Description libre',
            'attr' => array('rows' => '5')
        ))
            ->add( 'seeAt', DateTimeType::class, array(
                'label' => 'Date de l\'observation: ',
                'widget' => 'single_text',
                'date_format' => 'yyyy-MM-dd  HH:i'
            ))
            ->add('location', LocationType::class, array(
                'label' => false
            ))
            ->add('bird', BirdType::class, array(
                'label' => false
            ))
            ->add( 'save', SubmitType::class, array(
                'label' => 'Valider la saisie',
                'attr' => array(
                    'class' => 'btn btn-success'
                )
            ))



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Observation'
        ));
    }
}