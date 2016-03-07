<?php

namespace ECVulco\AppBundle\Entity\Cart;

use Doctrine\ORM\Mapping as ORM;
use ECVulco\AppBundle\Entity\AbstractBase;
use ECVulco\AppBundle\Entity\AbstractProduct as Product;

/**
 * Class CartItem
 *
 * @category Entity
 * @package  ECVulco\AppBundle\Entity\Cart
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Table(name="ec_vulco_cart_item")
 * @ORM\Entity(repositoryClass="ECVulco\AppBundle\Repository\Cart\CartItemRepository")
 */
class CartItem extends AbstractBase
{
    /**
     * @var integer
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var Cart
     * @ORM\ManyToOne(targetEntity="ECVulco\AppBundle\Entity\Cart\Cart", cascade={"persist"}, inversedBy="items")
     */
    private $cart;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="ECVulco\AppBundle\Entity\AbstractProduct", cascade={"persist"})
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
}
