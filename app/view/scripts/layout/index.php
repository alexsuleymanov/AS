<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=($this->page->title) ? $this->page->title : $this->sett['sitename'].". ".$this->page->name?></title>
    <meta name="description" content="<?=$this->page->descr?>" />
    <meta name="keywords" content="<?=$this->page->kw?>" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- css files -->
    <link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/owl.carousel.min.css" />
    <link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/owl.theme.default.min.css" />
    <link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/animate.css" />
    <link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/swiper.css" />

    <!-- this is default skin you can replace that with: dark.css, yellow.css, red.css ect -->
    <link id="pagestyle" rel="stylesheet" type="text/css" href="<?=$this->path?>/css/skin-blue.css" />

    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800&amp;subset=latin-ext" rel="stylesheet">

    <?=$this->blocks['meta']?>

    <?	if($this->canonical){?>
        <link rel="canonical" href="<?="https://".$_SERVER['HTTP_HOST'].$this->canonical?>"/>
    <?	}?>

    <?	if($this->noindex){?>
        <meta name="robots" content="noindex, follow" />
    <?	}?>

    <?		if($this->cnt && $this->results && $this->start > 0){
        if(strpos($_SERVER["REQUEST_URI"], "?")) $diff = 2;
        $str = substr($_SERVER["REQUEST_URI"], 1, strlen($_SERVER["REQUEST_URI"]) - strlen($_SERVER["QUERY_STRING"])-$diff);

        $prev = ($this->start-$this->results == 0) ? "" : $this->start-$this->results;?>
        <link rel="prev" href="/<?=$str.$this->url->gvar("start=".$prev)?>" />
    <?		}?>
    <?		if($this->cnt && $this->results && $this->start < ($this->cnt - $this->results)){
        if(strpos($_SERVER["REQUEST_URI"], "?")) $diff = 2;
        $str = substr($_SERVER["REQUEST_URI"], 1, strlen($_SERVER["REQUEST_URI"]) - strlen($_SERVER["QUERY_STRING"])-$diff);
        ?>
        <link rel="next" href="/<?=$str.$this->url->gvar("start=".($this->start+$this->results))?>" />
    <?		}?>

    <link href="<?=$this->path?>/css/asform.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/niceacc/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/tabs/style.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/comments.css" media="screen" />
    <link rel="stylesheet" href="<?=$this->path?>/js/sweetalert/sweet-alert.css" />
    <link rel="stylesheet" type="text/css" href="<?= $this->path ?>/js/autocomplete/jquery.autocomplete.css" />
    <link rel="stylesheet" type="text/css" href="<?= $this->path ?>/js/autocomplete/lib/thickbox.css" />
    <link href="<?=$this->path?>/css/custom.css" rel="stylesheet">

    <script type="text/javascript" src="<?=$this->path?>/js/jquery-3.1.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.1.js"></script>
    <script src="<?=$this->path?>/js/jquery-migrate-1.2.1.min.js"></script>
	
</head>
<body>

<!-- start topBar -->
<div class="topBar inverse">
    <div class="container">
        <ul class="list-inline pull-left hidden-sm visible-xs">
            <?=$this->render('block/search2.php') ?>
        </ul>
        <ul class="list-inline pull-left hidden-sm hidden-xs">
            <li class="tels"><?=$this->blocks['tels']?></li>
        </ul>

        <ul class="topBarNav pull-right">
            <li class="linkdown">
                <a href="javascript:void(0);">
                    <i class="fa fa-user mr-5"></i>
                            <span class="hidden-xs">
                                <?if(!ASweb\Auth\Auth::is_auth()) {?>Кабинет<?} else { echo $_SESSION['username'];}?>
                                <i class="fa fa-angle-down ml-5"></i>
                            </span>
                </a>
                <ul class="w-150">
                    <?if(!ASweb\Auth\Auth::is_auth()) {?>
                        <li><a href="/user/login">Вход</a></li>
                        <li><a href="/user/register">Регистрация</a></li>
                    <?} else {?>
                        <li><a href="/user">Мой кабинет</a></li>
                        <li><a href="/wishlist">Список желаний</a></li>
                        <li><a href="/user/logoff">Выход</a></li>
                    <?}?>
                </ul>
            </li>
            <li class="linkdown">
                <?= $this->render('cart/block.php') ?>
            </li>
        </ul>
    </div><!-- end container -->
