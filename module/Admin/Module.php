<?php
	
	namespace Admin;
	
	use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
	
	use Zend\Stdlib\Hydrator\ObjectProperty;
	
	use Zend\Db\ResultSet\HydratingResultSet;
	
	use Zend\Db\TableGateway\TableGateway;
	
	use Zend\Db\ResultSet\ResultSet;
	
	use Zend\Mvc\ModuleRouteListener;
	use Zend\Mvc\MvcEvent;
	
	class Module
	{
		
		public function onBootstrap(MvcEvent $e)
		{
			$eventManager        = $e->getApplication()->getEventManager();
			$moduleRouteListener = new ModuleRouteListener();
			$moduleRouteListener->attach($eventManager);
			
			$adapter = $e->getApplication()->getServiceManager()->get('dbConfig');
			GlobalAdapterFeature::setStaticAdapter($adapter);
		}
		
		public function getFormElementConfig()
		{
			return array(
				'factories' => array(
					'formAdminGroup'    => function ($sm) {
						$myForm = new \Admin\Form\Group();
						$myForm->setInputFilter(new \Admin\Form\GroupFilter());
						return $myForm;
					},
					'formAdminHomework' => function ($sm) {
						$myForm = new \Admin\Form\Homework();
						$myForm->setInputFilter(new \Admin\Form\HomeworkFilter());
						return $myForm;
					},
					'formAdminNest'     => function ($sm) {
						$myForm = new \Admin\Form\Nest();
						$myForm->setInputFilter(new \Admin\Form\NestFilter());
						return $myForm;
					},
					'formAdminSchool'   => function ($sm) {
						$myForm = new \Admin\Form\School();
						$myForm->setInputFilter(new \Admin\Form\SchoolFilter());
						return $myForm;
					},
					'formAdminUser'     => function ($sm) {
						$groupTable            = $sm->getServiceLocator()->get('Admin\Model\GroupTable');
						$nestedPermissionTable = $sm->getServiceLocator()->get('Admin\Model\NestedPermissionTable');
						$infoObj               = new \Zendvn\System\Info();
						$ordering              = $infoObj->getOrderingInfo();
						$myForm                = new \Admin\Form\User($groupTable, $ordering, $nestedPermissionTable);
						$myForm->setInputFilter(new \Admin\Form\UserFilter(null, $ordering));
						return $myForm;
					},
					'formAdminCategory' => function ($sm) {
						$categoryTable = $sm->getServiceLocator()->get('Admin\Model\CategoryTable');
						$myForm        = new \Admin\Form\Category($categoryTable);
						$myForm->setInputFilter(new \Admin\Form\CategoryFilter());
						return $myForm;
					},
					'formAdminBook'     => function ($sm) {
						$categoryTable = $sm->getServiceLocator()->get('Admin\Model\CategoryTable');
						$myForm        = new \Admin\Form\Book($categoryTable);
						$myForm->setInputFilter(new \Admin\Form\BookFilter());
						return $myForm;
					},
					
					'formCustomerHome' => function ($sm) {
						$categoryTable = $sm->getServiceLocator()->get('Admin\Model\CategoryTable');
						$myForm        = new \Admin\Form\Index($categoryTable);
						$myForm->setInputFilter(new \Admin\Form\IndexFilter());
						return $myForm;
					},
				),
			);
		}
		
		public function getConfig()
		{
			return array_merge(
				require_once __DIR__ . '/config/module.config.php',
				require_once __DIR__ . '/config/router.config.php'
			);
		}
		
		public function getAutoloaderConfig()
		{
			return array(
				'Zend\Loader\ClassMapAutoloader' => array(
					__DIR__ . '/autoload_classmap.php'
				),
				'Zend\Loader\StandardAutoloader' => array(
					'namespaces' => array(
						__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
					),
				),
			);
		}
		
		public function getServiceConfig()
		{
			return array(
				'factories' => array(
					'GroupTableGateway'         => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new \Zendvn\Model\Entity\Group());
						return new TableGateway(TABLE_GROUP, $adapter, null, $resultSetPrototype);
					},
					'Admin\Model\GroupTable'    => function ($sm) {
						$tableGateway = $sm->get('GroupTableGateway');
						return new \Admin\Model\GroupTable($tableGateway);
					},
					'TimeLineGateway'           => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new \Zendvn\Model\Entity\TimeLine());
						return new TableGateway(TABLE_TIME_LINE, $adapter, null, $resultSetPrototype);
					},
					'Admin\Model\TimeLineTable' => function ($sm) {
						$tableGateway = $sm->get('TimeLineGateway');
						return new \Admin\Model\TimeLineTable($tableGateway);
					},
					'HomeworkTableGateway'      => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new \Zendvn\Model\Entity\Homework());
						return new TableGateway(TABLE_HOMEWORK, $adapter, null, $resultSetPrototype);
					},
					'Admin\Model\HomeworkTable' => function ($sm) {
						$tableGateway = $sm->get('HomeworkTableGateway');
						return new \Admin\Model\HomeworkTable($tableGateway);
					},
					
					'NestTableGateway'                   => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new \Zendvn\Model\Entity\Nest());
						return new TableGateway(TABLE_NEST, $adapter, null, $resultSetPrototype);
					},
					'Admin\Model\NestTable'              => function ($sm) {
						$tableGateway = $sm->get('NestTableGateway');
						return new \Admin\Model\NestTable($tableGateway);
					},
					'SchoolTableGateway'                 => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new ResultSet();
						$resultSetPrototype->setArrayObjectPrototype(new \Zendvn\Model\Entity\School());
						return new TableGateway(TABLE_SCHOOL, $adapter, null, $resultSetPrototype);
					},
					'Admin\Model\SchoolTable'            => function ($sm) {
						$tableGateway = $sm->get('SchoolTableGateway');
						return new \Admin\Model\SchoolTable($tableGateway);
					},
					'UserTableGateway'                   => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new HydratingResultSet();
						$resultSetPrototype->setHydrator(new ObjectProperty());
						$resultSetPrototype->setObjectPrototype(new \Zendvn\Model\Entity\User());
						return new TableGateway(TABLE_USER, $adapter, null, $resultSetPrototype);
					},
					'Admin\Model\UserTable'              => function ($sm) {
						$tableGateway = $sm->get('UserTableGateway');
						return new \Admin\Model\UserTable($tableGateway);
					},
					'NestedTableGateway'                 => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new HydratingResultSet();
						$resultSetPrototype->setHydrator(new ObjectProperty());
						$resultSetPrototype->setObjectPrototype(new \Zendvn\Model\Entity\Nested());
						return new TableGateway(TABLE_NESTED, $adapter, null, $resultSetPrototype);
					},
					'Admin\Model\NestedTable'            => function ($sm) {
						$tableGateway = $sm->get('NestedTableGateway');
						return new \Admin\Model\NestedPermissionTable($tableGateway);
					},
					'NestedTablePermissionGateway'       => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new HydratingResultSet();
						$resultSetPrototype->setHydrator(new ObjectProperty());
						$resultSetPrototype->setObjectPrototype(new \Zendvn\Model\Entity\NestedPermission());
						return new TableGateway(TABLE_NESTED_PERMISSION, $adapter, null, $resultSetPrototype);
					},
					'Admin\Model\NestedPermissionTable'  => function ($sm) {
						$tableGateway = $sm->get('NestedTablePermissionGateway');
						return new \Admin\Model\NestedPermissionTable($tableGateway);
					},
					'CategoryTableGateway'               => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new HydratingResultSet();
						$resultSetPrototype->setHydrator(new ObjectProperty());
						$resultSetPrototype->setObjectPrototype(new \Zendvn\Model\Entity\Category());
						return new TableGateway(TABLE_CATEGORY, $adapter, null, $resultSetPrototype);
					},
					'PermissionTableGateway'             => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new HydratingResultSet();
						$resultSetPrototype->setHydrator(new ObjectProperty());
						$resultSetPrototype->setObjectPrototype(new \Zendvn\Model\Entity\Permission());
						return new TableGateway(TABLE_PERMISSION, $adapter, null, $resultSetPrototype);
					},
					'Admin\Model\CategoryTable'          => function ($sm) {
						$tableGateway = $sm->get('CategoryTableGateway');
						return new \Admin\Model\CategoryTable($tableGateway);
					},
					'BookTableGateway'                   => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new HydratingResultSet();
						$resultSetPrototype->setHydrator(new ObjectProperty());
						$resultSetPrototype->setObjectPrototype(new \Zendvn\Model\Entity\Book());
						return new TableGateway(TABLE_BOOK, $adapter, null, $resultSetPrototype);
					},
					'Admin\Model\BookTable'              => function ($sm) {
						$tableGateway = $sm->get('BookTableGateway');
						return new \Admin\Model\BookTable($tableGateway);
					},
					'Admin\Model\IndexTable'             => function ($sm) {
						$tableGateway = $sm->get('BookTableGateway');
						return new \Admin\Model\IndexTable($tableGateway);
					},
					'Admin\Model\PermissionTableGateway' => function ($sm) {
						$tableGateway = $sm->get('PermissionTableGateway');
						return new \Admin\Model\PermissionTable($tableGateway);
					},
				),
			);
		}
		
		public function getViewHelperConfig()
		{
			return array(
				'invokables' => array(
					'cmsLinkSort'       => '\Zendvn\View\Helper\CmsLinkSort',
					'cmsInfoPrice'      => '\Zendvn\View\Helper\CmsInfoPrice',
					'cmsInfoUser'       => '\Zendvn\View\Helper\CmsInfoUser',
					'cmsInfoAuthor'     => '\Zendvn\View\Helper\CmsInfoAuthor',
					'cmsLinkAdmin'      => '\Zendvn\View\Helper\CmsLinkAdmin',
					'cmsButtonStatus'   => '\Zendvn\View\Helper\CmsButtonStatus',
					'cmsButtonSpecial'  => '\Zendvn\View\Helper\CmsButtonSpecial',
					'cmsButtonMove'     => '\Zendvn\View\Helper\CmsButtonMove',
					'cmsButtonToolbar'  => '\Zendvn\View\Helper\CmsButtonToolbar',
					'zvnFormHidden'     => '\Zendvn\Form\View\Helper\FormHidden',
					'zvnFormSelect'     => '\Zendvn\Form\View\Helper\FormSelect',
					'zvnFormInput'      => '\Zendvn\Form\View\Helper\FormInput',
					'zvnFormButton'     => '\Zendvn\Form\View\Helper\FormButton',
					'cmsButtonGroupACP' => '\Zendvn\View\Helper\CmsButtonGroupACP',
					'cmsLinkCustomer'   => '\Zendvn\View\Helper\CmsLinkCustomer',
				)
			);
		}
		
	}