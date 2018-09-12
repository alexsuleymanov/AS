<?
	define("prod_photos_loaded", 1);

	class prod_photos extends Plugin{
		public function __construct(){
			$this->actions = array(
				"add_photo",
			);
		}

		public function add_photo(){
			echo "add photo!!!";
		}

/*		public function render($view){
			return "Dop. Photos";
		}*/
	}

