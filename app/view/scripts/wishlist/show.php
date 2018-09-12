<?
$Prod = new Model_Prod();
$Cat = new Model_Cat();
?>
    <!-- Main Heading Ends -->
<? if ((is_array($this->Wishlist->wishlist)) && (count($this->Wishlist->wishlist))) { ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><?=$this->labels["photo"]?></th>
                        <th><?=$this->labels["title"]?></th>
                        <th><?=$this->labels['price']?></th>
                        <th colspan="2"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach ($this->Wishlist->wishlist as $k => $v) {
                        $prod = $Prod->get($v['id']);
                        $cat = $Cat->get($prod->cat);
                        ?>
                        <tr>
                            <td>
                                <a href="<?=$this->url->mk('/catalog/'.$cat->intname.'/'.$prod->id)?>">
                                    <img width="60px" src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&amp;width=400&amp;height=520" alt="<?=$prod->name?>">
                                </a>
                            </td>
                            <td>
                                <h6 class="regular"><a href="<?=$this->url->mk('/catalog/'.$cat->intname.'/'.$prod->id)?>"><?=$prod->name?></a></h6>
                                <p><?=$prod->short?></p>
                            </td>
                            <td>
                                <span><?=ASweb\StdLib\Func::fmtmoney($prod->price).$this->sett["valuta"]?></span>
                            </td>
                            <td>
                                <form action="/cart/buy" method="post" id="prodform_<?=$prod->id?>">
                                    <input type="hidden" name="id" value="<?=$prod->id?>" />
                                    <input type="hidden" name="ajax" value="1" class="ajax" />
                                    <input type="hidden" name="fromurl" value="<?=$_SERVER['REQUEST_URI'].$this->url->gvar(time()."=")?>" class="prod_id" />
                                    <a href="#" onclick="buy(<?=$prod->id?>); return false;" class="btn btn-default round btn-sm"><i class="fa fa-cart-plus mr-5"></i><?=$this->labels['tocart']?></a>
                                </form>
                            </td>
                            <td>
                                <button type="button" class="close" onclick="
                                    wishlist_delete('<?=$k?>');
                                    location.reload();
                                    ">×</button>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                </table><!-- end table -->
            </div><!-- end table-responsive -->
        </div><!-- end col -->
    </div><!-- end row -->
<? } ?>