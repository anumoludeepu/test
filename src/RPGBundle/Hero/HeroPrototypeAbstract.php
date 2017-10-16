<?php
namespace RPGBundle\Hero;

use RPGBundle\Entity\HeroCharacter;
use RPGBundle\Helper\PasswordHelper;

abstract class HeroPrototypeAbstract implements HeroPrototypeInterface
{

    public static $type = 'Unknown';

    public static $skill = 'None';

    public static $atk = 0;
    public static $def = 0;
    public static $hp = 0;

    public function getCharacter(string $name, string $password): HeroCharacter
    {
        $character = new HeroCharacter();
        $character->setAtk(static::$atk);
        $character->setDef(static::$def);
        $character->setHp(static::$hp);
        $character->setBaseHp(static::$hp);
        $character->setName($name);
        $character->setPassword(PasswordHelper::encode($password));

        return $character;
    }


    public function getType(): string
    {
        return static::$type;
    }

    public function getSkillType(): string
    {
        return static::$skill;
    }
}