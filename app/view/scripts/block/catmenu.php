<div class="list-group">
<?
    $cats = $this->model->Cat->getall(array("where" => "cat = ".$this->cat->id, "order" => "prior desc"));
    if(count($cats)) {
        ?>
        <!-- Categories Links Starts -->
        <div class="list-group categories">
            <a href="<?=$this->url->mk('/catalog')?>" class="list-group-item"><strong><?=$this->labels['cats']?></strong></a>
            <?
            foreach($cats as $k => $cat_r){
                $Subcats = $this->model->Cat->getall(array("where" => "cat = ".$cat_r->id." and visible = 1", "order" => "prior desc"));
                if(count($Subcats)) {?>
                    <!-- onclick="$('.cm-<?=$cat_r->id?>').toggle(); return false;"-->
                    <a href="<?=$this->url->mk('/catalog/'.$cat_r->intname)?>" class="list-group-item">
                        <i class="fa fa-chevron-right"></i>
                        <?=$cat_r->name?>
                    </a>
                <?} else {?>
                    <a href="<?=$this->url->mk('/catalog/'.$cat_r->intname)?>" class="list-group-item">
                        <i class="fa fa-chevron-right"></i>
                        <?=$cat_r->name?>
                    </a>
                <?}?>
            <?	}?>
        </div>
        <!-- Categories Links Ends -->
    <?}?>
</div>

