<?php
	$aliasName = array(
		'controller' => array(
			'group'    => 'Quản lý chức vụ',
			'user'     => 'Quản lý người dùng',
			'category' => 'Quản lý danh mục giáo án',
			'book'     => 'Quản lý giáo án',
			'school'   => 'Quản lý trường',
			'nest'     => 'Quản lý tổ',
			'index'    => 'Trang chủ'
		
		),
		'action'     => array(
			'index'  => 'Trang chủ',
			'info'   => 'Info',
			'add'    => 'Add',
			'edit'   => 'Edit',
			'delete' => 'Delete',
			'email'  => 'Email',
			'image'  => 'Image',
			'form'   => 'Form',
		)
	);
	
	$headerNameParent = $aliasName['controller'][$this->controller];
	$headerNameChild  = $aliasName['action'][$this->action];
	
	$xhtmlHeader = sprintf('<h1>%s <small>%s</small></h1>', $headerNameParent, $headerNameChild);
	
	// 	$xhtmlBreadcrumb		= '';
	// 	if($this->controller != 'index'){
	// 		if($this->action == 'index'){
	// 			$xhtmlBreadcrumb	= sprintf('<li class="active">%s</li><li class="active">%s</li>', $headerNameParent, $headerNameChild);
	// 		}else{
	// 			$xhtmlBreadcrumb	= sprintf('<li class="active"><a href="%s">%s</a></li><li class="active">%s</li>',
	// 											$this->url('adminRoute/default', array('controller' => $this->arrParams['controller'], 'action' => 'index')),
	// 											$headerNameParent, $headerNameChild);
	// 		}
	// 	}
?>

<!-- HEADER -->
<?php echo $xhtmlHeader; ?>

<!-- BREADCRUMB -->
<!-- 
<ol class="breadcrumb">
	<li><a href="<?php //echo $this->url('adminRoute');?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<?php //echo $xhtmlBreadcrumb;?>
</ol>
 -->