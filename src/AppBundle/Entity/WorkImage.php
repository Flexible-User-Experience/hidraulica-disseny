<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Traits\ImageTrait;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class WorkImage
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   Anton Serra <aserratorta@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkImageRepository")
 * @Vich\Uploadable
 */
class WorkImage extends AbstractBase
{
    use ImageTrait;

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
     * @return Work
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * @param Work $work
     * @return WorkImage
     */
    public function setWork(Work $work)
    {
        $this->work = $work;

        return $this;
    }
}