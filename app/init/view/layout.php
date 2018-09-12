<?php
$view->layout = new stdClass();

$view->layout->articles = $Articles->getall([
	"order" => "tstamp desc",
    "limit" => 5,
]);

$view->layout->news = $News->getall([
	"order" => "tstamp desc",
    "limit" => 5,
]);



