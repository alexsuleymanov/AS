<?php
use ASweb\StdLib\Layout;
use ASweb\Auth\Auth;

$view = new Zend_View();
$layout = new Layout();

if (defined("ASWEB_MOBILE_VERSION")) {
	$layout->setlayout("mobile.php");
}
	
if (defined("ASWEB_FRAME")) {
	$layout->setlayout("frame.php");
}

$view->baseUrl = "/";

$view->page = ($page) ? $page : new stdClass();
$view->sett = $sett;
$view->labels = $labels;
$view->blocks = $blocks;
$view->templates = $templates;
$view->args = $args;
$view->url = $url;

$view->Paginator = $Paginator;
/**
 * @var Model_Cart Корзина
 */
$view->Cart = $Cart;
$view->Compare = $Compare;
$view->Wishlist = $Wishlist;
$view->Cache = $Cache;
$view->OutputCache = $OutputCache;
$view->visited_prods = $visited_prods;
$view->bc = array("/" => $labels['mainpage']);
	
$view->path = "/app/view";

//if (!Auth::is_admin()) {
	require 'view/model.php';
	require 'view/layout.php';
//}

if (defined('ASWEB_ADMIN')) {
	$view->setBasePath("../admin/view/");
	$view->path = "/admin/view";
	$layout->setlayout("layout.php");
	$view->globalpath = $path;
} else {
	$view->setBasePath("app/view/");
	$view->path = "/app/view";
	$view->globalpath = $path;
}
