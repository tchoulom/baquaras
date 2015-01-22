<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array(
                'label' => 'Nom *'))
            ->add('prenom', 'text', array(
                'label' => 'Prénom *'))
            ->add('cpteMatriculaire', 'text', array(
                'label' => 'Compte matriculaire *'))
            ->add('mail', 'text', array(
                'label' => 'Mail'))
            ->add('telephone', 'text', array(
                'label' => 'Téléphone'))
            ->add('profil1', 'entity', array(
                'label' => 'Profil *',
                'class' => 'BaquarasTestBundle:Profil',
                'property' => 'libelle',
                'empty_value' => 'Sélectionner un profil',
                'expanded' => false))
            ->add('profil2', 'entity', array(
                'label' => 'Autre profil',
                'class' => 'BaquarasTestBundle:Profil',
                'property' => 'libelle',
                'empty_value' => 'Sélectionner un profil additionnel',
                'expanded' => false))
            ->add('save', 'submit', array(
                'label' => 'Enregistrer'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\Utilisateur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_utilisateur';
    }
}
