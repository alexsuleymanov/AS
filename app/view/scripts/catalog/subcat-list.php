<!-- Main Heading Ends -->
<div class="row">
	<?foreach($this->cats as $cat_r) {?>
		<div class="col-md-4 col-sm-6 col-eq-height cat-col-w">
			<div class="product-col cat-col">
				<div class="image">
					<a href="<?=$this->url->mk('/catalog/'.$cat_r->intname)?>">
						<?if(file_exists('pic/cat/'.$cat_r->id.'.jpg')) {?>
							<img src="/thumb?src=pic/cat/<?=$cat_r->id?>.jpg&amp;width=244&amp;height=313&amp;crop=0" alt="<?=$cat_r->name?>" class="img-responsive img-center-sm" />
						<?} else {?>
							<img src="<?=$this->path?>/img/product-images/14.jpg" alt="<?=$cat_r->name?>" class="img-responsive img-center-sm" />
						<?}?>
					</a>
				</div>
				<div class="caption">
					<h4><a href="<?=$this->url->mk('/catalog/'.$cat_r->intname)?>"><?=$cat_r->name?></a></h4>
				</div>
			</div>
		</div>
		<!-- Product Ends -->
	<?}?>
</div>

