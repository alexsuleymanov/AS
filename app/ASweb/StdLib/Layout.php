<?php
    namespace ASweb\StdLib;
    
	class Layout
    {
		protected $layout;

		public function __construct()
        {
			$this->layout = "layout/index.php";
		}

		public function setlayout($name)
        {
			$this->layout = $name;
		}

		public function render($view)
        {
			return $view->render($this->layout);
		}

		public function error_404($view)
        {
			header("HTTP/1.1 404 Not Found");      
		    header("Status: 404 Not Found");

			$view->page = new \stdClass();
			$view->page->cont = "<font color=\"red\">".$view->labels["404"]."</font>";
			$view->page404 = true;
			return $this->render($view);
		}
	}