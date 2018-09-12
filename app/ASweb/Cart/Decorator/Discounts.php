<?php
namespace ASweb\Cart\Decorator;

use ASweb\Cart\CartInterface;

class Model_Cart_Decorator_Coockie implements Model_Cart_CartInterface
{	
	public function addItem(int $id, int $var, int $num, float $price, $discount = 0, $chars = array())
	{
		
	}

	public function deleteAll()
	{
		
	}

	public function deleteItem(string $cart_id)
	{
		
	}

	public function getAmount(): float
	{
		
	}

	public function getBaseAmount(): float
	{
		
	}

	public function getPackNum(): int
	{
		
	}

	public function getProdNum(): int
	{
		
	}

	public function saveCart(int $order_id)
	{
		
	}

	public function updateItem(string $cart_id, int $num)
	{
		
	}

}