<?php
namespace ASweb\Cart\Decorator;

use ASweb\Cart\CartInterface;

class Stock implements CartInterface
{
	private $Cart;
	private $Storage;
	
	public function __construct(Model_Cart_CartInterface $Cart)
	{
		$this->Cart = $Cart;
	}
/**
	* Товар закончился или количество на складе ограничено
	* @return array
	*/	
	public function prodsOutOfStock(): array
	{
		$prods_limited = array();		
		
		foreach ($this->cart as $k => $v) {
			$prod_not_available = 0;
			
			if ($v['var']) {
				if (is_null($this->Prodvar) || is_null($this->Prod)) {
					return array();
				}
				
				$prod = $this->Prod->get($v['id']);
				$prodvar = $this->Prodvar->get($v['var']);
				$prod_id = $prod->id;
				$prod_num = $prodvar->num;
				if ($prodvar->visible == 0) {
					$prod_not_available = 1; 
				}
			} else {
				if (is_null($this->Prod)) {
					return array();
				}

				$prod = $this->Prod->get($v['id']);
				$prod_id = $prod->id;
				$prod_num = $prod->num;
				if ($prod->visible == 0 || $prod->avail == 0) {
					$prod_not_available = 1; 
				}
			}
			
			if ($prod_id == $v['id'] && $prod_num < $v['num']) {
				$prods_limited[] = $v['id'];
				$this->cart[$k]['num'] = $prod_num;
			}
				
			if ($prod_id == $v['id'] && ($prod_num <= 0 || $prod_not_available)) {
				unset($this->cart[$k]);
			}	
		}

		return $prods_limited;
	}

	public function addItem(int $id, int $var, int $num, float $price, array $options = array())
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