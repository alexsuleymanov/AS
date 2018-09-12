<?if(count($this->prod->photos)) {?>
    <? foreach($this->prod->photos as $k => $v) {?>
        <div class='item'>
            <figure>
                <img src='/thumb?src=pic/photo/<?=$v->id?>.jpg&amp;width=400&amp;height=520' alt='<?=$v->name?>' />
            </figure>
        </div><!-- end item -->
    <?}?>
<?}?>