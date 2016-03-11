<?php

namespace AppBundle\Entity\Cart;

use AppBundle\Enum\CartStatusEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\AbstractBase;
use AppBundle\Entity\Product;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Cart
 *
 * @category Entity
 * @package  AppBundle\Entity\Cart
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Cart\CartRepository")
 */
class Cart extends AbstractBase
{
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="CartItem", mappedBy="cart")
     */
    private $items;

    /**
     * @var Customer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cart\Customer", inversedBy="carts", cascade={"persist"})
     */
    private $customer;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * Cart constructor
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @param ArrayCollection $items
     *
     * @return $this
     */
    public function setItems(ArrayCollection $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param CartItem $item
     */
    public function addItem($item)
    {
        $this->items->add($item);
    }

    /**
     * @param CartItem $item
     *
     * @return bool
     */
    public function hasItem(CartItem $item)
    {
        return $this->items->contains($item);
    }

    /**
     * @param Product $product
     *
     * @return bool
     */
    public function hasItemByProduct(Product $product)
    {
        return is_null($this->getCartItemByProduct($product)) ? false : true;
    }

    /**
     * @param CartItem $item
     *
     * @return CartItem|null
     */
    public function getCartItemByItem(CartItem $item)
    {
        /** @var CartItem $item */
        foreach ($this->items as $item)
        {
            if ($item->getId() == $item->getId()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param Product $product
     *
     * @return CartItem|null
     */
    public function getCartItemByProduct(Product $product)
    {
        /** @var CartItem $item */
        foreach ($this->items as $item)
        {
            if ($item->getProduct()->getId() == $product->getId()) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @return int
     */
    public function getTotalQuantity()
    {
        $quantity = 0;
        /** @var CartItem $item */
        foreach ($this->getItems() as $item) {
            $quantity += $item->getQuantity();
        }

        return $quantity;
    }

    /**
     * @return int
     */
    public function getTotalAmount()
    {
        $amount = 0;
        /** @var CartItem $item */
        foreach ($this->getItems() as $item) {
            $amount += $item->getQuantity() * $item->getProduct()->getPriceAmount();
        }

        return $amount;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        $result = array();
        $result['totalQuantity'] = $this->getTotalQuantity();

        return json_encode($result);
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     * @return Cart
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getStatusHumanFriendly()
    {
        return CartStatusEnum::getEnumArray()[$this->getStatus()];
    }

    /**
     * @param int $status
     * @return Cart
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
