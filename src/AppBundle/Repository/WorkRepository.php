<?php

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

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
     * @param int|null $limit
     *
     * @return QueryBuilder
     */
    public function findAllEnabledSortedByDateQB($limit = null)
    {
        $query = $this->createQueryBuilder('w')
            ->where('w.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('w.createdAt');

        if (!is_null($limit)) {
            $query->setMaxResults($limit);
        }

        return $query;
    }

    /**
     * @param int|null $limit
     *
     * @return Query
     */
    public function findAllEnabledSortedByDateQ($limit = null)
    {
        return $this->findAllEnabledSortedByDateQB($limit)->getQuery();
    }

    /**
     * @param int|null $limit
     *
     * @return ArrayCollection
     */
    public function findAllEnabledSortedByDate($limit = null)
    {
        return $this->findAllEnabledSortedByDateQ($limit)->getResult();
    }
}
