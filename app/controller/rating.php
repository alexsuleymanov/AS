<?
	$Rating = new Model_Rating();
	if(isset($_GET['type']) && isset($_GET['par'])){
		$rating = $Rating->getone(array("where" => "`type` = '".ASweb\Db\Db::nq($_GET['type'])."' and par = '".ASweb\Db\Db::nq($_GET['par'])."'"));

		$r = round(($rating->rating * $rating->count + $_GET['rating']) / ($rating->count + 1), 1);

		$data = array(
			'rating' => $r,
			'count' => $rating->count + 1,
		);

		$Rating->update($data, array("where" => "id = '".$rating->id."'"));

		setcookie("rated_".$_GET['type']."_".$_GET['par'], 1, time()+60*60*24*30);

		$result = array("rating" => $data['rating'], "count" => $data['count']);
		
		echo Zend_Json::encode($result);
	}
