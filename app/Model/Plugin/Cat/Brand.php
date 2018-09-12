<?php
use ASweb\Db\NullEntity;

class Model_Plugin_Cat_Brand extends Model_Plugin_Abstract
{
	public function getbybrand(int $brand_id)
	{
		$cats = array();

		if ($this->Options['prod_multicats']) {
			$qr = $this->db->q("
					select p.id as id, c.id as cid, c.name as cname, c.intname as cintname, b.id as bid, b.intname as bintname, b.name as bname
					from ".$this->db_prefix."relation as r 
					left join ".$this->db_prefix."prod as p on p.id = r.relation 
					left join ".$this->db_prefix."cat as c on c.id = r.obj 
					left join ".$this->db_prefix."brand as b on b.id = p.brand 
					where r.type = 'cat-prod' and c.id != 0 and c.visible = 1 and p.brand = ".$brand_id." group by p.cat order by c.name");
		}else {
			$qr = $this->db->q("
					select p.id as pid, c.id as cid, c.name as cname, c.intname as cintname, b.id as bid, b.intname as bintname, b.name as bname
					from ".$this->db_prefix."prod as p 
					left join ".$this->db_prefix."cat as c on c.id = p.cat 
					left join ".$this->db_prefix."brand as b on b.id = p.brand 
					where c.id != 0 and c.visible = 1 and p.brand = ".$brand_id." group by p.cat order by c.name");
		}

		while(!($r = $qr->f()) instanceof NullEntity) {
			$cats[] = $r;
		}

		return $cats;
	}
}

