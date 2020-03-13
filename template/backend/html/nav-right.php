<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
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
    <div class="navbar-right">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu"><a href="#"
                                                   class="dropdown-toggle" data-toggle="dropdown"> <i
                            class="glyphicon glyphicon-user"></i> <span><?php echo $username ?> <i
                                class="caret"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header bg-light-blue"><img src="<?php echo $pictureURL; ?>"
                                                               class="img-circle" alt="User Image"/>
                        <p>
							<?php
								echo $fullname;
							?>
                            <small><?php echo $created_by ?></small>
                        </p>
                    </li>
                    <!-- Menu Body -->

                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                        </div>
						<?php
							if ($this->identity()) {
								?>
                                <div class="pull-right">
                                    <a href="<?php echo $this->linkLogout(); ?>" class="btn btn-default btn-flat">Đăng
                                        xuất</a>
                                </div>
								<?php
							} else {
								?>
                                <div class="pull-right">
                                    <a href="<?php echo $this->linkLogin(); ?>" class="btn btn-default btn-flat">Đăng
                                        nhập</a>
                                </div>
								<?php
							}
						?>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>