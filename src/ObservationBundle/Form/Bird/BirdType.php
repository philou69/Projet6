<?php

namespace ObservationBundle\Form\Bird;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Doctrine\ORM\EntityManager;
$user = $this->getUser();
        if($user === null){
            throw new Exception('Vous n\'êtes pas autoriser à venir içi');
        }
class BirdType extends AbstractType
{

    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder
           ->add('nomVern', ChoiceType::class, array(
               'mapped' => false,
               'choices' => $this->createList(),
               'label' => 'Nom de l\'espèce observée'

           ))
        ;


    }

    public function createList() {

        $allBirds = $this->em ->getRepository('ObservationBundle:Bird')->findAll();

        $listBirds = [] ;
        foreach ($allBirds as $list){

            $listBirds[$list->getNomVern()] = $list->getNomVern();

        }

        return $listBirds;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ObservationBundle\Entity\Bird'
        ));

    }
}