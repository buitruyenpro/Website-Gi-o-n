<?php
namespace Zendvn\View\Helper\Url;
use Zend\View\Helper\AbstractHelper;

class LinkRegister extends AbstractHelper {
	
	public function __invoke($options = null){
		$urlHelper	= $this->getView()->plugin('url');
		
		if(URL_FRIENDLY == true){
			return $urlHelper('routeRegister');
		}
		
		return $urlHelper('customerRoute/default', array(
			'controller'	=> 'user',
			'action'		=> 'register',		
		));
	}
}