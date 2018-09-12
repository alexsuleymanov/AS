	<h1 class="search">Поиск</h1>
	<p>По запросу найдено <?=$this->cnt?> записей</p>
<?
	foreach($this->sres as $sres){?>
		<div class="box_link">
			<a href="<?=$sres['link']?>" class="srch"><strong><?=$sres['name']?></strong></a>
		</div>
		<p><?=$sres['short']?>...<br/><a href="<?=$sres['link']?>"><?=$sres['link']?></a></p>
		<br />
<?	}
