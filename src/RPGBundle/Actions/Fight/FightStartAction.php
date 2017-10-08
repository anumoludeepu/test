<?php
namespace RPGBundle\Actions\Fight;

use RPGBundle\Actions\ActionChainAbstract;
use RPGBundle\Entity\CharacterInterface;
use RPGBundle\Entity\HeroCharacter;
use RPGBundle\Entity\HeroFightInterface;
use RPGBundle\Entity\HeroHeroFight;
use RPGBundle\Entity\HeroMonsterFight;
use RPGBundle\Event\FightEvent;

class FightStartAction extends ActionChainAbstract
{

    public function doAction(FightEvent $fightEvent)
    {
        $character = $fightEvent->getCharacter();

        $enemy = $fightEvent->getEnemy();

        if (!$fightEvent->getFightLog($character)) {
            $fightEvent->addFightLog($this->createFightLog($character, $enemy));
        }

        if ($enemy instanceof HeroCharacter && !$fightEvent->getFightLog($enemy)) {
            $fightEvent->addFightLog($this->createFightLog($enemy, $character));
        }
    }

    private function createFightLog(HeroCharacter $hero, CharacterInterface $enemy): HeroFightInterface
    {
        $log = $enemy instanceof HeroCharacter ? new HeroHeroFight() : new HeroMonsterFight();

        $log->setEnemy($enemy);
        $log->setHero($hero);
        $log->setTimeStart(new \DateTime());

        return $log;
    }

}