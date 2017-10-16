<?php
namespace Tests\RPGBundle\Hero;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;
use RPGBundle\Entity\HeroCharacter;
use RPGBundle\Entity\HeroSkill;
use RPGBundle\Entity\Skill;
use RPGBundle\Helper\PasswordHelper;
use RPGBundle\Hero\AssassinPrototype;
use RPGBundle\Hero\HeroCharacterFactory;
use RPGBundle\Hero\MagePrototype;
use RPGBundle\Hero\WarriorPrototype;

class HeroCharacterFactoryTest extends TestCase
{

    /**
     * @dataProvider factoryTestProvider
     * @param $name
     * @param $type
     * @param $pass
     * @param $hp
     * @param $atk
     * @param $def
     * @param $skillType
     */
    public function testSuccessCharacterCreation($name, $type, $pass, $hp, $atk, $def, $skillType)
    {
        $factory = $this->createFactory();

        $this->assertEquals([AssassinPrototype::$type, MagePrototype::$type, WarriorPrototype::$type],
                            $factory->getAvailableCharacterTypes());

        /** @var HeroCharacter $char */
        $char = $factory->create($type, $name, $pass);

        $this->assertTrue($char instanceof HeroCharacter);

        $this->assertEquals($name, $char->getName());
        $this->assertTrue(PasswordHelper::verify($pass, $char->getPassword()));
        $this->assertEquals(1, $char->getLvl());
        $this->assertEquals($hp, $char->getHp());
        $this->assertEquals($atk, $char->getAtk());
        $this->assertEquals($def, $char->getDef());

        $heroSkill = $char->getSkills()->first();
        $this->assertTrue($heroSkill instanceof HeroSkill);
        $this->assertEquals($skillType, $heroSkill->getSkill()->getType());
    }

    public function factoryTestProvider()
    {
        return [
            [
                'testWar', WarriorPrototype::$type, 'wartest', WarriorPrototype::$hp, WarriorPrototype::$atk,
                WarriorPrototype::$def, WarriorPrototype::$skill
            ],
            [
                'testMage', MagePrototype::$type, 'magtest', MagePrototype::$hp, MagePrototype::$atk,
                MagePrototype::$def, MagePrototype::$skill
            ],
            [
                'testAssassin', AssassinPrototype::$type, 'asstest', AssassinPrototype::$hp, AssassinPrototype::$atk,
                AssassinPrototype::$def, AssassinPrototype::$skill
            ],
        ];
    }

    private function createFactory()
    {
        $emStub = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()
            ->setMethods(['getRepository', 'persist', 'flush'])->getMock();

        $repoStub = $this->getMockBuilder(EntityRepository::class)->disableOriginalConstructor()
            ->setMethods(['findOneBy'])->getMock();


        $valueMap = [
            [['type' => WarriorPrototype::$skill], null, $this->getSkill(WarriorPrototype::$skill)],
            [['type' => MagePrototype::$skill], null, $this->getSkill(MagePrototype::$skill)],
            [['type' => AssassinPrototype::$skill], null, $this->getSkill(AssassinPrototype::$skill)]
        ];

        $repoStub->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValueMap($valueMap));

        $emStub->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($repoStub));

        $factory = new HeroCharacterFactory($emStub);

        $factory->registerPrototype(new AssassinPrototype());
        $factory->registerPrototype(new MagePrototype());
        $factory->registerPrototype(new WarriorPrototype());

        return $factory;
    }

    private function getSkill($type)
    {
        $skill = new Skill();
        $skill->setType($type);

        return $skill;
    }
}