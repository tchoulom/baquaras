<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GestionDroitsApplicationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profils', 'entity', array(
				'class'=>'BaquarasTestBundle:Profil',
				'label' => 'Profil',
				'required' => 'false',
				'property'=>'libelle',
				'multiple' => false,
				'empty_value'=>'Selectionner un profil'))
			->add('statuts', 'entity', array(
				'class'=>'BaquarasTestBundle:Statut',
				'label' => 'Statut',
				'required' => 'false',
				'property'=>'libelle',
				'multiple' => false,
				'empty_value'=>'Selectionner un statut'))
			->add('access', 'choice', array(
				'label'=>'Accès',
                'choices' => array('L' => 'Lecture','M'=>'Modification','V'=>'Validation'),
				'empty_value' => 'Sélectionner un mode d\'accès'))
			->add('save', 'submit', array(
				'label'=>'Valider'))		  
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\GestionDroitsApplication'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_gestiondroitsapplication';
    }
}
