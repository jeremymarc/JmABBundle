<?php

namespace Jm\ABBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Jm\ABBundle\DependencyInjection\Compiler\TwigPass;

class JmABBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new TwigPass(), PassConfig::TYPE_REMOVE);
    }
}
