<?php

namespace AppBundle\Entity\Cart;

use Doctrine\ORM\Mapping as ORM;
use Payum\Core\Model\Token;

/**
 * Class PaymentToken
 *
 * @category Entity
 * @package  AppBundle\Entity\Cart
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Table
 * @ORM\Entity
 */
class PaymentToken extends Token
{
}
