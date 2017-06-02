<?php


namespace ObservationBundle\EventListener;


use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ObservationSubscriber implements EventSubscriberInterface
{
    const OBS = 'Observation_valide';
    const PICTURE = 'Observation_picture';
    const BIRD = 'Observation_bird';
    protected $em;

    /**
     * StarObservationSubscriber constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'observation.captured' => array(array('countObservations'), array('countPictures'), array('countBirds'))
        );
    }


    public function countObservations($event)
    {
        $observation = $event->getObservation();

        $observations = $this->em->getRepository('ObservationBundle:Observation')->findForUser($observation->getUser());
        $groupStar = $this->em->getRepository('ObservationBundle:GroupStar')->findOneBy(array('entity' => self::OBS));
        // On boucle sur les stars
        foreach ($groupStar->getStars() as $star)
        {
            // On vérifie si l'user a autant ou plus d'observation que quantity de star et s'il n'est pas déjà present dedans
            if (count($observations) >= $star->getQuantity() && $star->getUsers()->contains($observation->getUser()) == false){
                $star->addUser($observation->getUser());
            }
            $this->em->persist($star);
        }
        $this->em->flush();
    }

    public function countPictures($event)
    {
        $observation = $event->getObservation();

        $pictures = $this->em->getRepository('ObservationBundle:Picture')->findForValidate($observation->getUser());
        $groupStar = $this->em->getRepository('ObservationBundle:GroupStar')->findOneBy(array('entity' => self::PICTURE));
        foreach ($groupStar->getStars() as $star)
        {
            // On vérifie si l'user a autant ou plus d'observation que quantity de star et s'il n'est pas déjà present dedans
            if (count($pictures) >= $star->getQuantity() && $star->getUsers()->contains($observation->getUser()) == false){
                $star->addUser($observation->getUser());
            }
            $this->em->persist($star);
        }
        $this->em->flush();

    }

    public function countBirds($event)
    {
        $observation = $event->getObservation();

        $birds = $this->em->getRepository('ObservationBundle:Bird')->findForValide($observation->getUser());
        $groupStar = $this->em->getRepository('ObservationBundle:GroupStar')->findOneBy(array('entity' => self::PICTURE));
        foreach ($groupStar->getStars() as $star)
        {

            // On vérifie si l'user a autant ou plus d'observation que quantity de star et s'il n'est pas déjà present dedans
            if (count($birds) >= $star->getQuantity() && $star->getUsers()->contains($observation->getUser()) == false){
                $star->addUser($observation->getUser());
            }
            $this->em->persist($star);
        }
        $this->em->flush();
    }
}