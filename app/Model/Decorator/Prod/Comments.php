<?php
use ASweb\Db\Entity;

class Model_Decorator_Prod_Comments extends Model_Decorator_Abstract
{	
	public function get(Entity $row): Entity
	{
		$row->comments = $this->getcomments($row->id);
		return $row;
	}

	public function getall(array $rows): array
	{
		foreach ($rows as $k => $v) {
			if ($this->Options['in_prod_list'] == 1) {
				$rows[$k]->comments = $this->getcomments($v->id);
			}
		}
		
		return $rows;
	}

	protected function getcomments(int $id): array
	{
		$Comment = new Model_Comment();
		$cond = array(
			"where" => "`type` = 'prod' and `par` = $id and `visible` = 1",
			"order" => "tstamp desc",
		);
		return $Comment->getall($cond);
	}
}

