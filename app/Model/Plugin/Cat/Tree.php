<?php
use ASweb\Db\NullEntity;

class Model_Plugin_Cat_Tree extends Model_Plugin_Abstract
{
	public static $tree;
	
	public static function clear_tree()
	{
		self::$tree = array();
	}

	public function cat_tree(int $start_cat)
	{
		$qr_ct = $this->db->q("select id, cat from ".$this->db_prefix."cat where id = ".$start_cat);
		$i = 0;

		$ct_str .= " (";
		while (!($r_ct = $qr_ct->f()) instanceof NullEntity) {
    	   	$ct_str .= " cat = '".$r_ct->id."'";
			$ct_str .= " or";
			$qr_ct = $this->db->q("select id, cat from ".$this->db_prefix."cat where id = '".$r_ct->cat."'");
		}
		$ct_str .= " cat = '0')";

		return $ct_str;
	}

	public function cat_tree_down(int $start_cat)
	{
		$tree = $this->get_cat_tree($start_cat);
		$i = 0;

		$ct_str .= " (";
		foreach ($tree as $k => $v) {
			if ($i++) {
				$ct_str .= " or ";
			}
			
			if (is_array($v)) {
				$ct_str .= "cat = '".$k."' or ".$this->cat_tree_down($k);
			} else {
	    	    $ct_str .= "cat = '".$k."'";
			}
		}
		$ct_str .= ")";

		return $ct_str;
	}

	public function get_cat_tree(int $start_cat)
	{
		$tree = [];

		$qr = $this->db->q("select id from ".$this->db_prefix."cat where cat = $start_cat order by prior desc");
		while (!($r = $qr->f()) instanceof NullEntity) {
			$tree[$r->id] = $this->get_cat_tree($r->id);
		}

		return (empty($tree)) ? $start : $tree;
	}

	public function get_cat_tree_up(int $start_cat)
	{
		$qr = $this->db->q("select * from ".$this->db_prefix."cat where id = $start_cat order by prior desc");
		while (!($r = $qr->f()) instanceof NullEntity) {
			self::$tree[$r->id] = $r;
			self::get_cat_tree_up($r->cat);
		}
		return (empty(self::$tree)) ? array() : self::$tree;
	}	
}
