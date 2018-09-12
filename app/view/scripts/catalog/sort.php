<?	$desc_asc = ($_GET['desc_asc'] == 'desc') ? 'asc' : 'desc';?>
<select class="form-control" onchange="
    switch(this.value) {
    case 'name': location.href='<?=$this->url->gvar("order=name&desc_asc=".$desc_asc)?>'; break;
    case 'prior': location.href='<?=$this->url->gvar("order=prior&desc_asc=".$desc_asc)?>'; break;
    case 'price': location.href='<?=$this->url->gvar("order=price&desc_asc=".$desc_asc)?>'; break;
    }
    ">
    <option value="name"<?if($_GET['order'] == 'name') {?> selected="selected"<?}?>>по алфавиту</option>
    <option value="prior"<?if($_GET['order'] == 'prior') {?> selected="selected"<?}?>>по популярности</option>
    <option value="price"<?if($_GET['order'] == 'price') {?> selected="selected"<?}?>>по цене</option>
</select>