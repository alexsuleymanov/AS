<?php
use ASweb\Db\Db;
use ASweb\Cart\Cart;

class Model_Plugin_Order_User extends Model_Plugin_Abstract
{
	public function total(int $userid): float
	{
		$Order = new Model_Order();
		$orders = $Order->getall(array("select" => "id", "where" => "(status = 1 or status = 3 or status = 7) and user = ".Db::nq($userid)));
		$total = 0;
		foreach ($orders as $order) {
			$total += $this->ordersum($order->id);
		}
		return $total;
	}

	private function ordersum(int $id)
	{
		$Cart = new Cart(new Model_Cart(), $id);
		
		return $Cart->getAmount();
	}
	
	public function getOrdersNum($userid)
	{
		$Order = new Model_Order();
		$orders = $Order->getall(array("select" => "id", "where" => "user = ".Db::nq($userid)));
		
		return count($orders);
	}
}
