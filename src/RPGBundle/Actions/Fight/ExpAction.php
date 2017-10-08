<?php
namespace RPGBundle\Actions\Fight;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use RPGBundle\Actions\ActionChainAbstract;
use RPGBundle\Entity\CharacterLevel;
use RPGBundle\Entity\HeroCharacter;
use RPGBundle\Event\FightEvent;

class ExpAction extends ActionChainAbstract
{

    /** @var EntityManager */
    private $em;

    /**
     * ExpAction constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function doAction(FightEvent $fightEvent)
    {
        $character = $winner = $fightEvent->getCharacter();
        $enemy = $looser = $fightEvent->getEnemy();
        if ($enemy->getHp()) {
            $looser = $character;
            /** @var HeroCharacter $winner */
            $winner = $enemy;
        }
        $lvlDiff = $winner->getLvl() - $looser->getLvl();

        $winnerLevel = $this->getLvlRepo()->findOneBy(['lvl' => $winner->getLvl()]);
        $newExp = $winnerLevel->getExp() / 100;

        $newExp = $lvlDiff > 0 ? $newExp * $lvlDiff : $newExp / abs($lvlDiff);

        $winner->setExp($winner->getExp() + $newExp);
        $this->lvlUp($winner);
    }

    private function lvlUp(HeroCharacter $character)
    {
        /** @var CharacterLevel $nextLevel */
        $nextLevel = $this->getLvlRepo()->findOneBy(['lvl' => $character->getLvl() + 1]);

        if ($nextLevel->getExp() > $character->getExp()) {
            return;
        }

        $character->setExp($character->getExp() - $nextLevel->getExp());
        $character->setLvl($character->getLvl() + 1);

        return $this->lvlUp($character);
    }

    private function getLvlRepo(): EntityRepository
    {
        return $this->em->getRepository(CharacterLevel::class);
    }
}