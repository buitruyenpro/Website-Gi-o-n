<?php
namespace Customer\Model;

use Zend\Db\Sql\Expression;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;

class BookTable extends AbstractTableGateway {
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway	= $tableGateway;
	}
	
	public function countItem($arrParam = null, $options = null){
		if($options['task'] == 'list-item') {
				
			$result	= $this->tableGateway->select(function (Select $select) use ($arrParam){
				$select->where->in('category_id', $arrParam)
					   ->where->equalTo('status', 1);
			})->count();
				
		}
		return $result;
	}
	
	public function getItem($arrParam = null, $options = null){
	
		if($options['task'] == 'special-book') {
			$result	= $this->tableGateway->select(function (Select $select) use ($arrParam){
					$select->columns(array('id', 'name', 'price', 'sale_off', 'picture'))
					       ->limit(1)
					       ->order(new Expression('RAND()'))
					       ->where->equalTo('status', 1)
					       ->where->equalTo('special', 1);
			})->current();
		}
		
		if($options['task'] == 'book-popup') {
			$result	= $this->tableGateway->select(function (Select $select) use ($arrParam){
				$select->columns(array('id', 'name', 'price', 'sale_off', 'picture', 'description'))
						->where->equalTo('id', $arrParam['id']);
			})->current();
		}
	
		return $result;
	}
	
	public function listItem($arrParam = null, $options = null){
	
		if($options['task'] == 'new-book') {
			$result	= $this->tableGateway->select(function (Select $select) use ($arrParam){
				$select->columns(array('id', 'name', 'price', 'sale_off', 'picture'))
						->limit(6)
						->order('id DESC')
						->where->equalTo('status', 1);
			});
		}
		
		if($options['task'] == 'book-in-category') {
			$result	= $this->tableGateway->select(function (Select $select) use ($arrParam){
				$paginator	= $arrParam['paginator'];
				$filter		= $arrParam['filter'];
				
				$select->columns(array('id', 'name', 'price', 'sale_off', 'picture', 'description'))
					   ->limit($paginator['itemCountPerPage'])
					   ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage'])
					   ->where->in('category_id', $arrParam['data']['catIDs'])
					   ->where->equalTo('status', 1);
				
				if(!empty($filter['order']) && !empty($filter['dir'])){
					$select->order(array($filter['order'] . ' ' . $filter['dir']));
				}
			});
		}
	
	
		return $result;
	}
	
}