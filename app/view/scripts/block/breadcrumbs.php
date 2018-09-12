<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul>
                    <?
                    $i = 0;
                    $cou = count($this->bc);

                    if($cou){
                        foreach($this->bc as $l => $t){
                            if($i < $cou-1){?>
                                <li><a href="<?=$l?>"><?=$t?></a></li>

                            <?			}else{?>
                                <li class="active"><?=$t?></li>
                            <?			}
                            $lastcat=$t;
                        }
                    }
                    ?>
                </ul><!-- end breadcrumb -->
            </div><!-- end col -->
        </div><!-- end row -->
    </div><!-- end container -->
</div><!-- end breadcrumbs -->