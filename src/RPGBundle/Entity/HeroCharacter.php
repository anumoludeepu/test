<?php
namespace RPGBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity()
 * @ORM\Table(name="rpg_hero_character")
 * @UniqueEntity("name")
 */
class HeroCharacter extends Character
{

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\Expose()
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @JMS\Expose()
     */
    protected $exp = 0;

    /**
     * @var ArrayCollection | HeroSkill[]
     * @ORM\OneToMany(targetEntity="RPGBundle\Entity\HeroSkill", mappedBy="hero", orphanRemoval=true, cascade={"persist", "remove"})
     * @JMS\Expose()
     * @JMS\MaxDepth(3)
     */
    protected $skills;

    /**
     * @var ArrayCollection | HeroFight[]
     * @ORM\OneToMany(targetEntity="RPGBundle\Entity\HeroFight", mappedBy="hero", orphanRemoval=true, cascade={"persist", "remove"})
     * @JMS\Expose()
     * @JMS\MaxDepth(2)
     */
    protected $fightHistory;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getExp(): int
    {
        return $this->exp;
    }

    /**
     * @param int $exp
     */
    public function setExp(int $exp)
    {
        $this->exp = $exp;
    }

    /**
     * @return ArrayCollection|HeroSkill[]
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param ArrayCollection|HeroSkill[] $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

    /**
     * @return ArrayCollection|HeroFight[]
     */
    public function getFightHistory()
    {
        return $this->fightHistory;
    }

    /**
     * @param ArrayCollection|HeroFight[] $fightHistory
     */
    public function setFightHistory($fightHistory)
    {
        $this->fightHistory = $fightHistory;
    }

}