<?php
	function clear($str){
		return iconv("WINDOWS-1251", "UTF-8", $str);
	}
	
/*	$qr = $db->q("select * from express_brand");
	while($r = $qr->f()){
		$db->q("insert es_brand set id = '".$r->id."', name = '".$r->title."', intname = '".$r->intname."', cont = '".$r->cont."', prior = '".$r->prior."', title = '".$r->titletag."'");
		echo $r->title."<br>";
	}*/

	$qr = $db->q("select * from express_cat");
	while($r = $qr->f()){
//		print_r($r);
//		$db->q("insert es_cat set id = '".$r->id."', cat = '".$r->cat."', name = '".ASweb\Db\Db::nq($r->title)."', intname = '".$r->intname."', cont = '".ASweb\Db\Db::nq(clear($r->cont))."', prior = '".$r->prior."', title = '".$r->titletag."', kw = '".$r->keywords."', descr = '".$r->description."', visible = 1");
		echo $r->title."<br>";
	}


	$qr = $db->q("select * from express_prod");
	while($r = $qr->f()){
//		print_r($r);
		$db->q("insert es_prod set id = '".$r->id."', cat = '".$r->cat."', brand = '".$r->brand."', name = '".ASweb\Db\Db::nq(clear($r->title))."', short = '".ASweb\Db\Db::nq(clear($r->short))."', cont = '".ASweb\Db\Db::nq(clear($r->cont))."', prior = '".$r->prior."', title = '".ASweb\Db\Db::nq($r->titletag)."', kw = '".ASweb\Db\Db::nq($r->keywords)."', descr = '".ASweb\Db\Db::nq($r->description)."', visible = ".(1-$r->hidden).", price = '".$r->price."', price_usd = '".$r->price_usd."', price_eur = '".$r->price_eur."', course = '".$r->course."', main = '".$r->main."'");
		echo $r->title."<br>";
	}

	$qr = $db->q("select * from express_news");
	while($r = $qr->f()){
//		print_r($r);
		$db->q("insert es_page set id = '".$r->id."', `type` = 'news', intname = '".$r->intname."', tstamp = ".$r->tstamp.", name = '".$r->title."', cont = '".ASweb\Db\Db::nq(clear($r->cont))."', kw = '".$r->keywords."', descr = '".$r->description."', visible = 1");
//		echo $r->title."<br>";
	}
	
	$qr = $db->q("select * from express_pages where par = 31");
	while($r = $qr->f()){
		$r->name = str_replace("articles/", "", $r->name);
//		print_r($r);
		$db->q("insert es_page set `type` = 'article', href = '".$r->href."', intname = '".$r->name."', name = '".$r->menutitle."', cont = '".ASweb\Db\Db::nq(clear($r->cont))."', prior = '".$r->prior."', title = '".$r->title."', h1 = '".$r->h1."', kw = '".$r->keywords."', descr = '".$r->description."', visible = 1");
		echo $r->title."<br>";
	}
/*
	$qr = $db->q("select * from express_pages where par != 31");
	while($r = $qr->f()){
//		$r->name = str_replace("articles/", "", $r->name);
//		print_r($r);
		if($r->par){
			$par = $db->q("select id, page from es_page where intname = '".$r->name."'")->id;
		}
		$par = ($par) ? $par : $r->par; 
		$db->q("insert es_page set `page` = '".$par."', `type` = 'page', href = '".$r->href."', intname = '".$r->name."', name = '".$r->menutitle."', cont = '".ASweb\Db\Db::nq(clear($r->cont))."', prior = '".$r->prior."', title = '".$r->title."', h1 = '".$r->h1."', kw = '".$r->keywords."', descr = '".$r->description."', visible = ".(1-$r->hidden)."");
		echo $r->menutitle."<br>";
	}
*/	
