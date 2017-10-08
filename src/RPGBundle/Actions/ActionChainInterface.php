<?php
namespace RPGBundle\Actions;


use RPGBundle\Event\FightEvent;

interface ActionChainInterface
{
    public function doAction(FightEvent $fightEvent);

    public function next(): ?ActionChainInterface;

    public function setNext(ActionChainInterface $action);
}