<?php
use ASweb\Db\NullEntity;
use ASweb\Db\Db;

class Model_Page extends Model_Model{
	public $type;

	protected $name = 'page';
	protected $depends = array("page", "photo", "comment");
	protected $relations = array();
	protected $multylang = 1;
	protected $visibility = 1;
	protected static $tree = array();

	public $par = 0;

	public function __construct($type = '')
	{
		$this->type = $type;

		parent::__construct($id);
	}

	public function getall(array $options = [])
	{
		if (isset($options['where']) && $this->type) {
			$options['where'] .= " and `type` = '$this->type'";
		} elseif($this->type) {
			$options['where'] .= " `type` = '$this->type'";
		}

		return parent::getall($options);
	}

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
