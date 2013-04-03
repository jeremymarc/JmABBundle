<?php

namespace Twig;

use Jm\ABBundle\Twig\TemplateLoader;
use Jm\ABBundle\Entity\Template;

class TemplateLoaderTest extends \PHPUnit_Framework_TestCase
{
    protected $templateLoader;
    protected $container;

    protected function setUp()
    {
       $this->container = $this->getContainer(); 
       $this->templateLoader = $this->getTemplateLoader($this->container);
    }

    /**
     * @expectedException Twig_Error_Loader
     */
    public function shouldGenerateTwigErrorLoaderException()
    {
        $name = 'invalide-template-name';
        $this->templateLoader->getSource($name);
    }

    public function testGetSource()
    {
        $name = 'template:valid';
        $variationParameter = 'b';

        $manager = $this->getTemplateManager();
        $request = $this->getRequest();

        $template = new Template;
        $template->setName('test')
            ->setBody('body1')
            ->setVariationBody('body2');

        $request->expects($this->once())
            ->method('get')
            ->with($variationParameter)
            ->will($this->returnValue(null))
        ;

        $this->container->expects($this->once())
            ->method('getParameter')
            ->with('jm_ab.variation_parameter')
            ->will($this->returnValue($variationParameter))
        ;
            
        $this->container->expects($this->exactly(2))
            ->method('get')
            ->with($this->logicalOr(
                $this->equalTo('jm_ab.template_manager'),
                $this->equalTo('request')
            ))
            ->will($this->returnCallback(
                function($param) use ($manager, $request) {
                    if ('jm_ab.template_manager' == $param) {
                        return $manager;
                    }

                    return $request;
                })
            )
        ;

        $manager->expects($this->once())
            ->method('getTemplate')
            ->with('valid')
            ->will($this->returnValue($template))
        ;

        $content = $this->templateLoader->getSource($name);
        $this->assertEquals($content, $template->getBody());
    }

    public function testGetSourceWithVariationBody()
    {
        $name = 'template:valid';
        $variationParameter = 'b';

        $manager = $this->getTemplateManager();
        $request = $this->getRequest();

        $template = new Template;
        $template->setName('test')
            ->setBody('body1')
            ->setVariationBody('body2');

        $request->expects($this->once())
            ->method('get')
            ->with($variationParameter)
            ->will($this->returnValue(1))
        ;

        $this->container->expects($this->once())
            ->method('getParameter')
            ->with('jm_ab.variation_parameter')
            ->will($this->returnValue($variationParameter))
        ;
            
        $this->container->expects($this->exactly(2))
            ->method('get')
            ->with($this->logicalOr(
                $this->equalTo('jm_ab.template_manager'),
                $this->equalTo('request')
            ))
            ->will($this->returnCallback(
                function($param) use ($manager, $request) {
                    if ('jm_ab.template_manager' == $param) {
                        return $manager;
                    }

                    return $request;
                })
            )
        ;

        $manager->expects($this->once())
            ->method('getTemplate')
            ->with('valid')
            ->will($this->returnValue($template))
        ;

        $content = $this->templateLoader->getSource($name);
        $this->assertEquals($content, $template->getVariationBody());
    }

    public function testGetCacheKey()
    {
        $name = 'test';
        $variationParameter = 'b';
        $manager = $this->getTemplateManager();
        $now = new \DateTime();

        $template = new Template;
        $template->setUpdatedAt($now);

        $request = $this->getRequest();
        $request->expects($this->once())
            ->method('get')
            ->with($variationParameter)
            ->will($this->returnValue(1))
        ;

        $this->container->expects($this->once())
            ->method('getParameter')
            ->with('jm_ab.variation_parameter')
            ->will($this->returnValue($variationParameter))
        ;
        $this->container->expects($this->exactly(2))
            ->method('get')
            ->with($this->logicalOr(
                $this->equalTo('jm_ab.template_manager'),
                $this->equalTo('request')
            ))
            ->will($this->returnCallback(
                function($param) use ($manager, $request) {
                    if ('jm_ab.template_manager' == $param) {
                        return $manager;
                    }

                    return $request;
                })
            )
        ;
        $manager->expects($this->once())
            ->method('getTemplate')
            ->with($name)
            ->will($this->returnValue($template))
        ;

        $loader = $this->getTemplateLoader($this->container);
        $key = $loader->getCacheKey('template:'. $name);
        $expectedKey = 'Jm\ABBundle\Twig\TemplateLoader#test#B#' . $template->getUpdatedAt()->getTimestamp();

        $this->assertEquals($key, $expectedKey);
    }

    public function testIsFresh()
    {
        $name = 'test';
        $now = new \DateTime();
        $yesterday = new \DateTime(); //template update cached version is from yesterday
        $yesterday->modify('- 1 day');

        $template = new Template();
        $template->setUpdatedAt($now); //we've just modified the template

        $manager = $this->getTemplateManager();
        $manager->expects($this->once())
            ->method('getTemplate')
            ->with($name)
            ->will($this->returnValue($template))
        ;

        $this->container->expects($this->once())
            ->method('get')
            ->with('jm_ab.template_manager')
            ->will($this->returnValue($manager))
        ;

        $loader = $this->getTemplateLoader($this->container);
        $isFresh = $loader->isFresh('template:' . $name, $yesterday->getTimestamp());
        $this->assertFalse($isFresh);
    }

    private function getTemplateLoader($container)
    {
        return new TemplateLoader($container);
    }

    private function getTemplateManager()
    {
        return $this
                ->getMockBuilder('Jm\ABBundle\Entity\TemplateManager')
                ->disableOriginalConstructor()
                ->getMock()
                ;
    }

    private function getContainer()
    {
        return $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
    }

    public function getRequest()
    {
        return $this->getMock('Symfony\Component\HttpFoundation\Request');
    }
}
