<?php
namespace Admin\Form;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

use Zend\Validator\Regex;

use Zend\InputFilter\InputFilter;

class IndexFilter extends InputFilter {
	
	public function __construct($options = null){
		
		$exclude = null;
		if(!empty($options['id'])){
			$exclude	= array(
					'field'	=> 'id',
					'value'	=> 	$options['id']	
			);
		}
		
		// Name
		$this->add(array(
				'name'		=> 'name',
				'required'	=> true,
				'validators'	=> array(
						array(
								'name'		=> 'NotEmpty',
								'break_chain_on_failure'	=> true
						),
						array(
								'name'		=> 'StringLength',
								'options'	=> array('min' => 4, 'max' => 200),
								'break_chain_on_failure'	=> true
						),
						array(
								'name'		=> 'DbNoRecordExists',
								'options'	=> array(
										'table'		=> TABLE_BOOK,
										'field'		=> 'name',
										'adapter'	=> GlobalAdapterFeature::getStaticAdapter(),
										'exclude'	=> $exclude
								),
								'break_chain_on_failure'	=> true
						),
				)
		));
		
		// File
		$this->add(array(
				'name'		=> 'file',
				'required'	=> false,
				'validators'	=> array(
						array(
								'name'		=> 'FileSize',
								'options'	=> array(
										'min'	=> '1Kb',
										'max'	=> '10MB',
								),
								'break_chain_on_failure'	=> true
						),
						array(
								'name'		=> 'FileExtension',
								'options'	=> array(
										'extension'		=> array('jpg', 'png'),
								),
								'break_chain_on_failure'	=> true
						),
				)
		));
		
		// File
		$this->add(array(
			'name'		=> 'file_send',
			'required'	=> false,
			'validators'	=> array(
				array(
					'name'		=> 'FileSize',
					'options'	=> array(
						'min'	=> '10Kb',
						'max'	=> '10MB',
					),
					'break_chain_on_failure'	=> true
				),
				array(
					'name'		=> 'FileExtension',
					'options'	=> array(
						'extension'		=> array('zip', 'pdf','png'),
					),
					'break_chain_on_failure'	=> true
				),
			)
		));
		
		// Category
		$this->add(array(
				'name'		=> 'category_id',
				'required'	=> true,
		));
		
		
		
	}
}