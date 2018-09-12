<?
	define("prod_chars_loaded", 1);

	class prod_chars extends Plugin{
		private $type = 'prod';

		public function __construct(){
			$this->actions = array();
		}

		public function onset($id){
			extract($GLOBALS);
			$pc = array();
	
			foreach($_POST as $k => $v) {
				if (preg_match("/^charid_(\d+)$/", $k, $m)) $pc[$m[1]][id] = $v;
				if (preg_match("/^charval_(\d+)$/", $k, $m)) $pc[$m[1]][val] = $v;
				if (preg_match("/^charval2_(\d+)$/", $k, $m)) $pc[$m[1]][value] = ($v) ? $v : '';
			}

			$Prodcharsplugin = new Model_Plugin_Prod_Chars();
			$Prodcharsplugin->clearprodchars($id);

			$Prodchar = new Model_Prodchar();
			foreach($pc as $k => $v){
				if(is_array($v['val'])){
					foreach($v['val'] as $vv){
						$Prodchar->insert(array(
							"prod" => $id,
							"char" => $k,
							"charval" => 0 + $vv,
							"value" => $v['value'],
						));
					}
				}else{
					$Prodchar->insert(array(
						"prod" => $id,
						"char" => $k,
						"charval" => 0 + $v['val'],
						"value" => $v['value'],
					));
				}
			}
			
		}

		public function render($view){
			return parent::render($view);			
		}
	}
