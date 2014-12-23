<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Baquaras\TestBundle\Entity\ItemRepository;

class NonRequisType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'entity', array(
				'label' => 'Nom de l\'application non-requise *',
				'class' => 'BaquarasTestBundle:Application',
				'property' => 'NomAndVersion',
				'empty_value' => 'Sélectionner une application'))	
            ->add('modeGestion', 'entity', array(
				'label' => 'Mode de gestion *',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(14); 
					},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionnez un mode de gestion'))
            ->add('oscible', 'entity', array(
				'label' => 'Système d\'exploitation *',
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(22);
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
            'data_class' => 'Baquaras\TestBundle\Entity\NonRequis'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_nonrequis';
    }
}
