<?php

namespace AppBundle\Service;

use AppBundle\Entity\Cart\Customer;
use Doctrine\ORM\EntityManager;

/**
 * Class CustomerService
 *
 * @category Service
 * @package  AppBundle\Service
 * @author   David Romaní <david@flux.cat>
 */
class CustomerService
{
    /**
     * @var EntityManager|null
     */
    private $em = null;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * @param EntityManager   $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Customer $searchedCustomer
     *
     * @return Customer
     */
    public function loadCustomerByEmail($searchedCustomer)
    {
        $customer = $this->em->getRepository('AppBundle:Cart\Customer')->findOneBy(['email' => $searchedCustomer->getEmail()]);
        if (!$customer) {
            $customer = new Customer();
            $customer
                ->setName($searchedCustomer->getName())
                ->setAddress($searchedCustomer->getAddress())
                ->setPostalCode($searchedCustomer->getPostalCode())
                ->setCity($searchedCustomer->getCity())
                ->setState($searchedCustomer->getState())
                ->setCountry($searchedCustomer->getCountry())
                ->setEmail($searchedCustomer->getEmail())
                ->setPhone($searchedCustomer->getPhone());
        }

        return $customer;
    }
}