</div>
<!-- end topBar -->

<div class="middleBar hidden-xs">
    <div class="container">
        <div class="row display-table">
            <div class="col-sm-3 vertical-align text-left hidden-xs">
                <a href="<?=$this->url->mk('/')?>">
                    <img width="160" src="<?=$this->path?>/img/logo.png" alt="" />
                </a>
            </div><!-- end col -->
            <div class="col-sm-7 vertical-align text-center hidden-xs">
                <?=$this->render('block/search.php') ?>
            </div><!-- end col -->
            <div class="col-sm-2 vertical-align header-items hidden-xs">
                <div class="header-item mr-5">
                    <a href="<?=$this->url->mk('/wishlist')?>" data-toggle="tooltip" data-placement="top" title="Wishlist">
                        <i class="fa fa-heart-o"></i>
                        <sub><?=0+count($this->Wishlist->wishlist)?></sub>
                    </a>
                </div>
                <div class="header-item">
                    <a href="<? if($this->cat->id) echo $this->Compare->url($this->cat->id); else echo '#'?>" data-toggle="tooltip" data-placement="top" title="Compare">
                        <i class="fa fa-refresh"></i>
                        <sub><?$compare_count = $this->Compare->count($this->cat->id); echo 0+$compare_count?></sub>
                    </a>
                </div>
            </div><!-- end col -->
        </div><!-- end  row -->
    </div><!-- end container -->
</div><!-- end middleBar -->

<!-- start navbar -->
<div class="navbar yamm navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target="#navbar-collapse-3" class="navbar-toggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="<?=$this->url->mk('/')?>" class="navbar-brand visible-xs">
                <img src="<?=$this->path?>/img/logo.png" alt="logo">
            </a>
        </div>
        <?=$this->render('block/menu.php')?>
    </div><!-- end container -->
</div><!-- end navbar -->

<?if($this->args[0]!='') {?>
    <?=$this->render('block/breadcrumbs.php')?>
<?}?>

<!-- start section -->
<section class="section <?=($this->args[0]=='')?'light':'white' ?>-backgorund">
    <div class="container">
        <div class="row" id="cont">
            <?if($this->args[0]=='') {?>
                <?=$this->render('layout/block/main.php')?>
            <?} elseif($this->args[0]=='contacts') {?>
                <?=$this->render('layout/block/contact.php')?>
            <?} elseif(($this->args[0]=='catalog')||($this->args[0]=='user')) {?>
                <?	echo $this->page->cont?>
            <?} elseif(($this->args[0]=='compare')||($this->args[0]=='wishlist')||($this->args[0]=='cart')||($this->args[0]=='order')) {?>
                <h2 class="title"><?=($this->page->h1) ? $this->page->h1 : $this->page->name?></h2>
                <?	echo $this->page->cont?>
            <?} elseif($this->page404) {?>
                <?=$this->render('layout/block/404.php')?>
            <?} else {?>
                <?=$this->render('layout/block/static.php')?>
            <?}?>
        </div><!-- end row -->
    </div><!-- end container -->
</section>
<!-- end section -->

<?if($this->args[0]=='contacts') {?>
    <!-- start section -->
    <section class="light-background">
        <div class="container-fluid">
            <div class="row grid-space-0">
                <div class="col-sm-12">
                    <div class="map" id="map"></div>
                </div><!-- end col -->
            </div><!-- end row -->
        </div><!-- end container -->
    </section>
    <!-- end section -->
<?}?>

