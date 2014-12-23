<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Baquaras\TestBundle\Entity\ItemRepository;

class ArchitectureApplicationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('appliWeb', 'checkbox',  array(
				'label'=>'Application web'))
			->add('urlIntranet', 'url', array(
				'label' => 'URL Intranet'))
			->add('urlExtranet', 'url', array(
				'label' => 'URL Extranet'))
			->add('appliIntraOuInternet', 'choice', array(
				'choices' => array('internet' => 'Internet', 'intranet' => 'Intranet'), 
				'expanded'=>'true',
				'label'=>'Application ')) 
            ->add('utilisationActiveX', 'choice', array(
				'label'=>'Utilisation d\'ActiveX',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))				
            ->add('utilisationCertificats', 'choice', array(
				'label'=>'Utilisation des certificats',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))				
            ->add('utilisationJRE', 'choice',  array(
				'label'=>'Utilisation JRE',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))				
            ->add('appliClientServeur', 'choice', array(
				'label'=>'Application Client/Serveur',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
			->add('appliInfocentre', 'choice', array(
				'label' => 'Application infocentre',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
            ->add('baseDeDonnees', 'choice',  array(
				'label'=>'Base de données',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))				
            ->add('commentaire', 'textarea') 
			->add('utilisationOffice', 'choice', array(
				'label' => 'Utilisation d\'Office',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
			->add('liaisonsOffice', 'entity', array(	
				'label' => 'Liaisons Office',			
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(2); /* 2 correspond à Liaisons Office */
					},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionner une liaison Office',
				'multiple' => true,
				'expanded' => true))			
			->add('liaisonAccess', 'choice', array(	
				'label' => 'Liaison Access',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
            ->add('stockeDonneesUser', 'choice', array(
				'label' => 'Stockage de données utilisateur',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
            ->add('utilisationMaterielPeripherique', 'choice', array(
				'label' => 'Utilisation de matériel périphérique',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))				
            ->add('utilisationSSO', 'choice', array(
				'label' => 'Utilisation de SSO',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))				
			->add('briques', 'entity', array(
				'label' => 'Autres briques',
				'class' => 'BaquarasTestBundle:BriqueArchitecture',
				'multiple' => true,
				'expanded' => true,
				'property' => 'libelle',
				'empty_value' => 'Sélectionner une ou plusieurs briques'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\ArchitectureApplication'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_architectureapplication';
    }
}
