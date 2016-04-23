<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Cart\Cart;
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
     * @var integer
     * Default VAT tax amount
     */
    private $dvt;

    /**
     * TyreSubscriber constructor.
     *
     * @param int $dvt
     */
    public function __construct($dvt)
    {
        $this->dvt = $dvt;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,
            Events::postLoad,
        );
    }

    /**
     * @param LifecycleEventArgs $args ARgs
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof Cart) {
            $object->setVatTax($this->dvt);
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

    /**
     * @param LifecycleEventArgs $args Args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();
        if ($object instanceof Cart) {
            $object->setBaseAmount($object->getTotalAmount());
        }
    }
}
