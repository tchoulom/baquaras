<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Baquaras\TestBundle\Entity\ItemRepository;

class MiseAJourType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder
			->add('nomPublicationPatch', 'text', array(
				'label' => 'Nom de publication du patch *'))
			->add('type', 'entity', array(
				'label'=>'Type de la mise à jour *',
				'empty_value' => 'Sélectionner un type de mise à jour',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(21);
				},	
				'property' => 'libelle'))
			->add('version', 'text', array(
				'label' => 'Version *'))
			->add('indice', 'text', array( 
				'label' => 'Indice *'))
			->add('oscible', 'entity', array(
				'label'=>'Système d\'exploitation *',
				'empty_value' => 'Sélectionner un système d\'exploitation',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(22);
				},	
				'property' => 'libelle'))
			->add('statutPatch','entity', array(
				'label' => 'Statut du patch',
				'empty_value' => 'Sélectionner un statut',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(24);
				},	
				'property' => 'libelle'))
			->add('description', 'textarea', array(
				'label' => 'Description'))
			->add('documentationTechnique', 'file', array(
				'label' => 'Documentation technique'))
			->add('commentaire', 'textarea', array(
				'label' => 'Commentaire'))	
			->add('dateMiseEnProdMAJ', 'date', array(
				'label' => 'Date de mise en production',
				'format' => 'dd MM yyyy',
				'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))
			->add('personneChargeeMAJ', 'text', array(
				'label' => 'Agent chargé de la mise à jour',
				/*'class' => 'BaquarasTestBundle:Agents',
				'property' => 'libelle',
				'query_builder' => function(AgentsRepository $er) use ($id)
				{
					return $er->createQueryBuilder('a')
						->where('a.application = :id')
						->andWhere('a.role = :role')
                        ->setParameter('id', $id)
						->setParameter('role', 'chargeMAJ');
				},*/
				'read_only' => 'true'))	
			->add('ligneCommandePatchTeledistribution', 'text', array(
				'label' => 'Ligne de commande Patch Télédistribution *'))
			->add('ligneCommandePatchPublication', 'text', array(
				'label' => 'Ligne de commande Patch Publication *'))
			->add('cheminPatch', 'text', array(
				'label' => 'Chemin du patch'))
			->add('save', 'submit', array(
				'label' => 'Valider'))	
			;
			
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\MiseAJour'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_miseajour';
    }
}
