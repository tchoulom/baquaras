<?php
namespace Baquaras\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Baquaras\TestBundle\Entity\ItemRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Baquaras\TestBundle\Form\EventListener\AddFieldSubscriber;

class modifStatutQualifType extends AbstractType{
	
}