<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=($this->page->title) ? $this->page->title : $this->sett['sitename'].". ".$this->page->name?></title>
	<meta name="description" content="<?=$this->page->descr?>" />
	<meta name="keywords" content="<?=$this->page->kw?>" />
	<?	if(file_exists(dirname(__FILE__)."../favicon.ico")) {?>
	<link rel="Shortcut Icon" type="image/x-icon" href="/favicon.ico" />
	<?	}?>
	<link href="<?=$this->path?>/css/style.css" rel="stylesheet" type="text/css" />
	<link href="<?=$this->path?>/css/asform.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?=$this->path?>/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/niceacc/style.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?=$this->path?>/css/tabs/style.css" media="screen" />

	<script type="text/javascript" src="<?=$this->path?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?=$this->path?>/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="<?=$this->path?>/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<script type="text/javascript" src="<?=$this->path?>/js/jquery-ui.js"></script>

	<script type="text/javascript" src="<?=$this->path?>/js/autocomplete/lib/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="<?=$this->path?>/js/autocomplete/lib/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="<?=$this->path?>/js/autocomplete/lib/thickbox-compressed.js"></script>
	<script type="text/javascript" src="<?=$this->path?>/js/autocomplete/jquery.autocomplete.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=$this->path?>/js/autocomplete/jquery.autocomplete.css" />
	<link rel="stylesheet" type="text/css" href="<?=$this->path?>/js/autocomplete/lib/thickbox.css" />


	<script type="text/javascript">
		$(document).ready(function() {
			$("#cart #opencart").fancybox({
				'width'				: '75%',
				'height'			: '75%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});

			$('#gsearch').autocomplete('/search/hint/prod/href', {
				width: 500,
				height: 300,
				selectFirst: false
			});

		});


	</script>
	<?=$this->blocks['meta']?>
<?	if($this->canonical){?>
		<link rel="canonical" href="<?="https://".$_SERVER['HTTP_HOST'].$this->canonical?>"/>
<?	}?>
</head>
<body>

</body>
</html>
