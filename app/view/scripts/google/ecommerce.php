<?
use ASweb\StdLib\Func;
?>
<script type="text/javascript">
	ga('require', 'ecommerce');
	ga('ecommerce:addTransaction', {
		'id': '<?=$this->order_id?>',
		'affiliation': '<?=$this->sett['sitename']?>',
		'revenue': '<?=ASweb\StdLib\Func::fmtmoney($this->order_sum)?>',
		'shipping': '0',
		'tax': '0',
		'currency': 'UAH'
	});
<?	foreach($this->cartitems as $item){
		$Prod = new Model_Prod($item['id']);
		$prod = $Prod->get();		
		$cat = $Prod->getcat();
?>
	ga('ecommerce:addItem', {
		'id': '<?=$this->order_id?>',
		'name': '<?=$prod->name?>',
		'sku': '<?=$prod->art?>',
		'category': '<?=$cat->name?>',
		'price': '<?=ASweb\StdLib\Func::fmtmoney($item['price'])?>',
		'quantity': '<?=$item['num']?>'
	});
<?	}?>
	ga('ecommerce:send');
</script>