<?php
namespace Customer\Form;

use \Zend\Form\Form as Form;
use Zend\Form\Element as Element;

class Register extends Form {
	
	public function __construct(){
		parent::__construct();
		
		// FORM Attribute
		$this->setAttributes(array(
				'action'	=> '#',
				'method'	=> 'POST',
				'class'		=> 'form-horizontal',
				'role'		=> 'form',
				'name'		=> 'customerForm',
				'id'		=> 'customerForm',
				'enctype'	=> 'multipart/form-data'
		));
		
		
		// Username 
		$this->add(array(
				'name'			=> 'username',
				'type'			=> 'Text',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'username',
						'placeholder'	=> 'Nhập username',
				),
		));
		
		// Email
		$this->add(array(
				'name'			=> 'email',
				'type'			=> 'Email',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'email',
						'placeholder'	=> 'Nhập địa chỉ email',
				),
				
		));
		
		// Fullname
		$this->add(array(
				'name'			=> 'fullname',
				'type'			=> 'Text',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'fullname',
						'placeholder'	=> 'Nhập tên đầy đủ',
				),
				
		));
		
		// Password
		$this->add(array(
				'name'			=> 'password',
				'type'			=> 'Password',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'password',
						'placeholder'	=> 'Nhập mật khẩu',
				),
				
		));
		// Password
		$this->add(array(
			'name'			=> 'confirmPassword',
			'type'			=> 'Password',
			'attributes'	=> array(
				'class'			=> 'form-control',
				'id'			=> 'confirmPassword',
				'placeholder'	=> 'Nhập lại mật khẩu',
			),
		
		));
		
	}
}