<?
	define("photo_rating_loaded", 1);

	class photo_rating extends Plugin{
		private $type = 'photo';

		public function __construct(){
			$this->actions = array();
		}

		public function onset($id){
			$data = array("type" => $this->type, "par" => $id, "rating" => $_POST[$this->type.'_rating'], "count" => $_POST[$this->type.'_rating_count']);

			$Rating = new Model_Rating();
			if($rating = $Rating->getone(array("where" => "`type` = '".$this->type."' and par = '".$_GET['id']."'")))
				$Rating->update($data, array("where" => "`type` = '".$this->type."' and par = '".$_GET['id']."'"));
			else
				$Rating->insert($data);
		}

		public function onshow($row){
			$Rating = new Model_Rating();
			$rating = $Rating->getone(array("where" => "`type` = '".$this->type."' and par = '".$row->id."'"));

			$row->rating = ($rating->rating) ? $rating->rating." (".$rating->count.")" : "";
			return $row;
		}
		
		public function render($view){
			$view->plugin_vars = array();
			
			if($_GET["id"]){
				$Rating = new Model_Rating();
				$rating = $Rating->getone(array("where" => "`type` = '".$this->type."' and par = '".$_GET['id']."'"));

				$view->plugin_vars["type"] = $this->type;
				$view->plugin_vars[$this->type."_rating"] = 0 + $rating->rating;
				$view->plugin_vars[$this->type."_rating_count"] = 0 + $rating->count;

				return parent::render($view);			
			}else{
				return "";
			}	
		}
	}
