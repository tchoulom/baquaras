<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProfilRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProfilRepository extends EntityRepository
{
    /*
     * get profils withour admin
     * @return array
     */
    public function getProfilWithoutAdmin()
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.id != 8')
            ->getQuery()
            ->getResult();
        return $query;
    }
}
