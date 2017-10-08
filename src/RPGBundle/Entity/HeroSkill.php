<?php
namespace RPGBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity()
 * @ORM\Table(name="rpg_hero_skill")
 */
class HeroSkill
{

    /**
     * @var
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose()
     */
    protected $id;

    /**
     * @var HeroCharacter
     * @ORM\ManyToOne(targetEntity="RPGBundle\Entity\HeroCharacter", inversedBy="skills", cascade={"persist"})
     * @ORM\JoinColumn(name="hero", referencedColumnName="id")
     */
    protected $hero;

    /**
     * @var Skill
     * @ORM\ManyToOne(targetEntity="RPGBundle\Entity\Skill")
     * @ORM\JoinColumn(name="skill", referencedColumnName="id")
     * @JMS\Expose()
     * @JMS\MaxDepth(2)
     */
    protected $skill;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     * @JMS\Expose()
     */
    protected $receivedAt;

    /**
     * HeroSkill constructor.
     */
    public function __construct()
    {
        $this->receivedAt = new \DateTime();
    }

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

    /**
     * @return Skill
     */
    public function getSkill(): Skill
    {
        return $this->skill;
    }

    /**
     * @param Skill $skill
     */
    public function setSkill(Skill $skill)
    {
        $this->skill = $skill;
    }

    /**
     * @return \DateTime
     */
    public function getReceivedAt(): \DateTime
    {
        return $this->receivedAt;
    }

    /**
     * @param \DateTime $receivedAt
     */
    public function setReceivedAt(\DateTime $receivedAt)
    {
        $this->receivedAt = $receivedAt;
    }
}