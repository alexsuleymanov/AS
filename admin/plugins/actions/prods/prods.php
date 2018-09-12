<?
	define("actions_prods_loaded", 1);

	class actions_prods extends Plugin{
		public function __construct(){
			$this->actions = array(
				"add_prod",
				"del_prod",
				"edit_prod",
			);
		}

		public function add_prod(){
			$Relation = new Model_Relation();
			$Relation->insert(array("type" => "page-prod", "obj" => $_GET['id'], "relation" => 0));
			echo $Relation->last_id();
			die();
		}

		public function del_prod(){
			$Relation = new Model_Relation();
			$Relation->delete(array("where" => "id = '".$_GET["del_prod"]."'"));
			echo $_GET["del_prod"];
			die();
		}

		public function edit_prod(){
			$Relation = new Model_Relation();
			$Relation->save(array("relation" => $_GET['child']), $_GET['relid']);
			echo $_GET['child'];
			die();
		}

	}
