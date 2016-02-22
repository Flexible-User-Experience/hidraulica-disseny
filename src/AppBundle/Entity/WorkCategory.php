<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\TitleTrait;
use AppBundle\Entity\Traits\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class WorkCategory
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   Anton Serra <aserratorta@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkCategoryRepository")
 */
class WorkCategory extends AbstractBase
{
    use TitleTrait;
    use SlugTrait;

    /**
     * @ORM\OneToMany(targetEntity="Work", mappedBy="workCategory")
     */
    private $works;

    public function __construct() {
        $this->works = new ArrayCollection();
    }

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * @return mixed
     */
    public function getWorks()
    {
        return $this->works;
    }

    /**
     * @param mixed $works
     * @return WorkCategory
     */
    public function setWorks($works)
    {
        $this->works = $works;

        return $this;
    }
}