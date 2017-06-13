<?php


namespace ObservationBundle\EventListener;


use Doctrine\ORM\EntityManager;
use ObservationBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ObservationSubscriber implements EventSubscriberInterface
{
    const OBS = 'Observation';
    const PICTURE = 'Picture';
    const BIRD = 'Bird';
    const LOCATION = 'Location';
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

        $this->countEntities(self::OBS, $observation->getUser());
    }

    public function countEntities($nameEntity, User $user)
    {
        $entities = $this->em->getRepository('ObservationBundle:' . $nameEntity)->findForValidate($user);
        $groupStar = $this->em->getRepository('ObservationBundle:GroupStar')->findOneBy(array('entity' => $nameEntity));
        // On boucle sur les stars
        foreach ($groupStar->getStars() as $star)
        {
            // On vérifie si l'user a autant ou plus d'observation que quantity de star et s'il n'est pas déjà present dedans
            if (count($entities) >= $star->getQuantity() && $star->getUsers()->contains($user) == false) {
                $star->addUser($user);
            }
            $this->em->persist($star);
        }
        $this->em->flush();
    }

    public function countPictures($event)
    {
        $observation = $event->getObservation();

        $this->countEntities(self::PICTURE, $observation->getUser());
    }

    public function countBirds($event)
    {
        $observation = $event->getObservation();

        $this->countEntities(self::BIRD, $observation->getUser());
    }

    public function countLocation($event)
    {
        $observation = $event->getObservation();

        $this->countEntities(self::LOCATION, $observation->getUser());
    }
}