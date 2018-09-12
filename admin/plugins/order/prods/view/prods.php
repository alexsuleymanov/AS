<?	$opt = Zend_Registry::get('opt');?>

<div id="hiddencart" style="display: none;">
	<table class="show" id="cart0" width="100%">
		<tr>
			<td>
			</td>
		</tr>
		<tr>
			<td class="show" width="2%">0</td>
			<td class="show" id="cart_title0">
   				<div id="cart_select0">		
					Введите название товара<br>
					<input type="text" id="gsearch0" size="100" name="q" value=""/><br/><br/>
				</div>
			</td>
			<td class="show" width="120"><img id="cart_img0" src="/pic/prod/0.jpg" alt="" width="118" height="119"></td>
			<td class="show" width="22%" id="cart_price0">&nbsp;</td>
			<td class="show" width="22%"><input type='text' id="num" name='cart_num0' id="cart_num0" size="3" value="1" disabled="true"></td>
			<td class="show" width="2%" id="dela"><a href="" id="a" onclick="remove_cart(0); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	function add_row(data){
		table = $("#hiddencart table:first");
		title = table.find("#prod");
		newcart = table.clone();
		newcart.attr({"id": "cart"+data});
		newcart.find("#gsearch0").attr({"id": "gsearch"+data});
		newcart.find("#cart_img0").attr({"id": "cart_img"+data});
		newcart.find("#cart_title0").attr({"id": "cart_title"+data});
		newcart.find("#cart_price0").attr({"id": "cart_price"+data});
		newcart.find("#cart_num0").attr({"name": "cart_num"+data, "id": "cart_num"+data, "disabled": "0"});
		newcart.find("#dela").html('<a href="" id="a" onclick="remove_cart('+data+'); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a>');
//		$("#carts").append(newcart);

		newchildscript = "";

		newchildscript += "$().ready(function() {\n";
		newchildscript += "		$('#gsearch"+data+"').autocomplete('/search/hint/prod', {\n";
		newchildscript += "			width: 260,\n";
		newchildscript += "			selectFirst: false\n";
		newchildscript += "		});\n";
	
		newchildscript += "		$('#gsearch"+data+"').result(function(event, data, formatted) {\n";
//		newchildscript += "			alert(data[1]);\n";
		newchildscript += "			$('#cart_img"+data+"').attr({'src': '/pic/prod/'+data[1]+'.jpg', 'width': '118'});\n";
		newchildscript += "			$('#cart_title"+data+"').html('<b>'+data[0]+'</b>');\n";
		newchildscript += "			$.get('adm_order.php"+"<?=$this->url->gvar("time=")?>"+"', {'edit_cart': 1, 'order': <?=$_GET[id]?>, 'cart_id': "+data+", 'prod': data[1]}, function(data1){\n";
		newchildscript += "				$('#cart_price"+data+"').html(data1.price+'грн.');\n";
		newchildscript += "				location.reload();";//alert(data1);\n";
		newchildscript += "			});\n";
		newchildscript += "		});\n";
		newchildscript += "});\n";

		newchildscript1 = '\n<script type="text\/javascript">\n';
		newchildscript1 += newchildscript;
		newchildscript1 += '<\/script>\n';

		$("#carts").append(newchildscript1);
		$("#carts").prepend(newcart);
		eval(newchildscript);
	}

	function remove_row(data){
		$("#cart"+data).empty();
		location.reload();
	}

	function add_cart(){
		$.getJSON('adm_order.php<?=$this->url->gvar("time=")?>', {"add_prod" : 1}, add_row);
	}

	function remove_cart(id){
		if(confirm('Удалить товар из заказа?'))
			$.getJSON('adm_order.php<?=$this->url->gvar("time=")?>', {"del_prod" : id}, remove_row);
	}

	function update_cart(id, obj){
		$.get('adm_order.php<?=$this->url->gvar("update_cart=1")?>', {"cart_id" : id, "num": $(obj).val()}, function(){location.reload();});
	}
</script>

