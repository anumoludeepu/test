<?php
namespace RPGBundle\Actions\Fight;


use RPGBundle\Actions\ActionChainAbstract;
use RPGBundle\Event\FightEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class FightEndAction extends ActionChainAbstract
{
    /** @var EventDispatcherInterface  */
    private $dispatcher;

    /**
     * FightEndAction constructor.
     * @param $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param FightEvent $fightEvent
     */
    public function doAction(FightEvent $fightEvent)
    {
        $this->dispatcher->dispatch(FightEvent::ON_FIGHT_END, $fightEvent);
    }

}