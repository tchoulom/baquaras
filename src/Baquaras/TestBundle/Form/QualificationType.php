<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Baquaras\TestBundle\Entity\ItemRepository;
use Baquaras\TestBundle\Entity\AgentsRepository;
use Baquaras\TestBundle\Entity\QualificationRepository;
use Baquaras\TestBundle\Security\User\UtilisateurRepository;

class QualificationType extends AbstractType
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
		$id = $this->id;
		
        $builder
            ->add('type', 'entity', array(	
				'label' => 'Type de qualification',			
				'class' => 'BaquarasTestBundle:Item',
				'query_builder' => function(ItemRepository $er){
					return $er->getItemsQueryBuilder(19); 
					},	
				'property' => 'libelle',
				'empty_value' => 'Sélectionner un type de qualification'))			
            ->add('numeroLot', 'text', array(
				'label' => 'Numéro de lot *'))
            ->add('dateDemarragePackaging', 'date', array(
				'label' => 'Date de démarrage packaging',
				'format' => 'dd MM yyyy',
				'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))
            ->add('dateRecetteStandardisation', 'date', array(
				'label' => 'Date de recette standardisation',
				'format' => 'dd MM yyyy',
				'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))
			->add('dateRecetteConformite', 'date', array(
				'label' => 'Date de recette mise en conformité',
				'format' => 'dd MM yyyy',
				'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))
            ->add('dateMiseEnServiceSouhaitee', 'date', array(
				'label' => 'Date de mise en service souhaitée',
				'format' => 'dd MM yyyy',
				'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))
            ->add('dateProductionQualification', 'date', array(
				'label' => 'Date de mise en production',
				'format' => 'dd MM yyyy',
				'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))

            ->add('pVPrequalification', new FichierType(), array( //Ernest TCHOULOM "new FichierType()"
				'label' => 'PV de pré-qualification' ))
	    ->add('agentPreQualif', 'entity', array(                                                     //Ernest TCHOULOM 11-03-2015
				'label' => 'Agent chargé de la pré-qualification',
				'class' => 'BaquarasTestBundle:Utilisateur',
                                'attr' => array('class' => 'form-control select2'),
                                'empty_value' => 'Sélectionner l\'agent chargé de pré-qualification',
                'property' => 'getCompleteName',
                'query_builder' => function(\Baquaras\TestBundle\Security\User\UtilisateurRepository $er) //use ($id)//Ernest TCHOULOM 11-03-2015
                {
                        return $er->createQueryBuilder('a')
                                  ->leftJoin('a.profil1', 'prof')
                                  ->addSelect('prof')
                                  ->where('prof.libelle = :libelle1')
                                  ->setParameter('libelle1', 'Qualificateur')   
                                  ->orWhere('prof.libelle = :libelle2')
                                  ->setParameter('libelle2', 'Responsable qualification');
                },
		) )
            
            /*->add('type', 'choice', array('label' => 'Type', 'choices' => $this->libelle(), 'attr' => array('class' => 'form-control select2'), 'empty_value' => 'Sélectionnez l\'agent')) */                                   
            ->add('pVQualification', new FichierType(), array( //Ernest TCHOULOM "new FichierType()"
				'label' => 'PV de Qualification'))
            ->add('datePVQualification', 'date', array(
				'label' => 'Date du PV de qualification',
				'format' => 'dd MM yyyy',
				'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))
	->add('agentQualif', 'entity', array(                                                           //Ernest TCHOULOM 11-03-2015
				'label' => 'Agent chargé de la qualification',
				'class' => 'BaquarasTestBundle:Utilisateur',
                'property' => 'getCompleteName',
                'empty_value' => 'Sélectionner l\'agent chargé de qualification',            
                'query_builder' => function(\Baquaras\TestBundle\Security\User\UtilisateurRepository $er) //use ($id) //Ernest TCHOULOM 11-03-2015
                {
                         return $er->createQueryBuilder('a')
                                  ->leftJoin('a.profil1', 'prof')
                                  ->addSelect('prof')
                                  ->where('prof.libelle = :libelle1')
                                  ->setParameter('libelle1', 'Qualificateur')   
                                  ->orWhere('prof.libelle = :libelle2')
                                  ->setParameter('libelle2', 'Responsable qualification');
                },
		))

            ->add('sousCompte', 'text', array(
				'label' => 'Sous compte'))
			->add('commentaire', 'textarea', array(
				'label' => 'Commentaire'))
            /*->add('package')*/
        ;
    }
    

    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\Qualification'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'baquaras_testbundle_qualification';
    }
}
