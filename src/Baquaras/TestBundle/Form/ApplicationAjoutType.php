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
use Symfony\Component\DependencyInjection\Container;

class ApplicationAjoutType extends AbstractType {

    
    private $container;
    private $connection;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->connection = $this->container->get('doctrine.dbal.siera_connection');
        
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $container = $this->container;
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
                    'property' => 'libelle',
                    'query_builder' => function(ItemRepository $er) {
                        return $er->getItemsQueryBuilder(1);
                    },
                    'label' => 'Type de l\'application *',
                    'empty_value' => 'Sélectionner un type d\'application'))
                ->add('utilisateur', 'entity', array(
                    'class' => 'BaquarasTestBundle:Utilisateur',
                    'property' => 'getCompleteName',
                    'query_builder' => function(\Baquaras\TestBundle\Security\User\UtilisateurRepository $er) {
                        return $er->createQueryBuilder('u')
                                ->where('u.profil1 = :profil')
                                ->setParameter('profil', 3);
                    },
                    'label' => 'Chef de produit',
                    'multiple' => true,
                    'empty_value' => 'Sélectionner un ou plusieurs chefs de produit'))
                ->add('appliReferenceeSIERA', 'checkbox', array(
                    'label' => 'Rattachée à une application dans SIERA'))
                ->add('nomApplicationSIERA', 'text', array(
                    'label' => 'Nom de l\'application dans SIERA'))
                ->add('nomClientSIERA', 'text', array(
                    'label' => 'Client dans SIERA'))
                ->add('deptMoa', 'hidden', array(
                    'label' => 'Departement MOA'))
                ->add('deptUsers', 'hidden',array(
                    'label' => 'Departement utilisateurs'))
                ->add('save', 'submit', array(
                    'label' => 'Valider'))
                    
                ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($container) {
                    
                    $application = $event->getData();
                    $form = $event->getForm();
                    if (!$application) {
                        return;
                    }

                    // Check whether the user has chosen to display his email or not.
                    // If the data was submitted previously, the additional value that is
                    // included in the request variables needs to be removed.
                    if (true === $application->getAppliReferenceeSIERA() &&
                        $application->getNomApplicationSIERA()
                        && $application->getNomClientSIERA()) {
                        $results = $container->get('baquaras.connect_siera')->getAllInfosSiera($application->getNomClientSIERA(), $application->getNomApplicationSIERA());  
                        
                        foreach($results as $result) {
                            $application->setCodeMoa($result['moa']) ;
                            $application->setDeptMoa($result['dept_moa']);
                            $application->setDeptUsers($result['dept_utilisateurs']);
                            $application->setIdClientSIERA($result['id_application_siera']);
                        }
                   //  var_dump($results); exit;
                    } 
                        
                })
                ->getForm();

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Baquaras\TestBundle\Entity\Application'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'baquaras_testbundle_application';
    }

}
