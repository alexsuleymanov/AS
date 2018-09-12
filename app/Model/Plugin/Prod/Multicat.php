<?php
class Model_Plugin_Prod_Multicat extends Model_Plugin_Abstract
{
	public function getcasts(int $id)
	{
		$Cat = new Model_Cat();
		$cats = $Cat->getall(array("where" => "visible = 1", array("select" => "obj", "where" => "`type` = 'cat-prod' and `relation` = ".$id)));

		return $cats;
	}
}
