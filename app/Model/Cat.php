<?php
use ASweb\Db\Db;

class Model_Cat extends Model_Model
{
	protected $name = 'cat';
	protected $depends = array('cat', 'prod');
	protected $relations = array();
	protected $multylang = 1;
	protected $visibility = 1;
		
	public $par = 0;
	protected static $tree = array();
	
	public function getbyname(string $intname = '')
	{
		$r = $this->getall([
			"select" => "id",
			"where" => "`visible` = 1 and `intname` = '".Db::nq($intname)."'",
			"limit" => 1,
		]);
		
		if ($r[0]->id) {
			return $this->get($r[0]->id);
		} else {
			return NULL;
		}
	}
}
