<?php

namespace ObservationBundle\Form\Location;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class LocationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('latitude', NumberType::class, array(
                'label' => 'Latitude'
        ))

                ->add('longitude', NumberType::class, array(
                  'label' => 'Longitude'
                ))
        ;


    }
}