<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Baquaras\TestBundle\Entity\ItemRepository;

class AutrePreRequisType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'text', array(
				'label' => 'Libellé du pré-requis *'))	
            ->add('commentaire', 'textarea', array(
				'label' => 'Commentaire'))
            ->add('oscible', 'entity', array(
				'label' => 'Système d\'exploitation *',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(22); /* 22 correspond à OS cible */
					},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionnez un système d\'exploitation'))
			->add('save', 'submit', array(
				'label' => 'Enregistrer les modifications'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\AutrePreRequis'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_autreprerequis';
    }
}
