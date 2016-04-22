<?php

namespace AppBundle\Repository;

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
     * @param string   $order
     *
     * @return QueryBuilder
     */
    public function findAllEnabledSortedByDateQB($limit = null, $order = 'DESC')
    {
        $query = $this->createQueryBuilder('w')
            ->where('w.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('w.createdAt', $order);

        if (!is_null($limit)) {
            $query->setMaxResults($limit);
        }

        return $query;
    }

    /**
     * @param int|null $limit
     * @param string   $order
     *
     * @return Query
     */
    public function findAllEnabledSortedByDateQ($limit = null, $order = 'DESC')
    {
        return $this->findAllEnabledSortedByDateQB($limit, $order)->getQuery();
    }

    /**
     * @param int|null $limit
     * @param string   $order
     *
     * @return array
     */
    public function findAllEnabledSortedByDate($limit = null, $order = 'DESC')
    {
        return $this->findAllEnabledSortedByDateQ($limit, $order)->getResult();
    }

    /**
     * @param int|null $limit
     * @param string   $order
     *
     * @return QueryBuilder
     */
    public function findShowInHomepageEnabledSortedByDateQB($limit = null, $order = 'DESC')
    {
        $query = $this->findAllEnabledSortedByDateQB($limit, $order)
            ->andWhere('w.showInHomepage = :showInHomepage')
            ->setParameter('showInHomepage', true);

        return $query;
    }

    /**
     * @param int|null $limit
     * @param string   $order
     *
     * @return Query
     */
    public function findShowInHomepageEnabledSortedByDateQ($limit = null, $order = 'DESC')
    {
        return $this->findShowInHomepageEnabledSortedByDateQB($limit, $order)->getQuery();
    }

    /**
     * @param int|null $limit
     * @param string   $order
     *
     * @return array
     */
    public function findShowInHomepageEnabledSortedByDate($limit = null, $order = 'DESC')
    {
        return $this->findShowInHomepageEnabledSortedByDateQ($limit, $order)->getResult();
    }
}
