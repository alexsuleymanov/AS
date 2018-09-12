	<table cellspacing="15" border="0" width="100%">
		<tr>
<?		foreach ($this->actions as $k => $v) {?>
			<td width="100" valign="top" class="actionslistdate"><a href="<?=$this->url->mkd(array(1, $v->intname))?>" class="actionsh"><span class="date"><?echo date("d.m.Y", $v->tstamp);?></span></a></td>
			<td class="actionslistname"><a href="<?=$this->url->mkd(array(1, $v->intname))?>" class="actionsh"><?=$v->name?></a>
				<br><?=substr(strip_tags($v->cont), 0, 200)."...";?>
			</td>
		</tr>
<?		}?>
	</table>
