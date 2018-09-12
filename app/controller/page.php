<?
$view->page = $page;
$tree = array_reverse($Page->Plugin('Tree')->get_page_tree_up($page->id));

foreach($tree as $k => $v){
	$page_row = $Page->get($v->id);
	$view->bc["/".$page_row->intname] = $page_row->name;
}

$view->page->cont = $view->render('page/cont.php');
	
echo $layout->render($view);