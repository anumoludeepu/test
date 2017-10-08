<?php
namespace RPGBundle\Hero;


use Doctrine\ORM\EntityManager;
use RPGBundle\Entity\CharacterInterface;
use RPGBundle\Entity\HeroSkill;
use RPGBundle\Entity\Skill;

class HeroCharacterFactory
{
    private $prototypes = [];

    /** @var EntityManager  */
    protected $em;

    /**
     * HeroPrototypeAbstract constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * @param string $type
     * @param string $name
     * @param string|null $password
     * @return null|CharacterInterface
     */
    public function create(string $type, string $name, string $password): ?CharacterInterface
    {
        /** @var HeroPrototypeInterface $characterProto */
        $characterProto = isset($this->prototypes[$type]) ? $this->prototypes[$type] : null;

        if (!$characterProto) {
            return null;
        }

        $character = $characterProto->getCharacter($name, $password);

        $skill = $this->getSkill($characterProto->getSkillType());
        $heroSkill = $this->getHeroSkill($skill);
        $heroSkill->setHero($character);

        try {
            $this->em->persist($character);
            $this->em->persist($heroSkill);
            $this->em->flush();
        } catch (\Exception $e) {
            return null;
        }

        return $character;
    }

    /**
     * @param HeroPrototypeInterface $prototype
     */
    public function registerPrototype(HeroPrototypeInterface $prototype)
    {
        $this->prototypes[$prototype->getType()] = $prototype;
    }


    /**
     * @return array
     */
    public function getAvailableCharacterTypes()
    {
        return array_keys($this->prototypes);
    }

    protected function getHeroSkill(Skill $skill): HeroSkill
    {
        $heroSkill = new HeroSkill();
        $heroSkill->setSkill($skill);
        $heroSkill->setReceivedAt(new \DateTime());

        return $heroSkill;
    }

    protected function getSkill($type): Skill
    {
        return $this->em->getRepository(Skill::class)->findOneBy(['type' => $type]);
    }
}