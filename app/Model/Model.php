<?php
/**
 *	Базовый класс для всех моделей в архитектуре MVC AS-Commerce
 *  Версия 4
 * 
 *	@author Alex Suleymanov <alex.suleymanov@gmail.com>
 *	@abstract 
 */
use ASweb\Db\Db;
use ASweb\Db\MySQL;
use ASweb\Db\NullEntity;

abstract class Model_Model implements Model_ModelInterface, Model_DBInterface
{	
    protected $db = NULL;
	protected $opt;
	protected $_lastid = NULL;
	protected $name = '';
	protected $depends = array();
	protected $relations = array();
	protected $visibility = 0;
	protected $id = 0;
	protected $lang;
	protected $default_lang;

	public $db_prefix;
   	public $table = "";		
   	public $row  = array();
	public $par = 0;
				
    /**
	* Декораторы модели. Расширяют функционал get, getall, insert, update
	* 
	* @var array
	*/
    protected $Decorators = array();

	/**
	* Декораторы модели. Добавляют функционал для модели
	* 
	* @var array
	*/
    protected $Plugins = array();

   	public function __construct()
	{
		$this->db = MySQL::getInstance();
		$this->db_prefix = MySQL::$db_prefix;
		$this->table = $this->db_prefix.$this->name;
		$this->opt = \Zend_Registry::get('opt');

		if (defined('MULTY_LANG')) {
			$this->lang = \Zend_Registry::get('lang');
			$this->default_lang = \Zend_Registry::get('default_lang');
		}
	}
	
	public function getName()
	{
		return $this->name;
	}
				
	public function get(int $id)
	{
		$r = $this->q("select * from `$this->table` where id = '".Db::nq($id)."'")->f();
		if (defined('MULTY_LANG') && !($r instanceof NullEntity)) {
			$translate = $this->translate($r->id, $this->table, $this->lang);
			foreach ($translate as $k => $v) {
				$field = $v->field;
				$r->$field = $v->cont;
			}
		}

        foreach ($this->Decorators as $decorator) {
	        $decorator->setModel($this);
		    $r = $decorator->get($r);
        }

		return $r;
	}

	public function last_id()
	{
		return $this->_lastid;
	}
	
	public function lastid()
	{
		return $this->_lastid;
	}

	/**
	 * Пример array("where" => "cat = '$cat' and brand = '$brand", "order" => "tstamp desc, cat asc", "limit" => "0, 5")
	 */
	public function getone(array $options = array())
	{
		$rows = $this->getall($options);
		return $rows[0];
	}
		
	/**
	 * Пример array("where" => "cat = '$cat' and brand = '$brand", "order" => "tstamp desc, cat asc", "limit" => "0, 5")
	 */
	public function getall(array $options = array())
	{
		$rows = array();
		$ids = array();
			
		$select = isset($options['select']) ? $options['select'] : "*";
		$where = isset($options['where']) ? $options['where'] : "1";
		$order = "order by " . (isset($options['order']) ? $options['order'] : "id desc");
		$limit = isset($options['limit']) ? "limit $options[limit]" : "";

		if (isset($options["relation"])) {
			$Relation = new Model_Relation();
			$relations = $Relation->getall(array("select" => $options["relation"]["select"]." as relid", "$obj_rel as id", "where" => $options["relation"]["where"]));
			if (count($relations)) {
				foreach($relations as $k => $v) $ids[] = $v->relid;
				$where .= " and (id = ".implode(" or id = ", $ids).")";
			} else {
				return $rows;
			}
		}

		if ($options["relations"]) {
			foreach ($options["relations"] as $k => $rel) {
				$Relation = new Model_Relation();
				$relations = $Relation->getall(array("select" => $rel["select"]." as relid", "$obj_rel as id", "where" => $rel["where"]));
				
				if (count($relations)) {
					foreach ($relations as $v) {
						$ids[$k][$v->relid] = $v->relid;
					}
				} else {
					return $rows;
				}
			}
				
			if (count($ids) > 1) {
				$code = '$ids[0] = array_intersect(';
				for ($i = 0; $i < count($ids); $i++) {
					if ($i) {
						$code .= ", ";
					}
					$code .= '$ids['.$i.']';
				}
				$code .= ');';
				eval($code);
			}
				
			if (count($ids[0])) {
				$where .= " and (id in (".implode(",", $ids[0])."))";
			} else {
				$where .= " and (id = -1)";
			}
		}
			
		$q = "select $select " .
			"from `$this->table` " .
			"where $where " .
			"$order $limit";

		$qr = $this->q($q);
		
		while (!($r = $qr->f()) instanceof NullEntity) {
			if (defined('MULTY_LANG')) {
				$translate = $this->translate($r->id, $this->table, $this->lang);

				if ($this->default_lang != $this->lang && $this->multylang && !empty($translate)){
					foreach ($translate as $k => $v) {
						$field = $v->field;
						$r->$field = $v->cont;
					}
				}
			}
			$rows[] = $r;
		}
        
		foreach ($this->Decorators as $decorator) {
			$decorator->setModel($this);
			$rows = $decorator->getall($rows);
		}
		
		return (empty($rows)) ? array() : $rows;
	}

	public function getnum(array $options = array())
	{
		$options["select"] = "id";
		$arr = $this->getall($options);
		return count($arr);
	}

	public function q(string $query)
	{
		return $this->db->q($query);
	}

	public function mq(string $query)
	{
		return $this->db->mq($query);
	}

