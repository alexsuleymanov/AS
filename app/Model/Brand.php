<?
use ASweb\Db\NullEntity;
use ASweb\Db\Db;

class Model_Brand extends Model_Model
{
	protected $name = 'brand';
	protected $depends = array('prod');
	protected $relations = array();
	protected $multylang = 1;
	protected $visibility = 1;
	public $par = 0;

	public function getbyname(string $intname = '')
	{
		$r = $this->getall([
			"select" => "id",
			"where" => "`visible` = 1 and `intname` = '".Db::nq($intname)."'",
			"limit" => 1,
		]);
		
		if ($r[0]->id) {
			return $this->get($r[0]->id);
		} else {
			return NULL;
		}
	}
}