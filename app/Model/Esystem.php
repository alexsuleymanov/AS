<?php
	
class Model_Esystem extends Model_Model
{
	protected $name = 'esystem';
	protected $depends = array("eforms");
	protected $relations = array();
	protected $multylang = 1;
	protected $visibility = 1;

	public $par = 0;
}
