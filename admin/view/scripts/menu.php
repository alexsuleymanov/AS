<?
	$adms = array(
		"Сайт" => array(
			"sett" => array(
				"icon" => "fa-list",
			),
			"Страницы" => array(
				"url" => "adm_page.php",
				"comment" => "Страницы главного меню, подменю и скрытые страницы",				
			),
			"Новости" => array(
				"url" => "adm_news.php",
				"comment" => "Новостная лента сайта",
				"opt" => "news",
			),
			"Статьи (Блог)" => array(
				"url" => "adm_articles.php",
				"comment" => "Полезные статьи. Для людей и для раскрутки сайта",
				"opt" => "articles",
			),
			"Акции" => array(
				"url" => "adm_actions.php",
				"comment" => "Управление акциями",
				"opt" => "actions",
			),
/*			"Вакансии" => array(
				"url" => "adm_vacancy.php",
				"comment" => "Вакансии. Список вакансий компании",
				"opt" => "vacancy",
			),*/
		),
		
		"Фото" => array(
			"sett" => array(
				"icon" => "fa-photo",
			),
			"Категории" => array(
				"url" => "adm_photocat.php",
			),
			"Фото" => array(
				"url" => "adm_photo.php?type=photocat",
			),
		),

		"Каталог" => array(
  			"sett" => array(
				"icon" => "fa-th",
			),
			"Бренды" => array(
				"url" => "adm_brand.php",
				"comment" => "Редактирование списка брендов для каталога товаров",
				"opt" => "prod_brands",
			),
			"Категории" => array(
				"url" => "adm_cat.php",
				"comment" => "Редактирование товаров по категориям",
				"opt" => "prod_cats",
			),
			"Товары" => array(
				"url" => "adm_prod.php",
				"comment" => "Список всех товаров и их свойств",
				"opt" => "prods",
			),
			"Характеристики" => array(
				"url" => "adm_char.php",
				"comment" => "Общие характеристики для всех категорий товаров",
				"opt" => "prod_chars",
			),			
			"Цвета" => array(
				"url" => "adm_color.php",
				"comment" => "Список цветов",
				"opt" => "prod_colors",
			),			
			"Теги" => array(
				"url" => "adm_tags.php",
				"comment" => "Управление облаком тегов. Список тегов",
				"opt" => "prod_tags",
			),
			"Импорт товаров" => array(
				"url" => "adm_import.php",
				"comment" => "Импорт из XML, XLS",
				"opt" => "prod_brands",
			),
			"Экспорт товаров" => array(
				"url" => "adm_export.php",
				"comment" => "Экспорт товаров в прайс-агрегаторы",
				"opt" => "prod_export",
			),
		),

		"Управление клиентами" => array(
			"sett" => array(
				"icon" => "fa-user",
			),
			"Клиенты" => array(
				"url" => "adm_user.php?type=client",
				"comment" => "Зарегистрированные клиенты сайта",
				"opt" => "billing",
			),
/*			"Менеджеры" => array(
				"url" => "adm_user.php?type=manager",
				"comment" => "Зарегистрированные менеджеры сайта",
				"opt" => "managers",
			),*/
			"Заказы" => array(
				"url" => "adm_order.php",
				"comment" => "Список заказов всех клиентов",
				"opt" => "billing",
			),
/*			"Накопительные скидки" => array(
				"url" => "adm_discount.php?type=accum",
				"comment" => "Управление системой скидок. Размер скидки, размер накоплений для получения скидки",
				"opt" => "discounts",
			),*/
/*			"Статистика" => array(
				"url" => "adm_stat.php",
				"comment" => "AS-Stat",
			),*/
		),

		"Системы оплаты и доставки" => array(
			"sett" => array(
				"icon" => "fa-money",
			),
			"Способы оплаты" => array(
				"url" => "adm_esystem.php",
				"comment" => "Редактирование автоматических и неавтоматических способов оплаты",
				"opt" => "billing",
			),
			"Способы доставки" => array(
				"url" => "adm_delivery.php",
				"comment" => "Редактирование способов доставки. Описания, цена доставки",
				"opt" => "billing",
			),
		),

		
		"Почта" => array(
			"sett" => array(
				"icon" => "fa-envelope-o",
			),
			"Рассылка" => array(
				"url" => "adm_distrib.php",
				"comment" => "Система рассылки",
				"opt" => "distrib",
			),
			"Шаблоны писем" => array(
				"url" => "adm_template.php?type=mail",
				"comment" => "Редактирование шаблонов писем",
			),
			"Настройки" => array(
				"url" => "adm_sett.php?type=mail",
				"comment" => "Основные настройки сайта",
			),
		),

		"Блоки" => array(
			"sett" => array(
				"icon" => "fa-th-large",
			),
			"Баннеры" => array(
				"url" => "adm_banner.php",
				"comment" => "Система баннеров. Добавляйте все баннеры через эту систему.",
				"opt" => "banners",
			),
			"Блоки" => array(
				"url" => "adm_block.php",
				"comment" => "Редактирование блоков на сайте",
			),
			"Блоки HTML" => array(
				"url" => "adm_block.php?html=1",
				"comment" => "Редактирование блоков на сайте",
			),
/*			"Голосование" => array(
				"url" => "adm_vote.php",
				"comment" => "Редактирование списка вопросов и ответов. Результаты голосования",
				"opt" => "vote",
			),*/
		),


		"SEO модули" => array(
			"sett" => array(
				"icon" => "fa-search",
			),
			"Генерация sitemap.xml" => array(
				"url" => "adm_sitemap.php",
				"comment" => "sitemap для вебмастерской",
				"opt" => "sitemap",
			),
			"Шаблоны мета-тегов" => array(
				"url" => "adm_template.php?type=meta",
				"comment" => "sitemap для вебмастерской",
			),
			"Настройки" => array(
				"url" => "adm_sett.php?type=seo",
				"comment" => "Основные настройки сайта",
			),
			"Блоки" => array(
				"url" => "adm_block.php?html=1&type=seo",
				"comment" => "Редактирование блоков на сайте",
			),
		),

		"Языки" => array(
			"sett" => array(
				"icon" => "fa-language",
			),
			"Языки" => array(
				"url" => "adm_lang.php",
				"comment" => "Языки сайта. Добавление, удаление, редактирование языков",
				"opt" => "billing",
			),
			"Надписи" => array(
				"url" => "adm_labels.php",
				"comment" => "Редактирование надписей на сайте",
			),
		),

		"Настройки" => array(
			"sett" => array(
				"icon" => "fa-gears",
			),
/*			"Валюты" => array(
				"url" => "adm_currency.php",
				"comment" => "Редактирование блоков на сайте",
				"opt" => "currencies",
			),*/
			"Системные настройки" => array(
				"url" => "adm_sett.php?type=system",
				"comment" => "Основные настройки сайта",
			),
			"Администраторы" => array(
				"url" => "adm_admins.php",
				"comment" => "Изменение логина и пароля администратора, создание новых пользователей",
			),
		),
	);

	$opt = Zend_Registry::get('opt');	
