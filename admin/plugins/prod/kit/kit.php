<?
	define("prod_kit_loaded", 1);

	class prod_kit extends Plugin{
		private $type = 'prod';

		public function __construct(){
			$this->actions = array(
				"add_kit",
				"del_kit",
				"edit_kit",
				"edit_kit_discount",
			);
		}

		public function add_kit(){
			$vid = 0 + $_GET['id'];

			$Kit = new Model_Kit();
			$Kit->insert(array("prod" => $vid, "relation" => 0));
			echo $Kit->last_id();
			die();
		}

		public function del_kit(){
			$Kit = new Model_Kit();
			$Kit->delete(array("where" => "id = '".$_GET["del_kit"]."'"));
			echo $_GET["del_kit"];
			die();
		}

		public function edit_kit(){
			$Kit = new Model_Kit();
			$Kit->save(array("relation" => $_GET['kit']), $_GET['kitid']);
			echo $_GET['kit'];
			die();
		}
                        
		public function edit_kit_discount(){
			$Kit = new Model_Kit($_GET['kitid']);
			$Kit->save(array("discount" => $_GET['discount']));
			echo $_GET['discount'];
			die();
		}

		public function onset($id){
		}
		
		public function render($view){
			return parent::render($view);			
		}
	}
