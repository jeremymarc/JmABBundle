<?php

namespace Jm\ABBundle\Entity;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TemplateManager
{
    protected $em;
    protected $class;
    protected $repository;
    protected $container;
    protected $cache;
    protected $cacheTime;

    public function __construct(EntityManager $em, $class, ContainerInterface $container, $cacheTime)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository($class);
        $this->class      = $class;
        $this->container  = $container;
        $this->cacheTime  = $cacheTime;

        $this->cache      = array();
    }

    public function getTemplate($name)
    {
        $name = trim($name);
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        $template = $this->findTemplateByName($name);

        return $this->cache[$name] = $template;
    }

    public function renderTemplate($templateName, $vars = array())
    {
        if (0 !== strpos($templateName, 'template:')) {
            $templateName = "template:$templateName";
        }
        return $this->container->get('twig')->render($templateName, $vars);
    }

    /*
     * Do not call findTemplateByName directly
     * Use getTemplate instead as it's adding a cache support
     */
    protected function findTemplateByName($name)
    {
        return $this->repository->findTemplateByName($name, $this->cacheTime);
    }
}
