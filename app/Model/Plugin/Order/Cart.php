<?php
use ASweb\Cart\Cart;

class Model_Plugin_Order_Cart extends Model_Plugin_Abstract
{
	public $Cart;
	
	public function __construct(array $options = [], Cart $Cart)
	{
		$this->Cart = $Cart;
		
		parent::__construct($options);
	}
	
	public function Cart()
	{
		return $this->Cart;
	}
}