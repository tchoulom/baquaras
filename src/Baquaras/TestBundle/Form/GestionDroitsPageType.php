<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GestionDroitsPageType extends AbstractType
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
				'multiple' => true,
				'empty_value'=>'Selectionner un profil'))
			->add('actions', 'entity', array(
				'class'=>'BaquarasTestBundle:Action',
				'label' => 'Onglets',
				'required' => 'false',
				'property'=>'type',
				'multiple' => true,
				'empty_value'=>'Selectionner un profil'))
			->add('access', 'choice', array(
				'label' => 'Accès',
                'choices' => array('L' => 'Consultation','M'=>'Modification'),
				'empty_value' => 'Sélectionner un mode d\'accès'))
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
            'data_class' => 'Baquaras\TestBundle\Entity\GestionDroitsPage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_gestiondroitspage';
    }
}
