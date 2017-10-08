<?php
namespace RPGBundle\Actions\Fight;


use RPGBundle\Actions\ActionChainAbstract;
use RPGBundle\Entity\HeroCharacter;
use RPGBundle\Entity\HeroSkill;
use RPGBundle\Event\FightEvent;
use RPGBundle\Helper\SkillHelper;

class KickAction extends ActionChainAbstract
{
    public function doAction(FightEvent $fightEvent)
    {
        /** @var HeroCharacter $char */
        $char = $damager = $fightEvent->getCharacter();

        /** @var HeroCharacter $enemy */
        $enemy = $dmgReceiver = $fightEvent->getEnemy();

        if (mt_rand(0, 1)) { // who'se lucky to kick ?
            $dmgReceiver = $char;
            $damager = $enemy;
        }

        /** @var HeroSkill $skill */
        $skill = $damager->getSkills()->first();
        $dmg = SkillHelper::getDmg($skill);
        $hp = $dmgReceiver->getHp() > $dmg ? $dmgReceiver->getHp() - $dmg : 0;
        $dmgReceiver->setHp($hp);

        if ($damager instanceof HeroCharacter) {
            $log = $fightEvent->getFightLog($damager);
            $log->setDmgAffected($log->getDmgAffected() + $dmg);
        }

        if ($dmgReceiver instanceof HeroCharacter) {
            $log = $fightEvent->getFightLog($dmgReceiver);
            $log->setDmgReceived($log->getDmgReceived() + $dmg);
        }

        if ($dmgReceiver->getHp()) { // until somebody loose
            $this->doAction($fightEvent);
        }
    }

}