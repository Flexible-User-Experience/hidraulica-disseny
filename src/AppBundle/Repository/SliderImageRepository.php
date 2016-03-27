<?php

namespace AppBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * Class SliderImageRepository
 *
 * @category Repository
 * @package  AppBundle\Repository
 * @author   Anton Serra <aserratorta@gmail.com>
 */
class SliderImageRepository extends EntityRepository
{
    /**
     * @return ArrayCollection
     */
    public function findAllEnabledSortedByPosition()
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('s.position', 'ASC');

        return $query->getQuery()->getResult();
    }
}
