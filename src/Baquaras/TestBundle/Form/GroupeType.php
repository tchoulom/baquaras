<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Baquaras\TestBundle\Entity\Groupe;
use Baquaras\TestBundle\Entity\Utilisateur;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class GroupeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'text', array(
				'label' => 'Libellé'))
            ->add('utilisateurs', 'entity', array(
				'class'=>'BaquarasTestBundle:Utilisateur',
				'label' => 'Utilisateurs',
				'required' => 'false',
				'property'=>'NomAndPrenom',
				'multiple' => true,
				'empty_value'=>'Selectionner un utilisateur'))
            /*->add('applications')*/
			->add('save', 'submit', array(
				'label' => 'Valder'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\Groupe'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_groupe';
    }
}
