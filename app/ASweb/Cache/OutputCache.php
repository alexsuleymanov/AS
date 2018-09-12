<?php
	namespace ASweb\Cache;
	
	class OutputCache
	{
		private $Cache;
		
		public function __construct($Storage, $frontendOptions, $backendOptions)
		{
			$this->Cache = \Zend_Cache::factory('Output', $Storage, $frontendOptions, $backendOptions);
		}
		
		/**
		* Start the cache
		*
		* @param  string  $id                     Cache id
		* @return mixed True if the cache is hit (false else) with $echoData=true (default) ; string else (datas)
		*/
		public function start($id)
		{
			return $this->Cache->start($id, false, true);
		}

		/**
		* Stop the cache
		*
		* @param  array   $tags             Tags array
		* @return void
		*/
		public function end($tags = array())
		{
			$this->Cache->end($tags, false, null, true, 8);
		}
		
				/**
		* Удалить кеш
		*
		* @param  string $id Cache id to remove
		* @return boolean True if ok
		*/
		public function remove($id)
		{
			return $this->Cache->remove($id);
		}

		/**
		* Очищает записи в кеше
		*
		* Доступные значения $mode
		* 'all' (default)  => remove all cache entries ($tags is not used)
		* 'old'            => remove too old cache entries ($tags is not used)
		* 'matchingTag'    => remove cache entries matching all given tags
		*                     ($tags can be an array of strings or a single string)
		* 'notMatchingTag' => remove cache entries not matching one of the given tags
		*                     ($tags can be an array of strings or a single string)
		* 'matchingAnyTag' => remove cache entries matching any given tags
		*                     ($tags can be an array of strings or a single string)
		*
		* @param  string       $mode
		* @param  array|string $tags
		* @throws Zend_Cache_Exception
		* @return boolean True if ok
		*/
		public function clean($mode = 'all', $tags = array())
		{
			return $this->Cache->clean($mode, $tags);
		}
	}