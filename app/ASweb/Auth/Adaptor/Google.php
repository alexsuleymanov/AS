<?php
	namespace ASweb\Auth\Adaptor;
	
	class Google implements AuthAdaptorInterface
	{
		function getUser()
		{
			return new stdClass();
		}
	}
