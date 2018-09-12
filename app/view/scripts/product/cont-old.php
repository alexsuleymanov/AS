<?
$opt = Zend_Registry::get('opt');
$prod = $this->prod;
$Cat = new Model_Cat();

$wishlist_array = array();

$prodkey = 0;
foreach($this->Wishlist->wishlist as $k => $wishlist_item) {
    $wishlist_array[$k] = $wishlist_item['id'];
    if($wishlist_item['id'] == $prod->id) {
        $prodkey = $k;
    }
}
$iswish = in_array($this->prod->id, $wishlist_array);

?>

<!-- start sidebar -->
<div class="col-sm-4">
    <div class='carousel slide product-slider' data-ride='carousel' data-interval="false">
        <div class='carousel-inner'>
            <?if (file_exists('pic/prod/'.$this->prod->id.'.jpg')) {?>
                <div class='item active'>
                    <figure>
                        <img src='/thumb?src=pic/prod/<?= $this->prod->id ?>.jpg&amp;width=400&amp;height=520' alt='<?=$this->prod->name?>' />
                    </figure>
                </div><!-- end item -->
            <?}?>
            <?if(count($this->photos)) {?>
                <? foreach($this->photos as $k => $v) {?>
                    <div class='item'>
                        <figure>
                            <img src='/thumb?src=pic/photo/<?=$v->id?>.jpg&amp;width=400&amp;height=520' alt='<?=$v->name?>' />
                        </figure>
                    </div><!-- end item -->
                <?}?>
            <?}?>
            <!-- Arrows -->
            <a class='left carousel-control' href='.product-slider' data-slide='prev'>
                <span class='fa fa-angle-left'></span>
            </a>
            <a class='right carousel-control' href='.product-slider' data-slide='next'>
                <span class='fa fa-angle-right'></span>
            </a>
        </div><!-- end carousel-inner -->

        <!-- thumbs -->
        <ol class='carousel-indicators mCustomScrollbar meartlab'>
            <?if (file_exists('pic/prod/'.$this->prod->id.'.jpg')) {?>
                <li data-target='.product-slider' data-slide-to='0' class='active'><img src='/thumb?src=pic/prod/<?= $this->prod->id ?>.jpg&amp;width=400&amp;height=520' alt='<?=$this->prod->name?>' /></li>
            <?}?>
            <?if(count($this->photos)) {?>
                <?
                $p=1;
                foreach($this->photos as $k => $v) {?>
                    <li data-target='.product-slider' data-slide-to='<?=$p++?>'><img src='/thumb?src=pic/photo/<?=$v->id?>.jpg&amp;width=400&amp;height=520' alt='<?=$v->name?>' /></li>
                <?}?>
            <?}?>
        </ol><!-- end carousel-indicators -->
    </div><!-- end carousel -->
