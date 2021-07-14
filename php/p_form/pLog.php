<?PHP
class pLog{
	function __construct(){
		global $db;
		global $manage;

		$this->db = $db;
		global $third;
		global $sankaform;
	}
	public function index(){
		global $manage;
		if($manage[ 'mousikomi_status' ] == 1){
			//利用不可の時
			header("Location:/p_form/");
			exit();
		}

		global $third;
		global $sankaform;

		//ログイン
		if($_REQUEST[ 'login' ]){
			$err = "";
			if(!$_REQUEST[ 'logindata' ][ 'num' ]
				|| !$_REQUEST[ 'logindata' ][ 'password' ]
				){
				$err = 1;
			}else{
				$lg = $this->db->loginCheckLog($_REQUEST[ 'logindata' ]);

				if($lg[ 'id' ]){
					$sid = $lg[ 'id' ];
				}else{
					$err = 1;
				}
			}
			$lists[ 'err' ] = $err;
			$lists[ 'sid' ] = $sid;
			echo json_encode($lists);
			exit();
		}
		$this->third = $third;
		$title = $this->db->getTitleLog();
		$html[ 'title' ] = $title[ 'note' ];
		if($third){
    		$data = $this->db->getSankaCodeLog($third);
    		$html[ 'scode' ] = $data[ 'code' ];
		}
		if($_REQUEST[ 'err' ]){
			$html[ 'errmsg' ] = $sankaform[ 'sform' ][ '26' ][ 'errmsg' ];
		}
		return $html;
	}

}
?>