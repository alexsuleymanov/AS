<?php
namespace ASweb\StdLib;

class Func
{
	public static $mysqlq = 0;

   	public static function fmtmoney($money)
	{
		return sprintf("%0.2f", $money);
	}

	public static function getExtension($filename)
	{
		return array_pop(explode(".", $filename));
	}		

	public static function mess_from_tmp($tmp, $params)
	{
		$rep = array();
		preg_match_all("/{([\$\[\]\'\w\_\-\d]+)}/", $tmp, $m);

		foreach ($m[1] as $k => $v){
			if ($v[0] == '$'){
				if (strstr($v, "[")){
					$vv = substr($v, 1, strpos($v, "[")-1);
					preg_match("/\[[\'\"]([^\'\"]+)[\'\"]\]/", $v, $m);
					$rep["{".$v."}"] = ${$vv}[$m[1]];
				}else{
					$rep["{".$v."}"] = ${'v'};
				}
			}
			else
				$rep["{".$v."}"] = $params[$v];
		}
			
		return str_replace(array_keys($rep), array_values($rep), $tmp);
	}

	public static function translit($str)
	{
   		$letters = array(
			"а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e",
			"ё" => "e", "ж" => "zh", "з" => "z", "и" => "i", "й" => "j", "к" => "k",
   	        "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
       	    "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "c",
           	"ч" => "ch", "ш" => "sh", "щ" => "sh", "ы" => "i", "ь" => "", "ъ" => "",
            "э" => "e", "ю" => "yu", "я" => "ya",
			"А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D", "Е" => "E",
			"Ё" => "E", "Ж" => "ZH", "З" => "Z", "И" => "I", "Й" => "J", "К" => "K",
           	"Л" => "L", "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
            "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "C",
   	        "Ч" => "CH", "Ш" => "SH", "Щ" => "SH", "Ы" => "I", "Ь" => "", "Ъ" => "",
       	    "Э" => "E", "Ю" => "YU", "Я" => "YA",
		);
		
		foreach ($letters as $letterVal => $letterKey) {
			$str = str_replace($letterVal, $letterKey, $str);
		}
		
		return $str;
	}

	public static function mkintname($str)
	{
		return trim(preg_replace("/[\W]+/", "-", strtolower(trim(self::translit($str)))), '-');
	}

	public static function is_ajax()
	{
        if ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
   	        return true;
       	}

       	if (function_exists('apache_request_headers')) {
           	$headers = apache_request_headers();
            if ($headers["X-Requested-With"] == "XMLHttpRequest" || $headers["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
   	            return true;
       	    }
        }
		return false;
	}

	public static function ajaxdecode($str)
	{
		return iconv("UTF-8", "WINDOWS-1251", $str);
	}

	public static function controller_list($path)
	{
		$controllers = array();
		$controllers[''] = "Статическая страница";

		$dd = opendir($path."/app/controller");
		while ($ff = readdir($dd)) {
			if ($ff == "." || $ff == "..") continue;
			$ff_arr = file($path."/app/controller/".$ff);
			if (preg_match("/.*?Controller - (.*)/u", $ff_arr[0], $m)) {
				$controllers[$ff] = $ff." - ".$m[1];
			}
		}

		return $controllers;
	}

	public static function global_images($text)
	{
		return preg_replace("/\/pic\/image\//", "http://".$_SERVER['HTTP_HOST']."/pic/image/", $text);
	}

	public static function array_hash($arr)
	{
		ksort($arr);
		return md5(json_encode($arr));
	}
}
