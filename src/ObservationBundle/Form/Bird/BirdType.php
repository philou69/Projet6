<?php

namespace ObservationBundle\Form\Bird;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BirdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bec', TextType::class, array(
                'label' => 'Type de bec',
                'attr' => array(
                    'hidden' => 'true'
                )
            ))
            ->add('plumage', TextType::class, array(
                'label' => 'Type de plumage',
                'attr' => array(
                    'hidden' => 'true'
                )
            ))
            ->add('couleur', TextType::class, array(
                'label' => 'Couleur',
                'attr' => array(
                    'hidden' => 'true'
                )
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Bird'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'observationbundle_bird';
    }

}
