<?php
	
	namespace Admin\Controller;
	
	use Zendvn\Controller\ActionController;
	use Zend\Form\FormInterface;
	use Zend\Session\Container;
	use Zend\View\Model\ViewModel;
	
	use Zendvn\Paginator\Paginator as ZendvnPaginator;
	
	class IndexController extends ActionController
	{
		public function init()
		{
			
			
			// SESSION FILTER
			$ssFilter = new Container(__CLASS__);
			$ssFilter->getManager()->getStorage()->clear(__CLASS__);
			
			$this->_params['ssFilter']['order_by']             = !empty($ssFilter->order_by) ? $ssFilter->order_by : 'id';
			$this->_params['ssFilter']['order']                = !empty($ssFilter->order) ? $ssFilter->order : 'DESC';
			$this->_params['ssFilter']['filter_status']        = $ssFilter->filter_status;
			$this->_params['ssFilter']['filter_special']       = $ssFilter->filter_special;
			$this->_params['ssFilter']['filter_category']      = $ssFilter->filter_category;
			$this->_params['ssFilter']['filter_keyword_type']  = $ssFilter->filter_keyword_type;
			$this->_params['ssFilter']['filter_keyword_value'] = $ssFilter->filter_keyword_value;
			
			// PAGINATOR
			$this->_paginator['itemCountPerPage']  = 3;
			$this->_paginator['pageRange']         = 4;
			$this->_paginator['currentPageNumber'] = $this->params()->fromRoute('page', 1);
			$this->_params['paginator']            = $this->_paginator;
			
			// OPTIONS
			$this->_options['tableName'] = 'Admin\Model\IndexTable';
			$this->_options['formName']  = 'formCustomerHome';
			
			// DATA
			$this->_params['data'] = array_merge(
				$this->getRequest()->getPost()->toArray(),
				$this->getRequest()->getFiles()->toArray()
			);
			
		}
		
		public function indexAction()
		{
			$id         = $this->identity()->group_id;
			$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
			$ordering   = $groupTable->getOrdering($id);
			
			$id         = $this->identity()->id;
			$total       = $this->getTable()->countItem($this->_params, array('task' => 'list-item'),$id);
			$items       = $this->getTable()->listItem($this->_params, array('task' => 'list-item'),$id);
			$slbCategory = $this->getServiceLocator()->get('Admin\Model\CategoryTable')->itemInSelectbox(null, array('task' => 'list-book'));
			return new ViewModel(array(
				'items'       => $items,
				'paginator'   => ZendvnPaginator::createPaginator($total, $this->_params['paginator']),
				'ssFilter'    => $this->_params['ssFilter'],
				'slbCategory' => $slbCategory,
				'ordering'    => $ordering
			));
		}
		
		public function filterAction()
		{
			$loggedStatus = $this->identity() ? true : false;
			if ($loggedStatus == false)
				$this->goLogin();
			
			if ($this->getRequest()->isPost()) {
				$ssFilter                  = new Container(__CLASS__);
				$data                      = $this->_params['data'];
				$ssFilter->order_by        = $data['order_by'];
				$ssFilter->order           = $data['order'];
				$ssFilter->filter_status   = $data['filter_status'];
				$ssFilter->filter_category = $data['filter_category'];
			}
			$this->goAction();
		}
		
		public function statusAction()
		{
			$loggedStatus = $this->identity() ? true : false;
			if ($loggedStatus == false)
				$this->goLogin();
			
			if ($this->getRequest()->isPost()) {
				$flagAction = $this->getTable()->changeStatus($this->_params['data'], array('task' => 'change-status'));
				if ($flagAction == true)
					$this->flashMessenger()->addMessage('Trạng thái của phần tử đã được cập nhật thành công!');
			}
			$this->goAction();
		}
		
		public function multiStatusAction()
		{
			$loggedStatus = $this->identity() ? true : false;
			if ($loggedStatus == false)
				$this->goLogin();
			
			$message = 'Vui lòng chọn vào phần tử mà bạn muốn thay đổi trạng thái!';
			if ($this->getRequest()->isPost()) {
				$flagAction = $this->getTable()->changeStatus($this->_params['data'], array('task' => 'change-multi-status'));
				if ($flagAction == true)
					$message = 'Trạng thái của phần tử đã được cập nhật thành công!';
			}
			$this->flashMessenger()->addMessage($message);
			$this->goAction();
		}
		
		public function deleteAction()
		{
			$loggedStatus = $this->identity() ? true : false;
			if ($loggedStatus == false)
				$this->goLogin();
			
			$tableCategory = $this->getServiceLocator()->get('Admin\Model\CategoryTable');
			$flag          = $tableCategory->getDeadline($this->_params['data']['cid']);
			$message       = 'Vui lòng chọn vào phần tử mà bạn muốn xóa!';
			if ($flag == false) {
				$message = 'Đã quá hạn nộp tài liệu bạn không có quyền truy cập vào chức năng này!';
			}
			
			if ($this->getRequest()->isPost()) {
				if ($flag) {
					$flagAction = $this->getTable()->deleteItem($this->_params['data'], array('task' => 'multi-delete'));
					
					if ($flagAction == true)
						$message = 'Các phần tử đã được xóa thành công!';
				}
			}
			$this->flashMessenger()->addMessage($message);
			$this->goAction();
		}
		
		public function viewAction()
		{
			$loggedStatus = $this->identity() ? true : false;
			if ($loggedStatus == false)
				$this->goLogin();
			
			$this->_params['data']['id'] = $this->params('id');
			
			if (!empty($this->_params['data']['id'])) {
				$item = $this->getTable()->getItem($this->_params['data']);
			}
			return new ViewModel(array(
				'items' => $item,
			));
		}
		
		public function formAction()
		{
			$loggedStatus = $this->identity() ? true : false;
			if ($loggedStatus == false)
				$this->goLogin();
			
			$id         = $this->identity()->id;
			$group_id   = $this->identity()->group_id;
			$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
			$ordering   = $groupTable->getOrdering($group_id);
			
			$myForm                      = $this->getForm();
			$task                        = 'add-item';
			$this->_params['data']['id'] = $this->params('id');
			$tableCategory               = $this->getServiceLocator()->get('Admin\Model\CategoryTable');
			$flag                        = $tableCategory->getDeadline([$this->_params['data']['id']]);
			if ($flag == false && !empty($this->_params['data']['id'])) {
				$message = 'Đã quá hạn nộp tài liệu bạn không có quyền truy cập vào chức năng này!';
				$this->flashMessenger()->addMessage($message);
				$this->goAction();
			}
			
			if (!empty($this->_params['data']['id'])) {
				$item = $this->getTable()->getItem($this->_params['data']);
				if (!empty($item)) {
					$myForm->setInputFilter(new \Admin\Form\IndexFilter(array('id' => $this->_params['data']['id'])));
					$myForm->bind($item);
					$task = 'edit-item';
				}
			}
			
			if ($this->getRequest()->isPost()) {
				
				$action = $this->_params['data']['action'];
				$myForm->setData($this->_params['data']);
				if ($myForm->isValid()) {
					$this->_params['data'] = $myForm->getData(FormInterface::VALUES_AS_ARRAY);
					$tableCategory         = $this->getServiceLocator()->get('Admin\Model\CategoryTable');
					$flag                  = $tableCategory->getDeadLineCategory($this->_params['data']);
					if ($flag == false) {
						$message = 'Đã quá hạn nộp tài liệu bạn không có quyền truy cập vào chức năng này!';
						$this->flashMessenger()->addMessage($message);
						
					} else {
						$id = $this->getTable()->saveItem($this->_params['data'], array('task' => $task), $ordering,$id);
						$this->flashMessenger()->addMessage('Đã nộp bài thành công!');
					}
					if ($action == 'save-close')
						$this->goAction();
					if ($action == 'save-new')
						$this->goAction(array('action' => 'form'));
					if ($action == 'save')
						$this->goAction(array('action' => 'form', 'id' => $id));
				}
			}
			
			return new ViewModel(array(
				'myForm' => $myForm,
			));
		}
		
	}
