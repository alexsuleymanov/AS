<?php
use ASweb\StdLib\Func;

$view->prod = $Prod->getbyname($args[1]);

if (!$view->prod) {
    echo $layout->error_404($view);
	exit();
}

//$visited_prods->add($_SERVER['REQUEST_URI'], $view->prod->name);
if ($opt["prod_cats"] && $cat_id == 0) {
	$view->cat_id = $cat_id = $view->prod->cat;			
} elseif($opt['prod_multicats'] && $cat_id == 0) {
	$cats = $Prod->Plugin('Multicat')->getcasts($view->prod->id);
	$view->cat_id = $cats[0]->id;
}
	
$view->cat = $Cat->get($cat_id);
		
if ($cat_id) {
	$tree = array_reverse($Cat->Plugin('Tree')->get_cat_tree_up($cat_id));
	foreach ($tree as $k => $v) {
		$cat_row = $Cat->get($v->id);
		$view->bc["/catalog/".$cat_row->intname] = $cat_row->name;
	}
}

if ($opt["char_cats"]) {
	$Charcat = new Model_Charcat();
	$view->charcats = $Charcat->getall(array("where" => $Cat->Plugin('Tree')->cat_tree($cat_id)));
}

$Char = new Model_Char();
$view->chars = $Char->getall(array("where" => $Cat->Plugin('Tree')->cat_tree($cat_id), "order" => "prior desc"));

$view->bc["/product/".$view->prod->intname] = $view->prod->name;		

$view->page->id = $view->prod->id;
$view->page->name = $view->prod->name;
$view->page->title = ($view->prod->title) ? $view->prod->title : Func::mess_from_tmp($templates["prod_title"], array("name" => $view->prod->name));
$view->page->h1 = $view->prod->h1;
$view->page->kw = ($view->prod->kw) ? $view->prod->kw: Func::mess_from_tmp($templates["prod_kw"], array("name" => $view->prod->name));
$view->page->descr = ($view->prod->descr) ? $view->prod->descr : Func::mess_from_tmp($templates["prod_descr"], array("name" => $view->prod->name));
$view->page->rating = 0;

$view->canonical = "/product/".$view->prod->intname;

$view->page->cont = $view->render('product/cont.php');
echo $layout->render($view);