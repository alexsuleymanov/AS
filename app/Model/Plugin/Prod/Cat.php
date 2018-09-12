<?php

class Model_Plugin_Prod_Cat extends Model_Plugin_Abstract
{
	public function getcat(int $cat)
	{
		$Cat = new Model_Cat();
		return $Cat->get($cat);
	}
}

