<?php
namespace RPGBundle\Helper;

use RPGBundle\Entity\HeroSkill;
use RPGBundle\Entity\Skill;

class SkillHelper
{
    public static function getDmg(HeroSkill $heroSkill)
    {
        $skill = $heroSkill->getSkill();
        return $heroSkill->getHero()->getAtk() * (100 * $skill->getDmgModifier()) / 100 * self::getIsFail($skill);
    }

    public static function getIsFail(Skill $skill)
    {
        return mt_rand(0, 10) * ($skill->getFailModifier() - $skill->getResistantModifier()) > 50 ? 0 : 1;
    }
}