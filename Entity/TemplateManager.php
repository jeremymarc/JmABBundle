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

	public function __construct(EntityManager $em, $class, ContainerInterface $container)
	{
		$this->em         = $em;
		$this->repository = $em->getRepository($class);
		$this->class      = $class;
        $this->container  = $container;

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
        return $this->repository->findOneBy(array('name' => $name));
    }

	public function renderTemplate($templateName, $vars)
	{
        if (0 === strpos($name, 'template:')) {
            $name = "template:$templateName";
        }
		return $this->container->get('twig.loader')->render($templateName, $vars);
	}
}
