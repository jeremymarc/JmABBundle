<?php

namespace Jm\ABBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jm\ABBundle\Entity\Template
 *
 * @ORM\Table(
 *  indexes={@ORM\Index(name="name", columns={"name"})}
 * )
 * @ORM\Entity(repositoryClass="Jm\ABBundle\Entity\TemplateRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Template
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", unique=true, type="string", length=255)
     */
    private $name;

    /**
     * @var string $body
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     *
     * @ORM\Column(name="variation", type="text", nullable=true)
     */
    private $variationBody;


    /**
     * @var string $experimentCode
     *
     * @ORM\Column(name="experimentCode", type="string", length=15, nullable=true)
     */
    private $experimentCode;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Page
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return Page
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get variationBody.
     *
     * @return variationBody.
     */
    public function getVariationBody()
    {
        return $this->variationBody;
    }

    /**
     * Set variationBody.
     *
     * @param variationBody the value to set.
     */
    public function setVariationBody($variationBody)
    {
        $this->variationBody = $variationBody;
    }

    /**
     * Get experimentCode.
     *
     * @return experimentCode.
     */
    public function getExperimentCode()
    {
        return $this->experimentCode;
    }

    /**
     * Set experimentCode.
     *
     * @param experimentCode the value to set.
     */
    public function setExperimentCode($experimentCode)
    {
        $this->experimentCode = $experimentCode;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return DateTime
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get creationAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return DateTime
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function __toString()
    {
        return $this->getName() ?: '';
    }

    /**
     * @ORM\PrePersist
     */
    public function beforePersist()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function beforeUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    public function getAnalyticsScript()
    {
        if (null === $this->getExperimentCode() || strlen($this->getExperimentCode()) < 5) {
            return;
        }

        $template = <<<EOF
<!-- Google Analytics Content Experiment code -->
<script>function utmx_section(){}function utmx(){}(function(){var
k='%EXPERIMENT_CODE%',d=document,l=d.location,c=d.cookie;
if(l.search.indexOf('utm_expid='+k)>0)return;
function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
'<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':
'://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
'&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
'" type="text/javascript" charset="utf-8"><\/sc'+'ript>')})();
</script><script>utmx('url','A/B');</script>
<!-- End of Google Analytics Content Experiment code -->
EOF;
        return str_replace('%EXPERIMENT_CODE%', $this->getExperimentCode(), $template);
    }

    protected function isValidBody($body)
    {
        return (null !== $body && strlen(trim($body)) > 0);
    }
}
