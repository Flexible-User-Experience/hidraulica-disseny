<?php

namespace AppBundle\Enum;

/**
 * CartStatusEnum class
 *
 * @category Enum
 * @package  AppBundle\Enum
 * @author   David Romaní <david@flux.cat>
 */
class CartStatusEnum extends Enum
{
    const CART_STATUS_NEW = 0;
    const CART_STATUS_PENDING = 1;
    const CART_STATUS_SENT = 2;
    const CART_STATUS_INVOICED = 3;

    /**
     * @return array
     */
    public static function getEnumArray()
    {
        return array(
            self::CART_STATUS_NEW => 'backend.admin.cart.status.new',
            self::CART_STATUS_PENDING => 'backend.admin.cart.status.pending',
            self::CART_STATUS_SENT => 'backend.admin.cart.status.sent',
            self::CART_STATUS_INVOICED => 'backend.admin.cart.status.invoiced',
        );
    }
}
