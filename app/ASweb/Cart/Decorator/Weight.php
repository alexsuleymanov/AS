<?php
namespace ASweb\Cart\Decorator;

use ASweb\Cart\CartInterface;

class Weight implements CartInterface
{
	private $Cart;
	private $Storage;
	
	public function __construct(Model_Cart_CartInterface $Cart)
	{
		$this->Cart = $Cart;
	}

	/**
	 * Возвращает вес корзины. Нужен для расчета стоимости доставки
	 * 
	 * @param \Model_ModelInterface $Prod
	 * @return type
	 */
	public function getWeight()
	{
		$weight = 0;
		foreach ($this->cart as $k => $v) {
			if ($v['var']) {
				if (is_null($this->Prodvar)) {
					$weight = 0;
					break;
				} else {
					$prodvar = $this->Prodvar->get($v['var']);
					$weight += $v['num'] * $prodvar->weight;
				}
			} else {
				if (is_null($this->Prod)) {
					$weight = 0;
					break;				
				} else {
					$prod = $this->Prod->get($v['id']);
					$weight += $v['num'] * $prod->weight;
				}
			}
		}		
		return $weight;
	}

	public function addItem(int $id, int $var, int $num, float $price, array $options = array())
	{
		$this->Cart->addItem($id, $var, $num, $price, $options);
	}
	
	public function saveCart(int $order_id)
	{
		$this->Cart->saveCart($order_id);
	}

	public function deleteAll()
	{
		$this->Cart->deleteAll();
	}

	public function deleteItem(string $cart_id)
	{
		$this->Cart->deleteItem($cart_id);
	}

	public function getAmount(): float
	{
		return $this->Cart->getAmount();
	}

	public function getBaseAmount(): float
	{
		return $this->Cart->getBaseAmount();
	}

	public function getPackNum(): int
	{
		return $this->Cart->getPackNum();
	}

	public function getProdNum(): int
	{
		return $this->Cart->getProdNum();
	}

	public function updateItem(string $cart_id, int $num)
	{
		$this->Cart->updateItem($cart_id, $num);
	}
}