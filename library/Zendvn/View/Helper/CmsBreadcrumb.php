<?php
namespace Zendvn\View\Helper;
use Zend\View\Helper\AbstractHelper;

class CmsBreadcrumb extends AbstractHelper {
	
	public function __invoke($items, $options = null){
		$urlHelper	= $this->getView()->plugin('url');
		
		$result	= sprintf('<a href="%s">Home</a>&nbsp;&nbsp;&raquo&nbsp;&nbsp;', $urlHelper('homeRoute'));
		$total	= $items->count();
		if(!empty($items)){
			$i = 1;
			foreach ($items as $item) {
				$linkCategory	= $urlHelper('customerRoute/default', array('controller' => 'category', 'action' => 'index', 'id' => $item->id));
				
				if($i == $total){
					$result			.= sprintf('<a href="#">%s</a>', $item->name);
				}else{
					$result			.= sprintf('<a href="%s">%s</a>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;', $linkCategory, $item->name);
				}
				$i++;
			}
			
		}
		return $result;
	}
}