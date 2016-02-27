<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image trait
 *
 * @category Trait
 * @package  AppBundle\Entity\Traits
 * @author   Anton Serra <aserratorta@gmail.com>
 */
Trait ImageTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $imageName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $alt;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $position = 1;

    /**
     * Get ImageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set ImageName
     *
     * @param string $imageName
     * @return ImageTrait
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get Alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return ImageTrait
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get Position
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set Position
     *
     * @param int $position
     * @return ImageTrait
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }
}
