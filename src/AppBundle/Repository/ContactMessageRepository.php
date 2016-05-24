<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ContactMessageRepository
 *
 * @category Repository
 * @package  AppBundle\Repository
 * @author   Anton Serra <aserratorta@gmail.com>

 */
class ContactMessageRepository extends EntityRepository
{
    /**
     * @return int
     */
    public function getPendingMessagesAmount()
    {
        $query = $this
            ->createQueryBuilder('c')
            ->where('c.checked = :checked')
            ->setParameter('checked', false)
            ->getQuery();

        return count($query->getResult());
    }
}
