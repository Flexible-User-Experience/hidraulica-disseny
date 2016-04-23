<?php

namespace AppBundle\Entity\Cart;

use AppBundle\Entity\Traits\BaseAmountTrait;
use AppBundle\Entity\Traits\VatTaxTrait;
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
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Cart\CartRepository")
 */
class Cart extends AbstractBase
{
    use BaseAmountTrait;
    use VatTaxTrait;

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
     * @ORM\Column(type="integer", options={"default" = 0})
     */
    private $status = 0;

    /**
     * @var float
     * @ORM\Column(type="float", options={"default" = 0})
     */
    private $deliveryAmount = 0;

    /**
     * @var Payment
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Cart\Payment", inversedBy="cart")
     * @ORM\JoinColumn(name="payment_id", referencedColumnName="id")
     */
    private $payment;

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
     * @param CartItem $cartItem
     *
     * @return CartItem|null
     */
    public function getCartItemByItem(CartItem $cartItem)
    {
        /** @var CartItem $item */
        foreach ($this->items as $item) {
            if ($item->getId() == $cartItem->getId()) {
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
        foreach ($this->items as $item) {
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
     * @return float
     */
    public function getTotalAmount()
    {
        $amount = 0;
        /** @var CartItem $item */
        foreach ($this->getItems() as $item) {
            $amount += $item->getTotalAmount();
        }

        return $amount;
    }

    /**
     * @return float
     */
    public function getTotalAmountWithDelivery()
    {
        return $this->getTotalAmount() + $this->deliveryAmount;
    }

    /**
     * @return float
     */
    public function getVatTaxAmount()
    {
        $amount = $this->getTotalAmountWithDelivery();

        return ($amount * $this->vatTax) / 100;
    }

    /**
     * @return float
     */
    public function getTotalAmountWithDeliveryAndVatTax()
    {
        $amount = $this->getTotalAmountWithDelivery();

        return $amount + (($amount * $this->vatTax) / 100);
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
     *
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
     *
     * @return Cart
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get DeliveryAmount
     *
     * @return float
     */
    public function getDeliveryAmount()
    {
        return $this->deliveryAmount;
    }

    /**
     * Set DeliveryAmount
     *
     * @param float $deliveryAmount
     *
     * @return $this
     */
    public function setDeliveryAmount($deliveryAmount)
    {
        $this->deliveryAmount = $deliveryAmount;

        return $this;
    }

    /**
     * Get Payment
     *
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set Payment
     *
     * @param Payment $payment
     *
     * @return $this
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;

        return $this;
    }
}
