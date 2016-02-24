<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\TitleTrait;
use AppBundle\Entity\Traits\SlugTrait;
use AppBundle\Entity\Traits\DescriptionTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Product
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   Anton Serra <aserratorta@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product extends AbstractBase
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
     * @var float
     *
     * @ORM\Column(type="float", name="price")
     */
    private $price;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ProductImage", mappedBy="product")
     */
    private $productImages;

    /**
     *
     *
     * Methods
     *
     *
     */

    public function __construct() {
        $this->productImages = new ArrayCollection();
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
}