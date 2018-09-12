<?php
use ASweb\Db\MySQL;

abstract class Model_Plugin_Abstract
{
	protected $db;
	protected $db_prefix;
	
	protected $Options;
	
	public function __construct($options = [])
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
     * @return Zend_Form_Decorator_Abstract
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
     * 
     */
    public function setOption(string $key, $value)
    {
        $this->Options[$key] = $value;
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
    public function getOptions(): array
    {
        return $this->Options;
    }

    /**
     * Remove single option
     *
     * @param string $key
     * @return void
     */
    public function removeOption(string $key): void
    {
        if (null !== $this->getOption($key)) {
            unset($this->Options[$key]);
        }
    }

    /**
     * Clear all options
     *
     * @return void
     */
    public function clearOptions(): void
    {
        $this->Options = [];
    }
}
