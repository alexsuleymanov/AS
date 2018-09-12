<?php
$News = new Model_Page('news');

if ($opt["news_photos"]) {
	$News->addDecorator(new Model_Decorator_Page_Photos());
}

if ($opt["news_comments"]) {
	$News->addDecorator(new Model_Decorator_Page_Comments());
}
	
if ($opt["news_rating"]) {
	$News->addDecorator(new Model_Decorator_Page_Rating());
}
