<?php
use ASweb\Cache\Cache;
use ASweb\Cache\OutputCache;
	
$frontendOptions = array(
	'lifetime' => 3000000,
	'automatic_serialization' => true
);
 
$backendOptions = array(
   	'cache_dir' => $path."/tmp/",
);
 
$Cache = new Cache('File', $frontendOptions, $backendOptions);

$frontendOptions = array(
	'lifetime' => 3000000,
	'automatic_serialization' => true
);
$backendOptions = array(
   	'cache_dir' => $path."/tmp/img/",
);

$OutputCache = new OutputCache('File', $frontendOptions, $backendOptions);

define("ASWEB_CACHE_ON", 1);
