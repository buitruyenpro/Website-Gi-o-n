<?php
	
	namespace Zendvn\Model\Entity;
	
	class Homework
	{
		
		public $id;
		public $name;
		public $description;
		public $time;
		public $week;
		public $status;
		public $ordering;
		public $created;
		public $created_by;
		public $modified;
		public $modified_by;
		public $nest_id;
		
		
		public function exchangeArray($data)
		{
			$this->id          = (!empty($data['id'])) ? $data['id'] : null;
			$this->name        = (!empty($data['name'])) ? $data['name'] : null;
			$this->time        = (!empty($data['time'])) ? $data['time'] : null;
			$this->week        = (!empty($data['week'])) ? $data['week'] : null;
			$this->description = (!empty($data['description'])) ? $data['description'] : null;
			$this->nest_id     = (!empty($data['nest_id'])) ? $data['nest_id'] : null;
			$this->status      = (!empty($data['status'])) ? $data['status'] : 0;
			$this->ordering    = (!empty($data['ordering'])) ? $data['ordering'] : null;
			$this->created     = (!empty($data['created'])) ? $data['created'] : null;
			$this->created_by  = (!empty($data['created_by'])) ? $data['created_by'] : null;
			$this->modified    = (!empty($data['modified'])) ? $data['modified'] : null;
			$this->modified_by = (!empty($data['modified_by'])) ? $data['modified_by'] : null;
			
		}
		
		public function getArrayCopy()
		{
			$result           = get_object_vars($this);
			$result['status'] = ($result['status'] == 1) ? 'active' : 'inactive';
			$result['nest']   = $result['nest_id'];
			unset($result['nest_id']);
			
			return $result;
		}
		
	}