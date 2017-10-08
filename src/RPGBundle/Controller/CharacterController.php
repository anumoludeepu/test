<?php
namespace RPGBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use RPGBundle\Entity\HeroCharacter;
use RPGBundle\Event\FightEvent;
use RPGBundle\Form\HeroCharacterFormData;
use RPGBundle\Form\HeroCharacterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CharacterController extends FOSRestController
{

    /**
     * @Rest\View(templateVar="heroes", serializerEnableMaxDepthChecks=true)
     * @ApiDoc(
     *  resource=true,
     *  description="Get list of Heroes",
     *  output={
     *     "class"="array<RPGBundle\Entity\HeroCharacter>",
     *  },
     * statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned on error"
     *   }
     * )
     */
    public function getCharactersAction() {
        $heroes = $this->getHeroRepository()->findAll();
        return $heroes;
    }


    /**
     * @Rest\View(templateVar="hero", serializerEnableMaxDepthChecks=true)
     * @ApiDoc(
     *  resource=true,
     *  description="Get Hero info",
     *  output={
     *     "class"="RPGBundle\Entity\HeroCharacter",
     *  },
     * statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     */
    public function getCharacterAction($id) {
        $hero = $this->getHeroRepository()->find($id);
        if (!$hero) {
            throw new NotFoundHttpException('Hero not found');
        }
        return $hero;
    }


    /**
     * @param Request $request
     *
     * @Rest\View(templateVar="attribute", serializerEnableMaxDepthChecks=true, statusCode=201, serializerGroups={"api"})
     * @ApiDoc(
     *  description="Create new Hero",
     *  input="RPGBundle\Form\HeroCharacterType",
     *  output={
     *     "class"="RPGBundle\Entity\HeroCharacter"
     *  },
     *  resource=true,
     *  statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when post data has errors"
     *   }
     * )
     * @return View|null|\RPGBundle\Entity\CharacterInterface
     */
    public function postCharacterAction(Request $request)
    {
        $factory = $this->get('character.factory');
        $form = $this->createForm(HeroCharacterType::class, new HeroCharacterFormData(), ['factory' => $factory]);

        if (!$form->handleRequest($request)->isValid()) {
            return View::create($form, Response::HTTP_BAD_REQUEST);
        }

        $hero = $factory->create($form->get('type')->getData(), $form->get('name')->getData(),
                                 $form->get('password')->getData());

        return $hero;
    }

    /**
     * @Rest\View(templateVar="hero", serializerEnableMaxDepthChecks=true)
     * @ApiDoc(
     *  resource=true,
     *  description="Make fight of Hero vs Hero",
     *  output={
     *     "class"="RPGBundle\Entity\HeroCharacter",
     *  },
     * statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned on error"
     *   }
     * )
     * @param $character
     * @param $enemy
     * @return HeroCharacter
     */
    public function characterFightEnemyAction($character, $enemy)
    {
        $character = $this->getHeroRepository()->find($character);
        $enemy = $this->getHeroRepository()->find($enemy);

        $event = new FightEvent($character, $enemy);

        $this->get('event_dispatcher')->dispatch(FightEvent::ON_FIGHT_START, $event);

        return $event->getCharacter();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    private function getHeroRepository()
    {
        return $this->get('doctrine.orm.entity_manager')->getRepository(HeroCharacter::class);
    }

}