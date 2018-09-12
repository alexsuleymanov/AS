<?php
	namespace ASweb\StdLib;
	
	class Mobile
	{
		public static function detect()
		{
		    $mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
		    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);    
		    foreach ($mobile_agent_array as $value) {    
        		if (strpos($agent, $value) !== false) return true;   
		    }       
		    return false; 
		}
	}