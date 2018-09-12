<?
$model_page = new Model_Page('page');
$Menus = $model_page->getall(array("where" => "page = 0 and visible = 1", "order" => "prior desc"));
?>
<div id="navbar-collapse-3" class="navbar-collapse collapse">
    <?
    $cat = 0 + $this->cat->id;
    $Cat = new Model_Cat();
    $cats = $Cat->getall(array("where" => "cat = 0", "order" => "prior desc"));
    if(count($cats)) {
        ?>
        <ul class="nav navbar-nav visible-xs">
            <li class="dropdown right">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                    <span class="hidden-sm"><?=$this->labels['cats']?></span><i class="fa fa-bars ml-5"></i>
                </a>
                <ul class="dropdown-menu">
                    <?
                    foreach($cats as $k => $cat_r){
                        $Subcats = $Cat->getall(array("where" => "cat = ".$cat_r->id." and visible = 1", "order" => "prior desc"));
                        if(count($Subcats)) {?>
                            <li class="dropdown-submenu"><a href="<?=$this->url->mk('/catalog/'.$cat_r->intname)?>" class="dropdown-toggle" data-toggle="dropdown"><?=$cat_r->name?></a>
                                <ul class="dropdown-menu">
                                    <?foreach($Subcats as $subcat_r) {?>
                                        <li><a href="<?=$this->url->mk('/catalog/'.$subcat_r->intname)?>"><?=$subcat_r->name?></a></li>
                                    <?}?>
                                </ul>
                            </li>
                        <?} else {?>
                            <li>
                                <a href="<?=$this->url->mk('/catalog/'.$cat_r->intname)?>">
                                    <?=$cat_r->name?>
                                </a>
                            </li>
                        <?}?>
                    <?	}?>
                </ul><!-- end ul dropdown-menu -->
            </li><!-- end dropdown -->
        </ul><!-- end navbar-right -->
    <?}?>
    <ul class="nav navbar-nav">
        <?	$i = 1;
        foreach($Menus as $k => $menu_r){
            $Submenus = $model_page->getall(array("where" => "page = ".$menu_r->id." and visible = 1", "order" => "prior desc"));
            if(count($Submenus)) {?>
                <li class="dropdown left">
                    <a href="<?=$this->url->mk("/".$menu_r->intname)?>" onclick="location.href='<?=$this->url->mk("/".$menu_r->intname)?>'" data-toggle="dropdown" class="dropdown-toggle"><?=$menu_r->name?><i class="fa fa-angle-down ml-5"></i></a>
                    <ul class="dropdown-menu">
                        <?foreach($Submenus as $k2 => $menu_r2){?>
                            <li><a href="<?=$this->url->mk("/".$menu_r2->intname)?>"><?=$menu_r2->name?></a></li>
                        <?}?>
                    </ul>
                </li>
            <?} else {?>
                <li><a href="<?=$this->url->mk("/".$menu_r->intname)?>"><?=$menu_r->name?></a></li>
            <?}?>
        <?	}?>
    </ul><!-- end navbar-nav -->
</div><!-- end navbar collapse -->
