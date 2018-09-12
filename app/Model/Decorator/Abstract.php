<?php

use ASweb\Db\Entity;
use ASweb\Db\MySQL;

/**
 * Абстрактный декоратор моделей
 * 
 * Реализует интерфейс Model_Decorator_Interface
 */
abstract class Model_Decorator_Abstract implements Model_Decorator_Interface
{
	protected $db;
	protected $db_prefix;

	/**
     * Decorator options
     * @var array
     */
    protected $Options = array();
	
	abstract public function get(Entity $row): Entity;
	abstract public function getall(array $rows): array;
	
	public function update(array $data, array $options)
	{		
	}
	
	public function insert(array $data, int $lastid)
	{		
	}
	
	public function delete(array $data, array $options)
	{
	}
	
    /**
     * Constructor
     *
     * @param  array
     * @return void
     */
    public function __construct($options = array())
    {
		$this->db = MySQL::getInstance();
		$this->db_prefix = MySQL::$db_prefix;
		
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Set options
     *
     * @param  array $options
     * @return Model_Decorator_Interface
     */
    public function setOptions(array $options)
    {
        $this->Options = $options;
        return $this;
    }

    /**
     * Set option
     *
     * @param  string $key
     * @param  mixed $value
     * @return Model_Decorator_Interface
     */
    public function setOption(string $key, $value): Model_Decorator_Abstract
    {
        $this->Options[$key] = $value;
        return $this;
    }

    /**
     * Get option
     *
     * @param  string $key
     * @return mixed
     */
    public function getOption(string $key)
    {
        if (isset($this->Options[$key])) {
            return $this->Options[$key];
        }

        return null;
    }

    /**
     * Retrieve options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->Options;
    }

    /**
     * Remove single option
     *
     * @param mixed $key
     * @return void
     */
    public function removeOption(string $key): bool
    {
        if (null !== $this->getOption($key)) {
            unset($this->Options[$key]);
            return true;
        }

        return false;
    }

    /**
     * Clear all options
     *
     * @return Model_Decorator_Interface
     */
    public function clearOptions(): Model_Decorator_Abstract
    {
        $this->Options = array();
        return $this;
    }

	/**
	 * Устанавливает Модель для декорирования
	 * 
	 * @param Model_ModelInterface $Model
	 * @return Model_Decorator_Interface
	 */
    public function setModel(Model_ModelInterface $Model): Model_Decorator_Interface
    {
        $this->Model = $Model;
        return $this;
    }
	
    /**
     * Возвращает текущую модель
     *
     * @return Model_ModelInterface
     */
    public function getModel(): Model_ModelInterface
    {
        return $this->Model;
    }
	
	
}