<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FushaOperimi
 *
 * @ORM\Table(name="fusha_operimi")
 * @ORM\Entity
 */
class FushaOperimi
{
    /**
     * @var string
     *
     * @ORM\Column(name="emer_fushe_operimi", type="string", length=255, nullable=false)
     */
    private $emerFusheOperimi;

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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set emerFusheOperimi
     *
     * @param string $emerFusheOperimi
     *
     * @return FushaOperimi
     */
    public function setEmerFusheOperimi($emerFusheOperimi)
    {
        $this->emerFusheOperimi = $emerFusheOperimi;

        return $this;
    }

    /**
     * Get emerFusheOperimi
     *
     * @return string
     */
    public function getEmerFusheOperimi()
    {
        return $this->emerFusheOperimi;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return FushaOperimi
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
     * @return FushaOperimi
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
