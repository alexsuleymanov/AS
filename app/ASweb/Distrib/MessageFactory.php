<?php
namespace ASweb\Distrib;
	
use Exception\WrongMessageTypeException;

/**
 * Обязательные параметры
 * 
 * В $params обязательно передаются $params = ['subj' => $subj, 'cont' => $cont, 'sett' => $sett, 'labels' => $labels, 'template' = $templates['...']]
 * Дополнительно может передаваться массив $items для шаблонов сообщение товаров, акций или новостей
 * А также массив $files, для вложенный файлов
 * 
 */
class MessageFactory
{
	const SIMPLE = 'Simple';
	const PRODS = 'Prods';
	const ACTIONS = 'Actions';
	const NEWS = 'News';
	
	/**
	 * Обязательный параметры
	 * 
	 * В $params обязательно передаются $params = ['subj' => $subj, 'cont' => $cont, 'sett' => $sett, 'labels' => $labels, 'template' = $templates['...']]
	 * Дополнительно может передаваться массив $items для шаблонов сообщение товаров, акций или новостей
	 * А также массив $files, для вложенный файлов
	 * 
	 * @param string $type
	 * @param array $params
	 * @return \ASweb\Distrib\Message
	 * @throws WrongMessageTypeException
	 */
	public static function create(string $type, array $params = array()): Message
	{
		if ($type == self::SIMPLE) {
			return new Message\SimpleMessage($params);
		} elseif ($type == self::PRODS) {
			return new Message\ProdsMessage($params);
		} elseif ($type == self::ACTIONS) {
			return new Message\ActionsMessage($params);
		} elseif ($type == self::NEWS) {
			return new Message\NewsMessage($params);			
		} else {
			throw new WrongMessageTypeException("Wrong Message Type");
		}
	}
}