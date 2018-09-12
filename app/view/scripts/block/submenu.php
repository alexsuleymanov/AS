<?
$Page = new Model_Page('page');
$Menus = $Page->getall(array("where" => "page = '".$this->page->id."' and visible = 1", "order" => "prior desc"));
$i = 1;
if(count($Menus)) {?>
<div class="lg-submenu">
<?foreach($Menus as $k => $menu_r){?>
    <a href="<?=$this->url->mk("/".$menu_r->intname)?>" class="list-group-item lgi-submenu">
        <i class="fa fa-chevron-right"></i>
        <?=$menu_r->name?>
    </a>
<?	}?>
</div>
<?}?>