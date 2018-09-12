<?php

class Model_Plugin_Prod_Export extends Model_Plugin_Abstract
{
	public function getallforexport(): array
	{
		$prods = array();

		if ($this->Options['multicats']) {
			$qr = $this->db->q("
					select p.id as id, c.id as cat, c.name as name, b.name as brandname, p.name as name, p.price as price, p.num as num, p.art as art, p.brand as brand, p.short as short 
					from ".$this->db_prefix."relation as r 
					left join ".$this->db_prefix."prod as p on p.id = r.relation 
					left join ".$this->db_prefix."cat as c on c.id = r.obj 
					left join ".$this->db_prefix."brand as b on b.id = p.brand 
					where r.type = 'cat-prod' and p.price > 0 and p.visible = 1 and c.visible = 1 group by p.id order by p.name");
		} elseif($this->opt['cats']) {
			$qr = $this->db->q("
					select p.id as id, c.id as cat, c.name as name, b.name as brandname, p.name as name, p.price as price, p.num as num, p.art as art, p.brand as brand, p.short as short 
					from ".$this->db_prefix."prod as p 
					left join ".$this->db_prefix."cat as c on c.id = p.cat 
					left join ".$this->db_prefix."brand as b on b.id = p.brand 
					where p.price > 0 and p.visible = 1 and c.visible = 1 group by p.id order by p.name");
		}

		while(!($r = $qr->f()) instanceof NullEntity){
			$prods[] = $r;
		}

		return $prods;
	}
}