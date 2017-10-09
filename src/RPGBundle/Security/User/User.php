<?php
namespace RPGBundle\Security\User;


use RPGBundle\Entity\HeroCharacter;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * @var HeroCharacter
     */
    private $hero;

    /**
     * User constructor.
     * @param $hero
     */
    public function __construct(HeroCharacter $hero)
    {
        $this->hero = $hero;
    }

    public function getName()
    {
        return $this->hero->getName();
    }


    public function getRoles()
    {
        return ['hero'];
    }

    public function getPassword()
    {
        return $this->hero->getPassword();
    }

    public function getSalt()
    {
        return '';
    }

    public function getUsername()
    {
        return $this->hero->getName();
    }

    public function eraseCredentials()
    {
        return;
    }

    /**
     * @return HeroCharacter
     */
    public function getHero(): HeroCharacter
    {
        return $this->hero;
    }

    /**
     * @param HeroCharacter $hero
     */
    public function setHero(HeroCharacter $hero)
    {
        $this->hero = $hero;
    }
}