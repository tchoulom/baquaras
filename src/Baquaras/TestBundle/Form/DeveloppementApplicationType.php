<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeveloppementApplicationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('developpementSpecifique', 'choice', array(
				'label' => 'Développement spécifique',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
            ->add('appliAvecTMA', 'choice', array(
				'label' => 'Application avec TMA',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
            ->add('outilDeveloppement', 'text', array(
				'label' => 'Outils de développement'))
            ->add('loginCompteTest', 'text', array(
				'label' => 'Identifiant du compte de test'))
            ->add('passwordCompteTest', 'text', array(
				'label' => 'Mot de passe du compte de test'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\DeveloppementApplication'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_developpementapplication';
    }
}
