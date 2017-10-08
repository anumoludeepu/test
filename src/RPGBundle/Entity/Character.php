<?php
namespace RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\ExclusionPolicy("all")
 * @ORM\MappedSuperclass
 */
abstract class Character implements CharacterInterface
{
    const DEFAULT_HP_QTY = 100;

    const DEFAULT_ATK = 2;

    const DEFAULT_DEF = 1;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @JMS\Expose()
     */
    protected $name;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     * @JMS\Expose()
     */
    protected $hp = self::DEFAULT_HP_QTY;

    /**
     * @var int
     * @ORM\Column(type="smallint", nullable=false)
     * @JMS\Expose()
     */
    protected $lvl = 1;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @JMS\Expose()
     */
    protected $atk = self::DEFAULT_ATK;

    /**
     * @var int
     * @ORM\Column(type="integer")
     * @JMS\Expose()
     */
    protected $def = self::DEFAULT_DEF;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="modified_at")
     */
    protected $modifiedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->modifiedAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getHp(): int
    {
        return $this->hp;
    }

    /**
     * @param int $hp
     */
    public function setHp($hp)
    {
        $this->hp = $hp;
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
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @param \DateTime $modifiedAt
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @return int
     */
    public function getAtk(): int
    {
        return $this->atk;
    }

    /**
     * @param int $atk
     */
    public function setAtk(int $atk)
    {
        $this->atk = $atk;
    }

    /**
     * @return int
     */
    public function getDef(): int
    {
        return $this->def;
    }

    /**
     * @param int $def
     */
    public function setDef(int $def)
    {
        $this->def = $def;
    }

}