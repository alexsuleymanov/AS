<?php
use ASweb\Db\Entity;

class Model_Decorator_Prod_Childs extends Model_Decorator_Abstract
{	
	public function get(Entity $row): Entity
	{
		$row->childs = $this->getprodchilds($row->id);
		return $row;
	}

	public function getall(array $rows): array
	{
		foreach ($rows as $k => $v) {
			if ($this->Options['in_prod_list']) {
				$rows[$k]->childs = $this->getprodchilds($v->id);
			}
		}
		
		return $rows;
	}

	protected function getprodchilds(int $id): array
	{
		$Prod = new Model_Prod();
		$cond = array(
			"where" => "visible = 1",
			"relation" => array("select" => "relation", "where" => "`type` = 'prod-prod' and `obj` = $id"),
			"order" => "prior desc",
		);

		return $Prod->getall($cond);
	}
}