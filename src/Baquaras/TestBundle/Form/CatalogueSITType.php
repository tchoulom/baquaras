<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatalogueSITType extends AbstractType
{
	public function __construct($id) {
		$this->id = $id;
    }
	
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$id = $this->id ;
	
        $builder
            ->add('referenceApplication', 'text', array(
				'label' => 'Référence de l\'application dans le catalogue'))
            ->add('usageApplication', 'text', array(
				'label' => 'Usage de l\'application'))
            ->add('dateMiseEnLigneApplication', 'date', array(
				'label' => 'Date de mise en ligne de l\'application',
				'format' => 'dd MM yyyy',
				'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))
            ->add('dateFinDeVieApplication', 'date', array(
				'label' => 'Date de fin de vie de l\'application',
				'format' => 'dd MM yyyy',
				'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))
            ->add('typeCatalogue', 'text', array(
				'label' => 'Type du catalogue'))
            ->add('versionPayee', 'text', array(
				'label' => 'Version payée'))
            ->add('cout', 'text', array(
				'label' => 'Coût (en euros)'))
            ->add('docInfoComplementaire', new FichierType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\CatalogueSIT'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_cataloguesit';
    }
}
