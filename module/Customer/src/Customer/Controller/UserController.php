<?php
	
	namespace Customer\Controller;
	
	use Customer\Form\LoginFilter;
	use Zend\Form\FormInterface;
	use Zendvn\Controller\ActionController;
	use Zend\View\Model\ViewModel;
	use Zendvn\System\Info;
	
	class UserController extends ActionController
	{
		public function init()
		{
			// OPTIONS
			$this->_options['tableName'] = 'Admin\Model\UserTable';
			$this->_options['formName']  = 'formAdminUser';
			
			// DATA
			$this->_params['data'] = array_merge(
				$this->params()->fromRoute(),
				$this->getRequest()->getFiles()->toArray(),
				$this->getRequest()->getPost()->toArray()
			);
		}
		
		public function loginAction()
		{
			$authService = $this->getServiceLocator()->get('MyAuth');
			if ($this->identity())
				$this->redirect()->toRoute('adminRoute');
			
			$myForm = $this->getServiceLocator()->get('FormElementManager')->get('formCustomerLogin');
			
			if ($this->getRequest()->isPost()) {
				$myForm->setData($this->_params['data']);
				if ($myForm->isValid()) {
					$this->_params['data'] = $myForm->getData(FormInterface::VALUES_AS_ARRAY);
					
					if ($authService->login($this->_params['data']) == true) {
						$userID  = $this->identity()->id;
						$groupID = $this->identity()->group_id;
						
						
						$userTable       = $this->getServiceLocator()->get('Customer\Model\UserTable');
						$groupTable      = $this->getServiceLocator()->get('Customer\Model\GroupTable');
						$permissionTable = $this->getServiceLocator()->get('Customer\Model\PermissionTable');
						
						$data['user']                     = $userTable->getItem(array('id' => $userID), array('task' => 'store-user-info'));
						$data['group']                    = $groupTable->getItem(array('id' => $groupID), array('task' => 'store-group-info'));
						$data['permission']['role']       = $data['group']->name;
						$data['permission']['privileges'] = $permissionTable->getItem($data['group'], array('task' => 'store-permission-info'));
						
						$id                          = $this->identity()->group_id;
						$groupTable                  = $this->getServiceLocator()->get('Admin\Model\UserTable');
						$ordering                    = $groupTable->getOrdering($id);
						
						$infoObj = new Info();
						$infoObj->storeInfo($data, $ordering);
						$this->redirect()->toRoute('adminRoute');
					}
				}
			}
			return array(
				'myForm'   => $myForm,
				'msgError' => $authService->getError(),
			);
		}
		
		public function logoutAction()
		{
			$this->getServiceLocator()->get('MyAuth')->logout();
			$infoObj = new Info();
			$infoObj->destroyInfo();
			return $this->redirect()->toRoute('adminRoute');
		}
		
		public function registerAction()
		{
			if ($this->identity())
				$this->redirect()->toRoute('adminRoute');
			$myForm  = $this->getServiceLocator()->get('FormElementManager')->get('formCustomerRegister');
			$myTable = $this->getServiceLocator()->get('Customer\Model\UserTable');
			
			if ($this->getRequest()->isPost()) {
				
				$myForm->setData($this->_params['data']);
				
				if ($myForm->isValid()) {
					$this->_params['data'] = $myForm->getData(FormInterface::VALUES_AS_ARRAY);
					$id                    = $myTable->saveItem($this->_params['data'], array('task' => 'user-register'));
					$userInfo              = $myTable->getItem(array('id' => $id), array('task' => 'user-register'));
					$mailObj               = new \Zendvn\Mail\Mail();
					
					$linkActive = $this->url()->fromRoute('customerRoute/active', array('id' => $userInfo->id, 'code' => $userInfo->active_code), array('force_canonical' => true));
					$mailObj->sendMail($userInfo->fullname, $userInfo->email, $linkActive);
					
					return $this->redirect()->toRoute('adminRoute/default', array(
						'controller' => 'notice',
						'action'     => 'register-success',
					));
				}
			}
			
			return new ViewModel(array(
				'myForm' => $myForm,
			));
		}
		
		public function activeAction()
		{
			$myTable = $this->getServiceLocator()->get('Customer\Model\UserTable');
			$check   = $myTable->getItem($this->_params['data'], array('task' => 'user-active'));
			if ($check == 0) {
				return $this->redirect()->toRoute('adminRoute/default', array(
					'controller' => 'notice',
					'action'     => 'active-finish',
				));
			}
			
			$myTable->saveItem($this->_params['data'], array('task' => 'user-active'));
			return $this->redirect()->toRoute('adminRoute/default', array(
				'controller' => 'notice',
				'action'     => 'active-success',
			));
			return false;
		}
		
	}
