<div class="col-sm-9">
    <h2 class="title"><?=($this->page->h1) ? $this->page->h1 : $this->page->name?></h2>
    <?	echo $this->page->cont?>
</div><!-- end col -->
<div class="col-sm-3">
    <?=$this->render('block/visited-prods.php')?>
</div><!-- end col -->