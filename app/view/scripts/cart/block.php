<?
$opt = Zend_Registry::get('opt');
if($_COOKIE['userid'] && $opt['discounts']){
	$Discount = new Model_Discount();
	$Order = new Model_Order();

	$order_total = $Order->total($_COOKIE['userid']);
	$dictounts = $Discount->getall();
	$discount = $Discount->getnakop($view->order_total);
	$nextdiscount = $Discount->nextdiscount($view->order_total);
	$tonextdiscount = $Discount->tonextdiscount($view->order_total);
}

foreach($this->Cart->cart as $k => $v)
	if ($v[num] < 1) $this->Cart->cart[$k][num] = 1;
if($opt['billing']){
	?>
<a href="<?=$this->url->mk('/cart')?>" id="cart">
	<i class="fa fa-shopping-basket mr-5"></i>
                            <span class="hidden-xs">
                                <?=$this->labels['cart']?><sup class="text-primary">(<span id="prods"><span id="val"><?=0 + $this->Cart->getProdNum();?></span></span>)</sup>
                                <!--<i class="fa fa-angle-down ml-5"></i>-->
                            </span>
</a>
	<?/*?>
<ul class="cart w-250">
	<li>
		<div class="cart-items">
			<ol class="items">
				<?	$n = $sum = 0;
				$Prod = new Model_Prod();
				$Cat = new Model_Cat();

				foreach($this->Cart->cart as $k => $v) {
				$prod = $Prod->get($v['id']);
				$cat = $Cat->get($prod->cat);
				$title = "<a href=\"/catalog/".$cat->intname."/".$prod->id."\">".$prod->name."</a>";

				if($v['var']){
					$ProdVar = new Model_Prodvar();
					$prodvar = $ProdVar->get($v['var']);
					$title .= "<br>(".$prodvar->name.")";
				}

				$sum += ($v['var']) ? $prodvar->price * $v['num'] : $prod->price * $v['num'];
				if($discount) $sum2 = $sum - ($sum * $discount) / 100;
				else $sum2 = $sum;
				?>
				<li>
					<a href="/catalog/<?=$cat->intname?>/<?=$prod->id?>" class="product-image">
						<img src="/thumb?src=pic/prod/<?=$v['id']?>.jpg&amp;width=400&amp;height=520" alt="<?=$prod->name?>">
					</a>
					<div class="product-details">
						<div class="close-icon">
							<a href="javascript:void(0);" onclick="$.get('/cart/delete/<?=$k?>', function(data){location.reload();});"><i class="fa fa-close"></i></a>
						</div>
						<p class="product-name">
							<a href="/catalog/<?=$cat->intname?>/<?=$prod->id?>"><?=$prod->name?></a>
						</p>
						<strong><?=$v['num']?></strong> x <span class="price text-primary"><?=($v['var']) ? ASweb\StdLib\Func::fmtmoney($prodvar->price).$this->sett["valuta"] : ASweb\StdLib\Func::fmtmoney($prod->price).$this->sett["valuta"];?></span>
					</div><!-- end product-details -->
				</li><!-- end item -->
				<?	}?>
			</ol>
		</div>
	</li>
	<li>
		<div class="cart-footer-2">
			<p class="tac"><strong><?=$this->labels["to_pay"]?></strong> <?=ASweb\StdLib\Func::fmtmoney($sum2).$this->sett['valuta']?></p>
		</div>
	</li>
	<li>
		<div class="cart-footer">
			<a href="<?=$this->url->mk('/cart')?>" class="pull-left"><i class="fa fa-cart-plus mr-5"></i><?=$this->labels['cart']?></a>
			<a href="<?=$this->url->mk('/order')?>" class="pull-right"><i class="fa fa-shopping-basket mr-5"></i><?=$this->labels["make_order"]?></a>
		</div>
	</li>
</ul>
<?*/?>
<?}?>