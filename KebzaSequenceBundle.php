<?php

namespace Kebza\SequenceBundle;

use Kebza\SequenceBundle\DependencyInjection\Compiler\RegisterReplacerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KebzaSequenceBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RegisterReplacerPass());
    }
}
