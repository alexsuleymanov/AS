<?
	define("prod_vars_loaded", 1);

	class prod_vars extends Plugin{
		private $type = 'prod';

		public function __construct(){
			$this->actions = array(
				"add_var",
				"del_var",
			);
		}

		public function add_var(){
			$add = 0 + $_GET['add_var'];
			$vid = 0 + $_GET['id'];

			$Prodvar = new Model_Prodvar();
			$Prodvar->insert(array("prod" => $vid));
			echo $Prodvar->last_id();
			die();
		}

		public function del_var(){
			$vid = 0 + $_GET['id'];
			$del = 0 + $_GET['del_var'];

			$Prodvar = new Model_Prodvar();
			$Prodvar->delete(array("where" => "id = '$del'"));
			echo $del;
			die();
		}

		public function onset($id){
			$Prod = new Model_Prod($id);

			$pv = array();

			foreach($_POST as $k => $v) {
				if (preg_match("/^var_(\d+)_title$/", $k, $m)) $pv[$m[1]][title] = ($v) ? $v : '';
				if (preg_match("/^var_(\d+)_price$/", $k, $m)) $pv[$m[1]][price] = ($v) ? $v : 0;
			}

			$Prod->clearprodvars();

			$Prodvar = new Model_Prodvar();
			foreach($pv as $k => $v)
				$Prodvar->insert(array(
					"prod" => $id,
					"name" => ASweb\Db\Db::nq($v['title']),
					"price" => $v['price'],
				));
		}
		
		public function render($view){
			return parent::render($view);			
		}
	}
