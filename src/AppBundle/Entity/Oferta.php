<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Oferta
 *
 * @ORM\Table(name="oferta")
 * @ORM\Entity
 */
class Oferta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tender_id", type="integer", nullable=false)
     */
    private $tenderId;

    /**
     * @var string
     *
     * @ORM\Column(name="pershkrimi", type="string", length=255, nullable=false)
     */
    private $pershkrimi;

    /**
     * @var float
     *
     * @ORM\Column(name="vlefta", type="float", precision=10, scale=0, nullable=false)
     */
    private $vlefta;

    /**
     * @var string
     *
     * @ORM\Column(name="adresa_dorezimit", type="string", length=255, nullable=false)
     */
    private $adresaDorezimit;

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
     * @ORM\Column(name="vendimi", type="string", length=255, nullable=false)
     */
    private $vendimi;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set tenderId
     *
     * @param integer $tenderId
     *
     * @return Oferta
     */
    public function setTenderId($tenderId)
    {
        $this->tenderId = $tenderId;

        return $this;
    }

    /**
     * Get tenderId
     *
     * @return integer
     */
    public function getTenderId()
    {
        return $this->tenderId;
    }

    /**
     * Set pershkrimi
     *
     * @param string $pershkrimi
     *
     * @return Oferta
     */
    public function setPershkrimi($pershkrimi)
    {
        $this->pershkrimi = $pershkrimi;

        return $this;
    }

    /**
     * Get pershkrimi
     *
     * @return string
     */
    public function getPershkrimi()
    {
        return $this->pershkrimi;
    }

    /**
     * Set vlefta
     *
     * @param float $vlefta
     *
     * @return Oferta
     */
    public function setVlefta($vlefta)
    {
        $this->vlefta = $vlefta;

        return $this;
    }

    /**
     * Get vlefta
     *
     * @return float
     */
    public function getVlefta()
    {
        return $this->vlefta;
    }

    /**
     * Set adresaDorezimit
     *
     * @param string $adresaDorezimit
     *
     * @return Oferta
     */
    public function setAdresaDorezimit($adresaDorezimit)
    {
        $this->adresaDorezimit = $adresaDorezimit;

        return $this;
    }

    /**
     * Get adresaDorezimit
     *
     * @return string
     */
    public function getAdresaDorezimit()
    {
        return $this->adresaDorezimit;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Oferta
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
     * @return Oferta
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
     * Set vendimi
     *
     * @param string $vendimi
     *
     * @return Oferta
     */
    public function setVendimi($vendimi)
    {
        $this->vendimi = $vendimi;

        return $this;
    }

    /**
     * Get vendimi
     *
     * @return string
     */
    public function getVendimi()
    {
        return $this->vendimi;
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
