<?// Controller - Каталог товаров
use ASweb\StdLib\Func;

$cat_id = $Cat->getbyname($args[1])->id;

foreach ($args as $k => $v) {
	if (preg_match("/cat-(\d+)-(.*?)/", $v, $m)) {
		$cat = 0 + $m[1];
	}
	
	if (preg_match("/brand-(\d+)-(.*?)/", $v, $m)) {
		$brand = 0 + $m[1];
	}
	
	if (preg_match("/tag-(\d+)-(.*?)/", $v, $m)) {
		$tag = 0 + $m[1];
	}
	
	if (preg_match("/action-(\d+)-(.*?)/", $v, $m)) {
		$action = 0 + $m[1];
	}
	
	if (preg_match("/char-(\d+)-(\d+)/", $v, $m)) {
		$char = 0 + $m[1];
		$charval = 0 + $m[2];
	}
		
	if (preg_match("/prod-(\d+)/", $v, $m)) {
		$prod = 0 + $m[1];
	}

	if (preg_match("/filter-(.*)/", $v, $m)) {
		$filter = $m[1];
		$view->filter = $filter;
		$is_filter = 1;
		preg_match_all("/brand(\d+)/", $filter, $m);
		$view->brands = $m[1];
		preg_match_all("/char(\d+)\-([\d_]+)/", $filter, $m);
		$view->chars = array();
		preg_match("/sale-(\w+)/", $filter, $m2);
		$view->sale = $m2[1];
			
		foreach ($m[1] as $k => $v) {
			if (preg_match("/_/", $m[2][$k])) {
				preg_match_all("/(\d+)/", $m[2][$k], $mm);
				$view->chars[$v] = $mm[0];
			} else {
				$view->chars[$v][] = $m[2][$k];
			}
		}
	}
}

if ($_GET['getnum']) {
	$Prod = new	Model_Prod();
	$type = false;
		
	if (($args[1] === 'new') || ($args[1] === 'action') || ($args[1] === 'pop') || ($args[1] === 'onsale')) {
		$type = $args[1];
	}
				
	$result = array("num" => $Prod->quickcount($cat, $type));
	echo Zend_Json::encode($result);
	die();
}
	
if ($_GET['filter']) {
	if ($args[1] === 'new' || $args[1] === 'action' || $args[1] === 'pop' || $args[1] === 'onsale') {
		$url_redir = "/catalog/".$args[1]."/".$args[2]."/filter";
	} else {
		$url_redir = "/catalog/".$args[1]."/"."filter";
	}
	$k = 0;
	if ($_GET['sale']) {
		$url_redir .= "-sale-".$_GET['sale'];
	}
		
	foreach ($_GET as $k => $b) {
		if (preg_match("/brand(\d+)/", $k, $m)) {
			$url_redir .= "-brand".$m[1];
		}
	}
	
	foreach ($_GET as $k => $b) {
		if (preg_match("/char(\d+)/", $k, $m)) {
			$url_redir .= "-char".$m[1]."-".implode("_", $b);
		}
	}
	
	if (isset($_GET['minprice']) && isset($_GET['maxprice'])) {
		$url_redir .= "?minprice=".$_GET['minprice']."&maxprice=".$_GET['maxprice'];
	}

	$url->redir($url_redir);
	die();
}

$view->bc["/catalog"] = $labels["catalog"];

