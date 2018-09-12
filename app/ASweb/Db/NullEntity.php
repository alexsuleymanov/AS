<?php
namespace ASweb\Db;
	
class NullEntity extends Entity
{
	function __toString()
	{
		return "";
	}
}