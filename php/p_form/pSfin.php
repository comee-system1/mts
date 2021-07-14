<?PHP
class pSfin{
	function __construct(){
		global $db;
		global $manage;
		$this->db = $db;
		global $third;
	}
	public function index(){
		global $manage;
		if($manage[ 'mousikomi_status' ] == 1){
			//���p�s�̎�
			header("Location:/p_form/");
			exit();
		}
		global $third;
		$this->third = $third;
		$title = $this->db->getTitleSfin();
		$html[ 'title' ] = $title[ 'note' ];
		$data = $this->db->getSankaCodeSfin($this->third);
		$html[ 'scode' ] = $data[ 'code' ];
		$use = $this->db->getKagakuUserSfin();
		$html[ 'disabled' ] = $use[ 'happyou_status' ];
		return $html;
	}

}
?>