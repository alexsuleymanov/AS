<?php
	namespace ASweb\Auth\Adaptor;
	
	class Facebook implements AuthAdaptorInterface
	{
		function getUser()
		{
			return new stdClass();
		}
	}
