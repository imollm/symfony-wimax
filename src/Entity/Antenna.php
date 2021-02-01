<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Antenna
 *
 * @ORM\Entity(repositoryClass="App\Repository\AntennaRepository")
 * @ORM\Table(name="antennas", uniqueConstraints={@ORM\UniqueConstraint(name="wlan_mac_UNIQUE", columns={"wlan_mac"}), @ORM\UniqueConstraint(name="UNIQ_17B46F653EA3F4B", columns={"ip"}), @ORM\UniqueConstraint(name="UNIQ_17B46F64FECC1BF", columns={"lan_mac"})}, indexes={@ORM\Index(name="IDX_17B46F6A76ED395", columns={"user_id"})})
 */
class Antenna
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="wlan_mac", type="string", length=17, nullable=false)
     */
    private string $wlanMac;

    /**
     * @var string
     *
     * @ORM\Column(name="lan_mac", type="string", length=17, nullable=false)
     */
    private string $lanMac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=true)
     */
    private ?string $ip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude", type="string", length=20, nullable=true)
     */
    private ?string $latitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitude", type="string", length=20, nullable=true)
     */
    private ?string $longitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="model", type="string", length=100, nullable=true)
     */
    private ?string $model;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private ?string $name;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private DateTime $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private DateTime $updatedAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="antennas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var Ap
     * 
     * @ORM\OneToMany(targetEntity=Ap::class, mappedBy="antenna")
     */
    private $ap;

    /**
     * @var Station
     * 
     * @ORM\OneToMany(targetEntity=Station::class, mappedBy="antenna")
     */
    private $station;

    public function __construct()
    {
        $this->ap = new ArrayCollection();
        $this->station = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWlanMac(): ?string
    {
        return $this->wlanMac;
    }

    public function setWlanMac(string $wlanMac): self
    {
        $this->wlanMac = $wlanMac;

        return $this;
    }

    public function getLanMac(): ?string
    {
        return $this->lanMac;
    }

    public function setLanMac(string $lanMac): self
    {
        $this->lanMac = $lanMac;

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

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAp()
    {
        return $this->ap;
    }

    public function getStation()
    {
        return $this->station;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function addAp(Ap $ap): self
    {
        if (!$this->ap->contains($ap)) {
            $this->ap[] = $ap;
            $ap->setAntenna($this);
        }

        return $this;
    }

    public function removeAp(Ap $ap): self
    {
        if ($this->ap->contains($ap)) {
            $this->ap->removeElement($ap);
            // set the owning side to null (unless already changed)
            if ($ap->getAntenna() === $this) {
                $ap->setAntenna(null);
            }
        }

        return $this;
    }

    public function addStation(Station $station): self
    {
        if (!$this->station->contains($station)) {
            $this->station[] = $station;
            $station->setAntenna($this);
        }

        return $this;
    }

    public function removeStation(Station $station): self
    {
        if ($this->station->contains($station)) {
            $this->station->removeElement($station);
            // set the owning side to null (unless already changed)
            if ($station->getAntenna() === $this) {
                $station->setAntenna(null);
            }
        }

        return $this;
    }

}
