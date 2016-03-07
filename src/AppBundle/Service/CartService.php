<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Product;
use AppBundle\Entity\Cart\Cart;
use AppBundle\Entity\Cart\CartItem;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class CartService
 *
 * @category Service
 * @package  AppBundle\Service
 * @author   David Romaní <david@flux.cat>
 */
class CartService
{
    /**
     * @var null|Session
     */
    private $session = null;

    /**
     * @var EntityManager|null
     */
    private $em = null;

    /**
     * @var SecurityContext|null
     */
    private $securityContext = null;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * @param Session         $session
     * @param EntityManager   $em
     * @param SecurityContext $securityContext
     */
    public function __construct(Session $session, EntityManager $em, SecurityContext $securityContext)
    {
        $this->session = $session;
        $this->em = $em;
        $this->securityContext = $securityContext;
    }

    /**
     * @return null|Cart
     */
    public function getCart()
    {
        if ($this->session->get('cart', null)) {
            $cart = $this->getCartById($this->session->get('cart', null));
            if ($cart) {
                if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
                    $cart->setUser($this->securityContext->getToken()->getUser());
                    $this->em->persist($cart);
                    $this->em->flush();
                }

                return $cart;
            }
        }
        $cart = new Cart();
        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $cart->setUser($this->securityContext->getToken()->getUser());
        }

        return $cart;
    }


    /**
     * @param int $itemId
     * @param int $quantity
     */
    public function addItem($itemId, $quantity = 1)
    {
        $cart = $this->loadCart();
        $product = $this->getItemById($itemId);

        if ($cart->hasItemByProduct($product)) {
            $cartItem = $cart->getCartItemByProduct($product);
            $cartItem->setQuantity($cartItem->getQuantity() + $quantity);
            $this->em->persist($cartItem);
            $this->em->flush();
        } else {
            $cartItem = new CartItem();
            $cartItem->setCart($cart);
            $cartItem->setProduct($product);
            $cartItem->setQuantity($quantity);
            $cart->addItem($cartItem);
            $this->em->persist($cartItem);
            $this->em->persist($cart);
            $this->em->flush();
        }
    }

    /**
     * @param int $itemId
     * @param int $quantity
     */
    public function setItemQuantity($itemId, $quantity = 1)
    {
        $cart = $this->loadCart();
        $product = $this->getItemById($itemId);

        if ($cart->hasItemByProduct($product)) {
            $cartItem = $cart->getCartItemByProduct($product);
            $cartItem->setQuantity($quantity);
            $this->em->persist($cartItem);
            $this->em->flush();
        } else {
            $cartItem = new CartItem();
            $cartItem->setCart($cart);
            $cartItem->setProduct($product);
            $cartItem->setQuantity($quantity);
            $cart->addItem($cartItem);
            $this->em->persist($cartItem);
            $this->em->persist($cart);
            $this->em->flush();
        }
    }

    /**
     * @param $itemId
     */
    public function removeItem($itemId)
    {
        $cart = $this->loadCart();
        $product = $this->getItemById($itemId);
        $cartItem = $cart->getCartItemByProduct($product);
        if ($cartItem) {
            $this->em->remove($cartItem);
            $this->em->flush();
        }
    }

    /**
     * @return Cart
     */
    private function loadCart()
    {
        if ($this->session->get('cart', null)) {
            $cart = $this->getCartById($this->session->get('cart', null));
            if ($cart) {
                return $cart;
            }
        }

        $cart = new Cart();
        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $cart->setUser($this->securityContext->getToken()->getUser());
        }
        $this->em->persist($cart);
        $this->em->flush();
        $this->session->set('cart', $cart->getId());

        return $cart;
    }

    /**
     * remove persisted cart
     */
    public function clearCart()
    {
        $cart = $this->loadCart();
        $this->em->remove($cart);
        $this->session->set('cart', null);
    }

    /**
     * @param int $itemId
     *
     * @return Product
     */
    public function getItemById($itemId)
    {
        return $this->em->getRepository('ECVulcoAppBundle:AbstractProduct')->findOneBy(array('id' => $itemId));
    }

    /**
     * @param int $cartId
     *
     * @return Cart
     */
    private function getCartById($cartId)
    {
        return $this->em->getRepository('ECVulcoAppBundle:Cart\Cart')->findOneBy(array('id' => $cartId));
    }
}
