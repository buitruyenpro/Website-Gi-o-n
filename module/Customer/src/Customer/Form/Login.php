<?php
namespace Customer\Form;
use \Zend\Form\Form as Form;
use Zend\Form\Element as Element;

class Login extends Form {
	
	public function __construct($name = null){
		parent::__construct();
		
		
		// FORM Attribute
		$this->setAttributes(array(
				'action'	=> '',
				'method'	=> 'POST',
				'class'		=> 'form-horizontal',
				'name'		=> 'customerForm',
				'id'		=> 'customerForm',
				'enctype'	=> 'multipart/form-data',
		));
		
		// Email
		$this->add(array(
				'name'			=> 'email',
				'type'			=> 'email',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'placeholder'   => 'Địa chỉ Email'
				)
		));
		
		// Password
		$this->add(array(
				'name'			=> 'password',
				'type'			=> 'Password',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'placeholder'   => 'Mật khẩu',
						
				),
				
		));
	}
}