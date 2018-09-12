<?php
namespace ASweb\Auth;
	
use ASweb\Auth\Adaptor\AuthAdaptorInterface;
use ASweb\Discount\UserDiscount;

class Auth
{
	private $UserDiscount;
	
	private $Adaptor;
	private $Storage;
		
	public function __construct(\Model_ModelInterface $Storage, AuthAdaptorInterface $Adaptor = null)
	{
		$this->Storage = $Storage;
		$this->Adaptor = $Adaptor;
		
		$this->UserDiscount = new UserDiscount();
	}
				
	public static function is_auth(): bool
	{
		if ($_SESSION['userid']) {
			return true;
		} else {
			return false;	
		}
	}
			
	public static function is_admin(): bool
	{
		return ($_SESSION['admin_id']) ? true : false;
	}

	public static function authfromcookie()
	{
		if($_COOKIE['user_id']) {
			$User = new Model_User('client');
			$user = $User->get($_COOKIE['user_id']);
			
			$_SESSION['userid'] = $user->id;
			$_SESSION['username'] = $user->name;
			$_SESSION['useremail'] = $user->email;
			$_SESSION['usertype'] = $user->type;
			$_SESSION['useropt'] = $user->opt;
			
			$this->UserDiscount->userLogin();
				
			return true;
		}
	}	
		
	public static function mkpass()
	{
		return md5(time());
	}

	public function auth (string $login = '', string $pass = ''): bool
	{
		//Получить данные из соц.сети
		if($this->Adaptor){
			$user = $this->Adaptor->getUser();
		}
			
		// Проверить, если ли пользователь в базе, Если нет, то зарегистрировать его, если есть, то получить данные о нем.
		if($this->Storage){
			$user = $this->Storage->getone(array("where" => "email = '".ASweb\Db\Db::nq($login)."' and pass = '".ASweb\Db\Db::nq($pass)."'"));
		}
			
		if($user->id){ // Пользователь получен
			$_SESSION['userid'] = $user->id;
			$_SESSION['username'] = $user->name;
			$_SESSION['usertype'] = $user->type;
			$_SESSION['useropt'] = ($user->opt) ? $user->opt : 0;
			$_SESSION['userlevel'] = ($user->level) ? $user->level : 0;
			
			$this->UserDiscount->userLogin();
			
			setcookie("user_id", $user->id, time()+60*60*24*3000);
			setcookie("username", $user->name, time()+60*60*24*3000);
			setcookie("usertype", $user->type, time()+60*60*24*3000);
			setcookie("useropt", $user->opt, time()+60*60*24*3000);
			setcookie("userlevel", $user->level, time()+60*60*24*3000);
			setcookie("userlevel", $_SESSION['userdiscount'], time()+60*60*24*3000);
			return true;
		}else{
			return false;
		}			
	}
		
	public static function register($userid, $username, $usertype)
	{
		$_SESSION['userid'] = $userid;
		$_SESSION['username'] = $username;
		$_SESSION['usertype'] = $usertype;
		setcookie("user_id", $userid, time()+60*60*24*3000);
		setcookie("username", $username, time()+60*60*24*3000);
		setcookie("usertype", $usertype, time()+60*60*24*3000);
	}
		
	public static function logoff()
	{
		unset($_SESSION['userid']);
		unset($_SESSION['username']);
		unset($_SESSION['usertype']);
		unset($_SESSION['userdiscount']);
		unset($_SESSION['useropt']);
		
		setcookie("user_id", null, -1, "/");
		setcookie("username", null, -1, "/");
		setcookie("usertype", null, -1, "/");
		setcookie("userdiscount", null, -1, "/");
		setcookie("userdiscountlevel", null, -1, "/");
		setcookie("useropt", null, -1, "/");	
	}
		
	public static function userid(): int
	{
		return isset($_SESSION['userid']) ? intval($_SESSION['userid']) : 0;
	}
		
	public static function username(): string
	{
		return isset($_SESSION['username']) ? $_SESSION['username'] : '';
	}
		
	public static function usertype(): string
	{
		return isset($_SESSION['usertype']) ? $_SESSION['usertype'] : '';
	}
		
	public static function useropt(): int
	{
		return isset($_SESSION['useropt']) ? intval($_SESSION['useropt']) : 0;
	}
		
	public static function userdiscount(): float
	{
		return isset($_SESSION['userdiscount']) ? floatval($_SESSION['userdiscount']) : 0;
	}
}