<?  if($_GET['id']){?>
			<a href="" onclick="add_cart(); return false;"><img src="<?=$this->path?>/img/add.jpg">Добавить</a><br><br>

			<table class="show" width="100%">
				<tr>
					<th class="show" width="2%">#</th>
					<th class="show">Товар</th>
					<th class="show" width="120">Фото</th>
					<th class="show" width="22%">Цена</th>
					<th class="show" width="22%">Количество</th>
					<th class="show" width="2%"><img src="<?=$this->path?>/img/tr.gif" width="16"></th>
				</tr>
			</table>

			<div id="carts">		

<?		$Cart = new Model_Cart();
		$Order = new Model_Order();
		$order = $Order->get($_GET[id]);
		if($opt["discounts"]){
			$Discount = new Model_Discount();
			$order_total = $Order->total($order->user);
			$dictounts = $Discount->getall();
			$discount = $Discount->getnakop($order_total);
		}

		$prods = $Cart->getall(array("where" => "`order` = '".ASweb\Db\Db::nq($_GET['id'])."'"));

		$total_weight = 0;

		foreach($prods as $k => $r){
			$Prod = new Model_Prod($r->prod);
			$prod = $Prod->get();
			$total_weight += $prod->weight * $r->num;
			$skidka += $r->price * $r->skidka / 100;
			$sum += $r->skidka ? ($r->price - $r->price * $r->skidka / 100) * $r->num : ($prod->price - $prod->price * $discount / 100) * $r->num;
?>
			<table class="show" id="cart<?=$r->id?>" width="100%">
				<tr>
					<td class="show" width="2%"><?=$k+1?></td>
					<td class="show" id="cart_title<?=$r->id?>"><a href="adm_prod.php?action=edit&id=<?=$prod->id?>" target="_blank"><?=$prod->name?></a></td>
					<td class="show" width="120" align="center"><img id="cart_img<?=$r->id?>" src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&amp;width=118&amp;height=119" alt="" width="118" height="119"></td>
					<td class="show" width="22%"><?=Func::fmtmoney($r->price)?> грн. <?if($opt['prod_points'] && $r->points) echo "<br />+".$r->points." баллов"?></td>
					<td class="show" width="22%"><input type='text' id="num" name='cart_num<?=$r->id?>' id="cart_num<?=$r->id?>" size="3" value="<?=$r->num?>" onblur="update_cart(<?=$r->id?>, this)" /></td>
					<td class="show" width="2%" id="dela"><a href="" id="a" onclick="remove_cart(<?=$r->id?>); return false;"><img src="<?=$this->path?>/img/b_del.png" alt="Del"></a></td>
				</tr>
			</table>
	<?}?>
		<table cellpadding="0" cellspacing="0" align="right" width="100%">
			<tr valign="top">
				<td align="right" style="font-size: 16px; font-weight: bold;">Стоимость:&nbsp; </td><td width="180" aligh="left" style="font-weight: bold; font-size: 16px; color: red"> <?=Func::fmtmoney($sum)?> <?=Zend_Registry::get('cur_name')?></td>
			</tr>
<?		if($opt['prod_points']){?>
			<tr valign="top">
				<td align="right" style="font-size: 14px; font-weight: bold;">Начислено баллов:&nbsp; </td><td width="180" aligh="left" style="font-weight: bold; font-size: 14px; color: red"> <?=$Order->points($_GET['id'])?></td>
			</tr>
			<tr valign="top">
				<td align="right" style="font-size: 14px; font-weight: bold;">Списано баллов:&nbsp; </td><td width="180" aligh="left" style="font-weight: bold; font-size: 14px; color: red"> <?=$order->points?></td>
			</tr>
			<tr valign="top">
				<td align="right" style="font-size: 16px; font-weight: bold;">К оплате:&nbsp; </td><td width="180" aligh="left" style="font-weight: bold; font-size: 16px; color: red"> <?=Func::fmtmoney($sum - $Order->discount($_GET['id']))?> <?=Zend_Registry::get('cur_name')?></td>
			</tr>
<?		}?>
		</table>
			</div>
<?	}?>
