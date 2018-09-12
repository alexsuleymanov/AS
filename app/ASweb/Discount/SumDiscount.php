<?php
namespace ASweb\Discount;

class SumDiscount implements DiscountInterface
{
		protected static function sumdiscount($sett, $sum){
			return 0;
/*			$sum2 = $sum;
			$sum_skidka = explode(";",$sett['sum_skidka']);
			$discount = 0;
			
			foreach($sum_skidka as $k => $v)
				$sum_skidka[$k] = explode(":", $v);

			foreach($sum_skidka as $k => $v){
				if($sum > $v[0]){
					if($discount < $v[1]) $discount = $v[1];
				}else break;
			}
			
			return $discount;*/
		}

	public function getValue(): float
	{
		
	}

	public function __toString(): string
	{
		
	}

}