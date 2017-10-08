<?php
namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity()
 * @ORM\Table(name="rpg_hero_fight", indexes={
 *     @ORM\Index(name="fight_time_idx", columns={"time_start", "time_finish"})
 * })
 * @ORM\InheritanceType(value="JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "hero" = "RPGBundle\Entity\HeroHeroFight",
 *     "monster" = "RPGBundle\Entity\HeroMonsterFight"
 *     })
 */
abstract class HeroFight implements HeroFightInterface
{

    /**
     * @var
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $timeStart;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $timeFinish;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $dmgAffected = 0;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $dmgReceived = 0;

    /**
     * @var HeroCharacter
     * @ORM\ManyToOne(targetEntity="RPGBundle\Entity\HeroCharacter", inversedBy="id")
     * @ORM\JoinColumn(name="hero_id", referencedColumnName="id")
     */
    protected $hero;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getTimeStart(): \DateTime
    {
        return $this->timeStart;
    }

    /**
     * @param \DateTime $timeStart
     */
    public function setTimeStart(\DateTime $timeStart)
    {
        $this->timeStart = $timeStart;
    }

    /**
     * @return \DateTime
     */
    public function getTimeFinish(): \DateTime
    {
        return $this->timeFinish;
    }

    /**
     * @param \DateTime $timeFinish
     */
    public function setTimeFinish(\DateTime $timeFinish)
    {
        $this->timeFinish = $timeFinish;
    }

    /**
     * @return int
     */
    public function getDmgAffected(): int
    {
        return $this->dmgAffected;
    }

    /**
     * @param int $dmgAffected
     */
    public function setDmgAffected(int $dmgAffected)
    {
        $this->dmgAffected = $dmgAffected;
    }

    /**
     * @return int
     */
    public function getDmgReceived(): int
    {
        return $this->dmgReceived;
    }

    /**
     * @param int $dmgReceived
     */
    public function setDmgReceived(int $dmgReceived)
    {
        $this->dmgReceived = $dmgReceived;
    }

    /**
     * @return HeroCharacter
     */
    public function getHero(): HeroCharacter
    {
        return $this->hero;
    }

    /**
     * @param HeroCharacter $hero
     */
    public function setHero(HeroCharacter $hero)
    {
        $this->hero = $hero;
    }
}