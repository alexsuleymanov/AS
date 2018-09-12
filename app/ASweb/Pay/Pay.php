<?php
	namespace ASweb\Pay;
	
	class Pay{
		public static function pay(\Model_ModelInterface $Esystem, $order_sum)
		{
			global $view;

			$esystem_id = ($_POST["esystem"]) ? $_POST["esystem"] : $_GET["esystem"];
			$order_id = ($_POST["order"]) ? $_POST["order"] : $_GET["order"];

			$esystem = $Esystem->get($esystem_id);

			$params = array(
				'SITE_NAME' => $_SERVER['HTTP_HOST'],
				'SITE_ESYSTEM' => $esystem_id,
				'SITE_ORDERNUMBER' => $order_id,
				'SITE_PRODDESCR' => $labels["pay_for_bill"].$order_id,
				'SITE_PAYAMOUNT' => Func::fmtmoney($order_sum * $esystem->course),
			);

			if ($esystem->form) {
				$esystem->form = str_replace(array_keys($params), array_values($params), $esystem->form);
				echo $esystem->form;
				echo "<script type=\"text/javascript\">window.payform.submit();</script>";
				die();
			} elseif($esystem->script) {
				$Pay = new $esystem->script();
				$Pay->pay($params);
				die();
			} else {
				$view->prod->cont = $esystem->cont;
				echo $layout->render($view);
				die();
			}
		}
	}