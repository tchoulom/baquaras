<?php

namespace Baquaras\TestBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Finder\Iterator;
use Knp\Menu\Iterator\RecursiveItemIterator;
use Knp\Menu\Iterator\CurrentItemFilterIterator;
use Knp\Menu\MenuItem;
use Symfony\Component\DependencyInjection\Container;


class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

	// Applications
	$menu->addChild('Applications', array('route' => ''))->setAttribute('dropdown', true);
        if($this->container->get('management_roles')->RoleVerified('Liste des applications')) {
            $menu['Applications']->addChild('Liste des applications', array('route' => 'listerApplications'));
        }
        if($this->container->get('management_roles')->RoleVerified('Ajouter une application')) {
            $menu['Applications']->addChild('Ajouter une application', array('route' => 'ajouterApplication'));
        }
        // Recherche
        if($this->container->get('management_roles')->RoleVerified('recherche'))
        {
            $menu->addChild('Recherche', array('route' => 'recherche'));
        }
        if($this->container->get('management_roles')->RoleVerified('Suivi des qualifications'))
        {
            // Suivi des qualifications
            $menu->addChild('Suivi des qualifications', array('route'=> 'voirSuiviQualif'/*'accueil'*/));
        }
        if($this->container->get('management_roles')->RoleVerified("Administration"))
        {
		// Administration
            $menu->addchild('Administration', array(
                'route'=>''
                ))->setAttribute('dropdown', true)
                /*->addChild('Liste des utilisateurs', array(
                    'route' => 'listeruser'
                    ))->getParent()*/
                ->addChild('Gestion d\'accès aux pages', array(
                        'route' => 'droitsAccess',
                        'routeParameters' => array('type' => 1)
                        ))->getParent()
                ->addChild('Gestion  d\'accès des ongles', array(
                        'route' => 'droitsAccess',
                        'routeParameters' => array('type' => 2)
                        ))->getParent()
                ->addChild('Gestion d\'accès aux items', array(
                        'route' => 'droitsAccess',
                        'routeParameters' => array('type' => 3)
                        ))->getParent()
                /*->addChild('Gestion des applications', array(
                    'route' => 'listerApplicationsAdmin'
                    ))->getParent()*/
                ->addChild('Gestion des listes déroulantes', array(
                    'route' => 'listerItem'
                    ))->getParent()
                /*->addChild('Ajouter un utilisateur', array(
                    'route' => 'rechercherUserHarpe'
                    ))->getParent()*/
                /*->addChild('Ajouter un groupe d\'utilisateurs', array(
                    'route' => 'ajouterGroupeUserHarpe'
                    ))->getParent()*/
                ->addChild('Liste des utilisateurs', array(
                    'route' => 'listerUsers'
                    ))->getParent()			
            ;
  }
        return $menu; 
    }
	
	public function accueilMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
		
		// Accueil
		$menu->addChild('BAQUARAS', array(
			'route' => 'accueil'
			));
		
        return $menu;
	}
	
    public function connexionMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
	if( $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            // Connexion
            $menu->addChild('Déconnexion', array(
                'route' => 'logout'
			));
        } else {
            $menu->addChild('s\'identifier', array(
                'route' => 'authentificate'
            ));
        }

        return $menu;
	}
	
	
    public function breadCrumb(FactoryInterface $factory, array $options)
    {
        $menu = $this->mainMenu($factory, $options);

        /* @var $matcher \Knp\Menu\Matcher\Matcher */
        $matcher = $this->container->get('knp_menu.matcher');

        $treeIterator = new \RecursiveIteratorIterator(
                new RecursiveItemIterator(
                new \ArrayIterator(array($menu))
                ), \RecursiveIteratorIterator::SELF_FIRST
        );

        $iterator = new CurrentItemFilterIterator($treeIterator, $matcher);

        // Set Current as an empty Item in order to avoid exceptions on knp_menu_get
        $current = new MenuItem('', $factory);

        foreach ($iterator as $item) {
            $item->setCurrent(true);
            $current = $item;
            break;
        }

    return $current;
}
}