<?if(count($this->page->subpages)) {?>
<div class="lg-submenu">
<?foreach($this->page->subpages as $k => $v){?>
    <a href="<?=$this->url->mk("/".$v->intname)?>" class="list-group-item lgi-submenu">
        <i class="fa fa-chevron-right"></i>
        <?=$v->name?>
    </a>
<?	}?>
</div>
<?}?>