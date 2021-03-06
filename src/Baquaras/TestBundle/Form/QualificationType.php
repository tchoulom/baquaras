<?php

namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Baquaras\TestBundle\Entity\ItemRepository;
use Baquaras\TestBundle\Entity\AgentsRepository;

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
            ->add('pVPrequalification','file', array(
				'label' => 'PV de pré-qualification' ))
			->add('agentPreQualif', 'entity', array(
				'label' => 'Agent chargé de la pré-qualification',
				'class' => 'BaquarasTestBundle:Agents',
                'property' => 'libelle',
                'query_builder' => function(AgentsRepository $er) use ($id)
                {
                        return $er->createQueryBuilder('a')
                                        ->where('a.application = :id')
										->andWhere('a.role = :role')
                                        ->setParameter('id', $id)
										->setParameter('role', 'preQualif');
                },
				'read_only' => 'true'))
            ->add('pVQualification', 'file', array(
				'label' => 'PV de Qualification'))
            ->add('datePVQualification', 'date', array(
				'label' => 'Date du PV de qualification',
				'format' => 'dd MM yyyy',
				'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour')))
			->add('agentQualif', 'entity', array(
				'label' => 'Agent chargé de la qualification',
				'class' => 'BaquarasTestBundle:Agents',
                'property' => 'libelle',
                'query_builder' => function(AgentsRepository $er) use ($id)
                {
                        return $er->createQueryBuilder('a')
                                        ->where('a.application = :id')
										->andWhere('a.role = :role')
                                        ->setParameter('id', $id)
										->setParameter('role', 'qualif');
                },
				'read_only' => 'true'))
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
