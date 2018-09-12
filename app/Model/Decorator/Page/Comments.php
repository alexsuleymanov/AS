<?php
use ASweb\Db\Entity;

class Model_Decorator_Page_Comments extends Model_Decorator_Abstract
{	
	public function get(Entity $row): Entity
	{
		$row->comments = $this->getcomments($row->id);
		return $row;
	}

	public function getall(array $rows): array
	{
		foreach ($rows as $k => $v) {
			if ($this->Options['in_list'] == 1) {
				$rows[$k]->comments = $this->getcomments($v->id);
			}
		}
		
		return $rows;
	}

	private function getcomments(int $id)
	{
		$Comment = new Model_Comment();
		$cond = array(
			"where" => "`type` = '".$this->type."' and `par` = ".$id." and visible = 1",
			"order" => "tstamp desc",
		);

		return $Comment->getall($cond);
	}
}