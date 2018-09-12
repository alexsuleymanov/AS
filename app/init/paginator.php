<?php

$Paginator = new ASweb\Paginator\Paginator();


if ($_GET['results'] && $_GET['results'] != $_SESSION['results']) {
	$_SESSION['results'] = $_GET['results'];
	$results = $_SESSION['results'];
} else {
	$results = ($_SESSION['results']) ? $_SESSION['results'] : 12;
}
$start = 0 + $_GET['start'];

$Paginator->retults = $results;
$Paginator->start = $start;
$Paginator->cnt = 0;

