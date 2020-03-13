<?php
	

	// LOGIN
	$routeLogin = array(
		'type'    => 'Segment',
		'options' => array(
			'route'    => '/login.html',
			'defaults' => array(
				'__NAMESPACE__' => 'Customer\Controller',
				'controller'    => 'User',
				'action'        => 'login'
			)
		)
	);
	
	// REGISTER
	$routeRegister = array(
		'type'    => 'Segment',
		'options' => array(
			'route'    => '/register.html',
			'defaults' => array(
				'__NAMESPACE__' => 'Customer\Controller',
				'controller'    => 'user',
				'action'        => 'register'
			)
		)
	);
	
	// LOGOUT
	$routeLogout = array(
		'type'    => 'Segment',
		'options' => array(
			'route'    => '/logout.html',
			'defaults' => array(
				'__NAMESPACE__' => 'Customer\Controller',
				'controller'    => 'User',
				'action'        => 'logout'
			)
		)
	);
	
	
	// Admin\Controller\Index - indexAction
	$customerRoute = array(
		'type'          => 'Literal',
		'options'       => array(
			'route'    => '/login',
			'defaults' => array(
				'__NAMESPACE__' => 'Customer\Controller',
				'controller'    => 'User',
				'action'        => 'login'
			)
		),
		'may_terminate' => true,
		'child_routes'  => array(
			'default'  => array(
				'type'    => 'Segment',
				'options' => array(
					'route'       => '/[:controller[/:action[/:id]]][/]',
					'constraints' => array(
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'         => '[0-9]*',
					),
					'defaults'    => array()
				)
			),
			'active'   => array(
				'type'    => 'Segment',
				'options' => array(
					'route'       => '/user/active/:id/code/:code[/]',
					'constraints' => array(
						'id' => '[0-9]*',
					),
					'defaults'    => array(
						'__NAMESPACE__' => 'Customer\Controller',
						'controller'    => 'User',
						'action'        => 'active'
					)
				)
			),
			'category' => array(
				'type'    => 'Segment',
				'options' => array(
					'route'       => '/category/index/:id[/display/:display][/order/:order][/dir/:dir][/limit/:limit][/page/:page][/]',
					'constraints' => array(
						'id'      => '[0-9]*',
						'page'    => '[0-9]*',
						'display' => 'grid|list',
						'order'   => 'id|name|price',
						'dir'     => 'ASC|DESC',
						'limit'   => '[0-9]*',
					),
					'defaults'    => array(
						'__NAMESPACE__' => 'Customer\Controller',
						'controller'    => 'Category',
						'action'        => 'index'
					)
				)
			),
		)
	);
	
	return array(
		'router' => array(
			'routes' => array(
				'customerRoute' => $customerRoute,
				'routeRegister' => $routeRegister,
				'routeLogin'    => $routeLogin,
				'routeLogout'   => $routeLogout,
				
			),
		)
	
	);