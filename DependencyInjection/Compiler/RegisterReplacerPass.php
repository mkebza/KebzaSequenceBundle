<?php

namespace Kebza\SequenceBundle\DependencyInjection\Compiler;

use Kebza\SequenceBundle\Sequence\Replacer\ReplacerRegistry;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class RegisterReplacerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $registry = $container->getDefinition(ReplacerRegistry::class);

        $services = $container->findTaggedServiceIds('kebza.sequence.replacer');
        foreach ($services as $id => $definition) {
            $registry->addMethodCall('add', [new Reference($id)]);
        }
    }
}
