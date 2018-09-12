<?php
use ASweb\Db\Entity;

interface Model_Decorator_Interface
{	
	public function get(Entity $row): Entity;
	public function getall(array $rows): array;
	public function update(array $data, array $options);
	public function insert(array $data, int $lastid);
	public function delete(array $data, array $options);
	
	public function setOptions(array $options);
	public function setOption(string $key, $value): Model_Decorator_Abstract;
	public function getOption(string $key);
	public function getOptions();
	public function removeOption(string $key): bool;
	public function clearOptions(): Model_Decorator_Abstract;
	public function setModel(Model_ModelInterface $Model): Model_Decorator_Interface;
	public function getModel(): Model_ModelInterface;
}