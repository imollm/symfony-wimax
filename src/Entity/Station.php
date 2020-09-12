<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Station
 *
 * @ORM\Table(name="stations", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_9F39F8B1B6FC8A64", columns={"antenna_id"})}, indexes={@ORM\Index(name="IDX_9F39F8B1904F155E", columns={"ap_id"})})
 * @ORM\Entity
 */
class Station
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Ap
     *
     * @ORM\ManyToOne(targetEntity="Ap")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ap_id", referencedColumnName="id")
     * })
     */
    private $ap;

    /**
     * @var \Antenna
     *
     * @ORM\ManyToOne(targetEntity=Antenna::class, inversedBy="id")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="antenna_id", referencedColumnName="id")
     * })
     */
    private $antenna;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAp(): ?Ap
    {
        return $this->ap;
    }

    public function setAp(?Ap $ap): self
    {
        $this->ap = $ap;

        return $this;
    }

    public function getAntenna(): ?Antenna
    {
        return $this->antenna;
    }

    public function setAntenna(?Antenna $antenna): self
    {
        $this->antenna = $antenna;

        return $this;
    }


}
