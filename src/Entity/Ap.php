<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ap
 *
 * @ORM\Table(name="ap", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_6D3A3925B6FC8A64", columns={"antenna_id"}), @ORM\UniqueConstraint(name="UNIQ_6D3A392535C246D5", columns={"password"})})
 * @ORM\Entity
 */
class Ap
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
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="frequency", type="string", length=4, nullable=true)
     */
    private $frequency;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bandwith", type="string", length=2, nullable=true)
     */
    private $bandwith;

    /**
     * @var \Antenna
     *
     * @ORM\ManyToOne(targetEntity="Antenna")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="antenna_id", referencedColumnName="id")
     * })
     */
    private $antenna;


}
