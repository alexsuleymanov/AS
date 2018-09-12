<?php
	namespace ASweb\Auth\Adaptor;
	
	class Vk implements AuthAdaptorInterface
	{
		function getUser()
		{
			return new stdClass();
		}
	}
