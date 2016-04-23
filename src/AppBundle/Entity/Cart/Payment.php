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
}
