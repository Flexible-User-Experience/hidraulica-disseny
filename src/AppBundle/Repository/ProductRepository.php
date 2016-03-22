<?php

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * Class ProductRepository
 *
 * @category Repository
 * @package  AppBundle\Repository
 * @author   Anton Serra <aserratorta@gmail.com>

 */
class ProductRepository extends EntityRepository
{
    /**
     * @return ArrayCollection
     */
    public function findAllEnabledSortedByDate()
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('p.createdAt');

        return $query->getQuery()->getResult();
    }
}
