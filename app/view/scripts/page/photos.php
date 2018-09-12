<?if(count($this->page->photos)) {
    $i=0;?>
    <div class="carousel-inner">
        <?foreach($this->page->photos as $k => $v){?>
            <div class="item<?if($i++==0){?> active<?}?>">
                <img src="/pic/photo/<?=$v->id?>.jpg" alt="Slider" class="img-responsive img-center-xs" />
            </div>
        <?}?>
    </div>
<?}?>
