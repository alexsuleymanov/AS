<?	if (count($this->prod->colors)) {?>
<br />
<h3>Другие цвета этого товара:</h3>
<table id="models" width="100%" cellspacing="0" border="0">
	<tr>
<?		$i = 0;
		foreach ($this->prod->colors as $prod) {?>
		<td class="pc6">
			<div class="pc6_prod_title" style="margin-bottom: 3px;"><a href="/product/<?=$prod->intname?>"><?=$prod->cname?></a></div>
			<div id="prod_wrapper" onclick="location.href = '/product/<?=$prod->intname?>';" style="cursor: hand;">
				<div id="prod_img6"><a href="/product/<?=$prod->intname?>"><img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&width=50" id="mainimg" alt="<?=$prod->name?>"></a></div>
				<div class="pc6_prod_price"><?=($prod->skidka) ? "<s>".ASweb\StdLib\Func::fmtmoney($prod->price)."</s> ".ASweb\StdLib\Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100).Zend_Registry::get('cur_name'): ASweb\StdLib\Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100).Zend_Registry::get('cur_name')?></div>
			<div>
		</td>
<?	}?>
	</tr>
</table>
<div class="trr6"></div>
<?	}?>
