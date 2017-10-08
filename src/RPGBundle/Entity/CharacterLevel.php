<?php
namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity()
 * @ORM\Table(name="rpg_character_level", indexes={
 *     @ORM\Index(name="lvl_idx", columns={"lvl"})
 * })
 */
class CharacterLevel
{
    /**
     * @var
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $lvl = 1;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $atkModifier = 0;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $hpModifier = 0;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $defModifier = 0;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $exp = 0;

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
     * @return int
     */
    public function getLvl(): int
    {
        return $this->lvl;
    }

    /**
     * @param int $lvl
     */
    public function setLvl(int $lvl)
    {
        $this->lvl = $lvl;
    }

    /**
     * @return int
     */
    public function getAtkModifier(): int
    {
        return $this->atkModifier;
    }

    /**
     * @param int $atkModifier
     */
    public function setAtkModifier(int $atkModifier)
    {
        $this->atkModifier = $atkModifier;
    }

    /**
     * @return int
     */
    public function getHpModifier(): int
    {
        return $this->hpModifier;
    }

    /**
     * @param int $hpModifier
     */
    public function setHpModifier(int $hpModifier)
    {
        $this->hpModifier = $hpModifier;
    }

    /**
     * @return int
     */
    public function getDefModifier(): int
    {
        return $this->defModifier;
    }

    /**
     * @param int $defModifier
     */
    public function setDefModifier(int $defModifier)
    {
        $this->defModifier = $defModifier;
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

}