if ($opt["prod_cats"] && empty($cat_id) && empty($prod_id) && empty($view->tag) && empty($args[1])) {
	$Cat = new Model_Cat();
	$view->cats = $Cat->getall(array("where" => "visible = 1 and cat = 0", "order" => "prior desc"));

	$view->page->cont = $view->render('catalog/cat-list.php');
	echo $layout->render($view);	
} elseif(empty($prod_id)) {
	$Cat = new Model_Cat();
	$Prod = new Model_Prod();
		
	if($cat_id) {
		$row = $Cat->get($cat_id);
			
		$view->cat = $row;
		$view->page->title = ($row->title) ? $row->title : Func::mess_from_tmp($templates["cat_title"], array("name" => $row->name));
		$view->page->h1 = ($row->h1) ? $row->h1 : $row->name;
		$view->page->kw = $row->kw;
		$view->page->descr = ($row->descr) ? : Func::mess_from_tmp($templates["cat_descr"], array("name" => $row->name));
		$view->page->cont2 = $row->cont;

		$tree = array_reverse($Cat->get_cat_tree_up($cat_id));

		foreach($tree as $k => $v) {
			$cat_row = $Cat->get($v->id);
			$view->bc["/catalog/".$cat_row->intname] = $cat_row->name;
		}
		$view->canonical = "/".$args[0]."/".$row->intname;
	}

	if ($brand) {
		$Brand = new Model_Brand();
		$row = $Brand->get($brand);

		$view->page->title = ($row->title) ? $view->page->title.". ".$row->title : $view->page->title.". ".$row->name;
		$view->page->h1 .= ($row->h1) ? $view->page->h1.". ".$row->h1 : $view->page->h1.". ".$row->name;
		$view->page->kw .= ($row->kw) ? $row->kw.", ".$view->page->kw : $row->name.", ".$view->page->kw;
		$view->page->descr = ($row->descr) ? $row->descr : $row->name.". ".$view->page->descr;
		$view->canonical = "/".$args[0]."/tag-".$row->id."-".$row->intname;
	}

	if($tag){
		$Tag = new Model_Tag();
		$tag = $Tag->get($tag);

		$view->page->title .= ". ".$tag->name;
		$view->page->h1 .= ". ".$tag->name;
		$view->page->kw .= ", ".$tag->name;
		$view->page->descr .= ". ".$tag->name;

		$view->canonical = "/".$args[0]."/tag-".$row->id."-".$row->intname;
	}

	$cond = array(
		"where" => "visible = 1",
	);

	$order = ($_GET['order']) ? $_GET['order'] : "prior";
	$desc_asc = ($_GET['desc_asc']) ? $_GET['desc_asc'] : "desc";

	$cond['order'] = $order." ".$desc_asc;

	if($cat_id){
		if($opt['prod_cats'])
			$cond['where'] .= " and cat = '".ASweb\Db\Db::nq($cat_id)."'";
		elseif($opt['prod_multicats'])
			$cond["relation"] = array("select" => "relation", "where" => "`type` = 'cat-prod' and obj = '".ASweb\Db\Db::nq($cat_id)."'");
	}

	if($brand) $cond['where'] .= " and brand = '".ASweb\Db\Db::nq($brand)."'";

	if($tag) $cond["relation"] = array("select" => "obj", "where" => "`type` = 'prod-tag' and relation = '".ASweb\Db\Db::nq($tag)."'");

	if($args[1] == 'sale' || $args[1] == 'new' || $args[1] == 'pop')
		 $cond['where'] .= " and `".$args[1]."` = 1";

	if($_GET["filter"])
		$cond["where"] .= " and ".Model_Prod::filter($cat_id);

	$view->cnt = $Prod->getnum($cond);
	$view->results = $results;
	$view->start = $start;
		
	$cond["limit"] = "$start, $results";
	$prods = $Prod->getall($cond);

	$view->prods = $prods;

	if($opt["articles_cats"]){
		$view->articles = $Cat->getarticles($cat_id);
	}
		
	if($opt["cat_tree"]){
		$view->cats = $Cat->getall(array("where" => "visible = 1 and cat = '".ASweb\Db\Db::nq($cat_id)."'", "order" => "prior desc"));
	}

	if($_GET['view']) {
		$_SESSION['view'] = $_GET['view'];
	}
	if($_SESSION['view']) {
		$view->view = $_SESSION['view'];
	}

	$view->page->cont = $view->render('catalog/prod-list.php');
	echo $layout->render($view);
}
