<?php
	
	namespace Admin\Model;
	
	use Zend\Db\Sql\Where;
	
	use Zend\Db\Sql\Select;
	use Zend\Db\TableGateway\TableGateway;
	use Zend\Db\TableGateway\AbstractTableGateway;
	use Zend\Json\Json;
	
	class TimeLineTable extends AbstractTableGateway
	{
		
		protected $tableGateway;
		
		public function __construct(TableGateway $tableGateway)
		{
			$this->tableGateway = $tableGateway;
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
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])) {
						if ($ssFilter['filter_keyword_type'] != 'all') {
							$select->where->like($ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
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
						'id', 'name', 'status', 'ordering', 'created', 'created_by', 'modified', 'modified_by', 'group_acp'
					))
						->limit($paginator['itemCountPerPage'])
						->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
					
					if (!empty($ssFilter['order_by']) && !empty($ssFilter['order'])) {
						$select->order(array($ssFilter['order_by'] . ' ' . $ssFilter['order']));
					}
					
					if (!empty($ssFilter['filter_status'])) {
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('status', $status);
					}
					if (!empty($ssFilter['filter_group_acp'])) {
						$groupACP = ($ssFilter['filter_group_acp'] == 'yes') ? 1 : 0;
						$select->where->equalTo('group_acp', $groupACP);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])) {
						if ($ssFilter['filter_keyword_type'] != 'all') {
							$select->where->like($ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						} else {
							$select->where->NEST
								->like('name', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('id', $ssFilter['filter_keyword_value'])
								->UNNEST;
						}
					}
					
				});
				
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
			if ($options['task'] == 'change-group-acp') {
				if ($arrParam['status_id'] > 0) {
					$data  = array('group_acp' => ($arrParam['status_value'] == 1) ? 0 : 1);
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
		
		public function saveItem($arrParam = null, $options = null)
		{
			
			
			if ($options['task'] == 'add-item') {
				$data = array(
					'start_date'  => $arrParam['start_date'],
					'end_date'    => $arrParam['end_date'],
					'nest_id'     => $arrParam['nest_id'],
					'active'      => 0,
					'id_homework' => $arrParam['id_homework'],
				);
				$this->tableGateway->insert($data);
				
				return $this->tableGateway->getLastInsertValue();
			}
			if ($options['task'] == 'edit-item') {
				
				$data = array(
					'start_date'  => $arrParam['start_date'],
					'end_date'    => $arrParam['end_date'],
					'nest_id'     => $arrParam['nest_id'],
					'active'      => 0,
					'id_homework' => $arrParam['id_homework'],
				);
				
				$this->tableGateway->update($data, array('id' => $arrParam['id']));
				return $arrParam['id'];
			}
		}
	}