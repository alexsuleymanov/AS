<script type="text/javascript">
	$(document).ready(function() {
		$(".rating").rating({
			type: "page",
			id: <?=$this->page->id?>,
			<?if($_COOKIE["rated_page_".$this->page->id]) echo "rated: 1,\n";?>
			action: "/rating"
		});
	});
</script>

<div class="rating-block">
	<b><?=$this->labels['rate']?>:</b>
	<img class="rating" rel="page" src="<?=$this->path?>/img/rating/<?=round($this->page->rating->rating)?>stars.png" alt="Оценка: <?=$this->page->rating->rating?> звезды." width="80" />
	(<span class="rating_count"><?=$this->page->rating->count?></span> <?=$this->labels['ocenok']?>, <?=$this->labels['middle']?> <span class="rating_rating"><?=$this->page->rating->rating?></span> <?=$this->labels['iz']?> 5)
</div>

<div id="<?=$this->page->intname?>" class="post-ratings" itemscope itemtype="https://schema.org/Article" data-nonce="9ef8da47c1">
	<meta itemprop="name" content="<?=$this->page->title?>" />
	<meta itemprop="description" content="<?=$this->page->description?>" />
	<meta itemprop="url" content="https://<?=$_SERVER['HTTP_HOST']?><?=$this->canonical?>" />
<?	if(file_exists("pic/article/".$this->page->id.".jpg")){?>
	<meta itemprop="image" content="https://<?=$_SERVER['HTTP_HOST']?>/thumb?width=100&src=pic/article/<?=$this->page->id?>.jpg" />
<?	}?>
	<div style="display: none;" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
		<meta itemprop="bestRating" content="5" />
		<meta itemprop="ratingValue" content="<?=($this->page->rating->rating) ? $this->page->rating->rating : 1?>" />
		<meta itemprop="ratingCount" content="<?=$this->page->rating->count?>" />
	</div>
</div>


