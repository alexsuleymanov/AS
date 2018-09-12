<?php
use ASweb\Cart\Cart;

$Cart = new Cart(new Model_Cart(), 0);
	
if ($opt['cart_user_session']) {
	$Cart = new \ASweb\Cart\Decorator\User($Cart);
}
	
if ($opt['cart_cookie']) {
	$Cart = new ASweb\Cart\Decorator\Cookie($Cart);
}
	
if ($opt['cart_weight']) {	
	$Cart = new \ASweb\Cart\Decorator\Weight($Cart);
}
	
if ($opt['prod_stock']) {
	$Cart = new \ASweb\Cart\Decorator\Stock($Cart);
}

if ($opt['discount_accum']) {
	$Cart = new \ASweb\Cart\Decorator\UserDiscount($Cart);
}

if ($opt['discount_sum']) {
	$Cart = new \ASweb\Cart\Decorator\SumDiscount($Cart);
}

if ($opt['discount_num']) {
	$Cart = new \ASweb\Cart\Decorator\NumDiscount($Cart);
}