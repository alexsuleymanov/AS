<?
	$opt = Zend_Registry::get('opt');
	if($_COOKIE["userid"] && $opt['discounts']){
		$Discount = new Model_Discount();
		$Order = new Model_Order();

		$order_total = $Order->total($_COOKIE["userid"]);
		$dictounts = $Discount->getall();
		$discount = $Discount->getnakop($view->order_total);
		$nextdiscount = $Discount->nextdiscount($view->order_total);
		$tonextdiscount = $Discount->tonextdiscount($view->order_total);
	}

	foreach($this->Cart->cart as $k => $v)
		if ($v[num] < 1) $this->Cart->cart[$k][num] = 1;?>
<table>
	<tr>
		<td style="text-align: right;"><h2><?=$this->labels["your_order"]?></h2></td>
	</tr>
	<tr>
		<td>

	<table width="100%" border="0" cellspacing="20" class="cart-mini">
<?	$n = $sum = 0;
	$Prod = new Model_Prod();
	$Prodvar = new Model_Prodvar();
	$Cat = new Model_Cat();
	
	foreach($this->Cart->cart as $k => $v) {	
		$prod = $Prod->get($v['id']);
		$cat = $Cat->get($prod->cat);
		
		$title = "<a href=\"/catalog/".$cat->intname."/".$prod->intname."\" target=\"_blank\">".$prod->name."</a>";
				
		if($v['var']){			
			$prodvar = $Prodvar->get($v['var']);
			$title .= "<br>(".$prodvar->name.")";
		}

		$sum += $v['price'] * $v['num'];
		if($discount) $sum2 = $sum - ($sum * $discount) / 100;
		else $sum2 = $sum;
?>
		<tr style="background-color: <?=($w++ % 2) ? "#f0f0f0": "#ffffff";?> padding: 20px;">
			<td align="center"><img src="/thumb?src=pic/prod/<?=$v['id']?>.jpg&width=100" alt="" /></td>
			<td>
				<span class="prod-name"><?=$title?></span><br />
				<div style="text-align: right; white-space: nowrap;">
					<span class="prod-price"><?=ASweb\StdLib\Func::fmtmoney($v['price']).Zend_Registry::get('cur_name')?></span> x 
					<span class="prod-num"><?=$v['num']?> = 
					<span class="prod-price"><?=ASweb\StdLib\Func::fmtmoney($v['price']).Zend_Registry::get('cur_name')?></span>
				</div>
			</td>
		</tr>
<?	}?>

	</table>

    <p align="right" style="font-weight:bold;">
      <?if($discount) echo $this->labels["discount"].": ".$discount."%<br />";?>
      <div class="order-total"><?=$this->labels["to_pay"]?>: <?=ASweb\StdLib\Func::fmtmoney($sum2).Zend_Registry::get('cur_name')?> </div>
    </p>
		</td>
	</tr>
</table>

