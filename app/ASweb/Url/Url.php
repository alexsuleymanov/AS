<?php
	namespace ASweb\Url;
	
	class Url
	{
		private $Lang;
		
		protected $request_uri;
		protected $query_string;
		
		public $args;

		public $s; // $_SESSION
		public $p; // $_POST
		public $g; // $_GET
		public $c; // $_COOKIE
	
		public function __construct(\Model_ModelInterface $Lang = null)
		{			
			$this->Lang = $Lang;
			
			$this->args = array();
			$this->request_uri = $_SERVER['REQUEST_URI'];
			$this->query_string = $_SERVER['QUERY_STRING'];
			$this->page = $_SERVER['SCRIPT_NAME'];

			$this->s = &$_SESSION;
			$this->p = &$_POST;
			$this->g = &$_GET;
			$this->c = &$_COOKIE;
		}

		public function parce()
		{
			$diff = 1;
			if (strpos($this->request_uri, "?")) {
				$diff = 2;
			}			
			$this->page = substr($this->request_uri, 1, strlen($this->request_uri) - strlen($this->query_string)-$diff);
			$this->args = explode("/", $this->page);
			return $this->args;
		}
		
		public function gvar($dpar = "")
		{
			$s = $_SERVER[QUERY_STRING]."&".$dpar;
			$a = explode("&", $s);
			foreach ($a as $v) {
				if (preg_match("/^([^=]+)=(.*)$/", $v, $m)) {
					$gv[$m[1]] = urldecode($m[2]);
				}
			}
			$q = "?";
			foreach ($gv as $k => $v) {
				if ($v != "") {
					$q .= $k."=".urlencode($v)."&";
				}
			}
			
			return (empty($q) || $q == '?') ? "" : rtrim($q, "&amp;");
		}
		
		public function gvar2($dpar = "")
		{
			$s = urldecode($_SERVER['QUERY_STRING']."&".$dpar);
			$a = explode("&", $s);
			$new_a = array();
			$q = "";

			foreach ($a as $k => $v) {
				if (preg_match("/^([^=]+)=(.*)$/", $v, $m)) {
					if (strstr($m[1], "[")) {
						$new_a[$m[1]."_".$k] = urlencode($m[1])."=".urldecode($m[2]);
					} else {
						$new_a[$m[1]] = urlencode($m[1])."=".urldecode($m[2]);
					}
					
					if (empty($m[2])) {
						unset($new_a[$m[1]]);
					}
				}
			}
	
			foreach ($new_a as $v) {
				$q .= $v."&";
			}
			
			return (empty($q)) ? "/".$this->page : "/".$this->page."?".rtrim($q, "&");
		}
		
		/**
		 * parameter - array(0, "val0", 1, "val1", 2, "val2")
		 * 
		 * @global type $_SERVER
		 * @global type $_GET
		 * @param type $vars
		 * @return string
		 * @throws ASweb\Url\Exception
		 */
		public function mkd($vars)
		{ 
			$url = '';
			if (!is_array($vars)) {
				throw new Exception("mkd parameter must be an array");
			}

			while (count($vars)) {
				$this->args[array_shift($vars)] = array_shift($vars);
			}
			
			foreach ($this->args as $k=>$v) {
				$url .= (empty($v)) ? "" : "/".$v;
			}
			
			if (!empty($this->g)) {
				$url .= $this->gvar(md5(time())."=");
			}

			if(defined('MULTY_LANG') && \Zend_Registry::get('lang') != \Zend_Registry::get('default_lang')) {
				$url = "/".\Zend_Registry::get('lang').$url;
			}

			return $url;
		}

		public function mk($url)
		{
			if (defined('MULTY_LANG') == 1 && \Zend_Registry::get('lang') != \Zend_Registry::get('default_lang')) {
				$url = "/".\Zend_Registry::get('lang').$url;
			}

			return $url;
		}

		public function setlang($l)
		{
			$url = '';
			foreach ($this->args as $k=>$v) {
				$url .= (empty($v)) ? "" : "/".$v;
			}
			
			if (!empty($_GET)) {
				$url .= $this->gvar(md5(time())."=");
			}

			if ($this->Lang) {
				$lang = $this->Lang->getone(array("where" => "intname = '$l'"));
			}

			return ($l && $lang->main == 0) ? "/".$l.$url : $url;
		}

		public static function redir($url)
		{
			header("Location: ".$url);
		}

		public static function redirjs($url, $timeout = 1)
		{
			echo "<script>setTimeout(\"location.href='".$url."';\", ".$timeout.");</script>";
		}
	}
