<?php
	
	namespace Zendvn\Form\View\Helper;
	
	use Zend\Form\ElementInterface;
	use Zend\Form\View\Helper\FormElementErrors;
	class FormError extends FormElementErrors
	{
	
		public function __invoke(ElementInterface $element)
		{
			
			$messages = $element->getMessages();
			if (empty($messages))
				return '';
			
			return sprintf('<div class="callout callout-danger" style="margin-top:7px;color: red;">%s</div>', current($messages));
		}
	}