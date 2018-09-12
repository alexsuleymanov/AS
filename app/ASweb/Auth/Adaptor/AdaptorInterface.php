<?php
	namespace ASweb\Auth\Adaptor;
	
	interface AuthAdaptorInterface
	{
		public function getUser(): stdClass;
	}
