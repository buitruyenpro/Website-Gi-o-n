<?php
	
	namespace Zendvn\Form\View\Helper;
	
	use Zend\Form\Element\Text;
	use Zend\Form\View\Helper\FormInput as ZendFormInput;
	
	class FormInput extends ZendFormInput
	{
		public function __invoke($name = null, $value = null, $attributes = null, $status = null)
		{
			
			if ($status == 0 || $status == null) {
				$attributes['class'] = !empty($attributes['class']) ? $attributes['class'] : 'col-xs-2';
				$element             = new Text($name);
				$element->setValue($value);
				$element->setAttributes($attributes);
			} else {
				$attributes['class'] = !empty($attributes['class']) ? $attributes['class'] : 'col-xs-2';
				$element             = new Text($name);
				$element->setValue($value);
				$element->setAttributes(array_merge($attributes,['disabled' => 'disabled']));
			}
			
			return $this->render($element);
		}
		
	}
