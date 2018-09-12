<!-- Main Heading Starts -->
<h2 class="main-heading text-center">
    <?=array_pop($this->bc)?>
</h2>
<!-- Main Heading Ends -->
<!-- Shopping Cart Table Starts -->
<div class="table-responsive shopping-cart-table">
    <table class="table table-bordered">
        <form action="" method="post">
            <thead>
            <tr>
                <td class="text-center">#</td>
                <td class="text-center"><?=$this->labels["photo"]?></td>
                <td class="text-center"><?=$this->labels['title']?></td>
                <td class="text-center"><?=$this->labels['price']?></td>
                <td class="text-center">&nbsp;</td>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=++$n?></td>
                    <td><img src="/thumb?src=pic/prod/1.jpg&width=100" alt="" /></td>
                    <td><input type="hidden" name="id_<?=$k?>" value="<?=$v['id']?>">Название</td>
                    <td><?=($v['var']) ? ASweb\StdLib\Func::fmtmoney($prodvar->price).$this->sett["valuta"] : ASweb\StdLib\Func::fmtmoney($prod->price).$this->sett["valuta"];?></td>
                    <td><a href=""><button type="button" title="Удалить" class="btn btn-default tool-tip"><i class="fa fa-times-circle"></i></button></a></td>
                </tr>
                <tr>
                    <td><?=++$n?></td>
                    <td><img src="/thumb?src=pic/prod/1.jpg&width=100" alt="" /></td>
                    <td><input type="hidden" name="id_<?=$k?>" value="<?=$v['id']?>">Название</td>
                    <td><?=($v['var']) ? ASweb\StdLib\Func::fmtmoney($prodvar->price).$this->sett["valuta"] : ASweb\StdLib\Func::fmtmoney($prod->price).$this->sett["valuta"];?></td>
                    <td><a href=""><button type="button" title="Удалить" class="btn btn-default tool-tip"><i class="fa fa-times-circle"></i></button></a></td>
                </tr>
                <tr>
                    <td><?=++$n?></td>
                    <td><img src="/thumb?src=pic/prod/1.jpg&width=100" alt="" /></td>
                    <td><input type="hidden" name="id_<?=$k?>" value="<?=$v['id']?>">Название</td>
                    <td><?=($v['var']) ? ASweb\StdLib\Func::fmtmoney($prodvar->price).$this->sett["valuta"] : ASweb\StdLib\Func::fmtmoney($prod->price).$this->sett["valuta"];?></td>
                    <td><a href=""><button type="button" title="Удалить" class="btn btn-default tool-tip"><i class="fa fa-times-circle"></i></button></a></td>
                </tr>
            </tbody>
        </form>
    </table>
</div>
