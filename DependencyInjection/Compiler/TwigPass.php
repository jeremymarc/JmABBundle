<?php

namespace Jm\ABBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->getParameter('jm_ab.custom_loader')) {
            $loader = $container->getDefinition('twig.loader');

            $class = $loader->getClass();
            if (preg_match("/%(.*)%/", $class, $m)) {
                $class = $container->getParameter($m[1]);
            }

            if ("Twig\Loader\Chain" === $class) {
                $loader->addMethodCall('addLoader', array($container->getDefinition('jm_ab.template_loader')));
                return;
            }

            $abTwigLoader = $container->getDefinition('jm_ab.twig_loader');
            $abTwigLoader->addMethodCall('addLoader', array($loader));
            $container->setDefinition('twig.loader', $abTwigLoader);
        }
    }
}
