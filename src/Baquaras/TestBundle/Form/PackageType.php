<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Baquaras\TestBundle\Entity\ItemRepository;

class PackageType extends AbstractType
{
	public function __construct($id) {
		$this->id = $id;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$id = $this->id;
		
        $builder
            ->add('nom', 'text', array(
				'label' => 'Display Name *'))
            ->add('nomPublication', 'text', array(
				'label' => 'Nom Publication *'))
			/*->add('qualificateur', 'text', array(
				'label' => 'Qualificateur *',
				'read_only' => 'true'))/*
				'class' => 'BaquarasTestBundle:Utilisateur',
				'property' => 'NomAndPrenom',
				'empty_value' => 'Sélectionner
				un utilisateur'))*/
            ->add('type', 'entity', array(
				'label' => 'Type du package *',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(3);
					},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionner un type de package'))
            ->add('taille', 'text', array(
				'label' => 'Taille du package (en Mo)'))
            ->add('chemin', 'text', array(
				'label' => 'Chemin du package *'))
            ->add('paliersTechniques', 'entity', array(
				'label' => 'Palier(s) technique(s) supporté(s) *',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(4);
					},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionner un palier'))
		    ->add('espaceDisqueInstalle', 'text', array(
				'label' => 'Espace disque installé'))
			 ->add('ligneCommandePublication', 'text', array(
				'label' => 'Ligne de commande Publication'))
            ->add('ligneCommandeTeledistribution', 'text', array(
				'label' => 'Ligne de commande Télédistribution'))
            ->add('redemarrageOutilDeveloppement', 'choice', array(
				'label' => 'Redémarrage géré par outil déploiement',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
            ->add('redemarrageRequis', 'choice', array(
				'label' => 'Redémarrage requis',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
			->add('versionOutilPackaging', 'entity', array(
				'label' => 'Version de l\'outil de packaging',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(5);
					},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionner une version'))
            ->add('versionTemplate', 'entity', array(
				'label' => 'Version template',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(6);
					},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionner une version'))
            ->add('productCode', 'text', array(
				'label' => 'Product Code'))
            ->add('activeSetup', 'choice', array(
				'label'=>'Active Setup',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
            ->add('tNSNAMES', 'choice', array(
				'label'=>'TNS Names',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
            ->add('nomEntreeTNSNAMES',  'entity', array(
				'label' => 'Entrée TNS NAMES',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(9);
					},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionner une entrée'))
            /*->add('dossierTechnique', 'file', array(
                    'label' => 'Dossier technique'))*///Ernest TCHOULOM COMMENTAIRE 06-03-2015
              ->add('dossierTechnique', new FichierType(), array(
                    'label' => 'Dossier technique'))//Ernest TCHOULOM COMMENTAIRE 06-03-201
            ->add('commentaire', 'textarea', array(
				'label' => 'Commentaire'))
            ->add('creationCustomActions', 'choice', array(
				'label' => 'Création de custom action',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
           /* ->add('prequalificateur', 'text', array(
				'label' => 'Pré-qualificateur',
				'read_only' => 'true'))	*/			
			->add('installation', new InstallationPackageType())
			/*->add('modeOperatoire', new ModeOperatoireType())*/
			->add('qualification', new QualificationType($id))
			/*->add('scripts', new ScriptType())*/
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\Package'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_package';
    }
}
