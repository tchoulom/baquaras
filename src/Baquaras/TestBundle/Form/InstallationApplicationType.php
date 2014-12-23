<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InstallationApplicationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comptabilisationLicense', 'choice', array(
				'label' => 'Comptabilisation des licenses',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
            ->add('nombreLicenses', 'number', array(
				'label' => 'Nombre de licenses'))
            ->add('modaliteAcquisition', 'text', array(
				'label' => 'Modalité d\'acquisition'))
            ->add('modeInstallationSouhaitee', 'text', array(
				'label' => 'Mode d\'installation souhaité'))
            ->add('installationADistance', 'choice', array(
				'label' => 'Installation à distance',
				'choices' => array(1=>'Oui', 0=> 'Non'),
				'expanded' => true,
				'multiple' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\InstallationApplication'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_installationapplication';
    }
}
