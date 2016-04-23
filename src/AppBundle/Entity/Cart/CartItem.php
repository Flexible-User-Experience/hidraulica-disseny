<?php

namespace AppBundle\Entity\Cart;

use AppBundle\Entity\Traits\BaseAmountTrait;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\AbstractBase;
use AppBundle\Entity\Product;

/**
 * Class CartItem
 *
 * @category Entity
 * @package  AppBundle\Entity\Cart
 * @author   David Romaní <david@flux.cat>
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Cart\CartItemRepository")
 */
class CartItem extends AbstractBase
{
    use BaseAmountTrait;

    /**
     * @var integer
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var Cart
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cart\Cart", cascade={"persist"}, inversedBy="items")
     */
    private $cart;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", cascade={"persist"})
     */
    private $product;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return CartItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param Cart $cart
     *
     * @return CartItem
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Product $product
     *
     * @return CartItem
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->quantity * $this->baseAmount;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getProduct()->getTitle() . ' >>> ' . $this->quantity . ' * ' . $this->baseAmount . '€/u. = ' . $this->getTotalAmount() . '€';
    }
}
