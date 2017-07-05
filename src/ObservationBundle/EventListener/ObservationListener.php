<?php


namespace ObservationBundle\EventListener;


use ObservationBundle\Entity\Observation;
use ObservationBundle\Entity\User;

class ObservationListener
{
    public function obsOfNaturaliste(Observation $observation)
    {
        // On s'assure d'avoir l'obs d'un naturaliste
        if ($observation->getUser()->hasRole('ROLE_NATURALISTE')) {
            // On passe l'obs en validé et on ajoute la location à l'oiseau ainsique les photos s'il y en a
            $observation->setValidated(true)
                ->setValidatedBy($observation->getUser());

            $bird = $observation->getBird();
            $bird->addLocation($observation->getLocation());

            if ($observation->getPictures()->count() > 0) {
                foreach ($observation->getPictures() as $picture) {
                    $bird->addPicture($picture);
                    $picture->setBird($bird);
                }
            }
        }

    }

    public function validate(Observation $observation, User $user)
    {
        // On va passer l'observation à valider
        // Ajouter les photos à l'oiseau
        // Ajouter la location à l'oiseau
        $bird = $observation->getBird();
        foreach ($observation->getPictures() as $picture) {
            $picture->setBird($bird);
        }
        $bird->addLocation($observation->getLocation());
        $observation->setValidated(true)
            ->setValidatedBy($user)
            ->setValidatedAt(new \DateTime());
    }

    public function unvalidate(Observation $observation)
    {
        // On va passer l'observation à invalider
        // On retire les photos à l'oiseau
        // On retire la location à l'oiseau
        $bird = $observation->getBird();
        foreach ($observation->getPictures() as $picture) {
            $picture->setBird(null);
        }
        $bird->removeLocation($observation->getLocation());
        $observation->setValidated(false)
            ->setValidatedBy(null)
            ->setValidatedAt(null);
    }
}