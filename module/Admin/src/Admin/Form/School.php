<?php
	
	namespace Admin\Form;
	
	use \Zend\Form\Form as Form;
	use Zend\Form\Element as Element;
	
	class School extends Form
	{
		
		public function __construct($name = null)
		{
			parent::__construct();
			
			// FORM Attribute
			$this->setAttributes(array(
				'action' => '#',
				'method' => 'POST',
				'class'  => 'form-horizontal',
				'role'   => 'form',
				'name'   => 'adminForm',
				'id'     => 'adminForm',
				'style'  => 'padding-top: 20px;',
			));
			
			// ID
			$this->add(array(
				'name'       => 'id',
				'attributes' => array(
					'type' => 'hidden',
				),
			));
			
			// Action
			$this->add(array(
				'name'       => 'action',
				'attributes' => array(
					'type' => 'hidden',
				),
			));
			
			// Name
			$this->add(array(
				'name'       => 'name',
				'type'       => 'Text',
				'attributes' => array(
					'class'       => 'form-control',
					'id'          => 'name',
					'placeholder' => 'Nhập tên trường',
				),
				'options'    => array(
					'label'            => 'Tên trường',
					'label_attributes' => array(
						'for'   => 'name',
						'class' => 'col-xs-3 control-label',
					)
				),
			));
			
			// Ordering
			$this->add(array(
				'name'       => 'ordering',
				'type'       => 'Text',
				'attributes' => array(
					'class'       => 'form-control',
					'id'          => 'ordering',
					'placeholder' => 'Nhập vị trí',
				),
				'options'    => array(
					'label'            => 'Vị trí',
					'label_attributes' => array(
						'for'   => 'ordering',
						'class' => 'col-xs-3 control-label',
					)
				),
			));
			
			// Status
			$this->add(array(
				'name'       => 'status',
				'type'       => 'Select',
				'options'    => array(
					'empty_option'     => '-- Chọn trạng thái --',
					'value_options'    => array(
						'active'   => 'Kích hoạt',
						'inactive' => 'Không kích hoạt',
					),
					'label'            => 'Status',
					'label_attributes' => array(
						'for'   => 'status',
						'class' => 'col-xs-3 control-label',
					),
				),
				'attributes' => array(
					'class' => 'form-control',
				),
			));
			
		}
		
		public function showMessage()
		{
			$messages = $this->getMessages();
			
			if (empty($messages))
				return false;
			
			$xhtml = '<div class="callout callout-danger">';
			foreach ($messages as $key => $msg) {
				if ($key == 'name') {
					$key = 'Tên trường';
				} else if ($key == 'ordering') {
					$key = 'Vị trí';
				} else if ($key == 'status') {
					$key = 'Trạng thái';
				}
				$xhtml .= sprintf('<p><b>%s:</b> %s</p>', ucfirst($key), current($msg));
			}
			$xhtml .= '</div>';
			return $xhtml;
		}
		
		
	}