<?php
	
	namespace Customer;
	
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
		}
		
		public function getFormElementConfig()
		{
			return array(
				'factories' => array(
					'formCustomerRegister' => function ($sm) {
						$myForm = new \Customer\Form\Register();
						$myForm->setInputFilter(new \Customer\Form\RegisterFilter());
						return $myForm;
					},
					'formCustomerLogin'    => function ($sm) {
						$myForm = new \Customer\Form\Login();
						$myForm->setInputFilter(new \Customer\Form\LoginFilter());
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
				'factories'  => array(
					'AuthenticateService'          => function ($sm) {
						$dbTableAdapter = new \Zend\Authentication\Adapter\DbTable($sm->get('dbConfig'), TABLE_USER, 'email', 'password', 'MD5(?)');
						$dbTableAdapter->getDbSelect()->where->equalTo('status', 1)
							->where->equalTo('active_code', 1);
						$authenticateServiceObj = new \Zend\Authentication\AuthenticationService(null, $dbTableAdapter);
						return $authenticateServiceObj;
					},
					'MyAuth'                       => function ($sm) {
						return new \Zendvn\System\Authenticate($sm->get('AuthenticateService'));
					},
					'Customer\Model\CategoryTable' => function ($sm) {
						$tableGateway = $sm->get('CategoryTableGateway');
						return new \Customer\Model\CategoryTable($tableGateway);
					},
					'Customer\Model\BookTable'     => function ($sm) {
						$tableGateway = $sm->get('BookTableGateway');
						return new \Customer\Model\BookTable($tableGateway);
					},
					
					'Customer\Model\UserTable'       => function ($sm) {
						$tableGateway = $sm->get('UserTableGateway');
						return new \Customer\Model\UserTable($tableGateway);
					},
					'PermissionTableGateway'         => function ($sm) {
						$adapter            = $sm->get('dbConfig');
						$resultSetPrototype = new HydratingResultSet();
						$resultSetPrototype->setHydrator(new ObjectProperty());
						$resultSetPrototype->setObjectPrototype(new \Zendvn\Model\Entity\Permission());
						return new TableGateway(TABLE_PERMISSION, $adapter, null, $resultSetPrototype);
					},
					'Customer\Model\GroupTable'      => function ($sm) {
						$tableGateway = $sm->get('GroupTableGateway');
						return new \Customer\Model\GroupTable($tableGateway);
					},
					'Customer\Model\PermissionTable' => function ($sm) {
						$tableGateway = $sm->get('PermissionTableGateway');
						return new \Customer\Model\PermissionTable($tableGateway);
					},
				
				),
				'invokables' => array(
					'Zend\Authentication\AuthenticationService' => 'Zend\Authentication\AuthenticationService',
				),
			);
		}
		
		public function getViewHelperConfig()
		{
			return array(
				'invokables' => array(
					'blkFacebook'      => '\Block\BlkFacebook',
					'cmsBreadcrumb'    => '\Zendvn\View\Helper\CmsBreadcrumb',
					'cmsSummary'       => '\Zendvn\View\Helper\CmsSummary',
					'cmsChangeDisplay' => '\Zendvn\View\Helper\CmsChangeDisplay',
					'formError'        => '\Zendvn\Form\View\Helper\FormError',
					'linkLogin'        => '\Zendvn\View\Helper\Url\LinkLogin',
					'linkRegister'     => '\Zendvn\View\Helper\Url\LinkRegister',
					'linkLogout'       => '\Zendvn\View\Helper\Url\LinkLogout',
					'linkHome'         => '\Zendvn\View\Helper\Url\LinkHome',
				),
				'factories'  => array(
					'blkCategory' => function ($sm) {
						$helper = new \Block\BlkCategory();
						$helper->setData($sm->getServiceLocator()->get('Customer\Model\CategoryTable'));
						return $helper;
					},
					'blkSpecial'  => function ($sm) {
						$helper = new \Block\BlkSpecial();
						$helper->setData($sm->getServiceLocator()->get('Customer\Model\BookTable'));
						return $helper;
					},
					'blkNewBook'  => function ($sm) {
						$helper = new \Block\BlkNewBook();
						$helper->setData($sm->getServiceLocator()->get('Customer\Model\BookTable'));
						return $helper;
					},
					'systemInfo'  => function ($sm) {
						return $sm->getServiceLocator()->get('Zendvn\System\Info');
					},
				),
			);
		}
		
	}