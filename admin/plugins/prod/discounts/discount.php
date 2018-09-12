<?
	define("prod_discount_loaded", 1);

	class prod_discount extends Plugin{
		private $type = 'prod';

		public function __construct(){
			$this->actions = array();
		}

		public function onset($id){
			print_r($_POST);
			$discount_tstamp = strtotime($_POST["discount_tstamp"]);
			$discount_end = strtotime($_POST["discount_end"]);
			
			$data = array("type" => $this->type, "prod" => $id, "value" => $_POST['discount_value'], "tstamp" => $discount_tstamp, "end" => $discount_end);
			$Discount = new Model_Discount();
			
			if($_POST['discount_type'] == 'no'){
				$Discount->delete(array("where" => "`type` = '".$data['type']."' and prod = '".$id."'"));
			}else{
				if($discount = $Discount->getone(array("where" => "`type` = '".$data['type']."' and prod = '".$id."'")))
					$Discount->update($data, array("where" => "`type` = '".$data['type']."' and prod = '".$id."'"));
				else
					$Discount->insert($data);
			}
		}

		public function onshow($row){
			$Discount = new Model_Discount();
			$discount = $Discount->getone(array("where" => "`type` = 'prod' and prod = '".$row->id."'"));

			$row->discount = ($discount->value) ? "<span style=\"color: red; font-weight: bold;\">".$discount->value."%</span>" : "";
			$row->discount .= ($discount->end) ? "<br/>до ".date("d.m.Y", $discount->end) : "";
			return $row;
		}
		
		public function render($view){
			$view->plugin_vars = array();
			
			if($_GET["id"]){
				$Discount = new Model_Discount();
				$discount = $Discount->getone(array("where" => "`type` = '".$this->type."' and prod = '".$_GET['id']."'"));

				if($discount->value && $discount->end)
					$view->plugin_vars[$this->type."_discount_type"] = "tmp";
				elseif($discount->value)
					$view->plugin_vars[$this->type."_discount_type"] = "permanent";
				else
					$view->plugin_vars[$this->type."_discount_type"] = "no";
				
				$view->plugin_vars[$this->type."_discount_prod"] = $_GET['id'];
				$view->plugin_vars[$this->type."_discount"] = 0 + $discount->value;
				$view->plugin_vars[$this->type."_discount_tstamp"] = ($discount->tstamp) ? $discount->tstamp : time();
				$view->plugin_vars[$this->type."_discount_end"] = ($discount->end) ? $discount->end : time()+24*60*60*7;

				return parent::render($view);			
			}else{
				return "";
			}	
		}
	}
