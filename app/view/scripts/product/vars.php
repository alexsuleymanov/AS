<table cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td class="cblock">
			<div>
				<div>
					<h3>Варианты приобретения</h3>
				</div>
			</div>
		</td>
	</tr>
	<tr valign="top">
		<td class="cblock2">
<?			foreach($this->prod->prodvars as $k => $v){?>
			<div class="prod_var"><input type="radio" name="var" value="<?=$v->id?>">&nbsp;&nbsp;&nbsp;<?=$v->name?> (<?=ASweb\StdLib\Func::fmtmoney($v->price).Zend_Registry::get('cur_name')?>)</div>
<?			}?>
		</td>
	</tr>
	<tr valign="top">
		<td class="cblock3">
			<div>
				<div>
					&nbsp;
				</div>
			</div>
		</td>
	</tr>
</table>