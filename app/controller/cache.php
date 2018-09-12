<?php
use ASweb\StdLib\Minimize;
	
$type = $args[1];
$files = explode(",", str_replace('__', '/', $args[2]));
	
$minimize = new Minimize($type, $path."/app/view/", $files, 1, $cache);
	
$minimize->show();
	
	