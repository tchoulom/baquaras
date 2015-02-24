<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Baquaras\TestBundle\Entity\ItemRepository;
use Baquaras\TestBundle\Entity\AgentsRepository;

class ApplicationType extends AbstractType
{
    public function __construct($id) {
   //public function __construct($id= '') { //Ernest TCHOULOM 24-02-2015
		$this->id = $id;
    }
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$id = $this->id ;
	
		$builder
			->add('nom', 'text', array(	
				'label' => 'Nom de l\'application'))
			->add('editeur', 'text', array(
				'label' => 'Éditeur'))
            ->add('version', 'text', array(
				'label' => 'Version de l\'application'))
            ->add('type', 'entity', array(
				'label'=>'Type de l\'application',
				'empty_value' => 'Sélectionner un type d\'application',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(1); /* 1 correspond à Types d'application */
					},	
				'property' => 'libelle'))
            ->add('description', 'textarea')
			->add('correctifQualif', 'text', array('label' => 'Correctif Qualif'))
            ->add('codeConvergence', 'text', array('label' => 'Code Convergence'))
            ->add('codeECAR', 'text', array('label' => 'Code ECAR'))
            ->add('appliReferenceeSIERA', 'choice', array(
				'label'=>'Application référencée dans SIERA',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
            ->add('codeSIERA', 'text', array(
				'label' => 'Code SIERA'))
            ->add('nomApplicationSIERA','text', array('label' => 'Nom application SIERA'))
            ->add('appliSousGouvernance', 'choice', array(
				'label'=>'Application sous gouvernance',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false)) 
            ->add('oscible', 'entity', array(	
				'label' => 'OS Cible',			
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(22); /* 22 correspond à OS cible */
					},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionnez un système d\'exploitation'))				
          /*  ->add('dansCatalogueSIT', 'choice', array(
				'label'=>'Application référencée dans le catalogue SIT',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))*/
            ->add('inscriteRevuePerformance', 'choice', array(
				'label'=>'Application inscrite dans la revue performance',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false)) 
            /*->add('groupes', 'text', array(
				'label' => 'Groupes habilités à installer',
				'read_only' => 'true' ))*/
			//->add('refCatalogue', new CatalogueSITType($id))
			->add('architecture', new ArchitectureApplicationType())
			->add('installation', new InstallationApplicationType())
			->add('developpement', new DeveloppementApplicationType())
			->add('gestion', new GestionApplicationType())
			->add('packages', 'collection', array(
				'type' => new PackageType($id),
				'allow_add' => true,
				'by_reference' => false))
			/*->add('cancel', 'button', array(
				'label' => 'Annuler'))*/
			->add('save', 'submit', array(
				'label' => 'Enregistrer les modifications'))
			/*->add('modifStatutQualif' , 'button', array(
				'label' => 'Gérer l\'avancement de la Qualification'))*/
                        ->add('nom', 'text', array('label' => 'Nom de l\'agent')) //Ernest TCHOULOM 20-02-2015
                        ->add('utilisateur', 'collection', array('label' => 'Utilisateur', 'type' => new UtilisateurType(),
        		'prototype'=>true,
        		'allow_add' => true,
        		'allow_delete' => true,
        		'by_reference' => true,
                        /*'multiple' => true*/)) //Ernest TCHOULOM 20-02-2015
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\Application'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_application';
    }
}
