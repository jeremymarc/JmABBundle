<?php
namespace Jm\ABBundle\Twig\Extension;

use Jm\ABBundle\Entity\Template;
use Jm\ABBundle\Entity\TemplateManager;

class AbExtension extends \Twig_Extension
{
    /**
     * @var TemplateManager
     */
    protected $templateManager;

    /**
     * @param TemplateManager $templateManager
     */
    public function __construct(TemplateManager $templateManager)
    {
        $this->templateManager = $templateManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        $templateManager = $this->templateManager;

        return array(
            new \Twig_SimpleFunction('ab_template', function($templateName) use ($templateManager) {
                return $templateManager->getTemplate($templateName);
            }),
            new \Twig_SimpleFunction('ab_render_template', function(Template $template) use ($templateManager) {
                return $templateManager->renderTemplate($template);
            }),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ab_template';
    }
}