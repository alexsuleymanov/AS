<?php
use ASweb\Db\Entity;
use ASweb\Db\NullEntity;

class Model_Decorator_Prod_Chars extends Model_Decorator_Abstract
{	
	public function get(Entity $row): Entity
	{
		$row->chars = $this->getprodchars($row->id);
		return $row;
	}

	public function getall(array $rows): array
	{
		foreach ($rows as $k => $v) {
			if ($this->Options['in_prod_list'] == 1) {
				$rows[$k]->chars = $this->getprodchars($v->id);
			}
		}
		
		return $rows;
	}

	private function getprodchars(int $id): array
	{
		$prod_chars = array();

		$qr = $this->db->q("
				select c.id as cid, c.name as name, c.izm, cv.value as value, pc.charval as val, pc.value as text 
				from ".$this->db_prefix."prodchar as pc 
				left join ".$this->db_prefix."char as c on c.id = pc.`char` 
				left join ".$this->db_prefix."charval as cv on cv.id = pc.charval 
				where pc.prod = '".$id."' order by c.prior desc");

		while (!($r = $qr->f()) instanceof NullEntity) {
			$prod_chars[$r->cid] = $r;
		}
		
		return $prod_chars;
	}
}