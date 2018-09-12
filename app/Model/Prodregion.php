<?php

class Model_Prodregion extends Model_Model
{
	protected $name = 'prodregion';
	protected $depends = array();
	protected $relations = array();
	protected $visibility = 0;
	protected $multylang = 0;
	public $par = 0;

	public function clearprodregions(int $prod_id)
	{
		$this->delete(array("where" => "prod = $prod_id"));
	}
}
