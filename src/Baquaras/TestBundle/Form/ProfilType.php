<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ProfilType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'entity', array(
				'label' => 'Profil',
				'empty_value' => 'Sélectionner un profil',
				'class' => 'BaquarasTestBundle:Statut',
				'property' => 'libelle'))
            /*->add('utilisateurs')*/
			->add('statuts', 'entity', array(
				'label' => 'Page de l\'application',
				'empty_value' => 'Sélectionner un statut',
				'class' => 'BaquarasTestBundle:Statut',
				'property' => 'libelle'))
            ->add('pages', 'entity', array(
				'label'=>'Page de l\'application',
				'empty_value' => 'Sélectionner une page',
				'class' => 'BaquarasTestBundle:Action',
				'property' => 'page'))

        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\Profil'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_profil';
    }
}
