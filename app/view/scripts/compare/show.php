<!-- Compare Table Starts -->
<div class="table-responsive compare-table">
    <table class="table table-striped">
        <tr>
            <td></td>
            <?		foreach($this->prods as $k => $prod){?>
            <td>
                <img src="/thumb?src=pic/prod/<?=$prod->id?>.jpg&amp;width=100&amp;height=120" alt="<?=$prod->name?>" title="<?=$prod->name?>" class="img-thumbnail" />
                <br><br>
                <a href="/compare/del/<?=$prod->cat?>/<?=$prod->id?>"><button type="button" title="Удалить" class="btn btn-default tool-tip"><i class="fa fa-times-circle"></i></button></a>
                <br><br>
                <p><?=$prod->price?> <?=$this->sett['valuta']?></p>
            </td>
            <?		}?>
        </tr>
        <?		foreach($this->chars as $k => $cv){?>
        <tr>
            <td><?=$cv->name?></td>
            <?			foreach($this->prods as $k => $prod){?>
            <td>
                <?					if($cv->type == 4){
                    echo $this->prod_chars[$prod->id][$cv->id]->value." ".$this->prod_chars[$prod->id][$cv->id]->izm;
                }elseif($cv->type == 2){
                    echo $this->prod_chars[$prod->id][$cv->id]->text." ".$this->prod_chars[$prod->id][$cv->id]->izm;
                }elseif($cv->type == 1){
                    echo ($this->prod_chars[$prod->id][$cv->id]->text) ? $this->labels["yes"]: $this->labels["no"];
                }?>
            </td>
            <?			}?>
        </tr>
        <?			}?>
    </table>
</div>
<!-- Compare Table Ends -->