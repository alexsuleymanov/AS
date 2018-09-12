<script type="text/javascript">
	$(document).ready(function() {
		$(".rating").rating({
			type: "prod",
			id: <?=$this->prod->id?>,
			<?if($_COOKIE["rated_prod_".$this->prod->id]) echo "rated: 1,\n";?>
			action: "/rating"
		});
	});
</script>

<div class="rating-block">
	<b><?=$this->labels['rate']?>:</b>
	<img class="rating" rel="page" src="<?=$this->path?>/img/rating/<?=round($this->prod->rating)?>stars.png" alt="Оценка: <?=$this->prod->rating?> звезды." width="80" />
	(<span class="rating_count"><?=$this->prod->rating_count?></span> <?=$this->labels['ocenok']?>, <?=$this->labels['middle']?> <span class="rating_rating"><?=$this->prod->rating?></span> <?=$this->labels['iz']?> 5)
</div>
