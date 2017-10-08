<?php
namespace RPGBundle\Hero;

abstract class HeroPrototypeAbstract implements HeroPrototypeInterface
{

    public static $type = 'Unknown';

    public static $skill = 'None';

    public function getType(): string
    {
        return static::$type;
    }

    public function getSkillType(): string
    {
        return static::$skill;
    }
}