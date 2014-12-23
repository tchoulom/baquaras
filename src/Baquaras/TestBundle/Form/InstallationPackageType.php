<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Baquaras\TestBundle\Entity\ItemRepository;

class InstallationPackageType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('repertoireInstallationApplication', 'text', array(
				'label' => 'Répertoire d\'installation de l\'application'))
			->add('repertoireInstallationDonnees', 'text', array(
				'label' => 'Répertoire d\'installation des données'))
            ->add('portsOuvertsLocaux', 'text', array(
				'label' => 'Ports ouverts locaux utilisés par l\'application'))
			->add('portsOuvertsDistants', 'text', array(
				'label' => 'Ports ouverts distants utilisés par l\'application'))
            ->add('packageVirtualise', 'choice', array(
				'label' => 'Package virtualisé',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
			->add('connectionGroup', 'choice', array(
				'label' => 'Connection Group',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
			->add('versionAppVXP', 'entity', array(
				'label' => 'Version AppV XP',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(7);
				},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionner une version'))
			->add('versionAppVW7', 'entity', array(
				'label' => 'Version AppV W7',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(8);
					},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionner une version'));
		;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\InstallationPackage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_installationpackage';
    }
}
