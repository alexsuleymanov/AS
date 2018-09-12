<?php
	namespace ASweb\Compare;
	
	class Compare
	{
		protected $compare;
		
		public function __construct()
		{
			if (!isset($_SESSION['compare'])) {
				$_SESSION['compare'] = array();			
			}
			$this->compare = &$_SESSION['compare'];
		}

		protected function is_added($cat, $prod)
		{
			if (is_array($this->compare[$cat]) && in_array($prod, $this->compare[$cat])) {
				return true;
			} else {
				return false;
			}
		}

		public function add($cat, $prod)
		{
			if ($this->is_added($cat, $prod)) {
				return;
			}
			
			$this->compare[$cat][$prod] = $prod;
		}

		public function del($cat, $prod)
		{
			unset($this->compare[$cat][$prod]);
		}

		public function url($cat)
		{
			if (empty($this->compare[$cat])) {
				return "";
			} else {
				return "/compare/cmp/".$cat."/".implode("-", $this->compare[$cat]);
			}
		}
		
		public function clear($cat)
		{
			$this->compare[$cat] = array();
		}

		public function clear_all()
		{
			$this->compare = array();
		}

		public function getall($cat)
		{
			return $this->compare[$cat];
		}

		public function count($cat)
		{
			return count($this->compare[$cat]);
		}
	}