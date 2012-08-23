<?php

namespace Jm\ABBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $abTwigLoader = $container->getDefinition('jm_ab.twig_loader');

        if (true === $container->getParameter('jm_ab.custom_loader')) {
            $container->setDefinition('twig.loader', $abTwigLoader);
        }
    }
}
