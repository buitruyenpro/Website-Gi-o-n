<?php
	
	namespace Customer\Form;
	
	use Zend\InputFilter\InputFilter;
	use Zend\Validator\EmailAddress;
	use Zend\Validator\NotEmpty;
	use Zend\Validator\StringLength;
	
	class LoginFilter extends InputFilter
	{
		
		public function __construct()
		{
			
			// EMAIL
			$this->add(array(
				'name'       => 'email',
				'required'   => true,
				'validators' => array(
					array(
						'name'                   => 'NotEmpty',
						'break_chain_on_failure' => true
					)
				)
			));
			
			// PASSWORD
			$this->add(array(
				'name'       => 'password',
				'required'   => true,
				'validators' => array(
					array(
						'name'                   => 'NotEmpty',
						'break_chain_on_failure' => true
					),
					array(
						'name'                   => 'StringLength',
						'options'                => array(
							'min'      => 5,
							'max'      => 18,
							'messages' => array(
								StringLength::TOO_SHORT => 'Chiều dài mật khẩu từ 5 đến 18 ký tự.',
								StringLength::TOO_LONG  => 'Chiều dài mật khẩu từ 5 đến 18 ký tự.',
							)
						),
						'break_chain_on_failure' => true
					),
				)
			));
		}
	}