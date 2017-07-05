<?php

namespace ObservationBundle\Form\Type\Observation;

use ObservationBundle\Form\Type\Location\LocationType;
use ObservationBundle\Form\Type\Picture\PictureType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class AddObservationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
            ->add('observation', TextareaType::class, array(

            'label' => 'Description libre',
            'attr' => array('rows' => '5'),
            'required' => false
        ))
            ->add( 'seeAt', DateTimeType::class, array(
                'label' => 'Date de l\'observation: ',
                'widget' => 'single_text',
                'format' => 'dd-MM-yyy',
                'attr' => array('class' => 'dateObs'),
                'with_minutes' => false
            ))
            ->add('location', LocationType::class, array(
                'label' => false
            ))
            ->add('bird', EntityType::class, array(
                'class' => 'ObservationBundle:Bird',
                'choice_label' => 'getAName',
                'label' => 'Nom de l\'espèce observée',
                'placeholder' => 'Choisissez ou saisisez le nom d\'un oiseau'
            ))
            ->add('quantity', IntegerType::class, array(
                'label' => 'Nombre de Spécimens observés',
                'attr' => array('min' => 1,
                                'max' => 20,
                                'value' => 1)
            ))
            ->add('files', FileType::class, array(
                    'label' => 'Importer une image',
                    'multiple' => true,
                    'required' => false,
                    'mapped' => false,
                    'attr' => [
                        'accept' => 'image/*;capture=camera',
                        'class' => 'filestyle',
                        'data-input' => 'false',
                        'data-badge' => 'false',
                        'data-icon' => 'false',
                        'data-buttonText' => 'Choisir Photo',
                    ],
                    'data_class' => null
                )
            )
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
