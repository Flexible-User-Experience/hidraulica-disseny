<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\DescriptionTrait;
use AppBundle\Entity\Traits\ImageTrait;
use AppBundle\Entity\Traits\TitleTrait;
use AppBundle\Entity\Traits\SlugTrait;
use AppBundle\Entity\Traits\TranslationsTrait;
use AppBundle\Entity\Traits\UrlVimeoTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Work
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   Anton Serra <aserratorta@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\WorkTranslation")
 * @Vich\Uploadable
 */
class Work extends AbstractBase
{
    use ImageTrait;
    use TitleTrait;
    use SlugTrait;
    use DescriptionTrait;
    use TranslationsTrait;
    use UrlVimeoTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text", length=4000, nullable=true)
     * @Gedmo\Translatable
     */
    private $description;

    /**
     * @var WorkCategory
     *
     * @ORM\ManyToOne(targetEntity="WorkCategory", inversedBy="works")
     * @ORM\JoinColumn(name="workCategory_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="work", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize = "10M",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png", "image/gif"}
     * )
     * @Assert\Image(minWidth = 1200)
     */
    private $imageFile;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="WorkImage", mappedBy="work", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $images;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Translation\WorkTranslation",
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
        $this->images = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /**
     * Get Category
     *
     * @return WorkCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param WorkCategory $category
     *
     * @return Work
     */
    public function setCategory(WorkCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get Images
     *
     * @return ArrayCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param ArrayCollection $images
     *
     * @return Work
     */
    public function setImages(ArrayCollection $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @param WorkImage $workImage
     * @return $this
     */
    public function addImage(WorkImage $workImage)
    {
        $workImage->setWork($this);
        $this->images->add($workImage);

        return $this;
    }

    /**
     * @param WorkImage $workImage
     * @return $this
     */
    public function removeImage(WorkImage $workImage)
    {
        $this->images->removeElement($workImage);

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
