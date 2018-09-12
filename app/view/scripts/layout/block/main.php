<div class="col-sm-4 col-md-3 hidden-xs">
    <?=$this->render('block/catmenu.php')?>
    <?=$this->render('news/block.php')?>
    <?=$this->render('articles/block.php')?>
</div><!-- end col -->
<div class="col-sm-8 col-md-9">

    <?
    $Action = new Model_Page('actions');
    $actions = $Action->getall(array('where' => 'visible=1', 'order' => 'prior desc'));
    if(count($actions)) {?>

        <!-- start section -->
        <section class="section light-backgorund main-actions">
            <div>
                <div id="carousel-example-generic" class="carousel home-slide" data-interval="false" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <?
                        $i=0;
                        foreach($actions as $action) {?>
                            <li data-target="#carousel-example-generic" data-slide-to="<?=$i++?>"<?if($i==1) {?> class="active"<?}?>></li>
                        <?}?>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <?
                        $i=0;
                        foreach($actions as $action) {?>
                            <div class="item<?if($i++==0) {?> active<?}?>" style="background-image: url(/pic/actions/<?=$action->id?>.jpg)">
                                <div class="item-inner">
                                    <div class="carousel-caption">
                                        <h3 class="text-white"><?=$action->name?></h3>
                                        <p class="lead"><?=$action->short?></p>

                                        <hr class="spacer-10 no-border"/>

                                        <a href="<?=$this->url->mk('/actions/'.$action->intname)?>" class="btn btn-default semi-circle"><?=$this->labels['more']?></a>
                                    </div><!-- end carousel-caption -->
                                </div><!-- end item-inner -->
                            </div><!-- end item -->
                        <?}?>
                    </div><!-- end carousel-inner -->
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div><!-- end carousel -->
            </div><!-- end container -->
        </section>
        <!-- end section -->

    <?}?>


    <?/*if($this->args[0]=='') {?>
        <div class="row">
            <div class="col-sm-12">
                <?=$this->render('photos/list.php')?>
            </div><!-- end col -->
        </div><!-- end row -->

    <?}*/?>

    <hr class="spacer-20 no-border">

    <?=$this->render('block/hotprods.php')?>

    <?=$this->render('block/newprods.php')?>

    <h2 class="title"><?=($this->page->h1) ? $this->page->h1 : $this->page->name?></h2>
    <?	echo $this->page->cont?>
</div><!-- end col -->