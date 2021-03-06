<?php


namespace ObservationBundle\EventListener;


use Doctrine\ORM\EntityManager;
use ObservationBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    const BIRTH_DATE = 'User_birthday';
    const AVATAR = 'User_picture';

    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'user.captured' => array(array('hasBirthday'), array('hasAvatar'))
        );
    }

    public function hasBirthDay($event)
    {
        $user = $event->getUser();

        if ($user->getBirthDate() !== null) {
            $this->addStars($user, self::BIRTH_DATE);
        }
    }

    public function addStars(User $user, $entityName)
    {
        $groupStar = $this->em->getRepository('ObservationBundle:GroupStar')->findOneBy(
            array('entity' => $entityName)
        );
        if (!$groupStar->getUsers()->contains($user)) {
            $groupStar->getStars()->first()->addUser($user);
            $this->em->persist($groupStar->getStars()->first());
            $this->em->flush();
        }
    }

    public function hasAvatar($event)
    {
        $user = $event->getUser();

        if ($user->getAvatar() !== null) {
            $this->addStars($user, self::AVATAR);
        }
    }
}
