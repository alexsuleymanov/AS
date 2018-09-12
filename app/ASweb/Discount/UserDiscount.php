<?php
namespace ASweb\Discount;

use ASweb\Auth\Auth;

class UserDiscount implements DiscountInterface
{
	private $Model_Discount;
	
	public static $value = -1;
	
	public function __construct()
	{
		$this->Model_Discount = new \Model_Discount();
	}
	
	public function getValue(): float
	{
		if (!Auth::is_auth() || Auth::is_admin()) {
			return 0;
		} else {
			return floatval($_SESSION['userdiscount']);
		}
	}
		
	public function userLogin()
	{
		$_SESSION['userdiscount'] = $this->calculateUserDiscount();
	}
	
	public function calculateUserDiscount(): float
	{
		$User = new \Model_User();
		$user = $User->get(Auth::userid());
		$Order = new \Model_Order();
		$order_total = $Order->total(Auth::userid());
		$discount = $user->discount + $this->getAccum($order_total);
		
		return $discount;
	}
	
	public function getAccum(float $sum): float
	{
		$dis = $this->Model_Discount->getone(array("where" => "accum <= ".$sum."", "order" => "accum desc"));
		return $dis->value;
	}

	public function getSumToNextDiscount(float $accum): float
	{
		$dis = $this->Model_Discount->getone(array("where" => "accum > '".$accum."'", "order" => "accum"));
		return ($dis->accum - $accum);
	}

	public function getNextDiscountName(float $accum): string
	{
		$dis = $this->Model_Discount->getone(array("where" => "accum > '".$accum."'", "order" => "accum"));
		return $dis->name;
	}
}