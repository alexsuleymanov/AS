<?php
$Page = new Model_Page('page'); /* @var $Page Model_Page*/
$Page->addPlugin('Tree', new Model_Plugin_Page_Tree());

if ($opt["page_photos"]) {
	$Page->addDecorator(new Model_Decorator_Page_Photos());
}

if ($opt["page_comments"]) {
	$Page->addDecorator(new Model_Decorator_Page_Comments());
}
	
if ($opt["page_rating"]) {
	$Page->addDecorator(new Model_Decorator_Page_Rating());
}

if ($opt["page_prods"]) {
	$Page->addDecorator(new Model_Decorator_Page_Prods());
}
