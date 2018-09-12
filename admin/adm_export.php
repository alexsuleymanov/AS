<?
	include("incl.php");
	
	$view->title = "Экспорт товаров";
	echo $view->render('head.php');

	echo "Экспорт в Prom.ua: <a target=\"_blank\" href=\"http://".$_SERVER['HTTP_HOST']."/export/prom\">http://".$_SERVER['HTTP_HOST']."/export/prom</a><br />";
	echo "Экспорт в Hotprice: <a target=\"_blank\" href=\"http://".$_SERVER['HTTP_HOST']."/export/hotprice\">http://".$_SERVER['HTTP_HOST']."/export/hotprice</a><br />";
	echo "Экспорт в Price.ua: <a target=\"_blank\" href=\"http://".$_SERVER['HTTP_HOST']."/export/priceua\">http://".$_SERVER['HTTP_HOST']."/export/priceua</a><br />";
	echo "Экспорт в Freemarket: <a target=\"_blank\" href=\"http://".$_SERVER['HTTP_HOST']."/export/freemarket\">http://".$_SERVER['HTTP_HOST']."/export/freemarket</a><br />";
	echo "Экспорт в Hotline.ua: <a target=\"_blank\" href=\"http://".$_SERVER['HTTP_HOST']."/export/hotline\">http://".$_SERVER['HTTP_HOST']."/export/hotline</a><br />";
	echo "Экспорт в Pn.com.ua: <a target=\"_blank\" href=\"http://".$_SERVER['HTTP_HOST']."/export/pn\">http://".$_SERVER['HTTP_HOST']."/export/pn</a><br />";
	echo "Экспорт в Vcene: <a target=\"_blank\" href=\"http://".$_SERVER['HTTP_HOST']."/export/vcene\">http://".$_SERVER['HTTP_HOST']."/export/vcene</a><br />";
	echo "Экспорт в Yandex: <a target=\"_blank\" href=\"http://".$_SERVER['HTTP_HOST']."/export/yandex\">http://".$_SERVER['HTTP_HOST']."/export/yandex</a><br />";
	echo "Экспорт в Technoportal: <a target=\"_blank\" href=\"http://".$_SERVER['HTTP_HOST']."/export/technoportal\">http://".$_SERVER['HTTP_HOST']."/export/technoportal</a><br />";
	echo "Экспорт в 1C: <a target=\"_blank\" href=\"http://".$_SERVER['HTTP_HOST']."/export/1c\">http://".$_SERVER['HTTP_HOST']."/export/1c</a><br />";

	echo $view->render('foot.php');