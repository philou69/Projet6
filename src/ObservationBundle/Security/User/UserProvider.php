<?php

// Pour plus d'info http://clintberry.com/2011/custom-user-providers-symfony2/
namespace ObservationBundle\Security\User;


use Doctrine\Common\Persistence\ManagerRegistry;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use ObservationBundle\Entity\RequestOpen;
use Symfony\Bridge\Doctrine\Security\User\EntityUserProvider;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use ObservationBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserProvider extends EntityUserProvider implements OAuthAwareUserProviderInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

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
    public function supportsClass($class)
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
            $requestOpen->setToken(str_replace(['/', '+', '*', '-'], '', base64_encode(random_bytes(60))))->setAdresseIP($this->getIp());
            $user->setRequestOpen($requestOpen);
            $this->getObjectManager()->persist($user);
            $this->getObjectManager()->flush();
            $this->eventDispatcherInterface->dispatch('user.reopen', new GenericEvent($user));
            $user->setActive(false);
        }elseif ($user->getSleeping() && $user->getRequestOpen() !== null){
            $user->seActive(false);
        }
        return $user;
    }

    private function getRepository()
    {
        return $this->getObjectManager()->getRepository($this->classOrAlias);
    }

    private function getObjectManager()
    {
        return $this->registry->getManager($this->managerName);
    }

    private function getIp()
    {
        return $this->container->get('request_stack')->getCurrentRequest()->getClientIp();
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        // On vérifi si l'utilisateur existe
        $user = $this->getRepository()->findOneBy(array('email' => $response->getEmail()));

        // On vérifie si le compte a été mis en sommeil
        if ($user !== null && $user->getSleeping() === true && $user->getActive() === true) {
            // création du token qui servira de lien
            $token = str_replace(['/', '+', '*', '-'], '', base64_encode(random_bytes(60)));
            // On crée une requete d'ouverture de compte qu'on assigne au compte
            $requestOpen = new RequestOpen();
            $requestOpen->setAdresseIP($this->getIp())->setToken($token)->setUser($user);
            $user->setRequestOpen($requestOpen);
            // On enregistre la demansde
            $this->getObjectManager()->persist($requestOpen);
            $this->getObjectManager()->flush();
            // On envoie le mail de réouverture
            $this->eventDispatcherInterface->dispatch('user.reopen', new GenericEvent($user));
            // On passe le visiteur comme bloqué
            $user->setActive(false);
        }

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

}
