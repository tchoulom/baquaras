<?php
/**
 * Controleur qui gère la page d'acceuil
 */
namespace Baquaras\AppliBundle\Controller;

use Symfony\Component\Validator\Constraints\Choice;

use Symfony\Component\Validator\Constraints\ChoiceValidator;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class AppliController extends Controller
{
    /**
     * affiche la page d'accueil
     * @Route("/", name="_accueil")
     * @Template()
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Bundle\FrameworkBundle\Controller\Response
     */
    public function accueilAction(Request $request)
    {
        // Exemple de contraintes (normalement definis dans les annotations du modèles, c'est juste un exemple de cration à chaud)
        $collectionConstraint = new Collection(array(
            'nom' => new MinLength(5),
            'prenom'=> array(new NotBlank()),
            'adresse'=> array(new NotBlank()),
            'ville'=> array(new NotBlank()),
            'question'=> array(new NotBlank()),
            'prenom'=> array(new NotBlank()),
            'pays' =>new Choice(
                                        array('1', '2','3', '4')
                               ),
            'Texte Libre'=> array(),  // pas de contrainte
            'date' => new Date(),
        ));

        // Fake form
        $form = $this->createFormBuilder(null, array('validation_constraint' => $collectionConstraint))
            ->add('nom', 'text')
            ->add('prenom', 'text')
            ->add('date', 'datepicker', array('label' => 'Date de livraison'))
            ->add('adresse', 'text')
            ->add('ville', 'text')
            ->add('pays', 'choice', array('choices' => array('Amériques' => array('1'=>'Canada', '2'=>'Etats-Unis'), 'Europe' => array('3'=>'Canada', '4'=>'Etats-Unis'))))
            ->add('question', 'choice', array('label' => 'Est ce que ceci est bien l\'adresse à laquelle vous souhaitez être livré ?', 'choices' => array('yes', 'no'), 'multiple' => false, 'expanded' => true))
            ->add('Texte Libre', 'textarea', array('required' => false))
            ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $this->get('session')->setFlash('notice','Votre formulaire a été validé.');
                // perform some action, such as saving the task to the database
                return $this->redirect($this->generateUrl('_accueil'));
            }
        }

        $view = $form->createView();
        // on utilise le theme de formualaire fourni par Sonata (il permet d'avoir les CSS de Bootstrap appliqués)
        $this->get('twig')->getExtension('form')->setTheme($view, array(
            'SonataDoctrineORMAdminBundle:Form:form_admin_fields.html.twig'
        ));

        return $this->render('BaquarasAppliBundle:Appli:accueil.html.twig', array('form' => $view));
    }

    /**
     * As some auth handler doesn't redirect, the homepage redirect is forced here
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginAction()
    {
        return $this->redirect($this->generateUrl('_userPage'));
    }
}
