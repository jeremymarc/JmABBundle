<?php

namespace Jm\ABBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Jm\ABBundle\Entity\Template
 *
 * @ORM\Table(name="template",indexes={@index(name="search_name", columns={"name"})})
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
     * @var \DateTime $updateTime
     *
     * @ORM\Column(name="updateTime", type="datetime", nullable=true)
     */
    private $updateTime;

    /**
     * @var \DateTime $creationTime
     *
     * @ORM\Column(name="creationTime", type="datetime")
     */
    private $creationTime;

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

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @ORM\PrePersist
     */
    public function beforePersist()
    {
        $this->setCreationTime(new \DateTime());
        $this->setUpdateTime(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function beforeUpdate()
    {
        $this->setUpdateTime(new \DateTime());
    }
}
