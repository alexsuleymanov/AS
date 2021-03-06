<?php
use ASweb\Db\Entity;

class Model_Decorator_Page_Rating extends Model_Decorator_Abstract
{	
	public function get(Entity $row): Entity
	{
		$row->rating = $this->getrating($row->id);
		return $row;
	}

	public function getall(array $rows): array
	{
		foreach ($rows as $k => $v) {
			if ($this->Options['in_list'] == 1) {
				$rows[$k]->rating = $this->getrating($v->id);
			}
		}
		
		return $rows;
	}

	private function getrating(int $id)
	{
		$Rating = new Model_Rating();
		$rating = $Rating->getone(array("where" => "`type` = 'page' and `par` = '".$id."'"));

		return $rating;
	}
}