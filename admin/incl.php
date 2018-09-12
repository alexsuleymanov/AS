<?php
use ASweb\Url\Url;
	
define("ASWEB_ADMIN", 1);

require_once "../incl.php";
$url = new Url();
	
require_once("incl2.php");

if (defined("ASWEB_DEBUG")) {
	error_reporting(E_ALL & ~E_NOTICE);
	ini_set("display_errors", 1);		
} else {
	error_reporting(E_ERROR);
	ini_set("display_errors", 0);		
}

require_once "../app/init/view.php";

require_once("auth.php");
require_once("plugins/plugins.php");

$Plugins = new Plugins();


Zend_Registry::set('cur_name', "грн.");
Zend_Registry::set('currency_name', "грн.");