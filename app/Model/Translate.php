<?php
use ASweb\Db\Db;

class Model_Translate extends Model_Model
{
	protected $name = 'translate';
	protected $depends = array();
	protected $relations = array();
	protected $visibility = 0;
	public $par = 0;

	public function translate($obj_id = 0, $table = '', $lang = '')
	{
		return $this->getall(array("where" => "`obj_id` = '".Db::nq($obj_id)."' and `table` = '".Db::nq($table)."' and `lang` = '".Db::nq($lang)."'"));
	}
}
