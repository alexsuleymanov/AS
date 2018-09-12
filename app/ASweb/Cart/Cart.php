<?php
namespace ASweb\Cart;

use ASweb\Discount\Discount;
use ASweb\Db\Entity;

class Cart implements CartInterface
{
	protected $name = 'cart';
	protected $depends = [];
	protected $relations = [];
	protected $prod_vars;
	protected $visibility = 0;
	public $Model_Cart;
	public $par = 0;
		
	public $cart;
	
	public function __construct(\Model_ModelInterface $Model_Cart, int $order_id = 0)
	{
		$this->Model_Cart = $Model_Cart;
		
		if ($order_id) {
			$this->load($order_id);
		} else {
			$this->init();
		}
	}
				    		
	/**
	 * Инициализация корзины. 1 раз при созданиие новой корзины
	 */
	private function init() {
		session_start();
		$this->cart = &$_SESSION['cart'];

		if (empty($_SESSION['cart'])) {
			$_SESSION['cart'] = [];
		}
	}
	
	/**
	 * Загрузка корзины выбранного заказа
	 * 
	 * @param int $order_id
	 */
	private function load(int $order_id)
	{
		$cart_items = $this->Model_Cart->getall(array("where" => "`order` = ".$order_id));
		
		foreach ($cart_items as $item) {
			$this->cart[$this->cartId($item->prod, $item->prodvar, json_decode($item->chars))] = array('id' => $item->prod, 'var' => $item->prodvar, 'num' => $item->num, 'baseprice' => $item->price, 'price' => 0, 'discount' => $item->discount, 'chars' => json_decode($item->chars), 'tstamp' => $item->tstamp);
		}
		$this->recount();
	}
		
	/**
	 * Генерация CartId
	 * 
	 * @param int $id
	 * @param int $var
	 * @param array $chars
	 * @return string
	 */
	protected function cartId(int $id = 0, int $var = 0, array $chars = array()): string
	{
		if (!empty($chars)) {
			ksort($chars);
			return md5($id."_".$var."_".json_encode($chars));
		} else {
			return md5($id."_".$var);
		}
	}
		
	/**
	 * Добавляет товар в корзину
	 * 
	 * @param \ASweb\Db\Entity $prod
	 * @param \ASweb\Db\Entity $prodvar
	 * @param int $num
	 * @param array $chars
	 */
	public function addItem(Entity $prod, Entity $prodvar, int $num, $chars = [])
	{
		$cart_id = $this->cartId((int) $prod->id, (int) $prodvar->id, $chars);
			
		if (isset($this->cart[$cart_id])) {
			$this->cart[$cart_id]['num'] += $num;
		} else {
			$this->cart[$cart_id] = [
				'id' => intval($prod->id),
				'var' => intval($prodvar->id),
				'num' => intval($num),
				'baseprice' => floatval($prod->price),
				'price' => floatval($prod->price),
			];
			
			if (isset($chars)) {
				$this->cart[$cart_id]['chars'] = $chars;
			}
			
			if (isset($prod->discount)) {
				$this->cart[$cart_id]['discount'] = $prod->discount;
			}
			
			if (isset($prodvar->discount)) {
				$this->cart[$cart_id]['discount'] = $prodvar->discount;
			}
		}
		
		$this->recount();
	}	

	/**
	 * Изменяет количество выбранного товара в корзине
	 * 
	 * @param string $cart_id
	 * @param int $num
	 */
	public function updateItem(string $cart_id, int $num)
	{
		if ($num <= 0) {
			unset($this->cart[$cart_id]);
		} else {
			$this->cart[$cart_id]['num'] = $num;
		}
	}

	/**
	 * Возвращает общую стоимость корзины с учетом всех возможных скидок и надбавок
	 * 
	 * @return float
	 */
	public function getAmount(): float
	{
		$amount = 0;			
		foreach ($this->cart as $v) {
			$amount += $v['price'] * $v['num'];			
		}
		
		return $amount;
	}

	/**
	 * Возвращает общую стоимость корзины без учета возможных скидок или надбавок
	 * 
	 * @return float
	 */
	public function getBaseAmount(): float
	{
		$amount = 0;			
		foreach ($this->cart as $v) {
			$amount += $v['baseprice'] * $v['num'];
		}
			
		return $amount;
	}
				
	/**
	 * Пересчет цен в корзине при выполнении какого-либо действия, которое может повлечь за собой изменение цен в корзине
	 * 
	 */
	public function recount () 
	{		
		foreach ($this->cart as $k => $v) {
			if ($v['num'] < 1) {
				unset($this->cart[$k]);
			}
			
			if (isset($v['discount'])) {
				$this->cart[$k]['price'] = $v['baseprice'] * (100 - $v['discount']) / 100;
			}		
		}
	}
	
	/**
	 * Возвращает количество разных товаров в корзине
	 * 
	 * @return int
	 */
	public function getProdNum(): int
	{
		return count($this->cart);
	}

	/**
	 * Возвращает количество упаковок в корзине.
	 * 
	 * @return int
	 */
	public function getPackNum(): int
	{
		$num = 0;
		foreach ($this->cart as $v) {
			$num += $v['num'];
		}
		
		return $num;
	}

	/**
	 * Удаляет товар из корзины. В качестве параметра передается CartId (строка MD5)
	 * 
	 * @param string $cart_id
	 */
	public function deleteItem(string $cart_id)
	{
		unset($this->cart[$cart_id]);
	}		

	/**
	 * Очищает корзину
	 */
	public function deleteAll()
	{
		$this->cart = [];
	}	
	
	/**
	 * Сохранение корзины в базе данных для оформленного заказа
	 * 
	 * @param int $order_id
	 */
	public function saveCart(int $order_id)
	{
		foreach ($this->cart as $k => $v) {
			$item = [
				'order' => $order_id,
				'prod' => 0 + $v['id'],
				'prodvar' => 0 + $v['var'],
				'price' => 0 + $v['baseprice'],
				'num' => 0 + $v['num'],
				'chars' => json_encode($v['chars']),
				'discount' => $v['discount'],
				'tstamp' => 0 + $v['tstamp'],
			];
				
			$this->Model_Cart->insert($item);
		}
	}

}
