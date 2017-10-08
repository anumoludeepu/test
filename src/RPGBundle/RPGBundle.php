<?php

namespace RPGBundle;

use RPGBundle\Compiler\CharacterPrototypeRegisterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class RPGBundle
 */
class RPGBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CharacterPrototypeRegisterPass());
    }


}
