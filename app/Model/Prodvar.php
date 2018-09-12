<?php
	
class Model_Prodvar extends Model_Model
{
	protected $name = 'prodvar';
	protected $depends = array("cart");
	protected $relations = array();
	protected $multylang = 1;
	protected $visibility = 1;

	public $par = 0;

}
