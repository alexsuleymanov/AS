<?php
use ASweb\Db\NullEntity;

class Model_Char extends Model_Model
{
	protected $name = 'char';
	protected $depends = array("charval", "prodchar");
	protected $relations = array();
	protected $multylang = 1;
	protected $visibility = 1;

	public $par = 0;

	public function delete_empty_vals()
	{
		$rc = $this->q("select cv.id from ".$this->db_prefix."charval as cv left join `".$this->db_prefix."char` as c on cv.`char` = c.id where c.id = 'null'");
		
		while (!($rr = $rc->f()) instanceof NullEntity) {
			$this->q("delete from ".$this->db_prefix."charval where id = '".$rr->id."'");
		}
	}
}