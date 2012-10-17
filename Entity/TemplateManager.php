<?php

namespace Jm\ABBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
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

    public function findTemplateByName($name)
    {
        $template = $this->repository->findTemplateByName($name, $this->cacheTime);

        //todo: duplicate with TemplateLoader
        if (null !== $this->container->get('request')->get($this->container->getParameter('jm_ab.variation_parameter'))) {
            $template->setVariation(true);
        }

        return $template;

    }

    public function renderTemplate($templateName, $vars = array())
    {
        if (0 !== strpos($templateName, 'template:')) {
            $templateName = "template:$templateName";
        }
        return $this->container->get('twig')->render($templateName, $vars);
    }
}
