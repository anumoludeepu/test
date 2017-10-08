<?php
namespace RPGBundle\Actions;


abstract class ActionChainAbstract implements ActionChainInterface
{
    /**
     * @var null | ActionChainInterface
     */
    protected $next = null;

    public function next(): ?ActionChainInterface
    {
        return $this->next;
    }

    public function setNext(ActionChainInterface $action)
    {
        $this->next = $action;
    }

}