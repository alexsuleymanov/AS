<?php
	use ASweb\Sitemap\Sitemap;
	
	include("incl.php");
	echo $view->render('head.php');

	if($_GET['submit']){
		$Sitemap = new Sitemap();
		$Sitemap->save($path."/sitemap.xml");

		echo "<h3>sitemap.xml успешно обновлен</h3><p>Ссылка на sitemap - <a href=\"http://".$_SERVER['HTTP_HOST']."/sitemap.xml\" target=\"_blank\">http://".$_SERVER['HTTP_HOST']."/sitemap.xml</a></p>";
	}else{?>
<div style="margin: 20px;">
<h2>Генерация sitemap.xml</h2>
<br />
<form action="" method="get">
	<input type="submit" name="submit" value="Сгенерировать" />
</form>
</div>
<?	}

	echo $view->render('foot.php');