<?
echo $this->action->cont;

if($this->action->prods) {
	echo $this->render("catalog/prod-list.php");
}

