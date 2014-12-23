<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DroitType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profil',  'entity', array(
				'label' => 'Profil *',
				'empty_value' => 'Sélectionner un profil',
				'class' => 'BaquarasTestBundle:Profil',
				'property' => 'libelle'))
            ->add('page', 'entity', array(
				'label' => 'Page *',
				'empty_value' => 'Sélectionner une page/onglet/champ',
				'class' => 'BaquarasTestBundle:Page',
				'property' => 'libelle'))
            ->add('acces', 'checkbox', array(
				'label' => 'Accès *'))
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
            'data_class' => 'Baquaras\TestBundle\Entity\Droit'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_droit';
    }
}
