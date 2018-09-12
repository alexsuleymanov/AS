<?php

class Model_Plugin_Page_Archive extends Model_Plugin_Abstract
{
	public function getArchive()
	{
		$Page = new Model_Page();
		
		$archive = array();
		$oldest = getdate($this->getone(array("where" => "visible = 1", "order" => "tstamp", "limit" => 1))->tstamp);
		$now = getdate(time());

		for ($i = $now["year"]; $i >= $oldest["year"]; $i--) {
			$t1 = mktime(0, 0, 0, 1, 1, $i);
			$t2 = mktime(0, 0, 0, 1, 1, $i+1);
			if ($Page->getnum(array("where" => "tstamp > $t1 and tstamp < $t2"))) {
				$archive[$i] = array();
				for ($j = 1; $j <= 12; $j++) {
					$t1 = mktime(0, 0, 0, $j, 1, $i);
					$t2 = mktime(0, 0, 0, $j+1, 1, $i);
					if ($Page->getnum(array("where" => "tstamp > $t1 and tstamp < $t2"))) {
						$archive[$i][] = $j;
					}
				}
			}
		
			
					}
		return $archive;
	}
}

