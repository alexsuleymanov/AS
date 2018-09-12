<?// Controller - Корзина
use ASweb\Discount\Discount;
use ASweb\Discount\UserDiscount;

$action = ($args[1]) ? $args[1] : 'edit';

$view->bc["/" . $args[0]] = $labels["cart"];

if ($action == 'buy') {
	$id = $_POST['id'] ?? $_GET['id'] ?? 0;
	$var = $_POST['var'] ?? $_GET['var'] ?? 0;
	$num = $_POST["num"] ?? $_GET["num"] ?? 1;
	$chars = $_POST['chars'] ?? [];
		
	$Prod = new Model_Prod();
	$prod = $Prod->get($id);

	print_r($prod);
	die();
	$price = $prod->price;
	$weight = $prod->weight;
	$numdiscount = $prod->numdiscount;

	if ($var) {
		$Prodvar = new Model_Prodvar();
		$prodvar = $Prodvar->get($id);
		$Cart->addItem($prod, $prodvar, $num, $chars);
	} else {
		$Cart->addItem($prod, new \ASweb\Db\NullEntity(), $num, $chars);	
	}
	
	
	$result = array("id" => $id, "prods" => $Cart->getProdNum(), "packs" => $Cart->getPackNum(), "amount" => $Cart->getAmount(), "cart" => serialize($Cart->cart), "message" => $view->labels['prod_added_to_cart'] ,"reload" => $_POST['reload']);

	echo Zend_Json::encode($result);
	die();
} elseif ($action == 'update') {
	$cart_id = $_POST["cart_id"] ?? $_GET["cart_id"] ?? null;
	$num = $_POST["num"] ?? $_GET["num"] ?? 1;

	$Prod = new Model_Prod();
	$prod = $Prod->get($Cart->cart[$cart_id]['id']);

	$Cart->updateItem($cart_id, $num);
	
	$result = array("cart_id" => $cart_id, "id" => $Cart->cart[$cart_id]['id'], "price" => $Cart->cart[$cart_id]['price'], "num" => $Cart->cart[$cart_id]['num'], "prods" => $Cart->getProdNum(), "packs" => $Cart->getPackNum(), "amount" => $Cart->getAmount(), "cart" => serialize($Cart->cart), "reload" => $_POST['reload']);
	
	echo Zend_Json::encode($result);
	die();
} elseif ($action == 'edit') {
	$view->page->cont .= $view->render('cart/edit.php');
	echo $layout->render($view);
	die();
} elseif ($action == 'delete') {
	$cart_id = $args[2] ?? $_GET['cart_id'] ?? null;
	$Cart->deleteItem($cart_id);
	
	if ($_POST['ajax']) {
		$result = array("prods" => $Cart->getProdNum(), "amount" => $Cart->getAmount());
		echo Zend_Json::encode($result);
		die();
	} else {
		header("Location: /cart" . $url->gvar("asdflkha="));
		die();
	}
} elseif ($action == 'clear') {
	$Cart->deleteAll();
	
	if ($_POST['ajax']) {
		$result = array("prods" => $Cart->getProdNum(), "amount" => $Cart->getAmount());
		echo Zend_Json::encode($result);
		die();
	} else {
		header("Location: /cart" . $url->gvar("asdflkha="));
		die();
	}
}