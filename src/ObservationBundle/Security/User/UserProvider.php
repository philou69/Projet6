<?php

// Pour plus d'info http://clintberry.com/2011/custom-user-providers-symfony2/
namespace ObservationBundle\Security\User;


use Doctrine\Common\Persistence\ManagerRegistry;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use ObservationBundle\Entity\RequestOpen;
use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use ObservationBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserProvider extends EntityUserProvider implements OAuthAwareUserProviderInterface
{
    private $registry;
    private $managerName;
    private $classOrAlias;
    private $class;
    private $property;
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcherInterface;

    public function __construct(EventDispatcherInterface $eventDispatcherInterface, ManagerRegistry $registry, $classOrAlias, $property = null, $managerName = null)
    {

        $this->registry = $registry;
        $this->managerName = $managerName;
        $this->classOrAlias = $classOrAlias;
        $this->property = $property;
        parent::__construct($registry, $classOrAlias, $property, $managerName);
        $this->eventDispatcherInterface = $eventDispatcherInterface;
    }
    function supportsClass($class)
    {
        return $class === 'AppBundle\Entity\User';
    }

    public function loadUserByUsername($username)
    {
        $repository = $this->getRepository();
        if (null !== $this->property) {
            $user = $repository->findOneBy(array($this->property => $username));
        } else {
            if (!$repository instanceof UserLoaderInterface) {
                throw new \InvalidArgumentException(sprintf('You must either make the "%s" entity Doctrine Repository ("%s") implement "Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface" or set the "property" option in the corresponding entity provider configuration.', $this->classOrAlias, get_class($repository)));
            }

            $user = $repository->loadUserByUsername($username);
        }

        if (null === $user) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }
        if($user->getSleeping() && $user->getRequestOpen() === null ){
            $requestOpen = new RequestOpen();
            $requestOpen->setToken(str_replace(['/', '+', '*','-'], '', base64_encode(random_bytes(60))))->setAdresseIP($_SERVER['REMOTE_ADDR']);
            $user->setRequestOpen($requestOpen);
            $this->getObjectManager()->persist($user);
            $this->getObjectManager()->flush();
            $this->eventDispatcherInterface->dispatch('user.reopen', new GenericEvent($user));
            $user->setIsActive(false);
        }elseif ($user->getSleeping() && $user->getRequestOpen() !== null){
            $user->setIsActive(false);
        }
        return $user;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        // On vérifi si l'utilisateur existe
        $user = $this->getRepository()->findOneBy(array('email' => $response->getEmail()));

        if(!$user){
            // On recupere les utilisateurs contenant le même username
            $usersByUsername = $this->getRepository()->findUsernames($response->getNickname());
            
            // On crée un user avec les données renvoyer
            $user = new User;
            $user->setEmail($response->getEmail())
                ->setFirstname($response->getFirstName())
                ->setLastname($response->getLastName());
            // Si on n'a aucun utilisateur avec l'username, on lui passe le username
            if(!$usersByUsername){
                $user->setUsername($response->getNickname());
            }else{
                // Sinon on ajoute la quantité avec le username
                $user->setUsername($response->getNickname() . count($usersByUsername));
            }
            // On appelle le eventdispatcher afin de créer un mot de passe et de le hacher
            $this->eventDispatcherInterface->dispatch('user.register', new GenericEvent($user));
            // On enregistre en bdd
            $this->getObjectManager()->persist($user);
            $this->getObjectManager()->flush();
        }
        // On retourne le user
        return $user;
    }


    private function getObjectManager()
    {
        return $this->registry->getManager($this->managerName);
    }

    private function getRepository()
    {
        return $this->getObjectManager()->getRepository($this->classOrAlias);
    }

}