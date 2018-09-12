<?
use ASweb\StdLib\Func;

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
    if ($v[num] < 1) $this->Cart->cart[$k][num] = 1;?>
<!-- Main Heading Ends -->
<?	echo $this->page->cont;?>
<!-- Shopping Cart Table Starts -->
<?//print_r($this->Cart->cart);?>
<form action="/cart/update" method="post" id="cartform">
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?=$this->labels["photo"]?></th>
                        <th><?=$this->labels["title"]?></th>
                        <th><?=$this->labels['price']?></th>
                        <th><?=$this->labels['quantity']?></th>
                        <th colspan="2"><?=$this->labels['total_price']?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?	$n = $sum = 0;
                    $Prod = new Model_Prod();
                    $Cat = new Model_Cat();
                    foreach($this->Cart->cart as $k => $v) {						
                        $prod = $Prod->get($v['id']);
						$cat = $Cat->get($prod->cat);
						
                        $title = "<a href=\"/catalog/".$cat->intname."/".$prod->intname."\" target=\"_blank\">".$prod->name."</a>";

                        if($v['var']){
                            $ProdVar = new Model_Prodvar();
                            $prodvar = $ProdVar->get($v['var']);
                            $title .= "<br>(".$prodvar->name.")";
                        }

                        $sum += $v['price'] * $v['num'];
                        if($discount) $sum2 = $sum - ($sum * $discount) / 100;
                        else $sum2 = $sum;
                        ?>
                        <tr>
                            <td>
                                <a href="<?=$this->url->mk('/catalog/prod-'.$prod->id)?>">
                                    <img width="60px" src="/pic/prod/<?=$v['id']?>.jpg" alt="<?=$prod->name?>">
                                </a>
                            </td>
                            <td>
                                <h6 class="regular"><a href="<?=$this->url->mk('/catalog/'.$cat->intname.'/'.$prod->intname)?>"><input type="hidden" name="id_<?=$k?>" value="<?=$v['id']?>"><?=$title?></a></h6>
                                <p><?=$prod->short?></p>
                            </td>
                            <td>
                                <span><?=($v['baseprice'] != $v['price']) ? "<s>".ASweb\StdLib\Func::fmtmoney($v['baseprice'])."</s> ".ASweb\StdLib\Func::fmtmoney($v['price']).$this->sett["valuta"] : ASweb\StdLib\Func::fmtmoney($v['price']).$this->sett["valuta"];?></span>
                            </td>
                            <td class="ce-count">
                                <div class="row">
                                    <div class="col-xs-3 nopadding tac">
                                        <input type="button" class="cart_num_minus btn btn-black btn-pm" id="cart_num_minus_<?=$k?>" value="-" onclick="plus_minus_cart_num('minus', '<?=$k?>')"/>
                                    </div>
                                    <div class="col-xs-4 nopadding tac">
                                        <input type="text" name="num_<?=$k?>" value="<?=$v['num']?>" size=2 class="inp form-control cart_num tac" id="cart_num_<?=$k?>" onchange="change_cart_num('<?=$k?>')">
                                    </div>
                                    <div class="col-xs-3 nopadding tac">
                                        <input type="button" id="cart_num_plus_<?=$k?>" class="cart_num_plus btn btn-black btn-pm" value="+" onclick="plus_minus_cart_num('plus', '<?=$k?>')"/>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-primary"><span id="cart_sum_<?=$k?>"><?=ASweb\StdLib\Func::fmtmoney($v['price'] * $v['num'])?></span> <?=$this->sett["valuta"]?></span>
                            </td>
                            <td>
                                <button type="button" class="close" onclick="location.href='/cart/delete/<?=$k?>'">×</button>
                            </td>
                        </tr>
                    <?	}?>
                    </tbody>
                </table><!-- end table -->
                <p align="right" style="font-weight:bold;">
                    <?if($discount) echo $this->labels["discount"].": ".$discount."%<br />";?>
                <div class="but btn btn-danger pull-right"><?=$this->labels["to_pay"]?>: <span class="cart_amount"><?=ASweb\StdLib\Func::fmtmoney($sum2)?></span><?=$this->sett['valuta']?> </div>
                </p>
            </div><!-- end table-responsive -->

            <hr class="spacer-10 no-border">

            <a href="<?=$this->url->mk('/')?>" onclick="$('#cartform').submit()" class="btn btn-light semi-circle btn-md pull-left">
                <i class="fa fa-arrow-left mr-5"></i> <?=$this->labels["back_to_catalog"]?>
            </a>

            <a href="<?=$this->url->mk('/order')?>" onclick="window.parent.location.href='/order';" class="btn btn-default semi-circle btn-md pull-right">
                <?=$this->labels["make_order"]?> <i class="fa fa-arrow-right ml-5"></i>
            </a>
        </div><!-- end col -->
    </div><!-- end row -->
</form>
