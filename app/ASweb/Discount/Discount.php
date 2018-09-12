<?php
namespace ASweb\Discount;
	
class Discount implements DiscountInterface
{
	private $value;
	private $izm;
	private $final = 1;
		
	public function __construct(float $value) {
		$this->value = $value;
	}

	public function getValue(): float
	{
		return $this->value;		
	}
}
		
	