<?php

namespace Jm\ABBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $twig = $container->getDefinition('twig');
        $abTwigLoader = $container->getDefinition('jm_ab.twig_loader');

        if (true === $container->getParameter('jm_ab.custom_loader')) {
            $abTwigLoader->replaceArgument(0, $twig);
            $container->setDefinition('twig', $abTwigLoader);
        }
    }
}
