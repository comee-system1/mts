<?PHP
class endaiFin{
	function __construct(){
		global $db;
		$this->db = $db;
		global $third;
		$this->third = $third;
	}
	public function index(){
	    $code = $this->db->getKagakuEndai($this->third);
		$title= $this->db->gethappyoTitle();
		$html[ 'title'  ] = $title[ 'title1' ];
		$html[ 'code'   ] = $code[ 'code'    ];
		return $html;
	}

}
?>