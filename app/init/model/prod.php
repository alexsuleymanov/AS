<?php
$Prod = new Model_Prod();

if ($opt['prod_chars']) {
	$Prod->addDecorator(new Model_Decorator_Prod_Chars());
	$Prod->addPlugin('Char', new Model_Plugin_Prod_Chars());
}

if ($opt['prod_vars']) {
	$Prod->addDecorator(new Model_Decorator_Prod_Vars());
	$Prod->addPlugin('Prodvar', new Model_Plugin_Prod_Prodvar());
}

if ($opt['prod_cats']) {
	$Prod->addPlugin('Cat', new Model_Plugin_Prod_Cat());
}

if ($opt['prod_multicats']) {
	$Prod->addPlugin('Multicat', new Model_Plugin_Prod_Multicat());
}

if ($opt['ext_search']) {
	$Prod->addPlugin('Filter', new Model_Plugin_Prod_Filter());
}

if ($opt['prod_childs']) {
	$Prod->addDecorator(new Model_Decorator_Prod_Childs());
}

if ($opt['prod_analogs']) {
	$Prod->addDecorator(new Model_Decorator_Prod_Analogs());
}

if ($opt['prod_currency']) {
	$Prod->addDecorator(new Model_Decorator_Prod_Currency());
}

if ($opt['prod_comments']) {
	$Prod->addDecorator(new Model_Decorator_Prod_Comments());
}

if ($opt['prod_photos']) {
	$Prod->addDecorator(new Model_Decorator_Prod_Photos());
}

if ($opt['prod_rating']) {
	$Prod->addDecorator(new Model_Decorator_Prod_Rating());
}
