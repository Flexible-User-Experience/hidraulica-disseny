<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\TitleTrait;
use AppBundle\Entity\Traits\SlugTrait;
use AppBundle\Entity\Traits\TranslationsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class WorkCategory
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   Anton Serra <aserratorta@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkCategoryRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\WorkCategoryTranslation")
 */
class WorkCategory extends AbstractBase
{
    use TitleTrait;
    use SlugTrait;
    use TranslationsTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Work", mappedBy="workCategory")
     */
    private $works;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Translation\WorkCategoryTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     * @Assert\Valid(deep = true)
     * @var ArrayCollection
     */
    protected $translations;

    /**
     *
     *
     * Methods
     *
     *
     */

    public function __construct() {
        $this->works = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getWorks()
    {
        return $this->works;
    }

    /**
     * @param ArrayCollection $works
     * @return WorkCategory
     */
    public function setWorks(ArrayCollection $works)
    {
        $this->works = $works;

        return $this;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->title : '---';
    }
}