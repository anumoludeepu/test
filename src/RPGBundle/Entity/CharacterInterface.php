<?php
namespace RPGBundle\Entity;

/**
 * Class CharacterInterface
 * @package RPGBundle\Entity
 */
interface CharacterInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getLvl(): int;

    /**
     * @return int
     */
    public function getHp(): int;

    /**
     * @return int
     */
    public function getAtk(): int;

    /**
     * @return int
     */
    public function getDef(): int;
}