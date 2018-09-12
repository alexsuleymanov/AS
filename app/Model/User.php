<?php
	
class Model_User extends Model_Model
{
	public $type;

	protected $name = 'user';
	protected $depends = array("order");
	protected $relations = array();
	protected $visibility = 1;
	public $par = 0;

	public function __construct(string $type = '')
	{
		$this->type = $type;
		parent::__construct();
	}
}
