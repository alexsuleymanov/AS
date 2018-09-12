<!-- Categories Links Starts -->
<h6 class="subtitle text-uppercase">Статьи</h6>
<div class="list-group categories">
    <?	foreach($this->layout->articles as $k => $v) {?>
        <a href="/articles/<?=$v->intname?>" class="list-group-item">
            <i class="fa fa-chevron-right"></i>
            <?=$v->name?>
            <span><?=mb_substr(strip_tags($v->cont), 0, 200, "UTF-8")."...";?></span>
        </a>
    <?	}?>
</div>
<!-- Categories Links Ends -->