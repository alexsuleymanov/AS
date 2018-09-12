<?php
namespace ASweb\Cart;
use ASweb\Db\Entity;

interface CartInterface
{
	public function addItem(Entity $prod, Entity $prodvar, int $num, $chars = []);
	public function updateItem(string $cart_id, int $num);
	public function getAmount(): float;
	public function getBaseAmount(): float;
	public function getProdNum(): int;
	public function getPackNum(): int;
	public function deleteItem(string $cart_id);
	public function deleteAll();
	public function saveCart(int $order_id);
}