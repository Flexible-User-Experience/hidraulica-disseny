<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\DescriptionTrait;
use AppBundle\Entity\Traits\ImageTrait;
use AppBundle\Entity\Traits\ShowInHomepageTrait;
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
    const VAT_TAX = 21;
    const VAT_TAX_DIVIDER = 1.21;
    const VAT_TAX_MULTIPLIER = 0.21;

    use ImageTrait;
    use TitleTrait;
    use SlugTrait;
    use TranslationsTrait;
    use DescriptionTrait;
    use UrlVimeoTrait;
    use ShowInHomepageTrait;

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
     * @var float
     * 
     * @ORM\Column(type="float", name="price")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default" = false})
     */
    private $askPrice = false;

    /**
     * @var File
     * 
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
     * 
     * @ORM\OneToMany(targetEntity="ProductImage", mappedBy="product", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $images;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ProductCategory", inversedBy="products")
     */
    private $categories;

    /**
     * @var ArrayCollection
     * 
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\Translation\ProductTranslation",
     *     mappedBy="object",
     *     cascade={"persist", "remove"}
     * )
     * @Assert\Valid(deep = true)
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
        $this->categories = new ArrayCollection();
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
     * @return float
     */
    public function getPriceWithoutTax()
    {
        $result = 0;
        if ($this->price > 0) {
            $result = $this->price / self::VAT_TAX_DIVIDER;
        }

        return $result;
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
     * Get AskPrice
     *
     * @return boolean
     */
    public function getAskPrice()
    {
        return $this->askPrice;
    }

    /**
     * Set AskPrice
     *
     * @param boolean $askPrice
     *
     * @return $this
     */
    public function setAskPrice($askPrice)
    {
        $this->askPrice = $askPrice;

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

    /**
     * Get Categories
     *
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set Categories
     *
     * @param ArrayCollection $categories
     *
     * @return $this
     */
    public function setCategories(ArrayCollection $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param ProductCategory $category
     *
     * @return $this
     */
    public function addCategory(ProductCategory $category)
    {
        $category->addProduct($this);
        $this->categories->add($category);

        return $this;
    }

    /**
     * @param ProductCategory $category
     *
     * @return $this
     */
    public function removeCategory(ProductCategory $category)
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle() . ' # ' . $this->getPrice() . ' €';
    }
}