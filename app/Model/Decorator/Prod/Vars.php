<?php
use ASweb\Db\Entity;

class Model_Decorator_Prod_Vars extends Model_Decorator_Abstract
{	
	public function get(Entity $row): Entity
	{
		$row->prodvars = $this->getprodvars($row->id);
		return $row;
	}

	public function getall(array $rows): array
	{
		foreach ($rows as $k => $v) {
			$rows[$k]->prodvars = $this->getprodvars($v->id);
		}
		
		return $rows;
	}

	public function getprodvars(int $id): array
	{
		$Prodvar = new Model_Prodvar();
		$cond = array(
			"where" => "`prod` = $id",
			"order" => "prior desc",
		);
		
		return $Prodvar->getall($cond);
	}
}
