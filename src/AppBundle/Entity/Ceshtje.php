<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ceshtje
 *
 * @ORM\Table(name="ceshtje")
 * @ORM\Entity
 */
class Ceshtje
{
    /**
     * @var integer
     *
     * @ORM\Column(name="biznes_id", type="integer", nullable=false)
     */
    private $biznesId;

    /**
     * @var string
     *
     * @ORM\Column(name="problematika", type="string", length=255, nullable=false)
     */
    private $problematika;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     */
    private $isDeleted;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", nullable=false)
     */
    private $createdBy;

    /**
     * @var string
     *
     * @ORM\Column(name="statusi_ceshtjes", type="string", length=255, nullable=false)
     */
    private $statusiCeshtjes;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set biznesId
     *
     * @param integer $biznesId
     *
     * @return Ceshtje
     */
    public function setBiznesId($biznesId)
    {
        $this->biznesId = $biznesId;

        return $this;
    }

    /**
     * Get biznesId
     *
     * @return integer
     */
    public function getBiznesId()
    {
        return $this->biznesId;
    }

    /**
     * Set problematika
     *
     * @param string $problematika
     *
     * @return Ceshtje
     */
    public function setProblematika($problematika)
    {
        $this->problematika = $problematika;

        return $this;
    }

    /**
     * Get problematika
     *
     * @return string
     */
    public function getProblematika()
    {
        return $this->problematika;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Ceshtje
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set createdBy
     *
     * @param integer $createdBy
     *
     * @return Ceshtje
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return integer
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set statusiCeshtjes
     *
     * @param string $statusiCeshtjes
     *
     * @return Ceshtje
     */
    public function setStatusiCeshtjes($statusiCeshtjes)
    {
        $this->statusiCeshtjes = $statusiCeshtjes;

        return $this;
    }

    /**
     * Get statusiCeshtjes
     *
     * @return string
     */
    public function getStatusiCeshtjes()
    {
        return $this->statusiCeshtjes;
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
}
