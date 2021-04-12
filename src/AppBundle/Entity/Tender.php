<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tender
 *
 * @ORM\Table(name="tender")
 * @ORM\Entity
 */
class Tender
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
     * @ORM\Column(name="titull_thirrje", type="string", length=255, nullable=false)
     */
    private $titullThirrje;

    /**
     * @var string
     *
     * @ORM\Column(name="pershkrim", type="string", length=255, nullable=false)
     */
    private $pershkrim;

    /**
     * @var float
     *
     * @ORM\Column(name="fond_limit", type="float", precision=10, scale=0, nullable=false)
     */
    private $fondLimit;

    /**
     * @var string
     *
     * @ORM\Column(name="adresa_dorezimit", type="string", length=255, nullable=false)
     */
    private $adresaDorezimit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_fillimit", type="datetime", nullable=false)
     */
    private $dataFillimit;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_perfundimit", type="datetime", nullable=false)
     */
    private $dataPerfundimit;

    /**
     * @var string
     *
     * @ORM\Column(name="licenca", type="string", length=255, nullable=true)
     */
    private $licenca = 'NULL';

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
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="emer_statusi", type="string", length=255, nullable=false)
     */
    private $emerStatusi;

    /**
     * @var integer
     *
     * @ORM\Column(name="fushe_operimi_id", type="integer", nullable=false)
     */
    private $fusheOperimiId;

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
     * @return Tender
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
     * Set titullThirrje
     *
     * @param string $titullThirrje
     *
     * @return Tender
     */
    public function setTitullThirrje($titullThirrje)
    {
        $this->titullThirrje = $titullThirrje;

        return $this;
    }

    /**
     * Get titullThirrje
     *
     * @return string
     */
    public function getTitullThirrje()
    {
        return $this->titullThirrje;
    }

    /**
     * Set pershkrim
     *
     * @param string $pershkrim
     *
     * @return Tender
     */
    public function setPershkrim($pershkrim)
    {
        $this->pershkrim = $pershkrim;

        return $this;
    }

    /**
     * Get pershkrim
     *
     * @return string
     */
    public function getPershkrim()
    {
        return $this->pershkrim;
    }

    /**
     * Set fondLimit
     *
     * @param float $fondLimit
     *
     * @return Tender
     */
    public function setFondLimit($fondLimit)
    {
        $this->fondLimit = $fondLimit;

        return $this;
    }

    /**
     * Get fondLimit
     *
     * @return float
     */
    public function getFondLimit()
    {
        return $this->fondLimit;
    }

    /**
     * Set adresaDorezimit
     *
     * @param string $adresaDorezimit
     *
     * @return Tender
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
     * Set dataFillimit
     *
     * @param \DateTime $dataFillimit
     *
     * @return Tender
     */
    public function setDataFillimit($dataFillimit)
    {
        $this->dataFillimit = $dataFillimit;

        return $this;
    }

    /**
     * Get dataFillimit
     *
     * @return \DateTime
     */
    public function getDataFillimit()
    {
        return $this->dataFillimit;
    }

    /**
     * Set dataPerfundimit
     *
     * @param \DateTime $dataPerfundimit
     *
     * @return Tender
     */
    public function setDataPerfundimit($dataPerfundimit)
    {
        $this->dataPerfundimit = $dataPerfundimit;

        return $this;
    }

    /**
     * Get dataPerfundimit
     *
     * @return \DateTime
     */
    public function getDataPerfundimit()
    {
        return $this->dataPerfundimit;
    }

    /**
     * Set licenca
     *
     * @param string $licenca
     *
     * @return Tender
     */
    public function setLicenca($licenca)
    {
        $this->licenca = $licenca;

        return $this;
    }

    /**
     * Get licenca
     *
     * @return string
     */
    public function getLicenca()
    {
        return $this->licenca;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Tender
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
     * @return Tender
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
     * Set status
     *
     * @param string $status
     *
     * @return Tender
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set emerStatusi
     *
     * @param string $emerStatusi
     *
     * @return Tender
     */
    public function setEmerStatusi($emerStatusi)
    {
        $this->emerStatusi = $emerStatusi;

        return $this;
    }

    /**
     * Get emerStatusi
     *
     * @return string
     */
    public function getEmerStatusi()
    {
        return $this->emerStatusi;
    }

    /**
     * Set fusheOperimiId
     *
     * @param integer $fusheOperimiId
     *
     * @return Tender
     */
    public function setFusheOperimiId($fusheOperimiId)
    {
        $this->fusheOperimiId = $fusheOperimiId;

        return $this;
    }

    /**
     * Get fusheOperimiId
     *
     * @return integer
     */
    public function getFusheOperimiId()
    {
        return $this->fusheOperimiId;
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
