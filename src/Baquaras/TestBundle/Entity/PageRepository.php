<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PageRepository extends EntityRepository
{
    /*
     * get page by link
     */
    public function getPageByRoute($route)
    {
        $route = strtolower(trim($route));
        $q = $this->createQueryBuilder('p')
            ->select('p')
            ->where("TRIM(LOWER(p.libelle)) LIKE :pattern")
            ->setParameter('pattern', '%'.$route.'%')
            ->getQuery();
        return $q->getSingleResult(); 
        
    }
}