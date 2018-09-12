<?php
	namespace ASweb\Wishlist;
	
	use ASweb\Auth\Auth;
	
	class Wishlist
	{
		private static $instance;
		private $Storage;
		
		public $wishlist = array();

		public function __construct(\Model_ModelInterface $Storage)
		{
			$this->Storage = $Storage;
			
			$this->wishlist = &$_SESSION['wishlist'];

			if (empty($_SESSION['wishlist'])) {
				$_SESSION['wishlist'] = array();
			}
			
			if (Auth::is_auth()) {
				$this->loadwishlist(Auth::userid());
			}
		}
		
		public function wish_id($id = 0, $var = 0, $chars = array())
		{
			if (!empty($chars)) {
				ksort($chars);
				return md5($id."_".$var."_".json_encode($chars));
			} else {
				return md5($id."_".$var);
			}
		}
		
		public function add($id = 0, $var = 0, $chars = array())
		{
			$wish_id = $this->wish_id($id, $var, $chars);
			
			if(!isset($this->wishlist[$wish_id])) {
				$this->wishlist[$wish_id] = array('id' => intval($id), 'var' => intval($var), 'chars' => $chars, 'tstamp' => time());
	
				if(Auth::is_auth()) {
					$this->Storage->insert(array(
						"user" => Auth::userid(),
						"prod" => $this->wishlist[$wish_id]['id'],
						"prodvar" => $this->wishlist[$wish_id]['var'],
						"chars" => json_encode($this->wishlist[$wish_id]['chars']),
						"wish_id" => $wish_id,
						"tstamp" => $this->wishlist[$wish_id]['tstamp'],
					));
				}
			}
		}
		
		private function loadwishlist($user)
		{
			$prods = $this->Storage->getall(array("where" => "`user` = '".$user."'"));
			foreach ($prods as $prod) {
				$this->wishlist[$this->wish_id($prod->prod, $prod->prodvar, json_decode($prod->chars))] = array('id' => $prod->prod, 'var' => $prod->prodvar, 'chars' => json_decode($prod->chars));
			}			
		}
		
		private function savewishlist($user)
		{
			foreach ($this->wishlist as $k => $v) {
				$this->Storage->insert(array(
					"user" => Auth::userid(),
					"prod" => $v['id'],
					"prodvar" => $v['var'],
					"chars" => json_encode($v['chars']),
					"wish_id" => $k,
					"tstamp" => $v['tstamp'],
				));
			}
		}
		
		public function user_login()
		{
			if (Auth::is_auth()) {
				$this->savewishlist(Auth::userid());
				$this->loadwishlist(Auth::userid());
			}
		}
		
		public function prod_num()
		{
			return count($this->wishlist);
		}

		public function del($k)
		{
			unset($this->wishlist[$k]);
			if (Auth::is_auth()) {
				$this->Storage->delete(array("where" => "`user` = '".Auth::userid()."' and wish_id = '".$k."'"));
			}
		}		

		public function clear(){
			$this->wishlist = array();
			if (Auth::is_auth()) {
				$this->Storage->delete(array("where" => "`user` = '".Auth::userid()."'"));
			}
		}
	}