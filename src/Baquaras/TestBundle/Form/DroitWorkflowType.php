<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DroitWorkflowType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profil', 'entity', array(
				'label' => 'Profil *',
				'empty_value' => 'Sélectionner un profil',
				'class' => 'BaquarasTestBundle:Profil',
				'property' => 'libelle'))
            ->add('statut', 'entity', array(
				'label' => 'Statut de l\'application *',
				'empty_value' => 'Sélectionner un statut',
				'class' => 'BaquarasTestBundle:Statut',
				'property' => 'libelle'))
            ->add('acces', 'entity', array(
				'label' => 'Accès *',
				'empty_value' => 'Sélectionner un mode d\'accès',
				'class' => 'BaquarasTestBundle:Acces',
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
            'data_class' => 'Baquaras\TestBundle\Entity\DroitWorkflow'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_droitworkflow';
    }
}
