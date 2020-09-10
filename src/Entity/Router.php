<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Router
 *
 * @ORM\Table(name="routers", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_45D2F22521BDB235", columns={"station_id"}), @ORM\UniqueConstraint(name="UNIQ_45D2F225D374C9DC", columns={"serial"})})
 * @ORM\Entity
 */
class Router
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
     * @var string|null
     *
     * @ORM\Column(name="ssid", type="string", length=255, nullable=true)
     */
    private $ssid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=true)
     */
    private $ip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="serial", type="string", length=255, nullable=true)
     */
    private $serial;

    /**
     * @var \Station
     *
     * @ORM\ManyToOne(targetEntity="Station")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="station_id", referencedColumnName="id")
     * })
     */
    private $station;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSsid(): ?string
    {
        return $this->ssid;
    }

    public function setSsid(?string $ssid): self
    {
        $this->ssid = $ssid;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getSerial(): ?string
    {
        return $this->serial;
    }

    public function setSerial(?string $serial): self
    {
        $this->serial = $serial;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        $this->station = $station;

        return $this;
    }


}
