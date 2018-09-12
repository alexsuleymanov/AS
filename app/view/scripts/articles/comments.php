<?	foreach($this->comments as $k => $comment){
		if(empty($comment->cont)) continue;?>

<div class="hreview">
	<div class="item"><span class="fn"><?=$this->page->name?></span></div>
	<div class="num"><?=++$j?>.</div>
	<div class="comment">
		<span class="reviewer"><?=$comment->author?></span>
		<span class="dtreviewed">
			<?=date("d M Y", $comment->tstamp)?><span class="value-title" title="<?=date("Y-m-d", $comment->tstamp)?>"></span>
		</span>
		<div class="summary"><?=substr($comment->cont, 0, 200)?></div>
		<div class="description"><?=$comment->cont?></div>
		<div class="rating"><?=$this->page->rating->rating?></div>
	</div>
</div>

<?	}?>

<div class="add_comment">
	<div class="button"><input type="button" name="show_comment" value="<?=$this->labels['add_comment']?>" onclick="$('.add_comment .form').show();" /></div>
	<div class="form"><?echo $this->form?></div>
</div>