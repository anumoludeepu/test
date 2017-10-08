<?php
namespace RPGBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use RPGBundle\Entity\CharacterLevel;
use RPGBundle\Entity\HeroCharacter;
use RPGBundle\Entity\Skill;
use RPGBundle\Hero\AssassinPrototype;
use RPGBundle\Hero\MagePrototype;
use RPGBundle\Hero\WarriorPrototype;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $skillForce = new Skill();
        $skillForce->setDmgModifier(5);
        $skillForce->setFailModifier(5);
        $skillForce->setResistantModifier(2);
        $skillForce->setType(WarriorPrototype::$skill);
        $manager->persist($skillForce);

        $skillAgility = new Skill();
        $skillAgility->setDmgModifier(7);
        $skillAgility->setFailModifier(7);
        $skillAgility->setResistantModifier(2);
        $skillAgility->setType(AssassinPrototype::$skill);
        $manager->persist($skillAgility);

        $skillMagic = new Skill();
        $skillMagic->setDmgModifier(10);
        $skillMagic->setFailModifier(10);
        $skillMagic->setResistantModifier(1);
        $skillMagic->setType(MagePrototype::$skill);
        $manager->persist($skillMagic);

        $baseXp = 100;
        for ($lvl = 1; $lvl < 5; $lvl++) {
            $level = new CharacterLevel();
            $level->setExp($baseXp * $lvl^2);
            $level->setAtkModifier(HeroCharacter::DEFAULT_ATK * $lvl^3);
            $level->setDefModifier(HeroCharacter::DEFAULT_DEF * $lvl^2);
            $level->setHpModifier(HeroCharacter::DEFAULT_HP_QTY * $lvl^4);
            $level->setLvl($lvl);
            $manager->persist($level);
        }

        $manager->flush();

        $charFactory = $this->container->get('character.factory');

        $charFactory->create(MagePrototype::$type, 'Mage', 'magepass');

        $charFactory->create(WarriorPrototype::$type, 'War', 'warpass');

        $charFactory->create(AssassinPrototype::$type, 'Killa', 'killapass');
    }

}