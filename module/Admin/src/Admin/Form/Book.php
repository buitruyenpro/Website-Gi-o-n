<?php
namespace Admin\Form;
use Admin\Model\CategoryTable;
use \Zend\Form\Form as Form;
use Zend\Form\Element as Element;

class Book extends Form {
	
	public function __construct(CategoryTable $categoryTable){
		parent::__construct();
		
		// FORM Attribute
		$this->setAttributes(array(
				'action'	=> '#',
				'method'	=> 'POST',
				'class'		=> 'form-horizontal',
				'role'		=> 'form',
				'name'		=> 'adminForm',
				'id'		=> 'adminForm',
				'style'		=> 'padding-top: 20px;',
				'enctype'	=> 'multipart/form-data'
		));
		
		// ID
		$this->add(array(
				'name' 			=> 'id',
				'attributes' 	=> array(
						'type'  => 'hidden',
				),
		));
		
		// Action
		$this->add(array(
				'name' 			=> 'action',
				'attributes' 	=> array(
						'type'  => 'hidden',
				),
		));
		
		// Picture
		$this->add(array(
				'name' 			=> 'picture',
				'attributes' 	=> array(
						'type'  => 'hidden',
				),
		));
		
		// Name 
		$this->add(array(
				'name'			=> 'name',
				'type'			=> 'Text',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'name',
						'placeholder'	=> 'Enter name',
				),
				'options'		=> array(
						'label'				=> 'Tên giáo án',
						'label_attributes'	=> array(
								'for'		=> 'name',
								'class'		=> 'col-xs-3 control-label',
						)
				),
		));
		
		// Description
		$this->add(array(
				'name'			=> 'description',
				'type'			=> 'Textarea',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'description',
				),
				'options'		=> array(
						'label'				=> 'Miêu tả',
						'label_attributes'	=> array(
								'for'		=> 'description',
								'class'		=> 'col-xs-3 control-label',
						)
				),
		));
		
		// File picture
		$this->add(array(
				'name'			=> 'file',
				'type'			=> 'File',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'file',
				),
				'options'		=> array(
						'label'				=> 'Hình ảnh',
						'label_attributes'	=> array(
								'for'		=> 'file',
								'class'		=> 'col-xs-3 control-label',
						)
				),
		));
		// File docx,pdf,excel
		$this->add(array(
			'name'			=> 'file_send',
			'type'			=> 'File',
			'attributes'	=> array(
				'class'			=> 'form-control',
				'id'			=> 'file',
			),
			'options'		=> array(
				'label'				=> 'Tệp bài đăng',
				'label_attributes'	=> array(
					'for'		=> 'file',
					'class'		=> 'col-xs-3 control-label',
				)
			),
		));
		
		// Ordering
		$this->add(array(
				'name'			=> 'ordering',
				'type'			=> 'Text',
				'attributes'	=> array(
						'class'			=> 'form-control',
						'id'			=> 'ordering',
						'placeholder'	=> 'Nhập thứ tự',
				),
				'options'		=> array(
						'label'				=> 'Thứ tự',
						'label_attributes'	=> array(
								'for'		=> 'ordering',
								'class'		=> 'col-xs-3 control-label',
						)
				),
		));
		
		// Category
		$this->add(array(
				'name'			=> 'category_id',
				'type'			=> 'Select',
				'options'		=> array(
						'empty_option'	=> '-- Chọn thể loại --',
						'value_options'	=> $categoryTable->itemInSelectbox(null, array('task' => 'list-book')),
						'label'	=> 'Thể loại',
						'label_attributes'	=> array(
								'for'		=> 'category_id',
								'class'		=> 'col-xs-3 control-label',
						),
				),
				'attributes'	=> array(
						'class'			=> 'form-control',
				),
		));
		
		// Status
		$this->add(array(
				'name'			=> 'status',
				'type'			=> 'Select',
				'options'		=> array(
						'empty_option'	=> '-- Chọn trạng thái --',
						'value_options'	=> array(
								'active'	=> 'Active',
								'inactive'	=> 'InActive',
						),
						'label'	=> 'Trạng thái',
						'label_attributes'	=> array(
								'for'		=> 'status',
								'class'		=> 'col-xs-3 control-label',
						),
				),
				'attributes'	=> array(
						'class'			=> 'form-control',
				),
		));
		
		
		
	}
	
	public function showMessage(){
		$messages = $this->getMessages();
		
	
		
		if(empty($messages)) return false;
		
		$xhtml = '<div class="callout callout-danger">';
		foreach($messages as $key => $msg){
			
			if ($key == 'name') {
				$key = 'Tên giáo án';
			} else if ($key == 'time') {
				$key = 'Thời gian';
			}else if ($key == 'category_id') {
				$key = 'Nhóm giáo án';
			}else if ($key == 'status') {
				$key = 'Trạng thái';
			}else if ($key == 'ordering') {
				$key = 'Thứ tự';
			}
			
			$xhtml .= sprintf('<p><b>%s:</b> %s</p>',ucfirst($key), current($msg));
		}
		$xhtml .= '</div>';
		return $xhtml;
	}
}