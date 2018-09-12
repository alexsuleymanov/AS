<?
use ASweb\StdLib\Func;
?>
<div class="widget">
	<h6 class="subtitle"><?=$this->labels['visited_prods']?></h6>
	<figure>
		<?
		$Prod = new Model_Prod();
		$Cat = new Model_Cat();

		$prods = $Prod->getall(array("where" => "visible = 1", "limit" => "3", "order" => "rand()"));
		foreach($prods as $prod){
			$cat = $Cat->getone(array("where" => "id = $prod->cat"));
			?>
			<div class="thumbnail store style1">
				<div class="header">
					<a href="<?=$this->url->mk('/catalog/'.$cat->intname.'/'.$prod->intname)?>">
						<img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&amp;width=400&amp;height=520" alt="<?=$prod->name?>">
					</a>
				</div>
				<div class="caption">
					<h6 class="regular"><a href="<?=$this->url->mk('/catalog/'.$cat->intname.'/'.$prod->intname)?>"><?=$prod->name?></a></h6>
					<div class="price">
						<?if($prod->skidka) {?>
							<small class="amount off"><?=ASweb\StdLib\Func::fmtmoney($prod->price)." ".$this->sett["valuta"]?></small>
						<?}?>
						<span class="amount text-primary"><?=ASweb\StdLib\Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100)." ".$this->sett["valuta"]?></span>
					</div>
				</div><!-- end caption -->
			</div><!-- end thumbnail -->
		<?	}?>
	</figure>
</div><!-- end widget -->