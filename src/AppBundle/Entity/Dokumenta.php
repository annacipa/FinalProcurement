<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dokumenta
 *
 * @ORM\Table(name="dokumenta")
 * @ORM\Entity
 */
class Dokumenta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="tender_id", type="integer", nullable=true)
     */
    private $tenderId = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="oferta_id", type="integer", nullable=true)
     */
    private $ofertaId = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="titull_dokumenti", type="string", length=255, nullable=false)
     */
    private $titullDokumenti;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;

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
     * Set tenderId
     *
     * @param integer $tenderId
     *
     * @return Dokumenta
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
     * Set ofertaId
     *
     * @param integer $ofertaId
     *
     * @return Dokumenta
     */
    public function setOfertaId($ofertaId)
    {
        $this->ofertaId = $ofertaId;

        return $this;
    }

    /**
     * Get ofertaId
     *
     * @return integer
     */
    public function getOfertaId()
    {
        return $this->ofertaId;
    }

    /**
     * Set titullDokumenti
     *
     * @param string $titullDokumenti
     *
     * @return Dokumenta
     */
    public function setTitullDokumenti($titullDokumenti)
    {
        $this->titullDokumenti = $titullDokumenti;

        return $this;
    }

    /**
     * Get titullDokumenti
     *
     * @return string
     */
    public function getTitullDokumenti()
    {
        return $this->titullDokumenti;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Dokumenta
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Dokumenta
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
     * @return Dokumenta
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
