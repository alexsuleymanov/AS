<?php

class Model_Plugin_Prod_Prodvar extends Model_Plugin_Abstract
{
	public static function minprice(int $id): float
	{
		$Prodvar = new Model_Prodvar();
		$prodvar = $Prodvar->getone(array("where" => "`prod` = '".$id."'", "order" => "price"));
		return $prodvar->price;
	}	
	
	public function clearprodvars(int $id): void
	{
		$Prodvar = new Model_Prodvar();
		$Prodvar->delete(array("where" => "`prod` = $id"));
	}
}