</div><!-- end col -->
<!-- end sidebar -->
<div class="col-sm-8">
    <div class="row">
        <div class="col-sm-12">
            <h2 class="title"><?=$this->prod->name?></h2>
            <p class="text-gray alt-font">Код товара: <?=$this->prod->id?></p>

        </div><!-- end col -->
    </div><!-- end row -->

    <hr class="spacer-5"><hr class="spacer-10 no-border">

    <div class="row">
        <div class="col-sm-12">
            <?=$prod->short?>

            <form action="/cart/buy" method="post" id="prodform_<?=$prod->id?>">
                <hr class="spacer-15">
                <div class="row">
                    <!--<div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="color">
                                <?
                    $Prodchar = new Model_Prodchar();
                    $prodchars = $Prodchar->getall(array('where' => '`char`=416 and prod='.$this->prod->id));
                    $Charval = new Model_Charval();

                    foreach($prodchars as $prodchar) {
                        $charvals = $Charval->getall(array('where' => '`char`=416 and id='.$prodchar->charval));
                        foreach($charvals as $charval) {?>
                                    <option value="<?=$charval->value?>"<?if($t++==0) {?> selected<?}?>><?=$charval->value?></option>
                                    <?}
                    }?>
                            </select>
                        </div><!-- end col -->
                    <div class="col-md-12 col-sm-12">
                        <ul class="list list-inline">
                            <?if($prod->skidka) {?>
                                <li><h6 class="text-danger text-xs"><?=ASweb\StdLib\Func::fmtmoney($this->prod->price)?></h6></li>
                            <?}?>
                            <li><h5 class="text-primary"><?=ASweb\StdLib\Func::fmtmoney($this->prod->price * (100 - $this->prod->skidka) / 100)." ".$this->sett["valuta"]?></h5></li>
                            <li><input type="text" name="num" value="1" class="form-control"></li>
                        </ul>
                    </div><!-- end col -->
                </div><!-- end row -->
                <hr class="spacer-15">

                <ul class="list list-inline">
                    <li>
                        <button type="button" class="btn btn-default btn-lg round" onclick="buy(<?=$prod->id?>); return false;">
                            <input type="hidden" name="id" value="<?=$prod->id?>" />
                            <input type="hidden" name="ajax" value="1" class="ajax" />
                            <input type="hidden" name="fromurl" value="<?=$_SERVER['REQUEST_URI'].$this->url->gvar(time()."=")?>" class="prod_id" />
                            <input type="hidden" name="color" id="prodcolor" value="<?=$firstcolor?>">
                            <span><i class="fa fa-shopping-cart"></i> <?=$this->labels['tocart']?></span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="btn btn-default btn-lg round" data-toggle="modal" data-target=".oneclick-modal">
                            <span><?=$this->labels['oneclick']?></span>
                        </button>
                    </li>
                    <?if(!$iswish) {?>
                        <li><button type="button" class="btn btn-gray btn-lg round active" onclick="wishlist(<?=$this->prod->id?>); location.reload();"><i class="fa fa-heart mr-5"></i>В список желаний</button></li>
                    <?} else {?>
                        <li><button type="button" class="btn btn-gray btn-lg round" onclick="wishlist_delete('<?=$prodkey?>'); location.reload();"><i class="fa fa-heart mr-5"></i>Удалить из желаний</button></li>
                    <?}?>
                </ul>
            </form>
        </div><!-- end col -->
    </div><!-- end row -->
</div><!-- end col -->

</div><!-- end row -->
</div><!-- end container -->
</section>

