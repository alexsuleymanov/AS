<?if(count($this->photos)) {?>
    <div class="owl-carousel slider owl-theme">
        <?foreach($this->photos as $k => $v){?>
            <div class="item">
                <figure>
                    <a href="javascript:void(0);">
                        <img src="/thumb?src=pic/photo/<?=$v->id?>.jpg&amp;width=1200&amp;height=600" alt=""/>
                    </a>
                </figure>
            </div><!-- end item -->
        <?}?>
    </div><!-- end owl carousel -->
<?}?>