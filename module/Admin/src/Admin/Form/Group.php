<?php
	
	namespace Admin\Form;
	
	use \Zend\Form\Form as Form;
	use Zend\Form\Element as Element;
	
	class Group extends Form
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
			
			// CheckBox1
			$this->add(array(
				'name'  => 'group',
				'type'  => 'checkbox',
				'options' => [
			'label'          => 'Trang chức vụ',
			'checked_value'  => 'group',
			'uncheckedValue' => "not",
			'required'       => true,
		],
			));
			
			// CheckBox2
			$this->add(array(
				'name'    => 'user',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Trang người dùng',
					'checked_value' => 'user',
				],
			));
			// CheckBox3
			$this->add(array(
				'name'    => 'category',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Trang danh mục',
					'checked_value' => 'category',
				],
			));
			// CheckBox3
			$this->add(array(
				'name'    => 'book',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Trang giáo án',
					'checked_value' => 'book',
				],
			));
			
			//Check Action
			
			// CheckBox1
			$this->add(array(
				'name'    => 'check_action_status1:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thay đổi một trạng thái',
					'checked_value' => 'status',
				],
			));
			// CheckBox2
			$this->add(array(
				'name'    => 'check_action_multi-status1:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thay đổi nhiều trạng thái',
					'checked_value' => 'multi-status',
				],
			));
			// CheckBox3
			$this->add(array(
				'name'    => 'check_action_form1:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thêm và Chỉnh sửa',
					'checked_value' => 'form',
				],
			));
			
			// CheckBox3
			$this->add(array(
				'name'    => 'check_action_delete1:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xóa một',
					'checked_value' => 'delete',
				],
			));
			
			// CheckBox4
			$this->add(array(
				'name'    => 'check_action_multi-delete1:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xóa nhiều',
					'checked_value' => 'multi-delete',
				],
			));
			// CheckBox5
			$this->add(array(
				'name'    => 'check_action_view1:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xem giáo án',
					'checked_value' => 'view',
				],
			));
			
			// CheckBox6
			$this->add(array(
				'name'    => 'check_action_ordering1:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Cập nhật thứ tự',
					'checked_value' => 'ordering',
				],
			));
			// CheckBox7
			$this->add(array(
				'name'    => 'check_action_groupACP1:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Truy cập Admin',
					'checked_value' => 'groupACP',
				],
			));
			
			
			//Lần 2
			// CheckBox1
			$this->add(array(
				'name'    => 'check_action_status2:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thay đổi một trạng thái',
					'checked_value' => 'status',
				],
			));
			// CheckBox2
			$this->add(array(
				'name'    => 'check_action_multi-status2:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thay đổi nhiều trạng thái',
					'checked_value' => 'multi-status',
				],
			));
			// CheckBox3
			$this->add(array(
				'name'    => 'check_action_form2:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thêm và Chỉnh sửa',
					'checked_value' => 'form',
				],
			));
			
			// CheckBox3
			$this->add(array(
				'name'    => 'check_action_delete2:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xóa một',
					'checked_value' => 'delete',
				],
			));
			
			// CheckBox4
			$this->add(array(
				'name'    => 'check_action_multi-delete2:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xóa nhiều',
					'checked_value' => 'multi-delete',
				],
			));
			// CheckBox5
			$this->add(array(
				'name'    => 'check_action_view2:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xem giáo án',
					'checked_value' => 'view',
				],
			));
			
			// CheckBox6
			$this->add(array(
				'name'    => 'check_action_ordering2:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Cập nhật thứ tự',
					'checked_value' => 'ordering',
				],
			));
			// CheckBox7
			$this->add(array(
				'name'    => 'check_action_groupACP2:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Truy cập Admin',
					'checked_value' => 'groupACP',
				],
			));
			
			// CheckBox1
			$this->add(array(
				'name'    => 'check_action_status3:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thay đổi một trạng thái',
					'checked_value' => 'status',
				],
			));
			// CheckBox2
			$this->add(array(
				'name'    => 'check_action_multi-status3:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thay đổi nhiều trạng thái',
					'checked_value' => 'multi-status',
				],
			));
			// CheckBox3
			$this->add(array(
				'name'    => 'check_action_form3:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thêm và Chỉnh sửa',
					'checked_value' => 'form',
				],
			));
			
			// CheckBox3
			$this->add(array(
				'name'    => 'check_action_delete3:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xóa một',
					'checked_value' => 'delete',
				],
			));
			
			// CheckBox4
			$this->add(array(
				'name'    => 'check_action_multi-delete3:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xóa nhiều',
					'checked_value' => 'multi-delete',
				],
			));
			// CheckBox5
			$this->add(array(
				'name'    => 'check_action_view3:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xem giáo án',
					'checked_value' => 'view',
				],
			));
			// CheckBox6
			$this->add(array(
				'name'    => 'check_action_ordering3:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Cập nhật thứ tự',
					'checked_value' => 'ordering',
				],
			));
			// CheckBox7
			$this->add(array(
				'name'    => 'check_action_groupACP3:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Truy cập Admin',
					'checked_value' => 'groupACP',
				],
			));
			//Lần 3
			
			// CheckBox1
			$this->add(array(
				'name'    => 'check_action_status4:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thay đổi một trạng thái',
					'checked_value' => 'status',
				],
			));
			// CheckBox2
			$this->add(array(
				'name'    => 'check_action_multi-status4:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thay đổi nhiều trạng thái',
					'checked_value' => 'multi-status',
				],
			));
			// CheckBox3
			$this->add(array(
				'name'    => 'check_action_form4:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Thêm và Chỉnh sửa',
					'checked_value' => 'form',
				],
			));
			
			// CheckBox3
			$this->add(array(
				'name'    => 'check_action_delete4:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xóa một',
					'checked_value' => 'delete',
				],
			));
			
			// CheckBox4
			$this->add(array(
				'name'    => 'check_action_multi-delete4:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xóa nhiều',
					'checked_value' => 'multi-delete',
				],
			));
			// CheckBox5
			$this->add(array(
				'name'    => 'check_action_view4:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Xem giáo án',
					'checked_value' => 'view',
				],
			));
			
			// CheckBox6
			$this->add(array(
				'name'    => 'check_action_ordering4:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Cập nhật thứ tự',
					'checked_value' => 'ordering',
				],
			));
			// CheckBox7
			$this->add(array(
				'name'    => 'check_action_groupACP4:',
				'type'    => 'checkbox',
				'options' => [
					'label'         => 'Truy cập Admin',
					'checked_value' => 'groupACP',
				],
			));
			
			// Name
			$this->add(array(
				'name'       => 'name',
				'type'       => 'Text',
				'attributes' => array(
					'class'       => 'form-control',
					'id'          => 'name',
					'placeholder' => 'Nhập tên chức vụ',
				),
				'options'    => array(
					'label'            => 'Tên chức vụ',
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
					'placeholder' => 'Nhập vị trí quyền',
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
					'label'            => 'Trạng thái',
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
				if ($key == 'group') {
					$key = 'Trang truy cập';
				} else if ($key == 'name') {
					$key = 'Tên chức vụ';
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