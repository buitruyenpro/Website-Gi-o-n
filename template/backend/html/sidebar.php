<?php
	
	use Zendvn\System\Info;
	
	$infoObj  = new Info();
	$arrMenus = [];
	
	if ($infoObj->getGroupInfo('group_acp') == 1) {
		if ($infoObj->getOrderingInfo() == 1) {
			$arrMenus = array(
				array('class' => 'index', 'name' => 'Trang chủ', 'icon' => 'home', 'link' => $this->basePath('home.html/')),
				array('class' => 'group', 'name' => 'Chức vụ', 'icon' => 'group', 'link' => $this->basePath('admin.html/group/index')),
				array('class' => 'user', 'name' => 'Người dùng', 'icon' => 'user', 'link' => $this->basePath('admin.html/user/index')),
				array('class' => 'school', 'name' => 'Quản lý Trường', 'icon' => 'user', 'link' => $this->basePath('admin.html/school/index')),
				array('class' => 'category', 'name' => 'Nhóm tài liệu', 'icon' => 'suitcase', 'link' => $this->basePath('admin.html/category/index')),
				array('class' => 'book', 'name' => 'Giáo án', 'icon' => 'book', 'link' => $this->basePath('admin.html/book/index')),
			);
		} else if ($infoObj->getOrderingInfo() == 3) {
			$arrMenus = array(
				array('class' => 'index', 'name' => 'Trang chủ', 'icon' => 'home', 'link' => $this->basePath('home.html/')),
				array('class' => 'group', 'name' => 'Chức vụ', 'icon' => 'group', 'link' => $this->basePath('admin.html/group/index')),
				array('class' => 'user', 'name' => 'Người dùng', 'icon' => 'user', 'link' => $this->basePath('admin.html/user/index')),
				array('class' => 'nest', 'name' => 'Quản lý tổ', 'icon' => 'user', 'link' => $this->basePath('admin.html/Nest/index')),
				array('class' => 'category', 'name' => 'Nhóm tài liệu', 'icon' => 'suitcase', 'link' => $this->basePath('admin.html/category/index')),
				array('class' => 'book', 'name' => 'Giáo án', 'icon' => 'book', 'link' => $this->basePath('admin.html/book/index')),
			);
		} else if ($infoObj->getOrderingInfo() == 4) {
			$arrMenus = array(
				array('class' => 'index', 'name' => 'Trang chủ', 'icon' => 'home', 'link' => $this->basePath('home.html/')),
				array('class' => 'group', 'name' => 'Chức vụ', 'icon' => 'group', 'link' => $this->basePath('admin.html/group/index')),
				array('class' => 'user', 'name' => 'Người dùng', 'icon' => 'user', 'link' => $this->basePath('admin.html/user/index')),
				array('class' => 'homework', 'name' => 'Lịch giáo án', 'icon' => 'calendar', 'link' => $this->basePath('admin.html/homework/index')),
				array('class' => 'category', 'name' => 'Nhóm tài liệu', 'icon' => 'suitcase', 'link' => $this->basePath('admin.html/category/index')),
				array('class' => 'book', 'name' => 'Giáo án', 'icon' => 'book', 'link' => $this->basePath('admin.html/book/index')),
			);
		}
		
	} else {
		$arrMenus = array(
			array('class' => 'group', 'name' => 'Trang chủ', 'icon' => 'group', 'link' => $this->basePath('home.html/')),
		);
	}
	
	$xhtmlMenu = '';
	foreach ($arrMenus as $menu) {
		if (!empty($menu['children'])) {
			$xhtmlChildMenu = '';
			foreach ($menu['children'] as $menuChild) {
				$xhtmlChildMenu .= sprintf('<li class="admin-%s">
												<a href="%s" style="margin-left: 10px;">
													<i class="fa fa-%s"></i> %s
												</a>
											</li>', $menuChild['class'], $menuChild['link'], $menuChild['icon'], $menuChild['name']);
			}
			$xhtmlMenu .= sprintf('<li class="treeview admin-%s">
										<a href="%s"> 
											<i class="fa fa-%s"></i> <span>%s</span><i class="fa fa-angle-left pull-right"></i>
										</a>
										<ul class="treeview-menu">
											%s
										</ul>
									</li>', $menu['class'], $menu['link'], $menu['icon'], $menu['name'], $xhtmlChildMenu);
		} else {
			$xhtmlMenu .= sprintf('<li class="admin-%s">
									<a href="%s"> 
										<i class="fa fa-%s"></i><span>%s</span>
									</a>
								</li>', $menu['class'], $menu['link'], $menu['icon'], $menu['name']);
		}
	}

?>

<?php
	$ImageAvatar = $this->identity()->avatar;
	$fullname    = !empty($this->identity()->fullname) ? $this->identity()->fullname : "Khách";
	$username    = !empty($this->identity()->username) ? $this->identity()->username : "Khách";
	$created_by  = $this->identity()->created_by;
	$pictureURL  = '';
	if ($ImageAvatar == null) {
		$pictureURL = URL_FILES . '/users/thumb/avatar3.png';
	} else {
		$pictureURL = URL_FILES . '/users/' . $ImageAvatar;
	}


?>

<section class="sidebar">

    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="<?php echo $pictureURL; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p><?php echo $username; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
		<?php echo $xhtmlMenu; ?>
    </ul>
</section>