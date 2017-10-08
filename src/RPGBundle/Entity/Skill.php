<?php
namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\Entity()
 * @ORM\Table(name="rpg_skill", indexes={
 *     @ORM\Index(name="type_idx", columns={"type"})
 * })
 */
class Skill
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
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @JMS\Expose()
     */
    protected $type;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     * @JMS\Expose()
     */
    protected $dmgModifier = 0;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     * @JMS\Expose()
     */
    protected $resistantModifier = 0;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     * @JMS\Expose()
     */
    protected $failModifier = 0;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     * @JMS\Expose()
     */
    protected $hpModifier = 0;

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getDmgModifier(): int
    {
        return $this->dmgModifier;
    }

    /**
     * @param int $dmgModifier
     */
    public function setDmgModifier(int $dmgModifier)
    {
        $this->dmgModifier = $dmgModifier;
    }

    /**
     * @return int
     */
    public function getResistantModifier(): int
    {
        return $this->resistantModifier;
    }

    /**
     * @param int $resistantModifier
     */
    public function setResistantModifier(int $resistantModifier)
    {
        $this->resistantModifier = $resistantModifier;
    }

    /**
     * @return int
     */
    public function getFailModifier(): int
    {
        return $this->failModifier;
    }

    /**
     * @param int $failModifier
     */
    public function setFailModifier(int $failModifier)
    {
        $this->failModifier = $failModifier;
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
}