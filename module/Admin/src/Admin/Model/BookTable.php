<?php
	
	namespace Admin\Model;
	
	use Zend\Json\Json;
	
	use Zend\Db\Sql\Where;
	
	use Zendvn\File\Image;
	
	use PHPImageWorkshop\ImageWorkshop;
	
	use Zendvn\File\Upload;
	
	use Zend\Db\Sql\Select;
	use Zend\Db\TableGateway\TableGateway;
	use Zend\Db\TableGateway\AbstractTableGateway;
	
	class BookTable extends AbstractTableGateway
	{
		
		protected $tableGateway;
		
		public function __construct(TableGateway $tableGateway)
		{
			$this->tableGateway = $tableGateway;
		}
		
		public function itemInSelectbox($arrParam = null, $options = null)
		{
			if ($options['task'] == 'form-slider') {
				$items = $this->tableGateway->select(function (Select $select) use ($arrParam) {
					$select->columns(array('id', 'name'))
						->order('name ASC')
						->where->equalTo('status', 1);
				});
				
				$result = array();
				if (!empty($items)) {
					foreach ($items as $item) {
						$result[$item->id] = $item->name;
					}
				}
			}
			return $result;
		}
		
		public function countItem($arrParam = null, $options = null)
		{
			if ($options['task'] == 'list-item') {
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam) {
					$ssFilter = $arrParam['ssFilter'];
					
					if (!empty($ssFilter['filter_status'])) {
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('status', $status);
					}
					
					if (!empty($ssFilter['filter_category'])) {
						$select->where->equalTo('book.category_id', $ssFilter['filter_category']);
					}
					
					if (!empty($ssFilter['filter_special'])) {
						$special = ($ssFilter['filter_special'] == 'yes') ? 1 : 0;
						$select->where->equalTo('book.special', $special);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])) {
						if ($ssFilter['filter_keyword_type'] != 'all') {
							$select->where->like('book.' . $ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						} else {
							$select->where->NEST
								->like('name', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('id', $ssFilter['filter_keyword_value'])
								->UNNEST;
						}
					}
					
				})->count();
				
			}
			return $result;
		}
		
		public function listItem($arrParam = null, $options = null)
		{
			
			if ($options['task'] == 'list-item') {
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam) {
					$paginator = $arrParam['paginator'];
					$ssFilter  = $arrParam['ssFilter'];
					
					$select->columns(array(
						'id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'ordering', 'sale_off', 'special', 'document', 'level', 'status'
					))
						->join(
							array('c' => 'category'),
							'book.category_id = c.id',
							array('category_name' => 'name'),
							$select::JOIN_LEFT
						)
						->limit($paginator['itemCountPerPage'])
						->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
					
					if (!empty($ssFilter['order_by']) && !empty($ssFilter['order'])) {
						$select->order(array($ssFilter['order_by'] . ' ' . $ssFilter['order']));
					}
					
					if (!empty($ssFilter['filter_status'])) {
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('book.status', $status);
					}
					
					if (!empty($ssFilter['filter_special'])) {
						$special = ($ssFilter['filter_special'] == 'yes') ? 1 : 0;
						$select->where->equalTo('book.special', $special);
					}
					
					if (!empty($ssFilter['filter_category'])) {
						$select->where->equalTo('book.category_id', $ssFilter['filter_category']);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])) {
						if ($ssFilter['filter_keyword_type'] != 'all') {
							$select->where->like('book.' . $ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						} else {
							$select->where->NEST
								->like('book.name', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('book.id', $ssFilter['filter_keyword_value'])
								->UNNEST;
						}
					}
				});
				
			}
			
			if ($options['task'] == 'list-picture') {
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam) {
					$select->columns(array('picture', 'document'))
						->where->in('id', $arrParam);
				})->toArray();
			}
			
			return $result;
		}
		
		public function changeStatus($arrParam = null, $options = null)
		{
			if ($options['task'] == 'change-status') {
				
				if ($arrParam['status_id'] > 0) {
					$data  = array('status' => ($arrParam['status_value'] == 1) ? 0 : 1);
					$where = array('id' => $arrParam['status_id']);
					$this->tableGateway->update($data, $where);
					return true;
				}
			}
			
			if ($options['task'] == 'change-special') {
				if ($arrParam['status_id'] > 0) {
					$data  = array('special' => ($arrParam['status_value'] == 1) ? 0 : 1);
					$where = array('id' => $arrParam['status_id']);
					$this->tableGateway->update($data, $where);
					return true;
				}
			}
			
			if ($options['task'] == 'change-multi-status') {
				if (!empty($arrParam['cid'])) {
					$data  = array('status' => $arrParam['status_value']);
					$cid   = implode(',', $arrParam['cid']);
					$where = array('id IN (' . $cid . ')');
					$this->tableGateway->update($data, $where);
					return true;
				}
			}
			
			return false;
		}
		
		public function getItem($arrParam = null, $options = null)
		{
			
			if ($options == null) {
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam) {
					$select->columns(array('id', 'name', 'ordering', 'picture', 'status', 'special', 'category_id', 'description', 'sale_off', 'document', 'level'));
					$select->where->equalTo('id', $arrParam['id']);
				})->current();
			}
			
			return $result;
		}
		
		public function ordering($arrParam = null, $options = null)
		{
			
			if ($options == null) {
				if (!empty($arrParam['cid'])) {
					foreach ($arrParam['cid'] as $id) {
						$data  = array('ordering' => $arrParam['ordering'][$id]);
						$where = array('id' => $id);
						$this->tableGateway->update($data, $where);
					}
					return true;
				}
			}
			
			return false;
			
		}
		
		public function checkDelete($arrParam = null, $ordering = null)
		{
			$result = $this->tableGateway->select(function (Select $select) use ($arrParam) {
				$select->columns(array('level'));
				$select->where->in('id', $arrParam);
			})->toArray();
			
			foreach ($result as $key => $value) {
				if ($value['level'] < $ordering) {
					return false;
					break;
				}
			}
			return true;
			
		}
		
		
		public function deleteItem($arrParam = null, $options = null)
		{
			
			if ($options['task'] == 'multi-delete') {
				if (!empty($arrParam['cid'])) {
					$items  = $this->listItem($arrParam['cid'], array('task' => 'list-picture'));
					$imgObj = new Image();
					foreach ($items as $item) {
						if (!empty($item['picture']))
							$imgObj->removeImage($item['picture'], array('task' => 'book-picture'));
						if (!empty($item['document']))
							$imgObj->removeImage($item['document'], array('task' => 'book-document'));
					}
					$where = new Where();
					$where->in('id', $arrParam['cid']);
					$this->tableGateway->delete($where);
					
					return true;
				}
			}
			return false;
		}
		
		public function saveItem($arrParam = null, $options = null, $ordering = null, $id = null, $name)
		{
			
			
			if ($options['task'] == 'add-item') {
				$data = array(
					'name'        => $arrParam['name'],
					'category_id' => $arrParam['category_id'],
					'ordering'    => $arrParam['ordering'],
					'status'      => ($arrParam['status'] == 'active') ? 1 : 0,
					'created'     => date('Y-m-d H:i:s'),
					'level'       => $ordering,
					'user_id'     => $id,
					'created_by'  => $name
				);
				
				if (!empty($arrParam['file']['tmp_name'])) {
					$imageObj        = new Image();
					$data['picture'] = $imageObj->upload('file', array('task' => 'book-picture'));
				}
				if (!empty($arrParam['file_send']['tmp_name'])) {
					
					$imageObj         = new Image();
					$data['document'] = $imageObj->upload('file_send', array('task' => 'book-document'));
				}
				
				if (!empty($arrParam['description'])) {
					$config = array(
						array('HTML.AllowedElements', 'p,s,u,em,strong,span,ul,li,ol'),
						array('HTML.AllowedAttributes', 'style'),
					);
					
					$filter              = new \Zendvn\Filter\Purifier($config);
					$data['description'] = $filter->filter($arrParam['description']);
				}
				
				$this->tableGateway->insert($data);
				return $this->tableGateway->getLastInsertValue();
			}
			
			if ($options['task'] == 'edit-item') {
				$data = array(
					'name'        => $arrParam['name'],
					'category_id' => $arrParam['category_id'],
					'ordering'    => $arrParam['ordering'],
					'special'     => ($arrParam['special'] == 'yes') ? 1 : 0,
					'status'      => ($arrParam['status'] == 'active') ? 1 : 0,
					'modified'    => date('Y-m-d H:i:s'),
					'level'       => $ordering,
					'user_id'     => $id,
					'modified_by' => $name
				);
				
				if (!empty($arrParam['description'])) {
					$config = array(
						array('HTML.AllowedElements', 'p,s,u,em,strong,span,ul,li,ol'),
						array('HTML.AllowedAttributes', 'style'),
					);
					
					$filter              = new \Zendvn\Filter\Purifier($config);
					$data['description'] = $filter->filter($arrParam['description']);
				}
				
				if (!empty($arrParam['file']['tmp_name'])) {
					$imageObj        = new Image();
					$data['picture'] = $imageObj->upload('file', array('task' => 'book-picture'));
					$imageObj->removeImage($arrParam['picture'], array('task' => 'book-picture'));
				}
				if (!empty($arrParam['file_send']['tmp_name'])) {
					
					$imageObj         = new Image();
					$data['document'] = $imageObj->upload('file_send', array('task' => 'book-document'));
					$imageObj->removeImage($arrParam['picture'], array('task' => 'book-document'));
				}
				if (!empty($arrParam['description'])) {
					$config = array(
						array('HTML.AllowedElements', 'p,s,u,em,strong,span,ul,li,ol'),
						array('HTML.AllowedAttributes', 'style'),
					);
					
					$filter              = new \Zendvn\Filter\Purifier($config);
					$data['description'] = $filter->filter($arrParam['description']);
				}
				$this->tableGateway->update($data, array('id' => $arrParam['id']));
				return $arrParam['id'];
			}
		}
	}