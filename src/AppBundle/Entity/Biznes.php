<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Biznes
 *
 * @ORM\Table(name="biznes")
 * @ORM\Entity
 */
class Biznes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="role_id", type="integer", nullable=false)
     */
    private $roleId;

    /**
     * @var string
     *
     * @ORM\Column(name="emer_biznesi", type="string", length=255, nullable=false)
     */
    private $emerBiznesi;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="nipt", type="string", length=25, nullable=false)
     */
    private $nipt;

    /**
     * @var string
     *
     * @ORM\Column(name="adresa", type="string", length=255, nullable=false)
     */
    private $adresa;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=false)
     */
    private $logo;

    /**
     * @var integer
     *
     * @ORM\Column(name="numer_telefoni", type="integer", nullable=false)
     */
    private $numerTelefoni;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aktiv", type="boolean", nullable=false)
     */
    private $aktiv;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     */
    private $isDeleted;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paguar", type="boolean", nullable=false)
     */
    private $paguar;

    /**
     * @var integer
     *
     * @ORM\Column(name="createdBy", type="integer", nullable=true)
     */
    private $createdby = 'NULL';

    /**
     * @var integer
     *
     * @ORM\Column(name="fushe_operimi_id", type="integer", nullable=false)
     */
    private $fusheOperimiId;
    /**
     * @var string
     *
     * @ORM\Column(name="bashkia", type="string", length=255, nullable=false)
     */
    private $bashkia;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return int
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param int $roleId
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * @return string
     */
    public function getEmerBiznesi()
    {
        return $this->emerBiznesi;
    }

    /**
     * @param string $emerBiznesi
     */
    public function setEmerBiznesi($emerBiznesi)
    {
        $this->emerBiznesi = $emerBiznesi;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getNipt()
    {
        return $this->nipt;
    }

    /**
     * @param string $nipt
     */
    public function setNipt($nipt)
    {
        $this->nipt = $nipt;
    }

    /**
     * @return string
     */
    public function getAdresa()
    {
        return $this->adresa;
    }

    /**
     * @param string $adresa
     */
    public function setAdresa($adresa)
    {
        $this->adresa = $adresa;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return int
     */
    public function getNumerTelefoni()
    {
        return $this->numerTelefoni;
    }

    /**
     * @param int $numerTelefoni
     */
    public function setNumerTelefoni($numerTelefoni)
    {
        $this->numerTelefoni = $numerTelefoni;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function isAktiv()
    {
        return $this->aktiv;
    }

    /**
     * @param bool $aktiv
     */
    public function setAktiv($aktiv)
    {
        $this->aktiv = $aktiv;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @return bool
     */
    public function isPaguar()
    {
        return $this->paguar;
    }

    /**
     * @param bool $paguar
     */
    public function setPaguar($paguar)
    {
        $this->paguar = $paguar;
    }

    /**
     * @return int
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * @param int $createdby
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;
    }

    /**
     * @return int
     */
    public function getFusheOperimiId()
    {
        return $this->fusheOperimiId;
    }

    /**
     * @param int $fusheOperimiId
     */
    public function setFusheOperimiId($fusheOperimiId)
    {
        $this->fusheOperimiId = $fusheOperimiId;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getBashkia()
    {
        return $this->bashkia;
    }

    /**
     * @param string $bashkia
     */
    public function setBashkia($bashkia)
    {
        $this->bashkia = $bashkia;
    }


}

