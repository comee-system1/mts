<?PHP
class cus{
	function __construct(){
		global $db;
		$this->db = $db;
	}
	public function index(){
		//print "ccc";
		//$this->getTest();
		
		$html['test'] = "aaaaddd";
		return $html;
	}
	private function getTest(){
		$sql = "SELECT * FROM t_user ";
		$r   = mysql_query($sql);
		$i = 0;
		while($rst = mysql_fetch_array($r)){
			$rlt[$i] = $rst;
			$i++;
		}
	}
}
?>