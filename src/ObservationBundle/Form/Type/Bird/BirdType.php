<?php

namespace ObservationBundle\Form\Type\Bird;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BirdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeBec', ChoiceType::class, array(
                'label' => 'Type de bec',
                'placeholder' => "Choisisez un type de bec",
                'attr' => array(
                    'hidden' => 'true'
                ),
                'choices' => array(
                    'Autre' => 'autre',
                    'Autres becs droits' => 'autres becs droits',
                    'Canard' => 'canard',
                    'Courbé' => 'courbé',
                    'Crochu' => 'crochu',
                    'Droit et long' => 'droit et long',
                    'Épais et court' => 'épais et court',
                    'Fin et court' => 'fin et court',
                    'Mouette' => 'mouette',
                )
            ))
            ->add('plumage', ChoiceType::class, array(
                'label' => 'Couleur principale du plumage',
                'placeholder' => "Choisisez une couleur de plumage",
                'attr' => array(
                    'hidden' => 'true'
                ),
                'choices' => array(
                    'Blanc' => 'blanc',
                    'Bleu' => 'bleu',
                    'Gris' => 'gris',
                    'Jaune' => 'jaune',
                    'Marron' => 'marron',
                    'Noir' => 'noir',
                    'Rose' => 'rose',
                    'Rouge/orange' => 'rouge/orange',
                    'Vert' => 'vert',
                )
            ))
            ->add('patte', ChoiceType::class, array(
                'label' => 'Couleur des pattes',
                'placeholder' => "Choisisez une couleur de pattes",
                'attr' => array(
                    'hidden' => 'true'
                ),
                'choices' => array(
                    'Blanc' => 'blanc',
                    'Bleu' => 'bleu',
                    'Gris' => 'gris',
                    'Jaune' => 'jaune',
                    'Marron' => 'marron',
                    'Noir' => 'noir',
                    'Rose' => 'rose',
                    'Rouge/orange' => 'rouge/orange',
                    'Vert' => 'vert',
                )
            ))
            ->add('bec', ChoiceType::class, array(
                'label' => 'Couleur du bec',
                'placeholder' => "Choisisez une couleur de bec",
                'attr' => array(
                    'hidden' => 'true'
                ),
                'choices' => array(
                    'Blanc' => 'blanc',
                    'Bleu' => 'bleu',
                    'Gris' => 'gris',
                    'Jaune' => 'jaune',
                    'Marron' => 'marron',
                    'Noir' => 'noir',
                    'Rose' => 'rose',
                    'Rouge/orange' => 'rouge/orange',
                    'Vert' => 'vert',
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
