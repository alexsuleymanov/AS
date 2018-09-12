<?php
//	version 3
use ASweb\Db\Db;

class Model_Prod extends Model_Model 
{
	protected $_cat;
	protected $_brand;

	protected $name = 'prod';
	protected $depends = array("photo", "comment", "prodvar", "prodchar", "cart");
	protected $relations = array();
	protected $multylang = 1;
	protected $visibility = 1;

	public $par = 0;

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
