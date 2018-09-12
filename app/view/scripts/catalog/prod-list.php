<?
$opt = Zend_Registry::get('opt');

$compare_count = $this->Compare->count($this->cat->id);
$compare_link = $this->Compare->url($this->cat->id);
$compare_array = $this->Compare->getall($this->cat->id);
if(!$compare_array) {
    $compare_array = array();
}

$wishlist_array = array();

foreach($this->Wishlist->wishlist as $k => $wishlist_item) {
    $wishlist_array[$k] = $wishlist_item['id'];
}

?>

<!-- start sidebar -->
<div class="col-sm-3">
    <div class="widget">
        <div class="pl-catmenu hidden-xs">
            <?=$this->render('block/catmenu.php')?>
        </div>
        <hr class="spacer-20 no-border hidden-xs">
        <?=$this->render('block/extsearch.php')?>
    </div><!-- end col -->
    <!-- end sidebar -->
</div>
<div class="col-sm-9">
    <h5 class="title"><?=$this->cat->name?></h5>
    <?=$this->render('catalog/subcat-list.php')?>
    <!-- Product Filter Starts -->
    <div class="product-filter">
        <div class="row">
            <div class="col-md-4">
                <div class="display">
                    <?if($compare_count) {?>
                        <a href="<?=$compare_link?>" title="<?=$this->labels['compare']?>">
                            <i class="fa fa-bar-chart-o"></i> <span class="comparecount">(<?=$compare_count?>)</span>
                        </a>
                    <?}?>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <label class="control-label"><?=$this->labels['sort']?></label>
            </div>
            <div class="col-md-4 text-right">
                <?=$this->render('catalog/sort.php')?>
            </div>
            <!--<div class="col-md-2 text-right">
                    <label class="control-label" for="input-limit"><?=$this->labels['show']?></label>
                </div>
                <div class="col-md-2 text-right">
                    <select id="input-limit" class="form-control" onchange="
                        switch(this.value) {
                        case '3': location.href='<?=$this->url->gvar("results=3")?>'; break;
                        case '9': location.href='<?=$this->url->gvar("results=9")?>'; break;
                        case '18': location.href='<?=$this->url->gvar("results=18")?>'; break;
                        }
                        ">
                        <option value="3"<?if($_SESSION['results']=='3') {?> selected="selected"<?}?>>3</option>
                        <option value="9"<?if($_SESSION['results']=='9') {?> selected="selected"<?}?>>9</option>
                        <option value="18"<?if($_SESSION['results']=='18') {?> selected="selected"<?}?>>18</option>
                    </select>
                </div>-->
        </div>
    </div>
    <!-- Product Filter Ends -->

    <!-- Product Grid Display Starts -->
    <div class="row row-eq-height">
        <?

        foreach($this->prods as $prod){
            $Cat = new Model_Cat();
            $cat = $Cat->getone(array("where" => "id = $prod->cat"));?>

            <div class="col-sm-6 col-md-4 product-item">
                <div class="thumbnail store style1">
                    <div class="header">
                        <div class="badges">
                            <?if($prod->sale) {?>
                                <span class="product-badge top left primary-background text-white semi-circle">Распродажа</span>
                            <?}?>
                            <?if($prod->new) {?>
                                <span class="product-badge bottom right info-background text-white semi-circle">Новинка</span>
                            <?}?>
                            <?if($prod->pop) {?>
                                <span class="product-badge bottom left warning-background text-white semi-circle">Популярный товар</span>
                            <?}?>
                            <?if($prod->discount) {?>
                                <span class="product-badge top right danger-background text-white semi-circle">-<?=$prod->discount?>%</span>
                            <?}?>
                        </div>
                        <figure class="layer">
                            <a href="/catalog/<?=$cat->intname?>/<?=$prod->intname?>">
                                <?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
                                    <img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&amp;width=400&amp;height=520&amp;crop=0" alt="">
                                <?} else {?>
                                    <img src="/thumb?src=pic/tr.gif&amp;width=400&amp;height=520&amp;crop=0" alt="">
                                <?}?>
                            </a>
                        </figure>
                        <!--<div class="icons">
                            <?$iswish = in_array($prod->id, $wishlist_array);?>
                            <a class="icon semi-circle<?if($iswish){?> active<?}?>" href="#" onclick="wishlist(<?=$prod->id?>); location.reload();"><i class="fa fa-heart<?if(!$iswish){?>-o<?}?>"></i></a>

                            <?$prod_compare = in_array($prod->id, $compare_array);?>
                            <a class="icon semi-circle<?if($prod_compare) {?> active<?}?>" href="#" <?if($prod_compare) {?>
                                onclick="
                                    compare_del(<?=$prod->cat?>, <?=$prod->id?>);
                                    $(this).removeClass('btn-active');
                                    var count = parseInt($(this).find('span').first().text())-1;
                                    $(this).find('span').first().text(count);
                                    location.reload();
                                    "
                            <?} else {?>
                                onclick="
                                    compare_add(<?=$prod->cat?>, <?=$prod->id?>);
                                    $(this).addClass('btn-active');
                                    var count = parseInt($(this).find('span').first().text())+1;
                                    $(this).find('span').first().text(count);
                                    location.reload();
                                    "
                            <?}?>><i class="fa fa-bar-chart-o"></i></a>
                        </div>-->
                    </div>
                    <div class="caption">
                        <h6 class="regular"><a href="/catalog/<?=$cat->intname?>/<?=$prod->intname?>"><?=$prod->name?></a></h6>
                        <div class="price">
                            <?if($prod->skidka) {?>
                                <small class="amount off"><?=ASweb\StdLib\Func::fmtmoney($prod->price)." ".$this->sett["valuta"]?></small>
                            <?}?>
                            <span class="amount text-primary"><?=ASweb\StdLib\Func::fmtmoney($prod->price * (100 - $prod->skidka) / 100)." ".$this->sett["valuta"]?></span>
                        </div>
                        <?if($prod->avail==1) {?>
                            <form action="/cart/buy" method="post" id="prodform_<?=$prod->id?>">
                                <button type="button" class="btn btn-default btn-lg round" onclick="buy(<?=$prod->id?>); return false;">
                                    <input type="hidden" name="id" value="<?=$prod->id?>" />
                                    <input type="hidden" name="ajax" value="1" class="ajax" />
                                    <input type="hidden" name="fromurl" value="<?=$_SERVER['REQUEST_URI'].$this->url->gvar(time()."=")?>" class="prod_id" />
                                    <!--<a href="#" onclick="buy(<?=$prod->id?>); return false;"><i class="fa fa-cart-plus mr-5"></i><?=$this->labels['tocart']?></a>-->
                                    <span><i class="fa fa-shopping-cart"></i> <?=$this->labels['tocart']?></span>
                                </button>
                            </form>
                        <?}?>
                    </div><!-- end caption -->
                </div><!-- end thumbnail -->
            </div><!-- end col -->
        <? }?>
    </div>
    <!-- Product Grid Display Ends -->
    <hr />
    <?if(!$_GET['all']) {?>
        <!-- Pagination & Results Starts -->
        <div class="row">
            <!-- Pagination Starts -->
            <div class="col-sm-12 pagination-block">
                <?=$this->render('block/rule.php');?>
            </div>
            <!-- Pagination Ends -->
        </div>
        <!-- Pagination & Results Ends -->
    <?}?>

    <!-- Category Intro Content Starts -->
    <div class="row">
        <div class="col-sm-12 cat-body">
            <p>&nbsp;</p>
            <?	echo $this->page->cont2;?>
        </div>
    </div>
    <!-- Category Intro Content Ends -->

</div><!-- end col -->