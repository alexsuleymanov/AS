<?php
$Articles = new Model_Page('article');

if ($opt["articles_photos"]) {
	$Articles->addDecorator(new Model_Decorator_Page_Photos());
}

if ($opt["articles_comments"]) {
	$Articles->addDecorator(new Model_Decorator_Page_Comments());
}
	
if ($opt["articles_rating"]) {
	$Articles->addDecorator(new Model_Decorator_Page_Rating());
}

