<?php
namespace RPGBundle\Hero;

use RPGBundle\Entity\CharacterInterface;
use RPGBundle\Entity\HeroCharacter;
use RPGBundle\Helper\PasswordHelper;

class AssassinPrototype extends HeroPrototypeAbstract
{

    public static $skill = 'Stab';

    public static $type = 'Assassin';

    public function getCharacter(string $name, string $password): CharacterInterface
    {
        $character = new HeroCharacter();
        $character->setAtk(4);
        $character->setDef(1);
        $character->setHp(100);
        $character->setName($name);
        $character->setPassword(PasswordHelper::encode($password));

        return $character;
    }

}