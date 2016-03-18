<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\ImageTrait;
use AppBundle\Entity\Traits\TitleTrait;
use AppBundle\Entity\Traits\SlugTrait;
use AppBundle\Entity\Traits\DescriptionTrait;
use AppBundle\Entity\Traits\TranslationsTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Product
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   Anton Serra <aserratorta@gmail.com>
 *
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
    use DescriptionTrait;
    use TranslationsTrait;

    /**
     * @var float
     *
     * @ORM\Column(type="float", name="price")
     */
    private $price;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ProductImage", mappedBy="product", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $productImages;

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

    public function __construct() {
        $this->productImages = new ArrayCollection();
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
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

     /**
     * @return ArrayCollection
     */
    public function getProductImages()
    {
        return $this->productImages;
    }

    /**
     * @param ArrayCollection $productImages
     * @return Product
     */
    public function setProductImages(ArrayCollection $productImages)
    {
        $this->productImages = $productImages;
        return $this;
    }

    /**
     * @param ProductImage $productImage
     * @return $this
     */
    public function addProductImage(ProductImage $productImage)
    {
        $productImage->setProduct($this);
        $this->productImages->add($productImage);

        return $this;
    }

    /**
     * @param ProductImage $productImage
     * @return $this
     */
    public function removeProductImage(ProductImage $productImage)
    {
        $this->productImages->removeElement($productImage);

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle() . ' # ' . $this->getPrice() . ' €';
    }
}