<?php
use ASweb\Db\Entity;

class Model_Decorator_Page_Subpages extends Model_Decorator_Abstract
{
	
	public function get(Entity $row): Entity
	{
		$row->subpages = $this->getsubpages($row->id);
		return $row;
	}

	public function getall(array $rows): array
	{
		foreach ($rows as $k => $v) {
			if ($this->Options['in_list'] == 1) {
				$rows[$k]->subpages = $this->getsubpages($v->id);
			}
		}
		
		return $rows;
	}

	private function getsubpages(int $par = 0)
	{
		$cond = array(
			"where" => "`visible` = 1 and `page` = $par",
			"order" => "prior desc",
		);

		return $this->getall($cond);
	}
}