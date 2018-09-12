<?php

class Model_Plugin_Prod_Chars extends Model_Plugin_Abstract
{
	public function clearprodchars(int $id)
	{
		$Prodchar = new Model_Prodchar();
		$Prodchar->delete(array("where" => "`prod` = $id"));
	}
}
