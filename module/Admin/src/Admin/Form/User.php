<?php
	
	namespace Admin\Form;
	
	use Admin\Model\GroupTable;
	
	use Admin\Model\NestedPermissionTable;
	use Admin\Model\PermissionTable;
	use Admin\Model\SchoolTable;
	use \Zend\Form\Form as Form;
	use Zend\Form\Element as Element;
	
	class User extends Form
	{
		
		public function __construct(GroupTable $groupTable, $ordering, NestedPermissionTable $nestedPermissionTable)
		{
			parent::__construct();
			
			// FORM Attribute
			$this->setAttributes(array(
				'action'  => '#',
				'method'  => 'POST',
				'class'   => 'form-horizontal',
				'role'    => 'form',
				'name'    => 'adminForm',
				'id'      => 'adminForm',
				'style'   => 'padding-top: 20px;',
				'enctype' => 'multipart/form-data'
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
			
			// Avatar
			$this->add(array(
				'name'       => 'avatar',
				'attributes' => array(
					'type' => 'hidden',
				),
			));
			
			// Username
			$this->add(array(
				'name'       => 'username',
				'type'       => 'Text',
				'attributes' => array(
					'class'       => 'form-control',
					'id'          => 'username',
					'placeholder' => 'Enter username',
				),
				'options'    => array(
					'label'            => 'Tên người dùng',
					'label_attributes' => array(
						'for'   => 'username',
						'class' => 'col-xs-3 control-label',
					)
				),
			));
			
			// Sign
			$this->add(array(
				'name'       => 'sign',
				'type'       => 'Textarea',
				'attributes' => array(
					'class' => 'form-control',
					'id'    => 'sign',
				),
				'options'    => array(
					'label'            => 'Miêu tả',
					'label_attributes' => array(
						'for'   => 'sign',
						'class' => 'col-xs-3 control-label',
					)
				),
			));
			
			// Email
			$this->add(array(
				'name'       => 'email',
				'type'       => 'Email',
				'attributes' => array(
					'class'       => 'form-control',
					'id'          => 'email',
					'placeholder' => 'Nhập email',
				),
				'options'    => array(
					'label'            => 'Email',
					'label_attributes' => array(
						'for'   => 'email',
						'class' => 'col-xs-3 control-label',
					)
				),
			));
			
			// File avatar
			$this->add(array(
				'name'       => 'file',
				'type'       => 'File',
				'attributes' => array(
					'class' => 'form-control',
					'id'    => 'file',
				),
				'options'    => array(
					'label'            => 'Hình ảnh',
					'label_attributes' => array(
						'for'   => 'file',
						'class' => 'col-xs-3 control-label',
					)
				),
			));
			
			// Fullname
			$this->add(array(
				'name'       => 'fullname',
				'type'       => 'Text',
				'attributes' => array(
					'class'       => 'form-control',
					'id'          => 'fullname',
					'placeholder' => 'Nhập họ và tên',
				),
				'options'    => array(
					'label'            => 'Họ và tên',
					'label_attributes' => array(
						'for'   => 'fullname',
						'class' => 'col-xs-3 control-label',
					)
				),
			));
			
			// Password
			$this->add(array(
				'name'       => 'password',
				'type'       => 'Password',
				'attributes' => array(
					'class'       => 'form-control',
					'id'          => 'password',
					'placeholder' => 'Nhập mật khẩu',
				),
				'options'    => array(
					'label'            => 'Mật khẩu',
					'label_attributes' => array(
						'for'   => 'password',
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
					'placeholder' => 'Nhập thứ tự',
				),
				'options'    => array(
					'label'            => 'Thứ tự',
					'label_attributes' => array(
						'for'   => 'ordering',
						'class' => 'col-xs-3 control-label',
					)
				),
			));
			
			// Group
			$this->add(array(
				'name'       => 'group',
				'type'       => 'Select',
				'options'    => array(
					'empty_option'     => '-- Chọn chức vụ --',
					'value_options'    => $groupTable->itemInSelectbox(null, array('task' => 'form-user'), $ordering),
					'label'            => 'Chức vụ',
					'label_attributes' => array(
						'for'   => 'group',
						'class' => 'col-xs-3 control-label',
					),
				),
				'attributes' => array(
					'class' => 'form-control',
				),
			));
			// School
			$this->add(array(
				'name'       => 'school',
				'type'       => 'Select',
				'options'    => array(
					'empty_option'     => '-- Chọn trường --',
					'value_options'    => $nestedPermissionTable->itemInSelectbox(null, array('task' => 'list-school')),
					'label'            => 'Quản lý trường',
					'label_attributes' => array(
						'for'   => 'school',
						'class' => 'col-xs-3 control-label',
					),
				),
				'attributes' => array(
					'class' => 'form-control',
				),
			));
			// Nest
			$this->add(array(
				'name'       => 'nest',
				'type'       => 'Select',
				'options'    => array(
					'empty_option'     => '-- Chọn tổ --',
					'value_options'    => $nestedPermissionTable->itemInSelectbox(null, array('task' => 'list-nest')),
					'label'            => 'Quản lý tổ',
					'label_attributes' => array(
						'for'   => 'nest',
						'class' => 'col-xs-3 control-label',
					),
				),
				'attributes' => array(
					'class' => 'form-control',
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
				if ($key == 'school') {
					$key = 'Quản lý trường';
				} else if ($key == 'nest') {
					$key = 'Quản lý tổ';
				} else if ($key == 'username') {
					$key = 'Tên người dùng';
				} else if ($key == 'group') {
					$key = 'Nhóm chức vụ';
				} else if ($key == 'fullname') {
					$key = 'Họ và tên';
				} else if ($key == 'ordering') {
					$key = 'Thứ tự';
				} else if ($key == 'status') {
					$key = 'Trạng thái';
				} else if ($key == 'password') {
					$key = 'Mật khẩu';
				}
				$xhtml .= sprintf('<p><b>%s:</b> %s</p>', ucfirst($key), current($msg));
			}
			$xhtml .= '</div>';
			return $xhtml;
		}
		
		
	}