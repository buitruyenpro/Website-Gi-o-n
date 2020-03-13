<?php
	
	namespace Admin\Model;
	
	use Zend\Db\Sql\Expression;
	
	use Zend\Json\Json;
	
	use Zend\Db\Sql\Where;
	
	use Zend\Db\Sql\Select;
	use Zend\Db\TableGateway\TableGateway;
	use Zend\Db\TableGateway\AbstractTableGateway;
	
	class PermissionTable extends AbstractTableGateway
	{
		
		protected $tableGateway;
		protected $flag = true;
		
		public function __construct(TableGateway $tableGateway)
		{
			$this->tableGateway = $tableGateway;
		}
		
		public function getItem($arrParam = null, $options = null)
		{
			
			
			$permissions = $this->tableGateway->select(function (Select $select) use ($arrParam) {
				$select->columns(array('controller', 'action'))
					->where->in('id', $arrParam);
			})->toArray();
			
			return $permissions;
		}
		
		
		public function saveItem($arrParam = null, $options = null, $idPermision = null)
		{
			
			if ($options['task'] == 'add-item') {
				$data = array(
					'module'     => $arrParam['module'],
					'controller' => $arrParam['controller'],
					'action'     => $arrParam['action'],
				);
				$this->tableGateway->insert($data);
				
			}
			
			if ($options['task'] == 'edit-item') {
				
				$data = array(
					'module'     => $arrParam['module'],
					'controller' => $arrParam['controller'],
					'action'     => $arrParam['action'],
				);
				$this->tableGateway->insert($data);
			}
			
			
			return $this->tableGateway->getLastInsertValue();
		}
		
	}