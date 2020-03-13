<?php
	
	namespace Customer\Form;
	
	use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
	
	use Zend\Validator\Db\NoRecordExists;
	use Zend\Validator\Identical;
	use Zend\Validator\Regex;
	
	use Zend\InputFilter\InputFilter;
	use Zend\Validator\StringLength;
	
	class RegisterFilter extends InputFilter
	{
		
		public function __construct($options = null)
		{
			
			// Username
			$this->add(array(
				'name'       => 'username',
				'required'   => true,
				'validators' => array(
					array(
						'name'                   => 'NotEmpty',
						'break_chain_on_failure' => true
					),
					array(
						'name'                   => 'StringLength',
						'options'                => array('min' => 5, 'max' => 18),
						'break_chain_on_failure' => true,
						'messages'               => array(
							StringLength::TOO_SHORT => 'Chiều dài tên người dùng từ 5 đến 18 ký tự.',
							StringLength::TOO_LONG  => 'Chiều dài tên người dùng từ 5 đến 18 ký tự.',
						)
					),
					array(
						'name'                   => 'DbNoRecordExists',
						'options'                => array(
							'table'    => TABLE_USER,
							'field'    => 'username',
							'adapter'  => GlobalAdapterFeature::getStaticAdapter(),
							'messages' => array(
								NoRecordExists::ERROR_RECORD_FOUND => 'Tên người dùng này đã tồn tại.',
							)
						),
						'break_chain_on_failure' => true
					),
				)
			));
			
			// Email
			$this->add(array(
				'name'       => 'email',
				'required'   => true,
				'validators' => array(
					array(
						'name'                   => 'EmailAddress',
						'break_chain_on_failure' => true
					),
					array(
						'name'                   => 'DbNoRecordExists',
						'options'                => array(
							'table'   => TABLE_USER,
							'field'   => 'email',
							'adapter' => GlobalAdapterFeature::getStaticAdapter(),
							'messages' => array(
								NoRecordExists::ERROR_RECORD_FOUND => 'Email này đã tồn tại.',
							)
						),
						'break_chain_on_failure' => true
					),
				)
			));
			
			// Password
			// '#^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,15}$#';	// Php4567!
			$this->add(array(
				'name'       => 'password',
				'required'   => true,
				'validators' => array(
					array(
						'name'                   => 'Regex',
						'options'                => array(
							'pattern'  => '#^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,15}$#',
							'messages' => array(
								Regex::NOT_MATCH => 'Chiều dài 8 đến 15 ký tự, có ít nhất 1 ký tự in hoa, 1 ký tự in thường, 1 giá trị số và 1 ký tự đặc biệt'
							),
						),
						'break_chain_on_failure' => true
					),
				)
			));
			
			$this->add(array(
				'name' => 'confirmPassword', // references (5)
				'filters' => array(new \Zend\Filter\StringTrim()),
				'validators' => array(
					array(
						'name' => 'Identical',
						'options' => array(
							'token' => 'password',
							'messages' => array(
								Identical::NOT_SAME => 'Mật khẩu bạn nhập không trùng khớp.',
							)
						),
					),
				),
			));
			
		}
	}