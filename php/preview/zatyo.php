<?PHP

class zatyo{
	function __construct(){
		global $db;
		$this->db = $db;
		global $array_movie;
		$this->array_movie=$array_movie;
		global $array_movie_date;
		$this->array_movie_date=$array_movie_date;
		$this->errmsg = "";
	}
	public function index(){

		if($_REQUEST[ 'upload' ]){
			$this->regist();
		}
		//データ取得
		$data = $this->db->getEndaiPublicate();
		$html['errmsg'] = $this->errmsg;
		$html['zatyo'] = $data;
		return $html;
		
	}
	public function regist(){
		
		/* ファイルアップロードエラーチェック */
		$errmsg = "";
        switch ($_FILES['csvfile']['error']) {
            case UPLOAD_ERR_OK:
                // エラー無し
                break;
            case UPLOAD_ERR_NO_FILE:
                // ファイル未選択
                $errmsg = "ファイルを選択してください";
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                // 許可サイズを超過
                $errmsg = "ファイルサイズが大きすぎます";
				
			default:
				$errmsg = "アップロードに失敗しました。";
			
		}
		$tmp_name = $_FILES['csvfile']['tmp_name'];
		$name = $_FILES['csvfile']['name'];
		$filepath = pathinfo($name);
		$ext = $filepath['extension'];
		if($ext != "csv"){
			$errmsg = "CSVのみアップロード可能です。";
		}
		if($errmsg){
			$this->errmsg = $errmsg;
			return false;
		}
		$this->db->deleteEndaiPublicate();
		$fp = fopen($tmp_name, 'rb');
		$list = [];
		$table = "endai_publicate";
		$no=0;
        while ($row = fgetcsv($fp)) {
			if($no > 0){
				$set = [];
				$set[ 'publication' ] = $row[0];
				$set[ 'zatyo_name' ] = mb_convert_encoding($row[1],"UTF-8","SJIS");
				$set[ 'zatyo_group' ] = mb_convert_encoding($row[2],"UTF-8","SJIS");
				$set[ 'regist_ts' ] = date("Y-m-d H:i:s");
				$this->db->setUserData($table,$set);
			}
			$no++;
		}

	}


}
?>