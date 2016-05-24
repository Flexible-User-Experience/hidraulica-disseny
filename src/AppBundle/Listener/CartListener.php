<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Cart\Cart;
use AppBundle\Entity\Product;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

/**
 * Class CartListener
 *
 * @category Listener
 * @package  AppBundle\Listener
 * @author   David Romaní <david@flux.cat>
 */
class CartListener implements EventSubscriber
{
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,
        );
    }

    /**
     * @param LifecycleEventArgs $args ARgs
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof Cart) {
            $object->setVatTax(Product::VAT_TAX);
        }
    }

    /**
     * @param LifecycleEventArgs $args Args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof Cart) {
            $object->setBaseAmount($object->getTotalAmount());
        }
    }
}
