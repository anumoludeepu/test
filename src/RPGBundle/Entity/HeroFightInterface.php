<?php
namespace RPGBundle\Entity;


interface HeroFightInterface
{
    public function getHero(): HeroCharacter;

    public function setHero(HeroCharacter $character);

    public function getEnemy(): CharacterInterface;

    public function setEnemy(CharacterInterface $character);

    public function getDmgReceived(): int;

    public function setDmgReceived(int $damage);

    public function getDmgAffected(): int;

    public function setDmgAffected(int $damage);

    public function getTimeStart(): \DateTime;

    public function getTimeFinish(): \DateTime;
}