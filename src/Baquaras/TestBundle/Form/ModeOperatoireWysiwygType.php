<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModeOperatoireWysiwygType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
			->add('precautions', 'textarea', array(
				'label' => 'Précautions avant intervention',
				'attr' => array('class' => 'ckeditor')))
			->add('preliminaire', 'textarea', array(
				'label' => 'Préliminaire',
				'attr' => array('class' => 'ckeditor')))
			->add('installation', 'textarea', array(
				'label' => 'Installation',
				'attr' => array('class' => 'ckeditor')))
			->add('test', 'textarea', array(
				'label' => 'Test',
				'attr' => array('class' => 'ckeditor')))
			->add('repriseexistant', 'textarea', array(
				'label' => 'Reprise de l\'existant',
				'attr' => array('class' => 'ckeditor')))
			->add('arborescence', 'textarea', array(
				'label' => 'Arborescence créée',
				'attr' => array('class' => 'ckeditor')))
			->add('parameters', 'textarea', array(
				'label' => 'Fichiers paramètres',
				'attr' => array('class' => 'ckeditor')))
			
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
            'data_class' => 'Baquaras\TestBundle\Entity\ModeOperatoireWysiwyg'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_modeoperatoirewysiwyg';
    }
}
