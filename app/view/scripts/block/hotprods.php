<?
$Prod = new Model_Prod();
$Cat = new Model_Cat();

$prods = $Prod->getall(array("where" => "visible = 1", "limit" => "35", "order" => "id desc"));
if($prods){
    ?>
    <div class="row">
        <div class="col-sm-12">
            <h6 class="ml-5 mb-20 text-uppercase"><?=$this->labels['hotprods']?></h6>
        </div><!-- end col -->
        <div class="col-sm-12">
            <div class="owl-carousel column-3 owl-theme product-item">
                <? foreach($prods as $prod){
                    $cat = $Cat->get($prod->cat);?>
                    <div class="item">
                        <div class="thumbnail store style1">
                            <div class="header">
                                <a href="/catalog/<?=$cat->intname?>/<?=$prod->intname?>">
                                    <?if(file_exists('pic/prod/'.$prod->id.'.jpg')) {?>
                                        <img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&amp;width=360&amp;height=468" alt="<?=$prod->name?>">
                                    <?} else {?>
                                        <img src="/thumb?src=<?=$this->path?>/img/tr.gif&amp;width=360&amp;height=468" alt="<?=$prod->name?>">
                                    <?}?>
                                </a>
                            </div>
                            <div class="caption">
                                <h6 class="regular"><a href="/catalog/<?=$cat->intname?>/<?=$prod->intname?>"><?=$prod->name?></a></h6>
                                <div class="price">
                                    <?if($prod->skidka) {?>
                                        <small class="amount off"><?=$prod->price?> <?=$this->sett['valuta']?></small>
                                    <?}?>
                                    <span class="amount text-primary"><?=$prod->price * (100 - $prod->skidka) / 100?> <?=$this->sett['valuta']?></span>
                                </div>
                                <?if($prod->avail==1) {?>
                                    <form action="/cart/buy" method="post" id="prodform_<?=$prod->id?>">
                                        <button type="button" class="btn btn-default btn-lg round" onclick="buy(<?=$prod->id?>); return false;">
                                            <input type="hidden" name="id" value="<?=$prod->id?>" />
                                            <input type="hidden" name="ajax" value="1" class="ajax" />
                                            <input type="hidden" name="fromurl" value="<?=$_SERVER['REQUEST_URI'].$this->url->gvar(time()."=")?>" class="prod_id" />
                                            <!--<a href="javascript:void(0);" onclick="buy(<?=$prod->id?>); return false;"><i class="fa fa-cart-plus mr-5"></i><?=$this->labels['tocart']?></a>-->
                                            <span><i class="fa fa-shopping-cart"></i> <?=$this->labels['tocart']?></span>
                                        </button>
                                    </form>
                                <?}?>
                            </div><!-- end caption -->
                        </div><!-- end thumbnail -->
                    </div><!-- end item -->
                <?	}?>
            </div><!-- end owl carousel -->
        </div><!-- end col -->
    </div><!-- end row -->
<?	}?>