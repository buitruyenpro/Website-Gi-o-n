<?php
	
	namespace Admin\Form;
	
	use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
	
	use Zend\Validator\Regex;
	
	use Zend\InputFilter\InputFilter;
	use Zend\Validator\StringLength;
	
	class UserFilter extends InputFilter
	{
		
		public function __construct($options = null, $ordering = null)
		{
			$exclude         = null;
			$requirePassword = true;
			$requireNest     = true;
			$requireSchool   = true;
			if (!empty($options['id'])) {
				$exclude         = array(
					'field' => 'id',
					'value' => $options['id']
				);
				$requirePassword = false;
			}
			if ($ordering == 1) {
				$requireNest = false;
			}
			if ($ordering == 3) {
				$requireSchool = false;
			}
			
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
						'options'                => array('min'      => 4,
						                                  'max'      => 20,
						                                  'messages' => array(
							                                  StringLength::TOO_LONG  => 'Chiều dài tên người dùng từ 4 đến 20 ký tự.',
							                                  StringLength::TOO_SHORT => 'Chiều dài tên người dung từ 4 đến 20 ký tự.',
						                                  ),),
						'break_chain_on_failure' => true
					),
					array(
						'name'                   => 'DbNoRecordExists',
						'options'                => array(
							'table'   => TABLE_USER,
							'field'   => 'username',
							'adapter' => GlobalAdapterFeature::getStaticAdapter(),
							'exclude' => $exclude
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
							'table'   => 'user',
							'field'   => 'email',
							'adapter' => GlobalAdapterFeature::getStaticAdapter(),
							'exclude' => $exclude
						),
						'break_chain_on_failure' => true
					),
				)
			));
			
			// File
			$this->add(array(
				'name'       => 'file',
				'required'   => false,
				'validators' => array(
					array(
						'name'                   => 'FileSize',
						'options'                => array(
							'min' => '10Kb',
							'max' => '2MB',
						),
						'break_chain_on_failure' => true
					),
					array(
						'name'                   => 'FileExtension',
						'options'                => array(
							'extension' => array('jpg', 'png'),
						),
						'break_chain_on_failure' => true
					),
				)
			));
			
			// Password
			// '#^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,15}$#';	// Php4567!
			$this->add(array(
				'name'       => 'password',
				'required'   => $requirePassword,
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
			
			// Ordering
			$this->add(array(
				'name'       => 'ordering',
				'required'   => true,
				'validators' => array(
					array(
						'name'                   => 'Digits',
						'break_chain_on_failure' => true
					),
				)
			));
			
			// Group
			$this->add(array(
				'name'     => 'group',
				'required' => true,
			));
			// School
			$this->add(array(
				'name'     => 'school',
				'required' => $requireSchool,
			));
			// Nest
			$this->add(array(
				'name'     => 'nest',
				'required' => $requireNest,
			));
			
			// Status
			$this->add(array(
				'name'     => 'status',
				'required' => true,
			));
			
		}
	}