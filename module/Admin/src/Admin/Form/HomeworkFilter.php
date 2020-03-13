<?php
	
	namespace Admin\Form;
	
	use Zend\InputFilter\InputFilter;
	
	class HomeworkFilter extends InputFilter
	{
		
		public function __construct()
		{
			// Name
			$this->add(array(
				'name'       => 'name',
				'required'   => true,
				'validators' => array(
					array(
						'name'                   => 'NotEmpty',
						'break_chain_on_failure' => true
					),
					array(
						'name'                   => 'StringLength',
						'options'                => array('min' => 4, 'max' => 200),
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
			// week
			$this->add(array(
				'name'       => 'week',
				'required'   => true,
				'validators' => array(
					array(
						'name'                   => 'Digits',
						'break_chain_on_failure' => true
					),
				)
			));
			// time
			$this->add(array(
				'name'     => 'time',
				'required' => true
			));
			
			// Status
			$this->add(array(
				'name'     => 'status',
				'required' => true,
			));
			
		}
	}