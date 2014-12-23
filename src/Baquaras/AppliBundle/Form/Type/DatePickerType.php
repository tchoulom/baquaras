<?php
namespace Baquaras\AppliBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class DatePickerType extends AbstractType
{
    public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);
        $options['widget'] = "single_text";
        $options['input'] = "string";
        $options['format'] = "dd/MM/yyyy";
        return $options;
    }

    public function getParent(array $options)
    {
        return 'date';
    }

	public function getName()
	{
		return 'datepicker';
	}
}