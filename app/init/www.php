<?php
	$www = 0;

	if($www == 0 && strstr($_SERVER["HTTP_HOST"], "www")){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: http://".str_replace("www.", "", $_SERVER["HTTP_HOST"]).$_SERVER["REQUEST_URI"]);
		exit();
	}elseif($www == 1 && strstr($_SERVER["HTTP_HOST"], "www") == false){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: http://www.".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
		exit();
	}