	public function update(array $data, array $options = array())
	{
		if (!isset($options['where'])) {
			return false;
		}
			
		$where = $options['where'];
		
		$q = "update `$this->table` set ";

		$i = 0;
		while (list($k, $v) = each($data)) {
			if ($i++) {
				$q .= ", ";
			}
           	$q .= "`".$k."` = '".Db::nq($v)."'";
		}

		$q .= " where $where";
		$this->q($q);
		
		foreach ($this->Decorators as $decorator) {
	        $decorator->setModel($this);
		    $decorator->update($data, $options);
        }
	}

	public function insert(array $data)
	{
		$q = "insert into `$this->table` set ";

		$i = 0;
		while (list($k, $v) = each($data)) {
			if ($i++) {
				$q .= ", ";
			}
           	$q .= "`".$k."` = '".Db::nq($v)."'";
		}

		$this->q($q);
		$this->_lastid = $this->db->lastid();
		
		foreach ($this->Decorators as $decorator) {
	        $decorator->setModel($this);
		    $decorator->update($data, $this->_lastid);
        }
	}
	
	public function save(array $data, int $id)
	{
		return $this->update($data, array("where" => "id = ".$id));
	}

	public function translate($id, $table, $lang)
	{
		$Translate = new Model_Translate();
		return $Translate->translate($id, $table, $lang);
	}

	public function delete(array $options = array())
	{
		if (!isset($options['where'])) { 
			return false;
		}
			
		$where = $options['where'];
			
		if (defined('MULTY_LANG')) {
			$rows = $this->getall($options);
			foreach ($rows as $k => $r) {
				$this->q("delete from `".$this->db_prefix."translate` where obj_id = '".$r->id."' and `table` = '".$this->table."'");
			}
		}

		$this->q("delete from `$this->table` where $where");
		
		foreach ($this->Decorators as $decorator) {
	        $decorator->setModel($this);
		    $decorator->delete($options);
        }
	}

	public function delete_all()
	{
		if (defined('MULTY_LANG')) {
			$rows = $this->getall($options);
			foreach ($rows as $k => $r) {
				$this->q("delete from `".$this->db_prefix."translate` where obj_id = '".$r->id."' and `table` = '".$this->table."'");
			}
		}

		$this->q("truncate table `$this->table`");
	}

	public function destroy($id, $path)
	{
		foreach ($this->depends as $depend) {
			$model = 'Model_'.ucfirst($depend);
			$Model = new $model();

			if ($Model->par == 1) {
				$objs = $Model->getall(array("select" => "id", "where" => "`type` = '".$this->name."' and `par` = '".$id."'"));
			} else {
				$objs = $Model->getall(array("select" => "id", "where" => "`".$this->name."` = '".$id."'"));
			}

			foreach ($objs as $obj) {
				$Model->destroy($obj->id, $path);
			}
		}

		if ($this->ftype) {
			$dst = $path."/pic/".$this->name."/".$id.".".$this->ftype;
		} else {
			$dst = $path."/pic/".$this->name."/".$id.".jpg";
		}

		if (file_exists($dst)) {
			unlink($dst);
		}

		$Translate = new Model_Translate();
		$Translate->delete(array("where" => "`obj_id` = '".$id."' and `table` = '".$model."'"));

		$Relation = new Model_Relation();
		foreach ($this->relations as $k => $v) {
			$Relation->delete(array("where" => "`".$k."` = '".$id."' and `type` = '".$relation."'"));
		}

		$this->delete(array("where" => "`id` = ".$id));
	}

	public function visibility($id, $visible = 0)
	{
		foreach ($this->depends as $depend) {
			$model = 'Model_'.ucfirst($depend);
			$Model = new $model();
			if ($Model->visibility == 0) continue;

			if ($Model->par == 1) {
				$objs = $Model->getall(array("select" => "id", "where" => "`type` = '".$this->name."' and `par` = '".$id."'"));
			} else {
				$objs = $Model->getall(array("select" => "id", "where" => "`".$this->name."` = '".$id."'"));
			}

			foreach ($objs as $obj) {
				$Model->visibility($obj->id, $visible);
			}
		}

		$this->update(array("visible" => Db::nq($visible)), array("where" => "id = '".$id."'"));
	}
	
	public function addDecorator(Model_Decorator_Interface $Decorator)
	{
		$name = get_class($Decorator);
		$this->Decorators[$name] = $Decorator;

		return $this;
	}
	
	public function removeDecorator($name)
	{
		if (isset($this->Decorators[$name])) {
			unset($this->Decorators[$name]);
		}

		return $this;
	}

	public function clearDecorators()
	{
		$this->Decorators = [];
		return $this;
	}
	
	public function addPlugin(string $PluginName, Model_Plugin_Abstract $Plugin)
	{
		$this->Plugins[$PluginName] = $Plugin;

		return $this;
	}
	
	public function removePlugin($name)
	{
		if (isset($this->Plugins[$name])) {
			unset($this->Plugins[$name]);
		}

		return $this;
	}

	public function getPlugins()
	{
		$plugins = [];
		
		foreach ($this->Plugins as $k => $v) {
			$plugins[] = $k;
		}
		return $plugins;
	}
	
	public function clearPlugins()
	{
		$this->Plugins = [];
		return $this;
	}
	
	public function Plugin($name)
	{
		if (isset($this->Plugins[$name])) {
			return $this->Plugins[$name];
		} else {
			return NULL;
		}
	}
}