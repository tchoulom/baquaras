<?php

namespace Baquaras\TestBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * ApplicationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApplicationRepository extends EntityRepository
{

	public function findAllOrderedByName()
	{
	
		return $this->getEntityManager()
			->createQuery('SELECT app FROM BaquarasTestBundle:Application app ORDER BY app.id ASC'
			)
			->getResult();
	
	}
	
	public function findAppliJoin()
	{
		$builder = $this->createQueryBuilder('a', 'i', 'g')
			->join('a.installation','i')
			->join('a.gestion', 'g')
			->orderBy('a.nom', 'ASC');
 
		return $builder->getQuery()->getResult();
	}
	
	/**
     * Get the paginated list of published articles
     *
     * @param int $page
     * @param int $maxperpage
     * @param string $sortby
     * @return Paginator
     */
    public function getListe($page=1, $maxperpage=20)
    {

       $q = $this->createQueryBuilder('a', 'i')
			->join('a.installation','i')
			->orderBy('a.nom', 'ASC');

        $q->setFirstResult(($page-1) * $maxperpage)
            ->setMaxResults($maxperpage);

        return new Paginator($q);
	}
	
	/**
     * Get the paginated list of published articles
     *
     * @param int $page
     * @param int $maxperpage
     * @param string $sortby
     * @return Paginator
     */
	public function getListeLettre($lettre)
	{
		/*$qb = $this->createQueryBuilder('a', 'i', 'g')
			->join('a.installation','i')
			->join('a.gestion', 'g')
			->field($
			->orderBy('a.nom', 'ASC');
 
		return $builder->getQuery()->getResult();
		
*/
			
		$qb = $this->createQueryBuilder('a');
		$qb->where($qb->expr()->like('a.nom', ':nom'))
			->setParameter('nom','t*')
			->orderBy('a.nom', 'ASC')
			->getQuery()
			->getResult();
			
		return $qb;
	}
	
	public function countApplications()
	{
	    
        return $this->createQueryBuilder('id')
            ->select('COUNT(id)')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    
	}

}
