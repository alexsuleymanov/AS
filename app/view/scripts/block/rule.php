<ul class="pagination">
	<?
	$pagesinoneruler = 20;

	if(file_exists(dirname(__FILE__)."../../img/rule/prev.gif") && file_exists(dirname(__FILE__)."../../img/rule/next.gif")){
		$prev_img = "<img src=\"/img/rule/prev.gif\" alt=\"\">";
		$next_img = "<img src=\"/img/rule/next.gif\" alt=\"\">";
	}else{
		$prev_img = "&laquo;";
		$next_img = "&raquo;";
	}
	$separator = "";

	$cnt = $this->cnt;
	$results = $this->results;
	$start = $this->start;

	if ($cnt > $results) {
		$pages = ceil($cnt / $results);
		$fpage = 0;
		$tpage = $pages;
		$cpage = round($start / $results);

		if ($pagesinoneruler < $pages) {
			$fpage = $cpage - round($pagesinoneruler / 2);
			$tpage = $cpage + round($pagesinoneruler / 2);
			if ($fpage < 0) {
				$fpage = 0;
				$tpage = $pagesinoneruler;
			}
			if ($tpage > $pages) {
				$fpage = $pages - $pagesinoneruler;
				$tpage = $pages;
			}
		}

		if ($start > 0) {
			$newp = $start - $results;
			if ($start < 0) $start = 0;
			echo "<li><a href=\"/".$this->url->page.$this->url->gvar("start=")."\" class=\"rulea\">".$prev_img."</a></li>";
		}

		/*echo ($start <= 0)? '<span class="rulea">': '<a class="rulea" href="'.$this->url->gvar("start=".(($start - $results > 0)? $start - $results: 0)).'">';
//		echo "&lt;&lt;";
		if ($fpage > 0) echo ' ... ';
		echo ($start <= 0)? '</span>': '</a>';*/

		$first = 1;
		for ($n = $fpage; $n < $tpage; $n++) {
			if ($first) $first = 0;
//			else echo "|";
//			else echo "&nbsp;&nbsp;";
			echo "<li";
			echo ($cpage == $n)? ' class="active"' : '';
			echo ($n == 0) ? '><a href="/'.$this->url->page.$this->url->gvar("start=").'">' : '><a href="'.$this->url->gvar("start=".($n * $results)).'">';
			echo $n + 1;
			echo '</a>';
		}

		/*echo ($start + $results >= $cnt)? '<span class="rulea">': '<a class="rulea" href="'.$this->url->gvar("start=".($start + $results)).'">';
		if ($tpage < $pages) echo ' ... ';
//		echo "&gt;&gt;";
		echo ($start + $results >= $cnt)? '</span>': '</a>';*/

		if ($start < $cnt - $results) {
			$newp = $start + $results;
			if ($start >= $cnt - $results) $start = $cnt - $results;
			echo "<li><a href=\"".$this->url->gvar("start=".$newp)."\" class=\"rulea\">".$next_img."</a></li>";
		}
	}?>
</ul>