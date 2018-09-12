<?		foreach($this->articles as $k => $v){?>
    <div class="panel panel-smart">
        <div class="panel-heading">
            <h3 class="panel-title">
                <a href="<?=$this->url->mkd(array(1, $v->intname))?>"><?=$v->name?></a>
            </h3>
        </div>
        <div class="panel-body">
            <p>
                <strong><?echo date("d.m.Y.", $v->tstamp);?></strong> <?=mb_substr(strip_tags($v->cont), 0, 200, "UTF-8")."...";?>
            </p>
            <a href="<?=$this->url->mkd(array(1, $v->intname))?>" class="btn btn-black">
                <?=$this->labels['more']?>
            </a>
        </div>
    </div>

<?}?>