<!-- start section -->
<section class="section white-backgorund">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs style2 tabs-left" role="tablist">
                    <li role="presentation" class="active"><button href="#additional_info" aria-controls="tab" role="tab" data-toggle="tab" class="btn btn-default btn-lg round">Описание</button></li>
                    <?if($opt['prod_chars'] && !empty($this->prod_chars)){?>
                        <li role="presentation"><button href="#chars" aria-controls="profile" role="tab" data-toggle="tab" class="btn btn-default btn-lg round">Характеристики</button></li>
                    <?}?>
                    <?if(!empty(strip_tags($this->prod->cont2))){?>
                        <li role="presentation"><button href="#uploads" aria-controls="profile" role="tab" data-toggle="tab" class="btn btn-default btn-lg round">Загрузки</button></li>
                    <?}?>
                    <?/*if(!empty($this->childs)){?>
                        <li role="presentation"><a href="#childs" aria-controls="profile" role="tab" data-toggle="tab">С этим товаром покупают</a></li>
                    <?}?>
                    <?if(!empty($this->analogs)){?>
                        <li role="presentation"><a href="#analogs" aria-controls="profile" role="tab" data-toggle="tab">Похожие товары</a></li>
                    <?}*/?>
                </ul><!-- end nav-tabs -->
            </div><!-- end col -->
            <div class="col-xs-12 col-sm-9">
                <!-- Tab panes -->
                <div class="tab-content style2">
                    <div role="tabpanel" class="tab-pane fade in active" id="additional_info">
                        <?=$this->prod->cont?>
                    </div><!-- end tab-pane -->

                    <?if(!empty($this->prod_chars)){?>
                        <div role="tabpanel" class="tab-pane fade" id="chars">
                            <?if($opt['prod_chars']) echo $this->render("catalog/prod-chars.php");?>
                        </div><!-- end tab-pane -->
                    <?}?>

                    <?if(!empty(strip_tags($this->prod->cont2))){?>
                        <div role="tabpanel" class="tab-pane fade" id="uploads">
                            <?=$this->prod->cont2?>
                        </div><!-- end tab-pane -->
                    <?}?>
                </div><!-- end tab-content -->
            </div><!-- end col -->

            <div class="col-xs-12">
                <hr class="spacer-30">

                <?

                $Kit = new Model_Kit();
                $kits = $Kit->getall(array('where' => '`prod`='.$this->prod->id));
                $Prod = new Model_Prod();
                if(count($kits)) {
                    ?>
                    <!-- Latest Products Starts -->
                    <section class="product-carousel product-carousel-2">
                        <!-- Heading Starts -->
                        <h2 class="product-head">Вместе дешевле!</h2>
                        <!-- Heading Ends -->
                        <!-- Products Row Starts -->
                        <div class="row product-carousel-22">
                            <div class="col-xs-12">
                                <!-- Product Carousel Starts -->
                                <div id="owl-product-2" class="owl-carousel">
                                    <?foreach($kits as $kit) {
                                        $prod = $this->prod;
                                        $cat = $Cat->get($prod->cat);
                                        ?>
                                        <!-- Product # Starts -->
                                        <div class="item">
                                            <div class="product-col-2">
                                                <!-- Product Starts -->
                                                <div class="col-md-3 col-eq-height cat-col-w nopadding">
                                                    <div class="product-col cat-col nopadding">
                                                        <div class="image">
                                                            <a href="/catalog/<?=$cat->intname?>/<?=$prod->id?>">
                                                                <?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
                                                                    <img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&amp;width=244&amp;height=313&amp;crop=0" alt="<?=$prod->name?>" class="img-responsive img-center-sm" />
                                                                <?} else {?>
                                                                    <img src="<?=$this->path?>/img/product-images/14.jpg" alt="<?=$prod->name?>" class="img-responsive img-center-sm" />
                                                                <?}?>
                                                            </a>
                                                        </div>
                                                        <div class="caption caption-2">
                                                            <h4><a href="/catalog/<?=$cat->intname?>/<?=$prod->id?>"><?=$prod->name?></a></h4>
                                                            <div class="pl-icons">
                                                                <?if($prod->sale){?><div class="pl-sale">Скидка</div><?}?>
                                                                <?if($prod->pop){?><div class="pl-top">Хит продаж</div><?}?>
                                                                <?if($prod->new){?><div class="pl-new">Новинка</div><?}?>
                                                                <?if($prod->best){?><div class="pl-best">Лучшая цена</div><?}?>
                                                            </div>

                                                            <div class="price-old2">
                                                                &nbsp;
                                                            </div>
                                                            <div class="price">
                                                                <span class="price-new"><?=ASweb\StdLib\Func::fmtmoney($prod->price)." ".$this->sett["valuta"]?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Product Ends -->
                                                <div class="col-md-1">
                                                    <div class="pc-plus">
                                                        +
                                                    </div>
                                                </div>
                                                <?
                                                $prod = $Prod->get($kit->relation);
                                                $prodprice = $prod->price*(100-$kit->discount)/100;
                                                $price = $this->prod->price+$prod->price*(100-$kit->discount)/100;
                                                $cat = $Cat->get($prod->cat);
                                                ?>
                                                <!-- Product Starts -->
                                                <div class="col-md-3 col-eq-height cat-col-w nopadding">
                                                    <div class="product-col cat-col nopadding">
                                                        <div class="image">
                                                            <div class="pa kitproddiscount">
                                                                <span>- <?=$kit->discount?>%</span>
                                                            </div>
                                                            <a href="/catalog/<?=$cat->intname?>/<?=$prod->id?>">
                                                                <?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
                                                                    <img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&amp;width=244&amp;height=313&amp;crop=0" alt="<?=$prod->name?>" class="img-responsive img-center-sm" />
                                                                <?} else {?>
                                                                    <img src="<?=$this->path?>/img/product-images/14.jpg" alt="<?=$prod->name?>" class="img-responsive img-center-sm" />
                                                                <?}?>
                                                            </a>
                                                        </div>
                                                        <div class="caption caption-2">
                                                            <h4><a href="/catalog/<?=$cat->intname?>/<?=$prod->id?>"><?=$prod->name?></a></h4>
                                                            <div class="pl-icons">
                                                                <?if($prod->sale){?><div class="pl-sale">Скидка</div><?}?>
                                                                <?if($prod->pop){?><div class="pl-top">Хит продаж</div><?}?>
                                                                <?if($prod->new){?><div class="pl-new">Новинка</div><?}?>
                                                                <?if($prod->best){?><div class="pl-best">Лучшая цена</div><?}?>
                                                            </div>

                                                            <div class="price-old">
                                                                <span class="price-new"><?=ASweb\StdLib\Func::fmtmoney($prod->price)." ".$this->sett["valuta"]?></span>
                                                            </div>
                                                            <div class="price">
                                                                <span class="price-new"><?=ASweb\StdLib\Func::fmtmoney($prodprice)." ".$this->sett["valuta"]?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Product Ends -->

                                                <div class="col-md-1">
                                                    <div class="pc-plus">
                                                        =
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-eq-height cat-col-w nopadding">
                                                    <div class="pa kitproddiscount">
                                                        <span>Ваша выгода - <?=ASweb\StdLib\Func::fmtmoney($this->prod->price+$prod->price-$price)." ".$this->sett["valuta"]?></span>
                                                    </div>
                                                    <div class="product-col cat-col pc-plus-2">
                                                        <div class="price-old">
                                                            <span class="price-new"><?=ASweb\StdLib\Func::fmtmoney($prod->price+$this->prod->price)." ".$this->sett["valuta"]?></span>
                                                        </div>
                                                        <div class="price">
                                                            <span class="price-new"><?=ASweb\StdLib\Func::fmtmoney($price)." ".$this->sett["valuta"]?></span>
                                                        </div>
                                                        <div class="cart-button button-group">
                                                            <button type="button" class="btn btn-default btn-lg round" onclick="buykit(<?=$kit->id?>); return false;">
                                                                <form action="/cart/buykit" method="post" id="kitform_<?=$kit->id?>">
                                                                    <input type="hidden" name="kit" value="<?=$kit->id?>" />
                                                                    <input type="hidden" name="ajax" value="1" class="ajax" />
                                                                    <input type="hidden" name="fromurl" value="<?=$_SERVER['REQUEST_URI'].$this->url->gvar(time()."=")?>" class="prod_id" />
                                                                    <span><i class="fa fa-shopping-cart"></i> Купить комплект</span>
                                                                </form>
                                                            </button>


                                                        </div>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                        <!-- Product # Ends -->
                                    <?}?>
                                </div>
                                <!-- Product Carousel Ends -->
                            </div>
                        </div>
                        <!-- Products Row Ends -->
                    </section>
                    <!-- Latest Products Ends -->
                <?}?>

                <?if(!empty($this->childs)){?>
                    <hr class="spacer-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="mb-20">С этим товаром покупают</h4>
                        </div><!-- end col -->
                    </div><!-- end row -->
                    <?if($opt['prod_childs']) echo $this->render("catalog/prod-childs.php");?>
                <?}?>

                <?if(!empty($this->analogs)){?>
                    <hr class="spacer-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="mb-20">Похожие товары</h4>
                        </div><!-- end col -->
                    </div><!-- end row -->
                    <?if($opt['prod_analogs']) echo $this->render("catalog/prod-analog.php");?>
                <?}?>
            </div>





            <!-- Modal Product Quick View -->
            <div class="modal fade oneclick-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="oneclick-close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5>Введите Ваш телефон</h5>
                        </div><!-- end modal-header -->
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form action="/order/oneclick" method="get" id="oneclick-form">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="prid" id="oneclick-prid" value="<?=$this->prod->id?>">
                                            <input type="text" class="form-control" name="phone" id="oneclick-phone" value="">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-default btn-lg round"onclick="$('#oneclick-close').click(); $.get('/order/oneclick', $('#oneclick-form').serialize());" data-toggle="modal" data-target=".oneclick-modal-done">
                                                <span><?=$this->labels['submit']?></span>
                                            </button>
                                        </div>
                                    </form>
                                </div><!-- end col -->
                            </div><!-- end row -->
                        </div><!-- end modal-body -->
                    </div><!-- end modal-content -->
                </div><!-- end modal-dialog -->
            </div><!-- end productRewiew -->

            <!-- Modal Product Quick View -->
            <div class="modal fade oneclick-modal-done" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5><?=$this->labels["order_maked"]?></h5>
                        </div><!-- end modal-header -->
                    </div><!-- end modal-content -->
                </div><!-- end modal-dialog -->
            </div><!-- end productRewiew -->


