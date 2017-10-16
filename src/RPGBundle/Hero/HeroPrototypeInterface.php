<?php
namespace RPGBundle\Hero;

use RPGBundle\Entity\HeroCharacter;

interface HeroPrototypeInterface
{
    public function getType(): string;

    public function getSkillType(): string;

    public function getCharacter(string $name, string $password): HeroCharacter;
}