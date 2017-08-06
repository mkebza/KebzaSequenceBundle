<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 17:24
 */

namespace Kebza\SequenceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DoctrineSequence
 * @package Kebza\SequenceBundle\Entity
 * @ORM\Entity()
 * @ORM\Table(name="kebza_sequence")
 * @ORM\HasLifecycleCallbacks()
 */
class DoctrineSequence
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="sequence", type="string", length=200)
     */
    protected $key;

    /**
     * @ORM\Column(name="value", type="integer")
     */
    protected $current;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     * @return DoctrineSequence
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @param mixed $current
     * @return DoctrineSequence
     */
    public function setCurrent($current)
    {
        $this->current = $current;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     * @return DoctrineSequence
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preSaveUpdatedAt() {
        $this->updatedAt = new \DateTime('now');
    }
}