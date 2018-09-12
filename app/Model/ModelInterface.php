<?php
	
/**
 *	Интерфейс для всех моделей в архитектуре MVC AS-Commerce
 *	@author Alex Suleymanov <alex.suleymanov@gmail.com>
 * 
 */	
interface Model_ModelInterface {
	public function get(int $id);
	public function getall(array $options);
	public function update(array $data, array $options);
	public function insert(array $data);
	public function delete(array $data);
	public function last_id();
}

