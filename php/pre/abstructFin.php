<?PHP
class abstructFin{
	function __construct(){
		global $db;
		$this->db = $db;
		global $third;
		$this->third = $third;
	}
	public function index(){
		$title= $this->db->gethappyoTitle();
		$code = $this->db->getEndaiDataAbFin($this->third);
		$html[ 'title'  ] = $title[ 'title1' ];
		$html[ 'errmsg' ] = $errmsg;
		$html[ 'code'   ] = $code[ 'ecode' ];
		return $html;
	}


}
?>