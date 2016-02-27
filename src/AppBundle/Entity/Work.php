<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\TitleTrait;
use AppBundle\Entity\Traits\SlugTrait;
use AppBundle\Entity\Traits\DescriptionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Work
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   Anton Serra <aserratorta@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkRepository")
 */
class Work extends AbstractBase
{
    use TitleTrait;
    use SlugTrait;
    use DescriptionTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $mainImage;

    /**
     * @var WorkCategory
     *
     * @ORM\ManyToOne(targetEntity="WorkCategory", inversedBy="works")
     * @ORM\JoinColumn(name="workCategory_id", referencedColumnName="id")
     */
    private $workCategory;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="WorkImage", mappedBy="work")
     */
    private $workImages;

    /**
     *
     *
     * Methods
     *
     *
     */

    public function __construct() {
        $this->workImages = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @param string $mainImage
     * @return Work
     */
    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    /**
     * @return WorkCategory
     */
    public function getWorkCategory()
    {
        return $this->workCategory;
    }

    /**
     * @param WorkCategory $workCategory
     * @return Work
     */
    public function setWorkCategory(WorkCategory $workCategory)
    {
        $this->workCategory = $workCategory;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getWorkImages()
    {
        return $this->workImages;
    }

    /**
     * @param ArrayCollection $workImages
     * @return Work
     */
    public function setWorkImages(ArrayCollection $workImages)
    {
        $this->workImages = $workImages;

        return $this;
    }

    /**
     * @param WorkImage $workImage
     * @return $this
     */
    public function addWorkImage(WorkImage $workImage)
    {
        $this->workImages->add($workImage);

        return $this;
    }

    /**
     * @param WorkImage $workImage
     * @return $this
     */
    public function removeWorkImage(WorkImage $workImage)
    {
        $this->workImages->removeElement($workImage);

        return $this;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString() {

        return $this->id ? '#' . $this->getId() . ' · ' . $this->getTitle() :  '---';
    }
}
