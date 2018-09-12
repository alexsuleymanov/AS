            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
<?
	$Comment = new Model_Comment();
	$comments = $Comment->getall(array("where" => "visible = 0"));
	echo count($comments);
?>
									</div>
                                    <div>Коментариев</div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/adm_comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">Коментарии</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
<?
	$Message = new Model_Message();
	$messages = $Message->getall(array("where" => "visible = 0"));
	echo count($messages);
?>									
									</div>
                                    <div>Сообщений</div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/adm_message.php">
                            <div class="panel-footer">
                                <span class="pull-left">Сообщения</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
<?
	$Order = new Model_Order();
	$orders = $Order->getall(array("where" => "status = 0"));
	echo count($orders);
?>
									</div>
                                    <div>Новые заказы</div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/adm_order.php">
                            <div class="panel-footer">
                                <span class="pull-left">Заказы</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">
<?
	$User = new Model_User('client');
	$users = $User->getall(array("where" => "visible = 0"));
	echo count($users);
?>
									</div>
                                    <div>Клиентов</div>
                                </div>
                            </div>
                        </div>
                        <a href="/admin/adm_user.php">
                            <div class="panel-footer">
                                <span class="pull-left">Клиенты</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Статистика                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart"></div>
<?
	$Order = new Model_Order();
//	$Order->addPlugin('Period', new Model_Plugin_Order_Period());
	$periods = array();
	
	$year = intval(date("Y", time()));
	$month = intval(date("m", time()));
	
	for ($i = 0; $i < 12; $i++) {
		$period = $year."-".$month;
		
		if ($month == 1) {
			$year2 = $year;
			$month2 = $month;			
			$year--;
			$month = 12;			
		} else {
			$year2 = $year;
			$month2 = $month;

			$month--;
		}
		
//		$periods[] = array("period" => $period, "orders" => $Order->Plugin('Period')->getNumForPeriod(mktime(0, 0, 0, $month, 0, $year), mktime(0, 0, 0, $month2, 0, $year2)), "sum" => $Order->getSumForPeriod(mktime(0, 0, 0, $month, 0, $year), mktime(0, 0, 0, $month2, 0, $year2)), "leads" => $Message->getNumForPeriod(mktime(0, 0, 0, $month, 0, $year), mktime(0, 0, 0, $month2, 0, $year2)));
	}
	
	$periods = array_reverse($periods);
?>
<script>
$(function() {
    Morris.Area({
        element: 'morris-area-chart',
        data: [
<?	foreach ($periods as $k => $v) {
		if($iii++ > 0) echo ",";
	?>			
{
  period: '<?=$v['period']?>',
  sum: <?=$v['sum']?>
}<?	}?>],
        xkey: 'period',
        ykeys: ['sum'],
        labels: ['Сумма заказов'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });
});
</script>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
 <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Статистика                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-area-chart2"></div>
<script>
$(function() {
    Morris.Area({
        element: 'morris-area-chart2',
        data: [
<?	foreach ($periods as $k => $v) {
		if($ii++ > 0) echo ",";
	?>			
{
  period: '<?=$v['period']?>',
  orders: <?=$v['orders']?>,
  leads:  <?=$v['leads']?>
}<?	}?>],
        xkey: 'period',
        ykeys: ['orders', 'leads'],
        labels: ['Заказы', 'Лиды'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });
});
</script>
                        </div>
                        <!-- /.panel-body -->
                    </div>                   
                    <!-- /.panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-clock-o fa-fw"></i> Новые заказы
                        </div>
 <?
	$Order = new Model_Order();
	$orders = $Order->getall(array("where" => "status = 0", "order" => "id desc"));
?>                       
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Имя</th>
                                            <th>Телефон</th>
											<th>E-mail</th>
                                            <th>Сумма</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?	foreach($orders as $order) {
//		$Order1 = new Model_Order($order->id);
	?>										
                                        <tr>
                                            <td><?=$order->id?></td>
                                            <td><?=$order->name?></td>
                                            <td><?=$order->phone?></td>
                                            <td><?=$order->email?></td>
											<td><?//=$Order1->ordersum($order->id)?></td>
                                        </tr>
<?	}?>										
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                
            </div>