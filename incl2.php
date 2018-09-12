<?php
	
if (!defined('ASWEB_ADMIN') && (!empty($args) && !in_array($args[0].".php", $minimal_scripts))) {
//		require_once "init/region.php";
	require_once "init/lang.php";
	require_once "init/currency.php";

	require_once "init/sett.php";
	require_once "init/labels.php";
	require_once "init/blocks.php";
	require_once "init/templates.php";
	
	require_once "init/paginator.php";
//		require_once "init/history.php";
	require_once "init/auth.php";
	require_once "init/compare.php";
	require_once "init/cart.php";
	require_once "init/wishlist.php";
	
	require_once 'init/model/news.php';
	require_once 'init/model/articles.php';	
	require_once 'init/model/prod.php';
	require_once 'init/model/cat.php';
	require_once 'init/model/brand.php';
}