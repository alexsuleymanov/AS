<?
	$Lang = new Model_Lang();
	$langs = $Lang->getall();

	foreach($langs as $k => $v){?>
<a class="lang<?=($v->intname == Zend_Registry::get('lang')) ? "_a" : ""?>" href="<?=($v->main) ? "/" : "/".$v->intname."/"?>"><?=$v->name?></a>&nbsp;&nbsp;
<?	}
