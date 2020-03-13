<?php
	return array(
		'controllers'  => array(
			'invokables' => array(
				'Customer\Controller\User'  => 'Customer\Controller\UserController',
				
			)
		),
		'view_manager' => array(
			'doctype'             => 'HTML5',
			'template_path_stack' => array(__DIR__ . '/../view'),
		),
	
	);