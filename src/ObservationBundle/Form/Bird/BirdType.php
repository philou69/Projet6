<?php

namespace ObservationBundle\Form\Bird;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BirdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bec', ChoiceType::class, array(
                'label' => 'Type de bec',
                'attr' => array(
                    'hidden' => 'true'
                ),
                'choices' => array(
                    'blanc' => 'blanc',
                    'bleu' => 'bleu',
                    'gris' => 'gris',
                    'jaune' => 'jaune',
                    'marron' => 'marron',
                    'noir' => 'noir',
                    'rose' => 'rose',
                    'rouge/orange' => 'rouge/orange',
                    'vert' => 'vert',
                )
            ))
            ->add('plumage', ChoiceType::class, array(
                'label' => 'Type de plumage',
                'attr' => array(
                    'hidden' => 'true'
                ),
                'choices' => array(
                    'blanc' => 'blanc',
                    'bleu' => 'bleu',
                    'gris' => 'gris',
                    'jaune' => 'jaune',
                    'marron' => 'marron',
                    'noir' => 'noir',
                    'rose' => 'rose',
                    'rouge/orange' => 'rouge/orange',
                    'vert' => 'vert',
                )
            ))
            ->add('patte', ChoiceType::class, array(
                'label' => 'Couleur',
                'attr' => array(
                    'hidden' => 'true'
                ),
                'choices' => array(
                    'blanc' => 'blanc',
                    'bleu' => 'bleu',
                    'gris' => 'gris',
                    'jaune' => 'jaune',
                    'marron' => 'marron',
                    'noir' => 'noir',
                    'rose' => 'rose',
                    'rouge/orange' => 'rouge/orange',
                    'vert' => 'vert',
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
