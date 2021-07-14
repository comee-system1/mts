<?PHP
class up{
	function __construct(){
		global $db;
		global $html;
		global $array_pref;
		$this->db   = $db;
		$this->html = $html;
	}
	public function index(){
		//テンプレート
		if($_REQUEST[ 'template' ] == "on"){
			$data = $this->db->getUpData();
			// 出力
			$fileName = "template_" . date("YmdHis") . ".csv";
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . $fileName);
			echo mb_convert_encoding("受付ID","SJIS","UTF-8");
			echo ",";
			echo mb_convert_encoding("発表番号","SJIS","UTF-8");
			echo "\n";
			foreach($data as $key=>$val){
				echo $val[ 'code' ];
				echo "\n";
			}
			exit();
		}
		//ファイルアップロード
		if($_REQUEST[ 'upload' ] == "on"){
			if(!$_FILES[ 'files' ][ 'name' ]){
				$err = "ファイルが選択されていません。";
			}else
			if(!preg_match("/\.csv$/",$_FILES[ 'files' ][ 'name' ])){
				$err = "CSVファイルのみアップロード可能です。";
			}else
			if($_FILES[ 'files' ][ 'error' ]){
				$err = "アップロードに失敗しました。";
			}

			if($err){
				$html[ 'errmsg' ]  =$err;
			}else{
				setlocale(LC_ALL, 'ja_JP.UTF-8');
				$temp = $_FILES[ 'files' ][ 'tmp_name' ];
				$data = fopen($temp,"r");
				while( $ret_csv = fgetcsv( $data, 256 ) ) {
					$list[] = $ret_csv;
				}
				$table = "kagaku_endai";
				foreach($list as $key=>$val){
					if($key > 0 ){
						$edit = array();
						$edit[ 'where' ][ 'code'        ] = $val[0];
						$edit[ 'where' ][ 'status'  ] = 1;
						$edit[ 'edit'  ][ 'publication' ] = $val[1];

						$flg = $this->db->editUserData($table,$edit);
						if(!$flg){
							$err++;
						}
					}
				}
				if($err){

					$html[ 'errmsg' ]  = "アップロード失敗しました。";
				}else{
					$html[ 'success' ]  = "アップロード成功しました。";
				}
			}
		}
		return $html;
	}


}
?>