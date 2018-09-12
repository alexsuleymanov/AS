<?	
define("ASWEB_DEBUG", 1);
	
if (defined("ASWEB_DEBUG")) {
	error_reporting(E_ALL & ~E_NOTICE);
	ini_set("display_errors", 1);		
} else {
	error_reporting(E_ERROR);
	ini_set("display_errors", 0);		
}
	
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, array(realpath(dirname(__FILE__)), realpath(dirname(__FILE__)."/app"), ".", realpath(dirname(__FILE__))."/..")));

/**
 *  @global string $path
 *  Абсолютный путь к корню сайта
 */
$path = realpath(dirname(__FILE__));

ini_set("magic_quotes_gpc", 0);
ini_set("magic_quotes_runtime", 0);

require_once "Zend/Loader/Autoloader.php";

$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Model_');
$autoloader->registerNamespace('Form_');

Zend_Session::start();
spl_autoload_register(function ($class) {
	$class = str_replace("\\", "/", $class);
	include $class . '.php';
});

require_once "conn.php";

require_once "ASweb/Func.php";
	
require_once "init/opt.php";
require_once "init/www.php";
require_once "init/cache.php";
require_once "init/system-scripts.php";
	
require_once 'init/model/page.php';
