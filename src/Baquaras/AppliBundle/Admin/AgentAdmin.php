<?php
/**
 * Gestion des utilisateurs de l'appli
 */
namespace Baquaras\AppliBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class AgentAdmin extends Admin
{
    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Admin.Admin::configureListFields()
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
        ->addIdentifier('matricule')
        ->add('nom')
        ->add('prenom')
        ->add('tel')
        ->add('structuremetiernom')
        ->add('AppliUser', 'string', array('Entity'))

        // add custom action links
        ->add('_action', 'actions', array(
            'actions' => array(
                'edit' => array('AppliUser'),
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
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     */
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
        ->with('Agent')
        ->add('matricule')
        ->add('civilite')
        ->add('nom')
        ->add('prenom')
        ->add('structuremetiernom')
        ->add('mail')
        ->add('tel', null, array('required' => false))
        ->add('localisationnom')
        ->add('categorie', null, array('required' => false))
        ->add('statut')
        ->end();
    }

    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Admin.Admin::configureDatagridFilters()
     * @param \Sonata\AdminBundle\Datagrid\DatagridMapper $datagridMapper
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ->add('matricule')
        ->add('nom')
        ->add('prenom')
        ->add('structuremetiernom')
        ->add('tel')
        ->add('localisationnom')
        ;
    }

    /**
     * (non-PHPdoc)
     * @see Sonata\AdminBundle\Admin.Admin::getBatchActions()
     * @return null
     */
    public function getBatchActions()
    {
        $actions = NULL;
        return $actions;
    }
}