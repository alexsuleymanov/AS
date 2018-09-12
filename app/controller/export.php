<?	
	set_time_limit(0);

	if($opt["currencies"]){
		$Currency = new Model_Currency();
		$currency = $Currency->getone(array("where" => "`main` = 1"));
		$currency_code = $currency->intname;
		$currency_rate = $currency->course;
	}else{
		$currency_code = $sett['currency_code'];
		$currency_rate = 1;
	}

	function clear($str){
		$str = str_replace(";", ",", $str);
		return htmlspecialchars(iconv("UTF-8", "WINDOWS-1251", $str));
	}

	$Cat = new Model_Cat();
	$cats = $Cat->getall(array("where" => "visible != 0"));

	$Prod = new Model_Prod();
	$prods = $Prod->getallforexport();

	if($args[1] == '1c'){
		header('Content-type: text/xml; charset=windows-1251', true);
		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';?>
<_1CVzaimoraschet xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
	<Vers>1.00</Vers>
	<DataFile><?=date("Y-m-d", time())?></DataFile>

	<products>
<?		foreach($prods as $prod){
?>
		<item>
			<title><?=clear($prod->name)?></title>
			<art><?=clear($prod->art)?></art>
			<num><?=$prod->num?></num>
			<num><?=$prod->price?></num>
		</item>
<?		}?>
	</products>
</_1CVzaimoraschet>
<?
		die();
	}

	if($args[1] == 'csv'){
		$prods = $Prod->getall(array("where" => "visible != 0 and price != 0", "order" => "cat"));

//		header('Content-type: text/xml; charset=windows-1251', true);
		header('Content-Type: text/csv');
		foreach($prods as $k => $prod){
			echo "http://".$_SERVER['HTTP_HOST']."/catalog/prod-".$prod->id.";".$prod->art.";".clear($prod->name).";".Func::fmtmoney($prod->price).";\n";
		}

		die();
	}

	if($args[1] == 'prom'){
		header('Content-type: text/xml; charset=windows-1251', true);
		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';
		echo '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
?>
		<yml_catalog date="<?=date("Y-m-d H:i", time());?>">
			<shop>
				<name><?=clear($sett['sitename'])?></name>
				<company><?=clear($sett['sitename'])?></company>
				<url>http://<?=$_SERVER['HTTP_HOST']?></url>
				<platform>AS-Commerce</platform>
				<version>2.0</version>
				<currencies>
					<currency id="<?=$currency_code?>" rate="<?=$currency_rate?>"/>
				</currencies>

				<categories>
<?
		foreach($cats as $k => $cat){?>
					<category id="<?=$cat->id?>" <?if($cat->id){?>parentId="<?=$cat->cat?>"<?}?>><?=iconv("UTF-8", "WINDOWS-1251", $cat->name)?></category>
<?		}?>
				</categories>
				<offers>
<?		foreach($prods as $k => $prod){
			echo "<offer id=\"".$prod->id."\" available=\"true\"> <url>http://".$_SERVER['HTTP_HOST']."/catalog/prod-".$prod->id."</url> <price>".Func::fmtmoney($prod->price)."</price> <currencyId>".$currency_code."</currencyId> <categoryId>".$prod->cat."</categoryId> <picture>http://".$_SERVER['HTTP_HOST']."/pic/prod/".$prod->id.".jpg</picture> <name>".clear($prod->name)."</name> <vendor>".clear($prod->brandname)."</vendor> <description>".clear($prod->cont)."</description> </offer> ";
		}?>
				</offers>
			</shop>
		</yml_catalog>
<?		die();
	}

	if($args[1] == 'hotprice'){
		header('Content-type: text/xml; charset=windows-1251', true);
		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';?>
<price date="<?=date("Y-m-d H:i", time());?>">
<name><?=clear($sett['sitename'])?></name>

<currency code="UAH"></currency>

<catalog>
<?		foreach($cats as $k => $cat){
			if($cat->cat == 0){?>
	<category id="<?=$cat->id?>"><?=clear($cat->name)?></category>
<?			}else{?>
	<category id="<?=$cat->id?>" parentID="<?=$cat->cat?>"><?=clear($cat->name)?></category>
<?			}
		}?>
</catalog>

<items>
<?		foreach($prods as $prod){
?>
	<item id="<?=$prod->id?>">
	<name><?=clear($prod->name)?></name>
	<categoryId><?=$prod->cat?></categoryId>
	<price><?=$prod->price?></price>
	<bnprice><?=$prod->price?></bnprice>
	<url>http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?=$prod->id?></url>
	<image>http://<?=$_SERVER['HTTP_HOST']?>/pic/prod/<?=$prod->id?>.jpg</image>
	<vendor><?=clear($prod->brandname)?></vendor>
	<description><?=($prod->short) ? clear($prod->short) : "---"?></description>
	</item>
<?		}?>
</items>
</price>
<?		die();
	}
	
	if($args[1] == 'priceua' || $args[1] == 'freemarket'){
		header('Content-type: text/xml; charset=windows-1251', true);
		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';?>
<price date="<?=date("Y-m-d H:i", time());?>">
<name><?=clear($sett['sitename'])?></name>

<currency id="UAH" rate="1"></currency>

<catalog>
<?		foreach($cats as $k => $cat){
			if($cat->cat == 0){?>
	<category id="<?=$cat->id?>"><?=clear($cat->name)?></category>
<?			}else{?>
	<category id="<?=$cat->id?>" parentID="<?=$cat->cat?>"><?=clear($cat->name)?></category>
<?			}
		}?>
</catalog>

<items>
<?		foreach($prods as $prod){
?>
	<item id="<?=$prod->id?>">
	<name><?=clear($prod->name)?></name>
	<categoryId><?=$prod->cat?></categoryId>
	<price><?=$prod->price?></price>
	<bnprice><?=$prod->price?></bnprice>
	<url>http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?=$prod->id?></url>
	<image>http://<?=$_SERVER['HTTP_HOST']?>/pic/prod/<?=$prod->id?>.jpg</image>
	<vendor><?=clear($prod->brandname)?></vendor>
	<description><?=clear($prod->short)?></description>
	</item>
<?		}?>
</items>
</price>
<?	}elseif($args[1] == 'hotline'){
		header('Content-type: text/xml; charset=utf-8', true);
		echo '<?xml version="1.0" encoding="utf-8"'.'?'.'>';?>
<price>
    <date><?=date("Y-m-d H:i", time());?></date>
    <firmName><?=$sett['sitename']?></firmName>
    <firmId>1234</firmId>

<categories>
<?		foreach($cats as $k => $cat){?>
	<category>
		<id><?=$cat->id?></id>
		<name><?=htmlspecialchars($cat->name)?></name>
<?			if($cat->cat == 0){?>
<?			}else{?>
		<parentId><?=$cat->cat?></parentId>
<?			}?>
	</category>
<?		}?>
</categories>

<items>
<?		foreach($prods as $prod){
?>
	<item>
		<id><?=$prod->id?></id>
		<categoryId><?=$prod->cat?></categoryId>
<?/*		<code><?=$prod->intname?></code>*/?>
		<vendor><?=htmlspecialchars($prod->brandname)?></vendor>
		<name><?=htmlspecialchars($prod->name)?></name>
		<description><?=strip_tags(htmlspecialchars($prod->short))?></description>
		<url>http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?=$prod->id?></url>
		<image>http://<?=$_SERVER['HTTP_HOST']?>/pic/prod/<?=$prod->id?>.jpg</image>
		<priceRUAH><?=$prod->price?></priceRUAH>
	</item>
<?		}?>
</items>
</price>
<?	}elseif($args[1] == 'pn'){
		header('Content-type: text/xml; charset=utf-8', true);
		echo '<?xml version="1.0" encoding="utf-8"'.'?'.'>';?>
<price date="<?=date("Y-m-d H:i", time());?>">
<name><?=$sett['sitename']?></name>

<currency code="UAH" rate="1"></currency>

<catalog>
<?		foreach($cats as $k => $cat){
			if($cat->cat == 0){?>
	<category id="<?=$cat->id?>"><?=htmlspecialchars($cat->name)?></category>
<?			}else{?>
	<category id="<?=$cat->id?>" parentID="<?=$cat->cat?>"><?=htmlspecialchars($cat->name)?></category>
<?			}
		}?>
</catalog>

<items>
<?		foreach($prods as $prod){
?>
	<item id="<?=$prod->id?>">
	<name><?=htmlspecialchars($prod->name)?></name>
	<categoryId><?=$prod->cat?></categoryId>
	<price><?=$prod->price?></price>
	<bnprice><?=$prod->price?></bnprice>
	<url>http://<?=$_SERVER['HTTP_HOST']?>/catalog/prod-<?=$prod->id?></url>
	<image>http://<?=$_SERVER['HTTP_HOST']?>/pic/prod/<?=$prod->id?>.jpg</image>
	<vendor><?=htmlspecialchars($prod->brandname)?></vendor>
	<description><?=htmlspecialchars($prod->short)?></description>
	</item>
<?		}?>
</items>
</price>
<?	}elseif($args[1] == 'vcene'){
		header('Content-type: text/xml; charset=windows-1251', true);
		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';
		echo '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
?>
		<yml_catalog date="<?=date("Y-m-d H:i", time());?>">
			<shop>
				<name><?=clear($sett['sitename'])?></name>
				<company><?=clear($sett['sitename'])?></company>
				<url>http://<?=$_SERVER['HTTP_HOST']?></url>
				<platform>AS-Commerce</platform>
				<version>2.0</version>
				<currencies>
					<currency id="UAH" rate="1"/>
					<currency id="USD" rate="<?=$sett['course_usd']?>"/>
					<currency id="EUR" rate="<?=$sett['course_eur']?>"/>
					<currency id="RUR" rate="<?=$sett['course_rub']?>"/>
				</currencies>

				<categories>
<?
		foreach($cats as $k => $cat){?>
					<category id="<?=$cat->id?>" parentId="<?=$cat->cat?>"><?=clear($cat->name)?></category>
<?		}?>
				</categories>
				<offers>
<?		foreach($prods as $k => $prod){
?>
					<offer available="true" id="<?=$prod->id?>">
						<url>http://tesey.in.ua/catalog/prod-<?=$prod->id?></url>
						<price><?=$prod->price?></price>
						<currencyId>UAH</currencyId>
						<categoryId><?=$prod->cat?></categoryId>
						<picture>http://tesey.in.ua/pic/prod/<?=$prod->id?>.jpg</picture>
						<name><?=clear($prod->name)?></name>
						<vendor><?=c;ear($prod->brandname)?></vendor>
						<description><?=clear($prod->short)?></description>
					</offer>
<?		}?>
				</offers>
			</shop>
		</yml_catalog>
<?	}elseif($args[1] == 'yandex' || $args[1] == 'technoportal'){
		header('Content-type: text/xml; charset=windows-1251', true);
		echo '<?xml version="1.0" encoding="windows-1251"'.'?'.'>';
		echo '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">';
?>
		<yml_catalog date="<?=date("Y-m-d H:i", time());?>">
			<shop>
				<name><?=clear($sett['sitename'])?></name>
				<company><?=clear($sett['sitename'])?></company>
				<url>http://<?=$_SERVER['HTTP_HOST']?></url>
				<platform>AS-Commerce</platform>
				<version>2.0</version>
				<currencies>
					<currency id="UAH" rate="1"/>
<?/*					<currency id="USD" rate="<?=$sett['course_usd']?>"/>
					<currency id="EUR" rate="<?=$sett['course_eur']?>"/>
					<currency id="RUR" rate="<?=$sett['course_rub']?>"/>
*/?>
				</currencies>

				<categories>
<?
		foreach($cats as $k => $cat){?>
					<category id="<?=$cat->id?>" <?if($cat->id){?>parentId="<?=$cat->cat?>"<?}?>><?=iconv("UTF-8", "WINDOWS-1251", $cat->name)?></category>
<?		}?>
				</categories>
				<offers>
<?		foreach($prods as $k => $prod){
			echo "<offer id=\"".$prod->id."\" available=\"true\"> <url>http://".$_SERVER['HTTP_HOST']."/catalog/prod-".$prod->id."</url> <price>".$prod->price."</price> <currencyId>UAH</currencyId> <categoryId>".$prod->cat."</categoryId> <picture>http://".$_SERVER['HTTP_HOST']."/pic/prod/".$prod->id.".jpg</picture> <name>".clear($prod->name)."</name> <vendor>".clear($prod->brandname)."</vendor> <description>".clear($prod->short)."</description> </offer> ";
		}?>
				</offers>
			</shop>
		</yml_catalog>
<?	}?>