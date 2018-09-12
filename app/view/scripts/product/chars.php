<?	if(isset($this->charcats)){?>
<table>
	<tr>
		<td colspan="2"><h3><?=$this->labels["technical_chars"]?></h3>
			<table cellspacing="0" cellpadding="2" width="100%" border="0">
<?		foreach($this->charcats as $ccid => $ccv){?>
				<tr valign="top"> 
					<td colspan="2"><strong class="char_cat"><?=$ccv->name?></strong></td>
				</tr>
<?			foreach($this->chars as $k => $cv){
				if($cv->charcat != $ccv->id || !isset($this->prod->chars[$cv->id]) || ($this->prod->chars[$cv->id]->val == 0 && $this->prod->chars[$cv->id]->text == '')) continue;?>
				<tr>
					<td valign="bottom"><?=$cv->name?><hr class="gray"></td>
					<td valign="bottom">
<?					if($cv->type == 4){
						echo $this->prod->chars[$cv->id]->value." ".$this->prod->chars[$cv->id]->izm;
					}elseif($cv->type == 2){
						echo $this->prod->chars[$cv->id]->text." ".$this->prod->chars[$cv->id]->izm;
					}elseif($cv->type == 1){
						echo ($this->prod->chars[$cv->id]->text) ? $this->labels["yes"]: $this->labels["no"];
					}?>
						<hr class="gray">
					</td>
				</tr>
<?			}?>
<?		}?>
			</table>
		</td>
	</tr>
</table>
<?	}elseif(isset($this->chars)){
?>
<table>
	<tr>
		<td colspan="2"><h3><?=$this->labels["technical_chars"]?></h3>
			<table cellspacing="0" cellpadding="2" width="100%" border="0">
<?		foreach($this->chars as $k => $cv){
			if($this->prod->chars[$cv->id]->val == 0 && $this->prod->chars[$cv->id]->text == '') continue;
?>
				<tr>
					<td valign="bottom"><?=$cv->name?><hr class="gray"></td>
					<td valign="bottom">
<?					if($cv->type == 4){
						echo $this->prod->chars[$cv->id]->value." ".$this->prod->chars[$cv->id]->izm;
					}elseif($cv->type == 2){
						echo $this->prod->chars[$cv->id]->text." ".$this->prod->chars[$cv->id]->izm;
					}elseif($cv->type == 1){
						echo ($this->prod->chars[$cv->id]->text) ? $this->labels["yes"]: $this->labels["no"];
					}?>
						<hr class="gray">
					</td>
				</tr>
<?		}?>
			</table>
		</td>
	</tr>
</table>
<?	}?>