<!-- start footer -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <h5 class="title"><?=$this->labels['contacts']?></h5>
                <?=$this->blocks['footcontacts']?>
            </div><!-- end col -->
            <div class="col-sm-3 hidden-xs">
                <h5 class="title"><?=$this->labels['info']?></h5>
                <ul class="list alt-list">
                    <?	$model_page = new Model_Page('page');
                    $Menus = $model_page->getall(array("select" => "id, intname, name", "where" => "page = 0 and visible = 1", "order" => "prior desc", "limit" => "4"));
                    foreach($Menus as $k => $menu_r) {?>
                        <li><a href="<?=$this->url->mk("/".$menu_r->intname)?>"><i class="fa fa-angle-right"></i><?=$menu_r->name?></a></li>
                    <?}?>
                </ul>
            </div><!-- end col -->
            <div class="col-sm-3 hidden-xs">
                <h5 class="title"><?=$this->labels['cats']?></h5>
                <ul class="list alt-list">
                    <?
                    $Cat = new Model_Cat();
                    $cats = $Cat->getall(array("select" => "id, intname, name", "where" => "cat = 0", "order" => "prior desc", "limit" => 4));
                    foreach($cats as $cat) {
                        ?>
                        <li><a href="<?=$this->url->mk('/catalog/'.$cat->intname)?>"><i class="fa fa-angle-right"></i><?=$cat->name?></a></li>
                    <?}?>
                </ul>
            </div><!-- end col -->
            <div class="col-sm-3">
                <h5 class="title hidden-xs">Следите за нами</h5>
                <div class="form-group hidden-xs">
<?//                    <input type="text" id="email" class="form-control input-sm" placeholder="E-mail">*/?>
                </div>
<?/*                <div class="form-group hidden-xs">
                    <input type="submit" class="btn btn-default btn-block round btn-sm" value="Subscribe">
                </div>*/?>
                <ul class="social-icons style2">
                    <li class="facebook"><a class="semi-circle" href="https://www.facebook.com/groups/187122928392924/" target="_blank"><i class="fa fa-facebook"></i></a></li>
<?/*                    <li class="twitter"><a class="semi-circle" href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                    <li class="dribbble"><a class="semi-circle" href="javascript:void(0);"><i class="fa fa-dribbble"></i></a></li>
                    <li class="linkedin"><a class="semi-circle" href="javascript:void(0);"><i class="fa fa-linkedin"></i></a></li>*/?>
                </ul>
            </div><!-- end col -->
        </div><!-- end row -->

        <hr class="spacer-30 hidden-xs">

        <div class="row hidden-xs">
            <div class="col-sm-6 text-left">
                <p class="text-sm"><?=$this->blocks['copy']?></p>
            </div><!-- end col -->
            <div class="col-sm-6 text-right">
                <ul class="list list-inline">
                    <li class="text-white">Сдеано в <a href="http://asweb.com.ua">ASweb</a></li>
                </ul>
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</footer>
<!-- end footer -->


<!-- JavaScript Files -->

<script type="text/javascript" src="<?=$this->path?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=$this->path?>/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="<?=$this->path?>/js/jquery.downCount.js"></script>
<script type="text/javascript" src="<?=$this->path?>/js/nouislider.min.js"></script>
<script type="text/javascript" src="<?=$this->path?>/js/jquery.sticky.js"></script>
<script type="text/javascript" src="<?=$this->path?>/js/pace.min.js"></script>
<script type="text/javascript" src="<?=$this->path?>/js/star-rating.min.js"></script>
<script type="text/javascript" src="<?=$this->path?>/js/wow.min.js"></script>
<?if($this->args[0]=='contact') {?>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqvvx0F0ACM0IGVijI9pzUMrnTgkyAruk&callback=initMap"
            type="text/javascript"></script>
    <script src="<?=$this->path?>/js/map.js"></script>
<?}?>
<script type="text/javascript" src="<?=$this->path?>/js/swiper.min.js"></script>
<script type="text/javascript" src="<?=$this->path?>/js/main.js"></script>

<script src="<?=$this->path?>/js/sweetalert/sweet-alert.min.js"></script>
<script type="text/javascript" src="<?= $this->path ?>/js/autocomplete/lib/jquery.bgiframe.min.js"></script>
<script type="text/javascript" src="<?= $this->path ?>/js/autocomplete/lib/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="<?= $this->path ?>/js/autocomplete/lib/thickbox-compressed.js"></script>
<script type="text/javascript" src="<?= $this->path ?>/js/autocomplete/jquery.autocomplete.js"></script>

<script src="<?=$this->path?>/js/custom.js"></script>
<script src="<?=$this->path?>/js/cart.js"></script>

</body>
</html>