<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Cart\CartItem;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

/**
 * Class CartItemListener
 *
 * @category Listener
 * @package  AppBundle\Listener
 * @author   David Romaní <david@flux.cat>
 */
class CartItemListener implements EventSubscriber
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
        if ($object instanceof CartItem) {
            $object->setBaseAmount($object->getProduct()->getPrice());
        }
    }

    /**
     * @param LifecycleEventArgs $args Args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof CartItem) {
            $object->setBaseAmount($object->getProduct()->getPrice());
        }
    }
}
