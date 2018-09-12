<form method="get" action="/search" >
    <div class="row grid-space-1" id="search">
        <div class="col-sm-9">
            <input type="hidden" name="search" value="prod" id="searchkind" />
            <input type="text" name="q" id="gsearch" class="form-control input-lg" placeholder="<?=$this->labels["enterkeywordstosearch"]?>">
        </div><!-- end col -->
        <div class="col-sm-3">
            <input type="submit"  class="btn btn-default btn-block btn-lg" value="<?=$this->labels["search"]?>">
        </div><!-- end col -->
    </div><!-- end row -->
</form>