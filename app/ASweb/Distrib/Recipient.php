<?php
	namespace ASweb\Distrib;
	
	class Recipient
	{
		private $name;
		private $address;
		private $type;
		
		public function __construct(string $type, string $address, string $name)
		{
			$this->type = $type;
			$this->address = $address;
			$this->name = $name;
		}
		
		public function getName(): string
		{
			return $this->name;
		}
		
		public function getAddress(): string
		{
			return $this->address;
		}
		
		public function getType(): string
		{
			return $this->type;
		}
	}