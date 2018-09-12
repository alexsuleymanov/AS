<?php
	namespace ASweb\Cache;
	
	class Cache{
		private $Cache;
		
		const CLEANING_MODE_ALL              = 'all';
		const CLEANING_MODE_OLD              = 'old';
		const CLEANING_MODE_MATCHING_TAG     = 'matchingTag';
		const CLEANING_MODE_NOT_MATCHING_TAG = 'notMatchingTag';
		const CLEANING_MODE_MATCHING_ANY_TAG = 'matchingAnyTag';

		public function __construct($Storage, $frontendOptions, $backendOptions)
		{
			$this->Cache = \Zend_Cache::factory('Core', $Storage, $frontendOptions, $backendOptions);
		}
		
		/**
		* Test if a cache is available for the given id and (if yes) return it (false else)
		*
		* @param  string  $id                     Cache id
		* @return mixed|false Cached datas
		*/
		public function load($id)
		{
			return $this->Cache->load($id);
		}

		/**
		* Тестирует, есть ли объект в кеше
		*
		* @param  string $id Cache id
		* @return boolean True is a cache is available, false else
		*/
		public function test($id){
			return $this->Cache->test($id);
		}
		
		/**
		* Сохранить данные в кеш
		*
		* @param  mixed $data           Data to put in cache (can be another type than string if automatic_serialization is on)
		* @param  string $id             Cache id (if not set, the last cache id will be used)
		* @param  array $tags           Cache tags
		* @throws Zend_Cache_Exception
		* @return boolean True if no problem
		*/
		public function save($data, $id = null, $tags = array())
		{
			return $this->Cache->save($data, $id, $tags);
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
		
		/**
		* Return an array of stored cache ids which match given tags
		*
		* In case of multiple tags, a logical AND is made between tags
		*
		* @param array $tags array of tags
		* @return array array of matching cache ids (string)
		*/
		public function getIdsMatchingTags($tags = array())
		{
			$this->Cache->getIdsMatchingTags($tags);
		}

		/**
		* Return an array of stored cache ids which don't match given tags
		*
		* In case of multiple tags, a logical OR is made between tags
		*
		* @param array $tags array of tags
		* @return array array of not matching cache ids (string)
		*/
		public function getIdsNotMatchingTags($tags = array()){
			return $this->Cache->getIdsNotMatchingTags($tags);
		}

		/**
		* Return an array of stored cache ids
		*
		* @return array array of stored cache ids (string)
		*/
		public function getIds(){
			$this->Cache->getIds();
		}

		/**
		* Return an array of stored tags
		*
		* @return array array of stored tags (string)
		*/
		public function getTags(){
			return $this->Cache->getTags();
		}

		/**
		* Give (if possible) an extra lifetime to the given cache id
		*
		* @param string $id cache id
		* @param int $extraLifetime
		* @return boolean true if ok
		*/
		public function touch($id, $extraLifetime){
			return $this->Cache->touch($id, $extraLifetime);
		}

	}
	
 
	
