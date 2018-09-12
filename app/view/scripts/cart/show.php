<?
	$opt = Zend_Registry::get('opt');
/*	if($_COOKIE["userid"] && $opt['discounts']){
		$Discount = new Model_Discount();
		$Order = new Model_Order();

		$order_total = $Order->total($_COOKIE["userid"]);
		$dictounts = $Discount->getall();
		$discount = $Discount->getnakop($view->order_total);
		$nextdiscount = $Discount->nextdiscount($view->order_total);
		$tonextdiscount = $Discount->tonextdiscount($view->order_total);
	}*/

	foreach($this->Cart->cart as $k => $v)
		if ($v[num] < 1) $this->Cart->cart[$k][num] = 1;?>
	<table width="100%" border="0" cellspacing="0" cellpadding="2" class="cart" style="font-family: Arial; font-size: 12px; border-collapse:collapse;">
		<tr style="background-color: #cccccc;">
			<td width="20" align="center" style="border:1px solid #cccccc;"><b>#</b></td>
			<td width="120" align="center" style="border:1px solid #cccccc;"><b><?=$this->labels["photo"]?></b></td>
			<td align="center" style="border:1px solid #cccccc;"><b><?=$this->labels['title']?></b></td>
			<td width="120" align="center" style="border:1px solid #cccccc;"><b><?=$this->labels['price']?></b></td>
			<td width="70" align="center" style="border:1px solid #cccccc;"><b><?=$this->labels['quantity']?></b></td>
			<td width="150" align="center" style="border:1px solid #cccccc;"><b><?=$this->labels['total_price']?></b></td>
		</tr>
<?	$n = $sum = 0;
	$Prod = new Model_Prod();
	$Cat = new Model_Cat();
	
	foreach($this->Cart->cart as $k => $v) {		
		$prod = $Prod->get($v['id']);
		$cat = $Cat->get($prod->cat);
		$title = "<a href=\"/catalog/".$cat->intname."/".$prod->intname."\" target=\"_blank\">".$prod->name."</a>";
				
		$sum += $v['price'] * $v['num'];
		if($discount) $sum2 = $sum - ($sum * $discount) / 100;
		else $sum2 = $sum;
?>
		<tr style="background-color: <?=($w++ % 2) ? "#f0f0f0": "#ffffff";?>">
			<td style="border:1px solid #cccccc;"><?=++$n?></td>
			<td align="center" style="border:1px solid #cccccc;"><img src="https://<?=$_SERVER['HTTP_HOST']?>/thumb?src=pic/prod/<?=$v['id']?>.jpg&width=100" alt="" /></td>
			<td style="border:1px solid #cccccc;"><?=$title?></td>
			<td style="border:1px solid #cccccc;"><?=($v['baseprice'] != $v['price']) ? "<s>".ASweb\StdLib\Func::fmtmoney($v['baseprice'])."</s> ".ASweb\StdLib\Func::fmtmoney($v['price']).$this->sett["valuta"] : ASweb\StdLib\Func::fmtmoney($v['price']).$this->sett["valuta"];?></td>
			<td align="center" style="border:1px solid #cccccc;"><?=$v['num']?></td>
			<td style="border:1px solid #cccccc;"><?=ASweb\StdLib\Func::fmtmoney(($v['var']) ? $prodvar->price * $v['num'] : $prod->price * $v['num']).Zend_Registry::get('cur_name')?></td>
		</tr>
<?	}?>

	</table>

    <p align="right" style="font-weight:bold;">
      <?=$this->labels["total_price"]?>: <?=ASweb\StdLib\Func::fmtmoney($sum).Zend_Registry::get('cur_name')?><br />
      <?if($discount) echo $this->labels["discount"].": ".$discount."%<br />";?>
      <div style=" float:right; padding: 10px; background-color: #2c4a77; color: #ffffff; width: 200px; height: 20px; vertical-align: middle; text-align:center; font-family:'Times New Roman', Times, serif; font-size:20px;"><?=$this->labels["to_pay"]?>: <?=ASweb\StdLib\Func::fmtmoney($sum2).Zend_Registry::get('cur_name')?> </div>
    </p>