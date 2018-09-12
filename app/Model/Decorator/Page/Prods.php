<?php
use ASweb\Db\Entity;

class Model_Decorator_Page_Prods extends Model_Decorator_Abstract
{	
	public function get(Entity $row): Entity
	{
		$row->prods = $this->getprods($row->id);
		return $row;
	}

	public function getall(array $rows): array
	{
		foreach ($rows as $k => $v) {
			if ($this->Options['in_list'] == 1) {
				$rows[$k]->prods = $this->getprods($v->id);
			}
		}
		
		return $rows;
	}
	
	private function getprods(int $page = 0)
	{
		$Prod = new Model_Prod();
		$cond = [
			"where" => "visible = 1",
			"relation" => array("select" => "relation", "where" => "`type` = 'page-prod' and `obj` = ".$page.""),
//				"order" => "prior desc",
		];
		
		return $Prod->getall($cond);
	}
}