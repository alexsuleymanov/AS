<?
include ("incl.php");
$view->title = "Панель администратора";

$view->cont = $view->render('index.php');
echo $layout->render($view);