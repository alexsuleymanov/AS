<?php

class Model_Order extends Model_Model
{
	protected $name = 'order';
	protected $depends = array("cart");
	protected $relations = array();
	protected $visibility = 0;
	public $par = 0;

}
