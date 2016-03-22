<?php

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * Class WorkRepository
 *
 * @category Repository
 * @package  AppBundle\Repository
 * @author   Anton Serra <aserratorta@gmail.com>

 */
class WorkRepository extends EntityRepository
{
    /**
     * @return ArrayCollection
     */
    public function findAllEnabledSortedByDate()
    {
        $query = $this->createQueryBuilder('w')
            ->where('w.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('w.createdAt');

        return $query->getQuery()->getResult();
    }
}
