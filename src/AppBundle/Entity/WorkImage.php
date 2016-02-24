<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class WorkImage
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   Anton Serra <aserratorta@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkImageRepository")
 */
class WorkImage extends AbstractBase
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
     * @var Work
     *
     * @ORM\ManyToOne(targetEntity="Work", inversedBy="workImages")
     * @ORM\JoinColumn(name="work_id", referencedColumnName="id")
     */
    private $work;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     * @return WorkImage
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @param string $alt
     * @return WorkImage
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     * @return WorkImage
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Work
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * @param $work
     * @return WorkImage
     */
    public function setWork(Work $work)
    {
        $this->work = $work;

        return $this;
    }
}