<?
	define("prod_colors_loaded", 1);

	class prod_colors extends Plugin{
		private $type = 'prod';

		public function __construct(){
			$this->actions = array(
				"add_color",
				"del_color",
				"edit_color",
				"edit_color_color",
			);
		}

		public function add_color(){
			$vid = 0 + $_GET['id'];
			$Prodcolor = new Model_Prodcolor();
			$Prodcolor->insert(array("prod" => $vid, "relation" => 0));
			echo $Prodcolor->last_id();
			die();
		}

		public function del_color(){
			$Prodcolor = new Model_Prodcolor();
			$Prodcolor->delete(array("where" => "id = '".$_GET["del_color"]."'"));
			echo $_GET["del_color"];
			die();
		}

		public function edit_color(){
			$Prod = new Model_Prod();
			$prod = $Prod->get($_GET['prod']);
			
			$Prodcolor = new Model_Prodcolor();
			$Prodcolor->save(array("color" => $prod->color, "relation" => $_GET['prod']), $_GET['colorid']);
			echo $_GET['prod'];
			die();
		}
                        
/*		public function edit_color_color(){
			$Prodcolor = new Model_Prodcolor($_GET['colorid']);
			$Prodcolor->save(array("color" => $_GET['color']));
			echo $_GET['color'];
			die();
		}*/

		public function onset($id){
		}

		public function onshow($row){
			global $db, $url;
			$Prodcolor = new Model_Prodcolor();
			$db_prefix = $Prodcolor->db_prefix;
			$prod_parent = $Prodcolor->getone(array("where" => "relation = '".$row->id."'"));

			$q = "select p.id as pid, c.id as cid, pc.relation as pcid, c.name as cname from ".$db_prefix."prodcolor as pc 
									left join ".$db_prefix."prod as p on p.id = pc.prod 
									left join ".$db_prefix."color as c on c.id = pc.color 
									where pc.prod = ".$row->id;

			if($prod_parent->prod) $q .= " or pc.prod = ".$prod_parent->prod;

			$qr = $db->q($q);
			while($r = $qr->f()){
				$row->colors .= "<a href=\"adm_prod.php".$url->gvar("action=edit&id=".$r->pcid)."\">".$r->cname."</a><br />";
			}
			return $row;
		}
		
		public function render($view){
			return parent::render($view);			
		}
	}
