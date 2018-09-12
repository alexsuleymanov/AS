<?php
namespace ASweb\Cart\Decorator;

use ASweb\Cart\CartInterface;
use ASweb\Auth\Auth;

class User implements CartInterface
{
 	private $Cart;
	private $Session;
	
	public function __construct(Model_Cart_CartInterface $Cart)
	{
		$this->Cart = $Cart;
		$this->Session = $Session;
		
		if(Auth::is_auth() && self::$cart_loaded == 0){
			if($this->Session){
				$this->loadsesion(Auth::userid());					
				foreach($this->cart as $k => $v){
					$this->insertsession(Auth::userid(), $k, $v);
				}
				self::$cart_loaded = 1;
			}
			$this->recount();
		}
	}

	private function loadSession($user){
		if(!$this->Session) return;
		
		$prods = $this->Session->getall(array("where" => "`user` = '".$user."'"));
		foreach($prods as $prod){
			$this->Cart->cart[$this->cartId($prod->prod, $prod->prodvar, json_decode($prod->chars))] = array(
				'id' => $prod->prod, 
				'var' => $prod->prodvar, 
				'num' => $prod->num, 
				'baseprice' => $prod->price,
				'price' => 0, 
				'chars' => json_decode($prod->chars),
				'discounts' => json_decode($prod->discounts),
				'tstamp' => $prod->tstamp,
			);
		}
	}
		
	private function saveSession($user){
		foreach($this->Cart->cart as $k => $v){
			$this->insertsession($user, $k, $v);
		}
	}
		
	private function insertSession($user, $cart_id, $cart_item){
		if(!$this->Session) return;

		if($this->Session->getnum(array("where" => "'user' = ".Auth::userid()." and cart_id = '".$cart_id."'")) == 0){
			$this->Session->insert(array(
				"user" => Auth::userid(),
				"cart_id" => $cart_id,
				"prod" => $cart_item['id'],
				"prodvar" => $cart_item['var'],
				"price" => $cart_item['baseprice'],
				"num" => $cart_item['num'],
				"tstamp" => $cart_item['tstamp'],
				"chars" => json_encode($cart_item['chars']),
				"discounts" => json_encode($cart_item['discounts']),
			));
		}
	}

	public function user_login($discount = 0){
		$this->savesesion(Auth::userid());
		$this->loadsesion(Auth::userid());
			
		if($discount){
			foreach($this->cart as $k => $v){
				if($this->cart[$k]['skidka'] == 0) $this->cart[$k]['userdiscount'] = $discount;
			}
			$this->recount();
		}
	}

	private function deletesession(){
		if(!$this->Session) return;
			
		$this->Session->delete(array("where" => "user = ".Auth::userid()));
	}
	
	public function addItem(int $id, int $var, int $num, float $price, array $options = array())
	{
		$cart_id = $this->cartId($id, $var, $chars);
			
		if(isset($this->cart[$cart_id])){
			$this->cart[$cart_id]['num'] += $num;
			$this->cart[$cart_id]['discounts'] = $discounts;
			$this->recount();

			if(Auth::is_auth()){
				if($this->Session) 
					$this->Session->update(array(
						"num" => $this->cart[$id]['num'], 
						'discounts' => json_encode($this->cart[$cart_id]['discounts']), 							
					), array("where" => "`user` = '".Auth::userid()."' and cart_id = '".$cart_id."'"));
			}	
		}else{
			$this->cart[$cart_id] = array('id' => intval($id), 'var' => intval($var), 'num' => intval($num), 'baseprice' => floatval($price), 'price' => floatval($price), 'chars' => $chars, 'discounts' => $discounts);
			$this->recount();

			if(Auth::is_auth())
				$this->insertsession(Auth::userid(), $cart_id, $this->cart[$cart_id]);
		}
	}	


	public function amount(): float
	{
		
	}

	public function deleteAll()
	{
				if(!is_null($this->Session) && Auth::is_auth())
			$this->Session->delete(array("where" => "`user` = '".Auth::userid()."'"));
	}

	public function deleteItem(string $cart_id)
	{
				if(Auth::is_auth())
			$this->Session->delete(array("where" => "`user` = '".Auth::userid()."' and cart_id = '".$k."'"));

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
		if($num == 0){
			unset($this->cart[$cart_id]);
			if(Auth::is_auth())
				$this->Session->delete(array("where" => "`user` = '".Auth::userid()."' and cart_id = '".$cart_id."'"));
		}else{				
			$this->cart[$cart_id]['num'] = intval($num);
			$this->cart[$cart_id]['discounts'] = $discounts;
			$this->recount();
			if(Auth::is_auth() && !is_null($this->Session) && $this->cart[$id]['num'] != $num)
				$this->Session->update(array("num" => $this->cart[$id]['num'], "discounts" => json_encode($this->cart[$cart_id]['discounts'])), array("where" => "`user` = '".Auth::userid()."' and cart_id = '".$cart_id."'"));
		}			
	}

	public function getAmount(): float
	{
		
	}

	public function getBaseAmount(): float
	{
		
	}

}

