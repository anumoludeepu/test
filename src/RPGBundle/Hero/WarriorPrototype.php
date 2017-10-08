<?php
namespace RPGBundle\Hero;

use RPGBundle\Entity\CharacterInterface;
use RPGBundle\Entity\HeroCharacter;
use RPGBundle\Helper\PasswordHelper;

class WarriorPrototype extends HeroPrototypeAbstract
{

    public static $skill = 'Force';

    public static $type = 'Warrior';

    public function getCharacter(string $name, string $password): CharacterInterface
    {
        $character = new HeroCharacter();
        $character->setAtk(3);
        $character->setDef(2);
        $character->setHp(250);
        $character->setName($name);
        $character->setPassword(PasswordHelper::encode($password));

        return $character;
    }

}