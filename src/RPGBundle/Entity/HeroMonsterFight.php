<?php
namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity()
 * @ORM\Table(name="rpg_hero_monster_fight")
 */
class HeroMonsterFight extends HeroFight
{
    /**
     * @var MonsterCharacter
     * @ORM\ManyToOne(targetEntity="RPGBundle\Entity\MonsterCharacter", inversedBy="id")
     * @ORM\JoinColumn(name="enemy", referencedColumnName="id")
     */
    protected $enemy;

    /**
     * @return CharacterInterface
     */
    public function getEnemy(): CharacterInterface
    {
        return $this->enemy;
    }

    /**
     * @param CharacterInterface $enemy
     */
    public function setEnemy(CharacterInterface $enemy)
    {
        $this->enemy = $enemy;
    }
}