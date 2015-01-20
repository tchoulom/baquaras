<?php

namespace Baquaras\TestBundle\Form;

use Baquaras\TestBundle\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Baquaras\TestBundle\Entity\ItemRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Baquaras\TestBundle\Form\EventListener\AddFieldSubscriber;

class ApplicationAjoutType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text', array(
				'label' => 'Nom de l\'application *'))
			->add('editeur', 'hidden')
			->add('version', 'text', array(
				'label' => 'Version *'))
			->add('description', 'textarea', array(
				'label' => 'Description *'))
			->add('type', 'entity', array(
				'class' => 'BaquarasTestBundle:Item',
				'property' =>'libelle',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(1);
					},
				'label'=>'Type de l\'application *',
				'empty_value' => 'Sélectionner un type d\'application'))
			->add('utilisateur', 'entity', array(
				'class' => 'BaquarasTestBundle:Utilisateur',
				'property' =>'getCompleteName',
				'query_builder' => function(\Baquaras\TestBundle\Security\User\UtilisateurRepository $er) {
					return $er->createQueryBuilder('u')
						->where('u.profil1 = :profil')
						->setParameter('profil', 3);
				},
				'label'=>'Chef de produit',
				'multiple' => true,
				'empty_value' => 'Sélectionner un ou plusieurs chefs de produit'))
			->add('appliReferenceeSIERA', 'checkbox', array(
				'label'=>'Référencée dans SIERA'))
			->add('nomApplicationSIERA', 'text', array(
				'label' => 'Nom de l\'application dans SIERA'))
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
            'data_class' => 'Baquaras\TestBundle\Entity\Application'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_application';
    }
}
