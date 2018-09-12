<?php
use ASweb\Mail\Mail;
	
$Message = new Model_Message();
$Message->insert(array(
	"email" => $_POST['email'],
	"phone" => $_POST['phone'],
	"name" => $_POST['name'],
	"cont" => $_POST['cont'],
	"tstamp" => time(),
	"type" => "callback",
));
	
Mail::mailhtml($sett['sitename'], "callback@".$_SESSION['HTTP_HOST'], $sett['admin_email'], "CallBack", "Перезвоните: ".$_POST['phone']."(".$_POST['name'].") - ".$_POST['cont']);
echo "ok";
die();
