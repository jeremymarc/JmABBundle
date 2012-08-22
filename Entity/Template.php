<?php

namespace Jm\ABBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Jm\ABBundle\Entity\Template
 *
 * @ORM\Table(name="template")
 * @ORM\Entity(repositoryClass="Jm\ABBundle\Entity\TemplateRepository")
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
     * @ORM\Column(name="name", type="string", length=255)
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
     * @ORM\Column(name="variation", type="text")
     */
    private $variationBody;

    /**
     * @var boolean $enabled
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var \DateTime $updateTime
     *
     * Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updateTime", type="datetime", nullable=true)
     */
    private $updateTime;

    /**
     * @var \DateTime $creationTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="creationTime", type="datetime")
     */
    private $creationTime;

    public function __construct()
    {
        $this->updateTime = new Date();
    }

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
     * Set enabled
     *
     * @param boolean $enabled
     * @return Page
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
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
     * Set creationTime
     *
     * @param \DateTime $creationTime
     * @return Page
     */
    public function setCreationTime($creationTime)
    {
        $this->creationTime = $creationTime;

        return $this;
    }

    /**
     * Get creationTime
     *
     * @return \DateTime
     */
    public function getCreationTime()
    {
        return $this->creationTime;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     * @return Page
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }
}
