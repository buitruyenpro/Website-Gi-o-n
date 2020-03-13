<?php
	
	namespace Admin\Controller;
	
	use Zendvn\Controller\ActionController;
	use Zend\Form\FormInterface;
	use Zend\Session\Container;
	use Zend\View\Model\ViewModel;
	
	use Zendvn\Paginator\Paginator as ZendvnPaginator;
	use Zendvn\System\Info;
	
	class GroupController extends ActionController
	{
		public function init()
		{
			
			// SESSION FILTER
			$ssFilter                                          = new Container(__CLASS__);
			$this->_params['ssFilter']['order_by']             = !empty($ssFilter->order_by) ? $ssFilter->order_by : 'id';
			$this->_params['ssFilter']['order']                = !empty($ssFilter->order) ? $ssFilter->order : 'DESC';
			$this->_params['ssFilter']['filter_status']        = $ssFilter->filter_status;
			$this->_params['ssFilter']['filter_keyword_type']  = $ssFilter->filter_keyword_type;
			$this->_params['ssFilter']['filter_keyword_value'] = $ssFilter->filter_keyword_value;
			
			// PAGINATOR
			$this->_paginator['itemCountPerPage']  = 4;
			$this->_paginator['pageRange']         = 4;
			$this->_paginator['currentPageNumber'] = $this->params()->fromRoute('page', 1);
			$this->_params['paginator']            = $this->_paginator;
			
			// OPTIONS
			$this->_options['tableName'] = 'Admin\Model\GroupTable';
			$this->_options['formName']  = 'formAdminGroup';
			
			
			// DATA
			$this->_params['data'] = $this->getRequest()->getPost()->toArray();
		}
		
		public function groupAcpAction()
		{
			if ($this->getRequest()->isPost()) {
				$flagAction = $this->getTable()->changeStatus($this->_params['data'], array('task' => 'change-group-acp'));
				if ($flagAction == true)
					$this->flashMessenger()->addMessage('Group ACP của phần tử đã được cập nhật thành công!');
			}
			$this->goAction();
		}
		
		public function indexAction()
		{
			$total = $this->getTable()->countItem($this->_params, array('task' => 'list-item'));
			$items = $this->getTable()->listItem($this->_params, array('task' => 'list-item'));
			return new ViewModel(array(
				'items'     => $items,
				'paginator' => ZendvnPaginator::createPaginator($total, $this->_params['paginator']),
				'ssFilter'  => $this->_params['ssFilter']
			));
		}
		
		public function filterAction()
		{
			if ($this->getRequest()->isPost()) {
				$ssFilter                       = new Container(__CLASS__);
				$data                           = $this->_params['data'];
				$ssFilter->order_by             = $data['order_by'];
				$ssFilter->order                = $data['order'];
				$ssFilter->filter_status        = $data['filter_status'];
				$ssFilter->filter_keyword_type  = $data['filter_keyword_type'];
				$ssFilter->filter_keyword_value = $data['filter_keyword_value'];
				
				$btnClear = $data['btn-clear'];
				
				if ($btnClear == 'btn-clear') {
					$ssFilter->offsetUnset('filter_keyword_type');
					$ssFilter->offsetUnset('filter_keyword_value');
				}
			}
			$this->goAction();
		}
		
		public function statusAction()
		{
			if ($this->getRequest()->isPost()) {
				$id         = $this->identity()->group_id;
				$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
				$ordering   = $groupTable->getOrdering($id);
				$access     = $this->getTable()->getOrdering([$this->_params['data']['status_id']], $ordering);
				if ($access == false) {
					$message = 'Bạn không có quyền thay đổi trạng thái!';
					$this->flashMessenger()->addMessage($message);
					$this->goAction();
				} else {
					$flagAction = $this->getTable()->changeStatus($this->_params['data'], array('task' => 'change-status'));
					if ($flagAction == true)
						$this->flashMessenger()->addMessage('Trạng thái của phần tử đã được cập nhật thành công!');
				}
			}
			$this->goAction();
		}
		
		public function multiStatusAction()
		{
			$id         = $this->identity()->group_id;
			$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
			$ordering   = $groupTable->getOrdering($id);
			
			$access  = $this->getTable()->getOrdering($this->_params['data']['cid'], $ordering);
			$message = 'Vui lòng chọn vào phần tử mà bạn muốn thay đổi trạng thái!';
			if ($this->getRequest()->isPost()) {
				if ($access == false) {
					$message = 'Bạn không có quyền thay đổi trạng thái này!';
					$this->goAction();
				} else {
					$flagAction = $this->getTable()->changeStatus($this->_params['data'], array('task' => 'change-multi-status'));
					if ($flagAction == true)
						$message = 'Trạng thái của phần tử đã được cập nhật thành công!';
				}
			}
			$this->flashMessenger()->addMessage($message);
			$this->goAction();
		}
		
		public function orderingAction()
		{
			
			$id         = $this->identity()->group_id;
			$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
			$ordering   = $groupTable->getOrdering($id);
			$access     = $this->getTable()->getOrdering($this->_params['data']['cid'], $ordering);
			$message    = 'Vui lòng chọn vào phần tử mà bạn muốn thay đổi thứ tự sắp xếp!';
			
			if ($this->getRequest()->isPost()) {
				if ($access == false) {
					$message = 'Bạn không có quyền cập nhật chức vụ này!';
					$this->goAction();
				} else {
					$flagAction = $this->getTable()->ordering($this->_params['data']);
					if ($flagAction == true)
						$message = 'Thứ tự sắp xếp phần tử đã được cập nhật thành công!';
				}
				
			}
			$this->flashMessenger()->addMessage($message);
			$this->goAction();
		}
		
		public function deleteAction()
		{
			
			$id         = $this->identity()->group_id;
			$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
			$ordering   = $groupTable->getOrdering($id);
			$access     = $this->getTable()->getOrdering($this->_params['data']['cid'], $ordering);
			
			$message = 'Vui lòng chọn vào phần tử mà bạn muốn xóa!';
			if ($this->getRequest()->isPost()) {
				if ($access == false) {
					$message = 'Bạn không có quyền xóa chức vụ này!';
					$this->goAction();
				} else {
					$flagAction = $this->getTable()->deleteItem($this->_params['data'], array('task' => 'multi-delete'));
					if ($flagAction == true)
						$message = 'Các phần tử đã được xóa thành công!';
				}
			}
			$this->flashMessenger()->addMessage($message);
			$this->goAction();
		}
		
		function array_find($keyFind, $array)
		{
			foreach ($array as $key => $value) {
				if (strpos($key, $keyFind) !== false) {
					return $value;
				}
			}
			return false;
		}
		
		public function formAction()
		{
			
			$this->_params['data']['group'] = 'group';
			$myForm                         = $this->getForm();
			$this->_params['data']['id']    = $this->params('id');
			
			$id         = $this->identity()->group_id;
			$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
			$ordering   = $groupTable->getOrdering($id);
			
			if (!empty($this->_params['data']['id'])) {
				$access = $this->getTable()->getOrdering([$this->_params['data']['id']], $ordering);
				if ($access == false) {
					$message = 'Bạn không có quyền vào trang này!';
					$this->flashMessenger()->addMessage($message);
					$this->goAction();
					
				} else {
					$groupTable      = $this->getServiceLocator()->get('Admin\Model\GroupTable');
					$permistionTable = $this->getServiceLocator()->get('Admin\Model\PermissionTableGateway');
					$id              = $this->_params['data']['id'];
					
					$arrIdPermistion = $groupTable->getIDPermision($id);
					
					if ($arrIdPermistion != null) {
						$itemPermision = $permistionTable->getItem($arrIdPermistion);
						
						$arrItemPermision = [];
						foreach ($itemPermision as $key => $value) {
							if ($value['controller'] == 'group') {
								$keyName                                = 'check_action_' . $value['action'] . '1:';
								$arrItemPermision[$keyName]             = $value['action'];
								$arrItemPermision[$value['controller']] = $value['controller'];
							}
							if ($value['controller'] == 'user') {
								$keyName                                = 'check_action_' . $value['action'] . '2:';
								$arrItemPermision[$keyName]             = $value['action'];
								$arrItemPermision[$value['controller']] = $value['controller'];
							}
							if ($value['controller'] == 'category') {
								$keyName                                = 'check_action_' . $value['action'] . '3:';
								$arrItemPermision[$keyName]             = $value['action'];
								$arrItemPermision[$value['controller']] = $value['controller'];
							}
							if ($value['controller'] == 'book') {
								$keyName                                = 'check_action_' . $value['action'] . '4:';
								$arrItemPermision[$keyName]             = $value['action'];
								$arrItemPermision[$value['controller']] = $value['controller'];
							}
						}
						$item = $this->getTable()->getItem($this->_params['data']);
						$item = array_merge($arrItemPermision, $item[0]);
						if (!empty($item)) {
							$myForm->setData($item);
							$task = 'edit-item';
						}
					} else {
						$item = $this->getTable()->getItem($this->_params['data']);
						if (!empty($item)) {
							$myForm->setData($item[0]);
							$task = 'edit-item';
						}
					}
					
					if ($this->getRequest()->isPost()) {
						
						
						$arrayPermision  = [];
						$arrNumberPage   = [1, 2, 3, 4];
						$arrNumberAction = [1, 2, 3, 4, 5, 6, 7, 8];
						$arrAction       = ['action_status', 'action_multi-status', 'action_delete', 'action_form', 'action_multi-delete', 'action_view', 'action_ordering', 'action_groupACP'];
						$arrPage         = ['group', 'user', 'category', 'book'];
						foreach ($arrNumberPage as $key => $value) {
							$keyPage                             = $arrPage[$key];
							$arrayPermision['page_' . $value][1] = $this->array_find($keyPage, $this->_params['data']);
							foreach ($arrNumberAction as $key2 => $value2) {
								$keyAction                                     = $arrAction[$value2] . $value . ':';
								$arrayPermision['page_' . $value][$value2 + 1] = $this->array_find($keyAction, $this->_params['data']);
							}
							
						}
						
						$action = $this->_params['data']['action'];
						$myForm->setData($this->_params['data']);
						$arrayPermision2 = [];
						$arrayTmp        = [];
						foreach ($arrayPermision as $key => $value) {
							foreach ($value as $key2 => $value2) {
								if ($value2 == '0') {
									unset($value[$key2]);
								} else {
									$arrayTmp[] = $value2;
								}
							}
							$arrayPermision2[] = $arrayTmp;
							$arrayTmp          = [];
						}
						
						if ($myForm->isValid()) {
							$arrIdPermistion = [];
							$permistionTable = $this->getServiceLocator()->get('Admin\Model\PermissionTableGateway');
							
							foreach ($arrayPermision2 as $key => $value) {
								
								foreach ($value as $key2 => $value2) {
									
									if ($value[0] != null && $value[$key2 + 1] != null) {
										$arrParam          = ['module' => 'admin', 'controller' => $value[0], 'action' => $value[$key2 + 1]];
										$arrIdPermistion[] = (int)$permistionTable->saveItem($arrParam, ['task' => $task]);
									}
									if ($value[0] != null && $value[$key2 + 1] == null) {
										$arrParam          = ['module' => 'admin', 'controller' => $value[0], 'action' => 'index'];
										$arrIdPermistion[] = (int)$permistionTable->saveItem($arrParam, ['task' => $task]);
										break;
									}
								}
							}
							
							$this->_params['data']                  = $myForm->getData(FormInterface::VALUES_AS_ARRAY);
							$this->_params['data']['permission_id'] = $arrIdPermistion;
							
							if ($ordering > $this->_params['data']['ordering']) {
								$message = 'Bạn không có quyền thực hiện tác vụ này, vui lòng chọn vị trí quyền lớn hơn ' . $ordering . '!';
								$this->flashMessenger()->addMessage($message);
								$this->goAction(array('action' => 'form', 'id' => $id));
							} else {
								$id = $this->getTable()->saveItem($this->_params['data'], array('task' => $task), $this->identity()->fullname);
								$this->flashMessenger()->addMessage('Dữ liệu đã được lưu thành công!');
							}
							
							$userID  = $this->identity()->id;
							$groupID = $this->identity()->group_id;
							
							$userTable       = $this->getServiceLocator()->get('Customer\Model\UserTable');
							$groupTable      = $this->getServiceLocator()->get('Customer\Model\GroupTable');
							$permissionTable = $this->getServiceLocator()->get('Customer\Model\PermissionTable');
							
							$data['user']                     = $userTable->getItem(array('id' => $userID), array('task' => 'store-user-info'));
							$data['group']                    = $groupTable->getItem(array('id' => $groupID), array('task' => 'store-group-info'));
							$data['permission']['role']       = $data['group']->name;
							$data['permission']['privileges'] = $permissionTable->getItem($data['group'], array('task' => 'store-permission-info'));
							
							$infoObj = new Info();
							$infoObj->storeInfo($data);
							
							if ($action == 'save-close')
								$this->goAction();
							if ($action == 'save-new')
								$this->goAction(array('action' => 'form'));
							if ($action == 'save')
								$this->goAction(array('action' => 'form', 'id' => $id));
							
							
						}
					}
					
				}
				
				
			} else {
				$task = 'add-item';
				if ($this->getRequest()->isPost()) {
					
					
					$arrayPermision  = [];
					$arrNumberPage   = [1, 2, 3, 4];
					$arrNumberAction = [1, 2, 3, 4, 5, 6, 7, 8];
					$arrAction       = ['action_status', 'action_multi-status', 'action_delete', 'action_form', 'action_multi-delete', 'action_view', 'action_ordering', 'action_groupACP'];
					$arrPage         = ['group', 'user', 'category', 'book'];
					foreach ($arrNumberPage as $key => $value) {
						$keyPage                             = $arrPage[$key];
						$arrayPermision['page_' . $value][1] = $this->array_find($keyPage, $this->_params['data']);
						foreach ($arrNumberAction as $key2 => $value2) {
							$keyAction                                     = $arrAction[$value2] . $value . ':';
							$arrayPermision['page_' . $value][$value2 + 1] = $this->array_find($keyAction, $this->_params['data']);
						}
						
					}
					
					$action = $this->_params['data']['action'];
					$myForm->setData($this->_params['data']);
					$arrayPermision2 = [];
					$arrayTmp        = [];
					foreach ($arrayPermision as $key => $value) {
						foreach ($value as $key2 => $value2) {
							if ($value2 == '0') {
								unset($value[$key2]);
							} else {
								$arrayTmp[] = $value2;
							}
						}
						$arrayPermision2[] = $arrayTmp;
						$arrayTmp          = [];
					}
					
					if ($myForm->isValid()) {
						$arrIdPermistion = [];
						$permistionTable = $this->getServiceLocator()->get('Admin\Model\PermissionTableGateway');
						
						foreach ($arrayPermision2 as $key => $value) {
							
							foreach ($value as $key2 => $value2) {
								
								if ($value[0] != null && $value[$key2 + 1] != null) {
									$arrParam          = ['module' => 'admin', 'controller' => $value[0], 'action' => $value[$key2 + 1]];
									$arrIdPermistion[] = (int)$permistionTable->saveItem($arrParam, ['task' => $task]);
								}
								if ($value[0] != null && $value[$key2 + 1] == null) {
									$arrParam          = ['module' => 'admin', 'controller' => $value[0], 'action' => 'index'];
									$arrIdPermistion[] = (int)$permistionTable->saveItem($arrParam, ['task' => $task]);
									break;
								}
							}
						}
						
						$this->_params['data']                  = $myForm->getData(FormInterface::VALUES_AS_ARRAY);
						$this->_params['data']['permission_id'] = $arrIdPermistion;
						
						if ($ordering > $this->_params['data']['ordering']) {
							$message = 'Bạn không có quyền thực hiện tác vụ này, vui lòng chọn vị trí quyền lớn hơn ' . $ordering . '!';
							$this->flashMessenger()->addMessage($message);
							$this->goAction(array('action' => 'form', 'id' => $id));
						} else {
							
							$id = $this->getTable()->saveItem($this->_params['data'], array('task' => $task), $this->identity()->fullname);
							$this->flashMessenger()->addMessage('Dữ liệu đã được lưu thành công!');
							
						}
						
						$userID  = $this->identity()->id;
						$groupID = $this->identity()->group_id;
						
						$userTable       = $this->getServiceLocator()->get('Customer\Model\UserTable');
						$groupTable      = $this->getServiceLocator()->get('Customer\Model\GroupTable');
						$permissionTable = $this->getServiceLocator()->get('Customer\Model\PermissionTable');
						
						$data['user']                     = $userTable->getItem(array('id' => $userID), array('task' => 'store-user-info'));
						$data['group']                    = $groupTable->getItem(array('id' => $groupID), array('task' => 'store-group-info'));
						$data['permission']['role']       = $data['group']->name;
						$data['permission']['privileges'] = $permissionTable->getItem($data['group'], array('task' => 'store-permission-info'));
						
						
						$infoObj = new Info();
						$infoObj->storeInfo($data);
						
						if ($action == 'save-close')
							$this->goAction();
						if ($action == 'save-new')
							$this->goAction(array('action' => 'form'));
						if ($action == 'save')
							$this->goAction(array('action' => 'form', 'id' => $id));
						
					}
				}
			}
			return new ViewModel(array(
				'myForm' => $myForm,
			));
		}
	}
