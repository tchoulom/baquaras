<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Baquaras\TestBundle\Entity\ItemRepository;

class ScriptType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array(
				'label' => 'Nom du script *'))
            ->add('fonction', 'text', array(
				'label' => 'Fonction du script *'))
            ->add('type', 'entity', array(
				'label'=>'Type du script *',
				'empty_value' => 'Sélectionner un type de script',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(10);
					},	
				'property' => 'libelle'))
            ->add('techno', 'entity', array(
				'label' => 'Techonologie du script',
				'empty_value' => 'Sélectionner une technologie',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(11);
					},	
				'property' => 'libelle'))
            ->add('oscible', 'entity', array(
				'label' => 'Système d\'exploitation',
				'empty_value' => 'Sélectionner un système d\'exploitation',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(22);
					},	
				'property' => 'libelle'))
			->add('conditionExecution', 'entity', array(
				'label' => 'Condition d\'exécution',
				'empty_value' => 'Sélectionner une condition d\'exécution',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(12);
					},	
				'property' => 'libelle'))
			->add('conditionLancement', 'entity', array(
				'label' => 'Condition de lancement',
				'empty_value' => 'Sélectionner une condition de lancement',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(13);
					},	
				'property' => 'libelle'))
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
            'data_class' => 'Baquaras\TestBundle\Entity\Script'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_script';
    }
}
