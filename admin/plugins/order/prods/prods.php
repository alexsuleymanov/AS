<?
	define("order_prods_loaded", 1);

	class order_prods extends Plugin{
		public function __construct(){
			$this->actions = array(
				"add_prod",
				"del_prod",
				"export",
				"edit_cart",
				"update_cart",
			);
		}

		public function add_prod(){
			$Cart = new Model_Cart();
			$Cart->insert(array("order" => $_GET['id']));
			echo $Cart->last_id();
			die();
		}

		public function del_prod(){
			$Cart = new Model_Cart();
			$Cart->delete(array("where" => "id = '".$_GET['del_prod']."'"));
			echo $_GET['del_prod'];
			die();
		}

		public function export(){
			$Order = new Model_Order();
			$Order->export_csv($_GET['id']);
			die();
		}

		public function edit_cart(){
			$Cart = new Model_Cart;
			$Prod = new Model_Prod();
			$prod = $Prod->get($_GET['prod']);
		
			$data = array(
				'id' => $_GET['cart_id'],
				'order' => $_GET['order'],
				'prod' => $prod->id,
				'price' => $prod->price,
				'num' => 1,
	//			'skidka' => $prod->skidka,
			);

			$Cart->save($data, $_GET['cart_id']);

			Zend_Json::encode($data);
			die();
		}

		public function update_cart(){
			$Cart = new Model_Cart();
			$Cart->save(array("num" => $_GET['num']), $_GET['cart_id']);
			die();
		}
	}
