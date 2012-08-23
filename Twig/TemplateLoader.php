<?php

namespace Jm\ABBundle\Twig;

use Jm\ABBundle\Entity\Template;
use Jm\ABBundle\Entity\TemplateManager;
use Symfony\Component\HttpFoundation\Request;

class TemplateLoader implements \Twig_LoaderInterface
{
	private $manager;
	private $request;
    private $variationParameter;

    public function __construct(TemplateManager $manager, $variationParameter)
    {
		$this->manager = $manager;
        $this->request = Request::createFromGlobals();
        $this->variationParameter = $variationParameter;
	}

    /**
     * Gets the source code of a template, given its name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The template source code
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getSource($name)
    {
        $name = $this->parse($name);
        $template = $this->getTemplate($name);
        $source = $this->getTemplateVariation($template);

        return $source;
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The cache key
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getCacheKey($fullName)
    {
        $name = $this->parse($fullName);
        $template = $this->getTemplate($name);

        return
            __CLASS__
            . '#' . $name
			. '#' . $this->request->get($this->variationParameter) === null ? 'A' : 'B'
            // force reload even if Twig has autoReload to false
			. '#' . $template->getUpdateTime()->getTimestamp()
			;
	}

    /**
     * Returns true if the template is still fresh.
     *
     * @param string    $name The template name
     * @param timestamp $time The last modification time of the cached template
     *
     * @return Boolean true if the template is fresh, false otherwise
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function isFresh($name, $time)
    {
        $name = $this->parse($name);
        $template = $this->getTemplate($name);

        return $template->getUpdateTime()->getTimestamp() <= $time;
	}

    private function canHandle($name)
    {
        return 0 === strpos($name, 'template:');
	}

	private function parse($name)
	{
		if (!preg_match('#^template:(.*)$#', $name, $m)) {
			throw new \Twig_Error_Loader(sprintf("Unable to find template %s", $name));
		}

		return $m[1];
	}

	private function getTemplate($name)
	{
		if (!$template = $this->manager->getTemplate($name)) {
			throw new \Twig_Error_Loader(sprintf("Unable to find template %s", $name));
		}

		return $template;
	}

	private function getTemplateVariation(Template $template)
	{
		$content = $template->getBody();
		if (null !== $this->request->get($this->variationParameter)) {
			$content = $template->getVariationBody();
		}

		return $content;
	}
}
