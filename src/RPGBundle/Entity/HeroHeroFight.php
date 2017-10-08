<?php
namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity()
 * @ORM\Table(name="rpg_hero_hero_fight")
 */
class HeroHeroFight extends HeroFight
{
    /**
     * @var HeroCharacter
     * @ORM\ManyToOne(targetEntity="RPGBundle\Entity\HeroCharacter", inversedBy="id")
     * @ORM\JoinColumn(name="enemy", referencedColumnName="id")
     * @JMS\Expose()
     * @JMS\MaxDepth(2)
     */
    protected $enemy;

    /**
     * @return HeroCharacter
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