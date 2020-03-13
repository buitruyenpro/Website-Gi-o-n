<?php
	
	namespace Admin\Form;
	
	use \Zend\Form\Form as Form;
	use Zend\Form\Element as Element;
	
	class Homework extends Form
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
					'placeholder' => 'Nhập tên bài giáo án',
				),
				'options'    => array(
					'label'            => 'Tên giáo án',
					'label_attributes' => array(
						'for'   => 'name',
						'class' => 'col-xs-3 control-label',
					)
				),
			));
			
			// Ordering
			$this->add(array(
				'name'       => 'ordering',
				'type'       => 'number',
				
				'attributes' => array(
					'class'       => 'form-control',
					'id'          => 'ordering',
					'min'        => 1,
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
			// Week
			$this->add(array(
				'name'       => 'week',
				'type'       => 'number',
				'attributes' => array(
					'class'       => 'form-control',
					'id'          => 'week',
					'min'        => 1,
					'placeholder' => 'Nhập số tuần',
				),
				'options'    => array(
					'label'            => 'Số tuần',
					'label_attributes' => array(
						'for'   => 'week',
						'class' => 'col-xs-3 control-label',
					)
				),
			));
			// Time
			$this->add(array(
				'name'       => 'time',
				'type'       => 'date',
				'attributes' => array(
					'class'       => 'form-control',
					'id'          => 'datepicker',
					'placeholder' => 'Thời gian bắt đầu',
				),
				'options'    => array(
					'label'            => 'Thời gian',
					'label_attributes' => array(
						'for'   => 'time',
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
			// description
			$this->add(array(
				'name'       => 'description',
				'type'       => 'Textarea',
				'attributes' => array(
					'class' => 'form-control',
					'id'    => 'description',
				),
				'options'    => array(
					'label'            => 'Miêu tả',
					'label_attributes' => array(
						'for'   => 'description',
						'class' => 'col-xs-3 control-label',
					)
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
				$xhtml .= sprintf('<p><b>%s:</b> %s</p>', ucfirst($key), current($msg));
			}
			$xhtml .= '</div>';
			return $xhtml;
		}
		
		
	}