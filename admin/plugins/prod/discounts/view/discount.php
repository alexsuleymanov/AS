<style>
	.discount_div{
		float: left;
		padding: 0 10px 0 20px;
		margin-left: 10px;
		border-left: 1px solid #000000;
	}
</style>

<script type="text/javascript">
	function disc_change(e){
		var div_id = $(e).val(); 
		$(".discount_div").hide();
		$(".discount_input").attr("disabled", true);
		$("#"+div_id).show();
		$(".discount_input_"+div_id).attr("disabled", false);
	}
</script>

<div class="clear"></div>

<select name="discount_type" id="discount_type" onchange="disc_change(this);" style="float: left;"/>
	<option value="no">Нет</option>
	<option value="tmp" <?if($this->plugin_vars["prod_discount_type"] == 'tmp') echo "selected=\"1\""?>>Временная</option>
	<option value="permanent" <?if($this->plugin_vars["prod_discount_type"] == 'permanent') echo "selected=\"1\""?>>Постоянная</option>
</select>

<div id="tmp" class="discount_div" style="<?if($this->plugin_vars["prod_discount_type"] != 'tmp') echo "display: none;"?>">
	Скидка <input name="discount_value" class="discount_input discount_input_tmp" value="<?=$this->plugin_vars["prod_discount"]?>" size="2" <?if($this->plugin_vars["prod_discount_type"] != 'tmp') echo "disabled=\"1\"";?>/> % : c <input type="text" name="discount_tstamp" size="10" class="discount_input discount_input_tmp" value="<?=date("d.m.Y", $this->plugin_vars["prod_discount_tstamp"])?>" <?if($this->plugin_vars["prod_discount_type"] != 'tmp') echo "disabled=\"1\"";?>/> до <input type="text" name="discount_end" class="discount_input discount_input_tmp" value="<?=date("d.m.Y", $this->plugin_vars["prod_discount_end"])?>" size="10" <?if($this->plugin_vars["prod_discount_type"] != 'tmp') echo "disabled=\"1\"";?> />
</div>

<div id="permanent" class="discount_div" style="<?if($this->plugin_vars["prod_discount_type"] != 'permanent') echo "display: none;";?>">
	Скидка <input name="discount_value" class="discount_input discount_input_permanent" value="<?=$this->plugin_vars["prod_discount"]?>" size="2" <?if($this->plugin_vars["prod_discount_type"] != 'permanent') echo "disabled=\"1\"";?>/> %
</div>

<div class="clear"></div>