<?php

namespace AppBundle\Entity\Cart;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Payment as BasePayment;

/**
 * Class Payment
 *
 * @category Entity
 * @package  AppBundle\Entity\Cart
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Payment extends BasePayment
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @var Cart
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Cart\Cart", mappedBy="payment")
     */
    protected $cart;

    /**
     * Get Cart
     *
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set Cart
     *
     * @param Cart $cart
     *
     * @return $this
     */
    public function setCart($cart)
    {
        $this->cart = $cart;

        return $this;
    }
}
