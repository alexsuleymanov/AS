<?php
use ASweb\Db\Db;

class Model_Promocode extends Model_Model
{
	protected $name = 'promo';
	protected $depends = array();
	protected $relations = array();
	protected $multylang = 0;
	protected $visibility = 0;

	public $par = 0;

	public static function getbycode(string $code)
	{
		$Promocode = new Model_Promocode();
		return $Promocode->getone(array("where" => "`code` = '".Db::nq($code)."'"));
	}
}
