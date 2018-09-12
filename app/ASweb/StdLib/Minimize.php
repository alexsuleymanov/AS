<?php
    namespace ASweb\StdLib;
    
	class Minimize
    {
		private $cache;
        private $type;
        private $files;
		private $path;
		private $minimized;
		private $expires;
		
		public function __construct($type, $path, array $files, $minimized = 0, $cache = null)
        {
			$this->cache = $cache;
			$this->type = $type;
			$this->files = $files;
			$this->path = $path;
			$this->minimized = $minimized;
			$this->expires = 2592000;
		}
		
		public function setExpires($expires)
        {
			$this->expires = $expires;
		}
		
		public static function url($type, $files){			
			return '/cache/'.$type.'/'.str_replace('/', '__', implode(',', $files));
		}
			
		protected function file_minimize($f){
			if($this->minimized)
				return preg_replace("/[\n|\r| |\s|\t]/", "", $f);
			else
				return $f;
		}
		
		public function getcontenttype(){
			if($this->type == 'js') return "application/x-javascript";
			if($this->type == 'css') return "text/css";
		}
		
		private function cache_name(){
			return md5(implode("_", $this->files));
		}
		
		private function minimize(){
			$f = '';
			foreach($this->files as $v){
				$f .= $this->file_minimize(implode("", file($this->path.$v)));
				$f .= "\n\n/*--------------------Merged----------------------------------------------*/\n\n";
			}
			return $f;
		}
		
		public function show(){			
			if(!$this->cache || (!$content = $this->cache->load("minimize_".$this->cache_name()))){
				$content = $this->minimize();
				if($this->cache) $this->cache->save($sett, "minimize_".$this->cache_name());
			}

			header("Content-Type: ".$this->getcontenttype());
			header('Expires: '.date("D, d M Y H:i:s e", time()+$this->expires));
			header('Cache-Control: max-age='.$this->expires.', must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . strlen($content));
			header('Last-Modified: '.date("D, d M Y H:i:s e", time()));

			echo $content;
		}
	}