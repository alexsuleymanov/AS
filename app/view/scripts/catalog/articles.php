<?		if(!empty($this->articles)){
			foreach($this->articles as $k => $v){?>
			<div class="article_mini"><a href="/articles/<?=$v->intname?>" class="newsh"><?=$v->name?></a></div>	
<?			}
		}?>