<?php
namespace RPGBundle\Hero;

use RPGBundle\Entity\CharacterInterface;
use RPGBundle\Entity\HeroCharacter;
use RPGBundle\Helper\PasswordHelper;

class MagePrototype extends HeroPrototypeAbstract
{

    public static $skill = 'Magic';

    public static $type = 'Mage';

    public function getCharacter(string $name, string $password): CharacterInterface
    {
        $character = new HeroCharacter();
        $character->setAtk(2);
        $character->setDef(1);
        $character->setHp(150);
        $character->setName($name);
        $character->setPassword(PasswordHelper::encode($password));

        return $character;
    }

}