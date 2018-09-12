<div class="widget">
	<h6 class="subtitle"><?=$this->labels["menu"]?></h6>

	<ul class="list list-unstyled">
		<li<?if($this->args[1]=='') {?> class="active"<?}?>>
			<a href="/user"><?=$this->labels["common_information"]?></a>
		</li>
		<li<?if($this->args[1]=='profile') {?> class="active"<?}?>>
			<a href="/user/profile"><?=$this->labels["edit_profile"]?></a>
		</li>
		<li<?if($this->args[1]=='change-pass') {?> class="active"<?}?>>
			<a href="/user/change-pass"><?=$this->labels["change_password"]?></a>
		</li>
		<li<?if($this->args[1]=='logoff') {?> class="active"<?}?>>
			<a href="/user/logoff"><?=$this->labels["logoff"]?></a>
		</li>
	</ul>
</div><!-- end widget -->