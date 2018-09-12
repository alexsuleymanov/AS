<?	$Cat = new Model_Cat();?>
<ul>
<?	foreach($this->cats as $k => $cat){
		$Cat->clear_tree();
		$tree = array_reverse($Cat->get_cat_tree_up($cat->id));
?>
	<li>
		<a href="/catalog/cat-<?=$cat->cid?>-<?=$cat->cintname?>/brand-<?=$cat->bid?>-<?=$cat->bintname?>"><?=$tree[0]->name." ".$cat->cname?></a>
	</li>
<?	}?>
</ul>
