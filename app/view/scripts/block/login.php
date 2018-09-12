<!-- Header Links Ends -->
<div class="col-sm-6 col-xs-12 hidden-md hidden-sm hidden-xs msg">
   <?=$this->labels['welcome']?>
</div>
<!-- Header Links Starts -->
<div class="col-sm-6 col-xs-12">
        <div class="header-links">
            <ul class="nav navbar-nav navbar-right">
				<li>
					<a href="<?=$this->url->mk('/wishlist')?>">
						<i class="fa fa-heart hidden-lg hidden-md" title="<?=$this->labels['wishlist']?>"></i>
											<span class="hidden-sm hidden-xs">
												<?=$this->labels['wishlist']?> (<span class="wishlist_count"><?=$this->Wishlist->prod_num()?></span>)
											</span>
					</a>
				</li>
    <?	if(!ASweb\Auth\Auth::is_auth()){?>
				<li>
                    <a href="<?=$this->url->mk('/user')?>">
                        <i class="fa fa-lock hidden-lg hidden-md" title="Login"></i>
										<span class="hidden-sm hidden-xs">
											Личный кабинет
										</span>
                    </a>
                </li>	
                <li>
                    <a href="<?=$this->url->mk('/user/register')?>">
                        <i class="fa fa-unlock hidden-lg hidden-md" title="Register"></i>
										<span class="hidden-sm hidden-xs">
											<?=$this->labels['register']?>
										</span>
                    </a>
                </li>
    <?	}?>				
               
            
    <?	if(ASweb\Auth\Auth::is_auth()){?>			
            <li>
                <a href="<?=$this->url->mk('/user')?>">
                    <i class="fa fa-user hidden-lg hidden-md" title="My Account"></i>
										<span class="hidden-sm hidden-xs">
											<?=$_SESSION["username"]?>
										</span>
                </a>
            </li>
    <?	}?>			
        </ul>
		
</div>
<!-- Currency & Languages Ends -->