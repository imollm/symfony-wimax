<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Antenna
 *
 * @ORM\Table(name="antenna", uniqueConstraints={@ORM\UniqueConstraint(name="wlan_mac_UNIQUE", columns={"wlan_mac"}), @ORM\UniqueConstraint(name="UNIQ_17B46F653EA3F4B", columns={"ip"}), @ORM\UniqueConstraint(name="UNIQ_17B46F64FECC1BF", columns={"lan_mac"})}, indexes={@ORM\Index(name="IDX_17B46F6A76ED395", columns={"user_id"})})
 * @ORM\Entity
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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="wlan_mac", type="string", length=17, nullable=false)
     */
    private $wlanMac;

    /**
     * @var string
     *
     * @ORM\Column(name="lan_mac", type="string", length=17, nullable=false)
     */
    private $lanMac;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip", type="string", length=15, nullable=true)
     */
    private $ip;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude", type="string", length=20, nullable=true)
     */
    private $latitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitude", type="string", length=20, nullable=true)
     */
    private $longitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}
