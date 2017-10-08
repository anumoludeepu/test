<?php
namespace RPGBundle\Event;

use RPGBundle\Entity\CharacterInterface;
use RPGBundle\Entity\HeroCharacter;
use RPGBundle\Entity\HeroFight;
use RPGBundle\Entity\HeroFightInterface;
use Symfony\Component\EventDispatcher\Event;

class FightEvent extends Event
{

    const ON_FIGHT_START = 'fight.start';
    const ON_FIGHT_END = 'fight.end';

    /**
     * @var HeroCharacter
     */
    private $character;

    /**
     * @var CharacterInterface
     */
    private $enemy;

    private $fightLogs = [];

    /**
     * FightStartedEvent constructor.
     * @param $character
     * @param $enemy
     */
    public function __construct(HeroCharacter $character, CharacterInterface $enemy)
    {
        $this->character = $character;
        $this->enemy     = $enemy;
    }

    /**
     * @return HeroCharacter
     */
    public function getCharacter(): HeroCharacter
    {
        return $this->character;
    }

    /**
     * @param HeroFightInterface $heroFight
     */
    public function addFightLog(HeroFightInterface $heroFight)
    {
        $this->fightLogs[$heroFight->getHero()->getId()] = $heroFight;
    }

    /**
     * @param HeroCharacter $character
     * @return null|HeroFightInterface
     */
    public function getFightLog(HeroCharacter $character): ?HeroFightInterface
    {
        return $this->fightLogs[$character->getId()] ?? null;
    }

    /**
     * @return array | HeroFight[]
     */
    public function getFightLogs()
    {
        return $this->fightLogs;
    }

    /**
     * @return CharacterInterface
     */
    public function getEnemy(): CharacterInterface
    {
        return $this->enemy;
    }
}