<?php
namespace RPGBundle\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CharacterPrototypeRegisterPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('character.factory')) {
            return;
        }
        $definition = $container->getDefinition(
            'character.factory'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'character.prototype'
        );

        foreach ($taggedServices as $serviceId => $tag) {
            $alias = $tag[0]['alias'] ?? $serviceId;

            $definition->addMethodCall(
                'registerPrototype',
                array(
                    new Reference($serviceId),
                    $alias
                )
            );
        }
    }

}