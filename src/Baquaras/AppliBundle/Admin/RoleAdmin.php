<?php
/**
 * Gestion des roles possibles pour les utilisateurs
 */
namespace Baquaras\AppliBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class RoleAdmin extends Admin
{
    /**
     * nombre de champs maximum affiché par page
     * @var int
     */
    protected $maxPerPage = 10;

    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Admin.Admin::configureListFields()
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('id')
        ->add('name')

        // add custom action links
        ->add('_action', 'actions', array(
        'actions' => array(
        'edit' => array(),
        'delete' => array(),
        )))
        ;
    }

    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Admin.Admin::configureFormFields()
     */
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->with('General')
        ->add('name')
        ->end();
    }

    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Admin.Admin::getBatchActions()
     */
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