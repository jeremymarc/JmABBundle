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

    /**
     * @param string $name
     *
     * @return Template|null
     */
    public function getTemplate($name)
    {
        $name = trim($name);
        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        $template = $this->repository->findTemplateByName($name, $this->cacheTime);

        return $this->cache[$name] = $template;
    }

    /**
     * @param Template $template
     * @param array $vars
     *
     * @return string
     */
    public function renderTemplate(Template $template, $vars = array())
    {
        $vars['template'] = $template;

        return new \Twig_Markup(
            $this->container->get('twig')->render('JmABBundle::renderTemplate.html.twig', $vars),
            'UTF-8'
        );
    }
}
