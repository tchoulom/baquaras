<?php
namespace Baquaras\TestBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Baquaras\TestBundle\Entity\Utilisateur;
use Symfony\Component\DependencyInjection\Container;

use Doctrine\ORM\EntityRepository;

/**
 * UtilisateurRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UtilisateurRepository extends EntityRepository implements UserProviderInterface
{
    
    public function loadUserByUsername($username)
    {
        $role = array();
        $utilisateur = $this->findOneBy(array('cpteMatriculaire'=>$username));
        if(empty($utilisateur) ) {
             throw new UsernameNotFoundException(sprintf('Unable to find an user  in Baquaras with the compte matruclaire "%s".', $username));
        }
        switch ($utilisateur->getCpteMatriculaire()) {
            case 'Utilisateur non connecté':
                $role = array('ROLE_USER');
                breack;
            case 'Intégrateur':
                $role = array('ROLE_INTEGRATEUR');
                breack;
            case 'Lecteur avancé':
                $role = array('ROLE_LECTEUR');
                breack;
            case 'Technicien support':
                $role = array('ROLE_TECHNICIEN');
                breack;
            case 'Qualificateur':
                $role = array('ROLE_QUALIFICATEUR');
                breack;
            case 'Chef de produit':
                $role = array('ROLE_CHEF_PRODUIT');
                breack;
            case 'Responsable qualification':
                $role = array('ROLE_RESPONSABLE_QUALIF');
                breack;
            case 'Administrateur':
                $role = array('ROLE_SUPER_ADMIN');
                breack;
        }
        
        return new User($username, '', '', array('ROLE_INTEGRATEUR'));
        
    }

    /*
     * FROM websso
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }
    

    public function supportsClass($class)
    {
        return $class === 'Baquaras\TestBundle\Security\User\User';
    }
    
    /**
     *
     * @return array(Utilisateur)
     */
    public function findUser($term='RACHID')
    {
        $query = $this->createQueryBuilder('u')
            ->select('u.nom')
            ->where("u.nom LIKE :term")
            ->setParameter('term', '%'.$term.'%')
            ->getQuery()
            ->getArrayResult();
           // var_dump($query); die('test');
        return $query ;
    }
    
    
}

