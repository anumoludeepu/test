<?php
namespace RPGBundle\Security\User;


use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\HeroCharacter;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class Provider implements UserProviderInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @inheritdoc
     */
    public function loadUserByUsername($username)
    {
        $character = $this->em->getRepository(HeroCharacter::class)->findOneBy(['name' => $username]);
        if (!$character) {
            $exception = new UsernameNotFoundException();
            $exception->setUsername($username);

            throw $exception;
        }

        $user = new User($character);

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException('Wrong user provided!');
        }

        /** @var User $user */
        $hero = $user->getHero();
        $this->em->refresh($hero);

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function supportsClass($class)
    {
        return $class == User::class;
    }

}