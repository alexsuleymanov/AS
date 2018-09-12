<?
	define("prod_childs_loaded", 1);

	class prod_childs extends Plugin{
		private $type = 'prod';

		public function __construct(){
			$this->actions = array(
				"search_child",
				"add_child",
				"del_child",
				"edit_child",
			);
		}

		public function search_child(){
			$child = intval($_GET['child']);

			$Prod = new Model_Prod();
			$prod = $Prod->get($child);

			if ($prod) {
				echo json_encode([0, $prod->id, $prod->name, $prod->price]);
			} else {
				echo json_encode(["error"]);
			}
			die();
		}
		
		public function add_child(){
			$vid = intval($_GET['id']);
			$child = intval($_GET['child']);

			$Prod = new Model_Prod();
			$prod = $Prod->get($child);
			
			if ($prod) {				
				$Relation = new Model_Relation();
				$Relation->insert(array("type" => "prod-prod", "obj" => $vid, "relation" => $prod->id));
				echo json_encode([$Relation->last_id(), $prod->id, $prod->name, $prod->price]);
			} else {
				echo json_encode(["error"]);
			}
			die();			
		}

		public function del_child(){
			$Relation = new Model_Relation();
			$Relation->delete(array("where" => "id = '".$_GET["del_child"]."'"));
			echo $del_child;
			die();
		}

		public function edit_child(){
			$Relation = new Model_Relation();
			$Relation->save(array("relation" => $_GET['child']), $_GET['relid']);
			echo $_GET['child'];
			die();
		}

		public function onset($id){
		}
		
		public function render($view){
			return parent::render($view);			
		}
	}