?>
					<ul class="nav" id="side-menu">
                        <li class="sidebar-search">
							<form action="" method="GET">
                            <div class="input-group custom-search-form">								
								<input type="text" name="q" class="form-control" value="<?=($_GET['q']) ? $_GET['q'] : ""?>" placeholder="Search...">
								<span class="input-group-btn">
								<button class="btn btn-default" type="submit">
									<i class="fa fa-search"></i>
								</button>
<?	if ($_GET['q']) {?>									
								<button class="btn btn-danger" type="button" onclick="location.href = '<?=$this->url->page.$this->url->gvar("q=")?>'">
									<i class="fa fa-times"></i>
								</button>
<?	}?>									
                            </span>
                            </div>
							</form>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Стартовая страница</a>
                        </li>

<?	foreach($adms as $k => $v) {?>
						<li>
                            <a href="#"><i class="fa <?=$v['sett']['icon']?> fa-fw"></i> <?=$k?><span class="fa arrow"></span></a>
<?		if(count($v) > 1){?>
                            <ul class="nav nav-second-level">							
<?			foreach($v as $kk => $vv){
				if($kk == 'sett') continue;
	?>
                                <li>
                                    <a href="<?=$vv["url"]?>"><?=$kk?></a>
                                </li>

<?			}?>
							</ul>
<?		}?>
						</li>
<?	}?>						
                    </ul>
