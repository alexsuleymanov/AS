<?	echo $this->page->cont;?>
<div class="order-left">
	<?echo $this->form->render($this);?>
</div>

<div class="order-right">
	<?=$this->render("cart/show-mini.php");?>
</div>
