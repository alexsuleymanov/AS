<?
	class Plugin{
		protected $actions;

		public function render($view) {
			$path = realpath(dirname(__FILE__));
			$view->setBasePath($path);
			$view->setScriptPath($path);
			$view->path = "/admin/";
			
			$plugname = explode("_", get_class($this));
			$cont = $view->render($plugname[0]."/".$plugname[1]."/view/".$plugname[1].'.php');
			
			$view->setBasePath($path."/../view");
			$view->setScriptPath($path."/../view/scripts");
			$view->path = "/admin/view";
			
			return $cont;			
		}

		public function __construct(){
			$this->actions = array();
		}

		public function setactions($actions){
			$this->actions = $actions;
						
		}

		public function addaction($action){
			$this->actions[] = $action;
		}

		public function run(){
			foreach($this->actions as $k){
				if($_GET[$k] && is_callable($this->$k())) $this->$k();
			}
		}

		public function onshow($row){

		}

		public function ondel($id){

		}

		public function onset($id){

		}
	}

	class Plugins{
		private $plugins;
		
		public function __construct(){
			$this->plugins = array();
		}

		public function loadplugins($plugins){
			foreach($plugins as $name){
				$this->loadplugin($name);
			}
		}

		public function loadplugin($name){
			try{
				$loaded = $name."_loaded";
				$plugname = explode("_", $name);
				if(empty($$loaded)){
					require ("plugins/".str_replace("_", "/", $name).'/'.$plugname[1].'.php');
				}else{
					echo "loaded";
				}
				if(!class_exists($name)) throw new PluginException("Plugin not found: ".$name."<br />");
				$this->plugins[$name] = new $name;

				$this->run();
			}catch(PluginException $e){
				echo "<font color=red>Plugin Exception!</font><br />";
				echo $e->getMessage()."<br />";
				die();						
			}
		}

		public function get($name){
			if($this->plugins[$name])
				return $this->plugins[$name];
			else
				return new EmptyPlugin;
		}

		protected function run(){
			foreach($this->plugins as $plugin){
				$plugin->run();
			}
		}

		public function onshow($row){
			foreach($this->plugins as $plugin){
				$plugin->onshow($row);
			}
		}

		public function ondel($id){
			foreach($this->plugins as $plugin){
				$plugin->ondel($id);
			}
		}

		public function onset($id){
			foreach($this->plugins as $plugin){
				$plugin->onset($id);
			}
		}

	}

	class PluginException extends Exception{
		
    }

    class EmptyPlugin extends Plugin{
    	public function render($view){
    		return "";
		}
	}