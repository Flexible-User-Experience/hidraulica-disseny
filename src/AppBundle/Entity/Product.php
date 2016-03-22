<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\DescriptionTrait;
use AppBundle\Entity\Traits\ImageTrait;
use AppBundle\Entity\Traits\TitleTrait;
use AppBundle\Entity\Traits\SlugTrait;
use AppBundle\Entity\Traits\TranslationsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Product
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   Anton Serra <aserratorta@gmail.com>
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\Translation\ProductTranslation")
 * @Vich\Uploadable
 */
class Product extends AbstractBase
{
    use ImageTrait;
    use TitleTrait;
    use SlugTrait;
    use TranslationsTrait;
    use DescriptionTrait;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="text", length=4000, nullable=true)
     * @Gedmo\Translatable
     */
    private $description;

    /**
     * @var float
     * @ORM\Column(type="float", name="price")
     */
    private $price;

    /**
     * @var File
     * @Vich\UploadableField(mapping="product", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize = "10M",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png", "image/gif"}
     * )
     * @Assert\Image(minWidth = 1200)
     */
    private $imageFile;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ProductImage", mappedBy="product", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $images;

    /**
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Translation\ProductTranslation",
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

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

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
     * Set Images
     *
     * @param ArrayCollection $images
     *
     * @return $this
     */
    public function setImages(ArrayCollection $images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @param ProductImage $productImage
     *
     * @return $this
     */
    public function addImage(ProductImage $productImage)
    {
        $productImage->setProduct($this);
        $this->images->add($productImage);

        return $this;
    }

    /**
     * @param ProductImage $productImage
     *
     * @return $this
     */
    public function removeImage(ProductImage $productImage)
    {
        $this->images->removeElement($productImage);

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle() . ' # ' . $this->getPrice() . ' €';
    }
}