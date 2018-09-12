<?
	define("prod_analogs_loaded", 1);

	class prod_analogs extends Plugin{
		private $type = 'prod';

		public function __construct(){
			$this->actions = array(
				"search_analog",
				"add_analog",
				"del_analog",
				"edit_analog",
			);
		}

		public function search_analog(){
			$analog = intval($_GET['analog']);

			$Prod = new Model_Prod();
			$prod = $Prod->get($analog);

			if ($prod) {
				echo json_encode([0, $prod->id, $prod->name, $prod->price]);
			} else {
				echo json_encode(["error"]);
			}
			die();
		}

		public function add_analog(){
			$vid = intval($_GET['id']);
			$analog = intval($_GET['analog']);

			$Prod = new Model_Prod();
			$prod = $Prod->get($analog);
			
			if ($prod) {				
				$Relation = new Model_Relation();
				$Relation->insert(array("type" => "prod-prod-analog", "obj" => $vid, "relation" => $prod->id));
				echo json_encode([$Relation->last_id(), $prod->id, $prod->name, $prod->price]);
			} else {
				echo json_encode(["error"]);
			}
			die();			
		}

		public function del_analog(){
			$Relation = new Model_Relation();
			$Relation->delete(array("where" => "id = '".$_GET["del_analog"]."'"));
			echo $del_analog;
			die();
		}

		public function edit_analog(){
			$Relation = new Model_Relation();
			$Relation->save(array("relation" => $_GET['analog']), $_GET['relid']);
			echo $_GET['analog'];
			die();
		}

		public function onset($id){
		}
		
		public function render($view){
			return parent::render($view);			
		}
	}
