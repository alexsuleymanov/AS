<?php
use ASweb\Db\NullEntity;

class Model_Plugin_Page_Tree extends Model_Plugin_Abstract
{
	public static $tree;
	
	public function get_page_tree_up($start)
	{
		$qr = $this->db->q("select * from ".$this->db_prefix."page where `id` = '$start' order by prior desc");
		while (!($r = $qr->f()) instanceof NullEntity) {
			self::$tree[$r->id] = $r;
			self::get_page_tree_up($r->page);
		}

		return (empty(self::$tree)) ? array() : self::$tree;
	}
}

