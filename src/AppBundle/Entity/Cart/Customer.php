<?php

namespace AppBundle\Entity\Cart;

use AppBundle\Entity\AbstractBase;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Customer
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Cart\CustomerRepository")
 */
class Customer extends AbstractBase
{

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(strict = true, checkMX = true, checkHost = true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Cart", mappedBy="customer")
     */
    private $carts;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return Customer
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return Customer
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Customer
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     * @return Customer
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Customer
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Customer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCarts()
    {
        return $this->carts;
    }

    /**
     * @param ArrayCollection $carts
     * @return Customer
     */
    public function setCarts(ArrayCollection $carts)
    {
        $this->carts = $carts;
        return $this;
    }

    /**
     * @param Cart $cart
     * @return $this
     */
    public function addCart(Cart $cart)
    {
        $cart->setCustomer($this);
        $this->carts->add($cart);

        return $this;
    }

    /**
     * @param Cart $cart
     * @return $this
     */
    public function removeCart(Cart $cart)
    {
        $this->carts->removeElement($cart);

        return $this;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString() {

        return $this->id ? '#' . $this->getId() . ' · ' . $this->getName() :  '---';
    }

}