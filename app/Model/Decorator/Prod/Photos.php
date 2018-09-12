<?php
use ASweb\Db\Entity;

class Model_Decorator_Prod_Photos extends Model_Decorator_Abstract
{	
	public function get(Entity $row): Entity
	{
		$row->photos = $this->getphotos($row->id);
		return $row;
	}

	public function getall(array $rows): array
	{
		foreach ($rows as $k => $v) {
			if ($this->Options['in_prod_list'] == 1) {
				$rows[$k]->photos = $this->getphotos($v->id);
			}
		}
		
		return $rows;
	}

	protected function getphotos(int $id): array
	{
		$Photo = new Model_Photo();
		$cond = array(
			"where" => "`type` = 'prod' and `par` = $id",
			"order" => "prior desc",
		);
		
		return $Photo->getall($cond);
	}
}
