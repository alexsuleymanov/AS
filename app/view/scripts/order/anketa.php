<?
	$_GET["redirect"] = "/order/confirm";
	echo $this->page->cont;
?>
<div class="order-left">
	<?echo $this->orderform->render($this);?>
</div>

<div class="order-right">
<?	echo $this->render("cart/show-mini.php");?>
</div>
