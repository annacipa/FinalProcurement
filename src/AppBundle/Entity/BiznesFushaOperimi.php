<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BiznesFushaOperimi
 *
 * @ORM\Table(name="biznes_fusha_operimi", indexes={@ORM\Index(name="IDX_A648114F8B3BE709", columns={"fusha_operimi_id"}), @ORM\Index(name="IDX_A648114F90860C3E", columns={"biznes_id"})})
 * @ORM\Entity
 */
class BiznesFushaOperimi
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\FushaOperimi
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FushaOperimi")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fusha_operimi_id", referencedColumnName="id")
     * })
     */
    private $fushaOperimi;

    /**
     * @var \AppBundle\Entity\Biznes
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Biznes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="biznes_id", referencedColumnName="id")
     * })
     */
    private $biznes;



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
     * Set fushaOperimi
     *
     * @param \AppBundle\Entity\FushaOperimi $fushaOperimi
     *
     * @return BiznesFushaOperimi
     */
    public function setFushaOperimi(\AppBundle\Entity\FushaOperimi $fushaOperimi = null)
    {
        $this->fushaOperimi = $fushaOperimi;

        return $this;
    }

    /**
     * Get fushaOperimi
     *
     * @return \AppBundle\Entity\FushaOperimi
     */
    public function getFushaOperimi()
    {
        return $this->fushaOperimi;
    }

    /**
     * Set biznes
     *
     * @param \AppBundle\Entity\Biznes $biznes
     *
     * @return BiznesFushaOperimi
     */
    public function setBiznes(\AppBundle\Entity\Biznes $biznes = null)
    {
        $this->biznes = $biznes;

        return $this;
    }

    /**
     * Get biznes
     *
     * @return \AppBundle\Entity\Biznes
     */
    public function getBiznes()
    {
        return $this->biznes;
    }
}
