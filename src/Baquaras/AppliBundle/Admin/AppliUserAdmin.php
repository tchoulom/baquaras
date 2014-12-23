<?php
/**
 * Gestion des utilisateurs de l'appli
 */
namespace Baquaras\AppliBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class AppliUserAdmin extends Admin
{
    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Admin.Admin::configureListFields()
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('username')
        ->add('userRoles')

        // add custom action links
        ->add('_action', 'actions', array(
            'actions' => array(
                'edit' => array(),
                'delete' => array(),
        )))
        ;
    }

    /**
     * nombre de champs maximum affiché par page
     * @var int
     */
    protected $maxPerPage = 20;

    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Admin.Admin::configureFormFields()
     */
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->with('Utilisateur de l\'application')
        ->add('username')
        ->add('userRoles', null, array('required' => false))
        ->end();
    }

    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Admin.Admin::configureDatagridFilters()
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('username')
        ->add('userRoles');
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['delete'] = array(
    'label' => 'delete selected element(s)',
    'ask_confirmation' => true
    );

        return $actions;
    }
}