<?/*
	$adms = array(
		"Сайт" => array(
			"Страницы" => array(
				"url" => "adm_page.php",
				"comment" => "Страницы главного меню, подменю и скрытые страницы",
				
			),
			"Новости" => array(
				"url" => "adm_news.php",
				"comment" => "Новостная лента сайта",
				"opt" => "news",
			),
			"Статьи (Блог)" => array(
				"url" => "adm_articles.php",
				"comment" => "Полезные статьи. Для людей и для раскрутки сайта",
				"opt" => "articles",
			),
			"Акции" => array(
				"url" => "adm_actions.php",
				"comment" => "Управление акциями",
				"opt" => "actions",
			),
			"Вакансии" => array(
				"url" => "adm_vacancy.php",
				"comment" => "Вакансии. Список вакансий компании",
				"opt" => "vacancy",
			),
		),

		"Каталог" => array(
			"Бренды" => array(
				"url" => "adm_brand.php",
				"comment" => "Редактирование списка брендов для каталога товаров",
				"opt" => "prod_brands",
			),
			"Категории" => array(
				"url" => "adm_cat.php",
				"comment" => "Редактирование товаров по категориям",
				"opt" => "prod_cats",
			),
			"Товары" => array(
				"url" => "adm_prod.php",
				"comment" => "Список всех товаров и их свойств",
				"opt" => "prods",
			),
			"Характеристики" => array(
				"url" => "adm_char.php",
				"comment" => "Общие характеристики для всех категорий товаров",
				"opt" => "prod_chars",
			),			
			"Цвета" => array(
				"url" => "adm_color.php",
				"comment" => "Список цветов",
				"opt" => "prod_colors",
			),			
			"Теги" => array(
				"url" => "adm_tags.php",
				"comment" => "Управление облаком тегов. Список тегов",
				"opt" => "prod_tags",
			),
			"Импорт товаров" => array(
				"url" => "adm_import.php",
				"comment" => "Импорт из XML, XLS",
				"opt" => "prod_brands",
			),
			"Экспорт товаров" => array(
				"url" => "adm_export.php",
				"comment" => "Экспорт товаров в прайс-агрегаторы",
				"opt" => "prod_export",
			),
		),

		"Управление клиентами" => array(
			"Клиенты" => array(
				"url" => "adm_user.php?type=client",
				"comment" => "Зарегистрированные клиенты сайта",
				"opt" => "billing",
			),
			"Менеджеры" => array(
				"url" => "adm_user.php?type=manager",
				"comment" => "Зарегистрированные менеджеры сайта",
				"opt" => "managers",
			),
			"Заказы" => array(
				"url" => "adm_order.php",
				"comment" => "Список заказов всех клиентов",
				"opt" => "billing",
			),
			"Накопительные скидки" => array(
				"url" => "adm_discount.php?type=accum",
				"comment" => "Управление системой скидок. Размер скидки, размер накоплений для получения скидки",
				"opt" => "discounts",
			),
			"Статистика" => array(
				"url" => "adm_stat.php",
				"comment" => "AS-Stat",
			),
		),

		"Системы оплаты и доставки" => array(
			"Способы оплаты" => array(
				"url" => "adm_esystem.php",
				"comment" => "Редактирование автоматических и неавтоматических способов оплаты",
				"opt" => "billing",
			),
			"Способы доставки" => array(
				"url" => "adm_delivery.php",
				"comment" => "Редактирование способов доставки. Описания, цена доставки",
				"opt" => "billing",
			),
		),

		
		"Почта" => array(
			"Рассылка" => array(
				"url" => "adm_distrib.php",
				"comment" => "Система рассылки",
				"opt" => "distrib",
			),
			"Шаблоны писем" => array(
				"url" => "adm_template.php?type=mail",
				"comment" => "Редактирование шаблонов писем",
			),
			"Настройки" => array(
				"url" => "adm_sett.php?type=mail",
				"comment" => "Основные настройки сайта",
			),
		),


		"Блоки" => array(
			"Баннеры" => array(
				"url" => "adm_banner.php",
				"comment" => "Система баннеров. Добавляйте все баннеры через эту систему.",
				"opt" => "banners",
			),
			"Блоки" => array(
				"url" => "adm_block.php",
				"comment" => "Редактирование блоков на сайте",
			),
			"Голосование" => array(
				"url" => "adm_vote.php",
				"comment" => "Редактирование списка вопросов и ответов. Результаты голосования",
				"opt" => "vote",
			),
		),


		"SEO модули" => array(
			"Генерация sitemap.xml" => array(
				"url" => "adm_sitemap.php",
				"comment" => "sitemap для вебмастерской",
				"opt" => "sitemap",
			),
			"Шаблоны мета-тегов" => array(
				"url" => "adm_template.php?type=meta",
				"comment" => "sitemap для вебмастерской",
			),
			"Соц. сети" => array(
				"url" => "adm_block.php?type=social",
				"comment" => "интеграция соц.сетей",
			),
			"Настройки" => array(
				"url" => "adm_sett.php?type=seo",
				"comment" => "Основные настройки сайта",
			),
		),

		"Языки" => array(
			"Языки" => array(
				"url" => "adm_lang.php",
				"comment" => "Языки сайта. Добавление, удаление, редактирование языков",
				"opt" => "billing",
			),
			"Надписи" => array(
				"url" => "adm_labels.php",
				"comment" => "Редактирование надписей на сайте",
			),
		),

		"Настройки" => array(
			"Валюты" => array(
				"url" => "adm_currency.php",
				"comment" => "Редактирование блоков на сайте",
				"opt" => "currencies",
			),
			"Системные настройки" => array(
				"url" => "adm_sett.php?type=system",
				"comment" => "Основные настройки сайта",
			),
			"Администраторы" => array(
				"url" => "adm_admins.php",
				"comment" => "Изменение логина и пароля администратора, создание новых пользователей",
			),
		),
	);

	$opt = Zend_Registry::get('opt');	
?>
				<table width="250">
<?	foreach($adms as $k => $v) {?>
					<tr><td class="<?=(1) ? "cat" : "activecat"?>"><?=$k?></td></tr>
<?		foreach($v as $kk => $vv){?>
<?			if ($vv["url"] == '' || ($vv["opt"] && !$opt[$vv["opt"]])) {?>

<?			} else {?>
					<tr><td class="<?=(strstr($_SERVER['REQUEST_URI'], $vv['url'])) ? "activeadm" : "adm"?>"><a class="menu" href="<?=$vv["url"]?>" title="<?=$vv['comment']?>">&#9679; <?=$kk?></a></td></tr>
<?			}?>

<?		}?>
<?	}?>
				</table>
		  */