<?php	
	use ASweb\Url\Url;

	$langs = array(
		'ru' => array(
			"id" => 1,
			"intname" => 'ru',
			"main" => 1,
		),
		'en' => array(
			"id" => 1,
			"intname" => 'en',
			"main" => 0,
		),
	);
	
	$url = new Url($Lang);
	
	$args = $url->parce();

	foreach ($langs as $k => $v) {
		if ($v['main']) {
			$default_lang = $v['intname'];
			$default_lang_id = $v['id'];
		}
		
		if ($args[0] == $v['intname']) {
			$lang = $v['intname'];
			$lang_id = $v['id'];
			array_shift($args);
		}

	}

	$lang = $default_lang;
	$lang_id = $default_lang_id;

	$url->args = $args;

	Zend_Registry::set('lang', $lang);
	Zend_Registry::set('default_lang', $default_lang);

	define("MULTY_LANG", 1); // Обязательно
