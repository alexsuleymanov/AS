<?php
namespace ASweb\Discount;

class NumDiscount implements DiscountInterface
{
		static function numdiscount($num, $skidka){
			$discount = 0;
/*			$skidka = self::skidka_decode($skidka);
			if(!is_array($skidka)) return 0;
			foreach($skidka as $k => $v){
				if($num >= $v['min'] && $num <= $v['max']){
					$discount = $v['skidka'];
					break;
				}
			}*/
			
			return $discount;
		}

	public function getValue(): float
	{
		
	}

	public function __toString(): string
	{
		
	}
	