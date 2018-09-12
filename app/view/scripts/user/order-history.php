<h2><?=$this->labels["order_history"]?></h2>
<br>
<?	foreach($this->orders as $order){
		$Order = new Model_Order($order->id);
		if($opt['discounts']){
			$Discount = new Model_Discount();
			$discount = $Discount->getnakop($Order->total($_SESSION["userid"]));
		}
		$sum = $Order->ordersum($order->id);
		$sum2 = $sum - ($sum * $discount / 100);
?>
<table cellspacing="5" cellpadding="5" style="border-collapse: collapse;">
	<tr id="trorder<?=$order->id?>">
		<td class="t" style="border: 1px solid #999999;">
			<table cellspacing="3" cellpadding="0" border="0" width="100%">
			<form action="<?=$this->url->mkd(array("m", "upd", 1))?>" method="post" name="form<?=$order->id?>">
				<input type="hidden" name="ord_id" value="<?=$order->id?>">
				<tr>
					<td class="histh" width="100"><h2><?=$this->labels["order"]?> #</h2></td><td><h2><?=$order->id?></h2></td>
				</tr>
				<tr>
					<td class="histh"><?=$this->labels["order_date"]?></td><td><b><?=date("d.m.Y", $order->tstamp)?></b></td>
				</tr>
				<tr>
					<td><?=$this->labels["status"]?><td><font color="red"><?if($order->status == 2) echo $this->labels["delivered"]; else if($order->status == 1) echo $this->labels["payed_not_delivered"]; else echo $this->labels["not_payed"];?></font></td>
				</tr>
				<tr>
					<td colspan="2">
						<table cellspacing="0" cellpadding="5" border="0" style="border: 1px solid #999999;">
							<tr class="h">
								<td width="300"><?=$this->labels["title"]?></td>
								<td width="100"><?=$this->labels["price"]?></td>
								<td width="100"><?=$this->labels["quantity"]?></td>
							</tr>
<?		$w = 0;
		$Cart = new Model_Cart();
		$items = $Cart->getall(array("where" => "`order` = '".$order->id."'"));

		foreach($items as $item){
?>
							<tr bgcolor="<?=($w++ % 2) ? "#f0f0f0" : "#f5f5f5";?>">
							<input type="hidden" name="prod_<?=$item->prod?>" value="<?=$item->prod?>">
							<input type="hidden" name="prodvar_<?=$item->prodvar?>" value="<?=$item->prodvar?>">
								<td width="*"><?=($item->prodvar) ? Model_Prod::getname($item->prod)." (".Model_ProdVar::getname($item->prodvar).")" : Model_Prod::getname($item->prod);?></td>
								<td width="20%"><?=ASweb\StdLib\Func::fmtmoney($item->price).Zend_Registry::get('cur_name')?></td>
								<td width="20%"><?=$item->num?></td>
							</tr>
<?		}?>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="right"><?=$this->labels["total"].": ".ASweb\StdLib\Func::fmtmoney($sum).Zend_Registry::get('cur_name')?></td>
				</tr>
<?		if($discount){?>
				<tr>
					<td colspan="2" align="right"><?=$this->labels["discount"].": ".$discount."%"?></td>
				</tr>
				<tr>
					<td colspan="2" align="right"><?=$this->labels["to_pay"].": ".ASweb\StdLib\Func::fmtmoney($sum2).Zend_Registry::get('cur_name')?></td>
				</tr>
<?		}?>
				<input type="hidden" name="n" value="<?=$order->id?>">
			</form>
			</table>
		</td>
	</tr>
</table>
<br>
<?	}?>