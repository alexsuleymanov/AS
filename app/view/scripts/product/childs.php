<div class="row">
	<div class="col-sm-12">
		<div id="owl-demo" class="owl-carousel column-4 owl-theme">
<?			foreach ($this->prod->childs as $prod) {?>
				<div class="item product-item">
					<div class="thumbnail store style1">
						<div class="header">
							<figure class="layer">
								<a href="/product/<?=$prod->intname?>">
									<img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&amp;width=400&amp;height=520&amp;crop=0" alt="">
								</a>
							</figure>
						</div>
						<div class="caption">
							<h6 class="regular"><a href="/product/<?=$prod->intname?>"><?=$prod->name?></a></h6>
							<div class="price">
								<?if ($prod->skidka) {?>
									<small class="amount off"><?=ASweb\StdLib\Func::fmtmoney($prod->price)." ".$this->sett["valuta"]?></small>
								<?}?>
								<span class="amount text-primary"><?=ASweb\StdLib\Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100)." ".$this->sett["valuta"]?></span>
							</div>
							<?if ($prod->avail == 1) {?>
								<form action="/cart/buy" method="post" id="prodform_<?=$prod->id?>">
									<button type="button" class="btn btn-default btn-lg round" onclick="buy(<?=$prod->id?>); return false;">
										<input type="hidden" name="id" value="<?=$prod->id?>" />
										<input type="hidden" name="ajax" value="1" class="ajax" />
										<input type="hidden" name="fromurl" value="<?=$_SERVER['REQUEST_URI'].$this->url->gvar(time()."=")?>" class="prod_id" />
										<span><i class="fa fa-shopping-cart"></i> <?=$this->labels['tocart']?></span>
									</button>
								</form>
							<?}?>
						</div><!-- end caption -->
					</div><!-- end thumbnail -->
				</div><!-- end col -->
			<?	}?>
		</div><!-- end owl carousel -->
	</div><!-- end col -->
</div><!-- end row -->