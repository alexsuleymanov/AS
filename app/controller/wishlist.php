<?// Controller - Wishlist
	$action = ($args[1]) ? $args[1] : 'show';
	$wish_id = $cart_id = $args[2];
	
	if($action == 'clean'){
		$Wishlist->clear();
		die();
	}
	
	if ($action == 'add' || $action == 'fromcart') {
		if($action == 'fromcart'){
			$prod = 0 + $Cart->cart[$cart_id]['id'];
			$var = 0 + $Cart->cart[$cart_id]['var'];
			$chars = $Cart->cart[$cart_id]['chars'];
		}elseif($action == 'add'){
			$prod = 0 + $_POST['id'];
			$var = ($_POST['var']) ? $_POST['var'] : 0;
			$chars = $_POST['chars'];
		}

		$Wishlist->add($prod, $var, $chars);
 
		if($action == 'fromcart'){			
			$Cart->delete_cartitem($cart_id);			
		}
		
		if (Func::is_ajax()) {
			$result = array("num" => $Wishlist->prod_num());
			echo Zend_Json::encode($result);
			die();
		} else {
			header("Location: /wishlist/show");
			die();
		}
	} elseif ($action == 'show') {
		$view->wishlist = $Wishlist->wishlist;
		$view->page->cont = $view->render('wishlist/show.php');
		$view->bc['/'] = $view->labels['mainpage'];
		$view->bc['/wishlist'] = $view->page->name;
		echo $layout->render($view);
		die();
	} elseif ($action == 'delete') {
		$Wishlist->del($wish_id);
		header("Location: /wishlist/show");
		die();
	}