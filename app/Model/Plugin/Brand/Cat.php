<?php
use ASweb\Db\Db;
use ASweb\Db\NullEntity;

class Model_Plugin_Brand_Cat extends Model_Plugin_Abstract
{
	public function getbycat(int $cat)
	{
		$rows = array();

		$q = "select b.* 
			from ".$this->db_prefix."brand as b 
			left join ".$this->db_prefix."prod as p on p.brand = b.id 
			where b.visible = 1 and p.visible = 1 and p.cat = '".Db::nq($cat)."' group by b.id order by b.name";

		$qr = $this->db->q($q);
		while(!($r = $qr->f()) instanceof NullEntity) {
			$rows[] = $r;
		}

		return $rows;
	}
}