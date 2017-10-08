<?php
namespace RPGBundle\Listener;

use Doctrine\ORM\EntityManager;
use RPGBundle\Actions\Fight\FightStartAction;
use RPGBundle\Event\FightEvent;

class FightListener
{

    /** @var FightStartAction  */
    private $fightStartAction;

    /** @var EntityManager  */
    private $em;

    /**
     * FightListener constructor.
     * @param FightStartAction $fightStartAction
     * @param EntityManager $em
     */
    public function __construct(FightStartAction $fightStartAction, EntityManager $em)
    {
        $this->fightStartAction = $fightStartAction;
        $this->em = $em;
    }

    public function onFightStart(FightEvent $event)
    {
        $action = $this->fightStartAction;
        do{
            $action->doAction($event);
        } while ($action = $action->next());
    }

    public function onFightEnd(FightEvent $event)
    {
        $this->em->persist($event->getCharacter());
        $this->em->persist($event->getEnemy());
        $timeFinish = new \DateTime();
        foreach ($event->getFightLogs() as $fightLog) {
            $fightLog->setTimeFinish($timeFinish);
            $this->em->persist($fightLog);
        }


        $this->em->flush();
    }
}