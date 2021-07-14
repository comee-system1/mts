<?PHP

class judge{
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
		$data = $this->db->getSankaJudge();
		$html['errmsg'] = $this->errmsg;
		$html['judge'] = $data;
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
		$this->db->deleteSankaJudge();
		$fp = fopen($tmp_name, 'rb');
		$list = [];
		$table = "sanka_judge";
		$no=0;
        while ($row = fgetcsv($fp)) {
			if($no > 0){
				$set = [];
				$set[ 'code' ] = $row[0];
				$set[ 'judge_publication' ] = $row[1];
				$set[ 'regist_ts' ] = date("Y-m-d H:i:s");
				$this->db->setUserData($table,$set);
			}
			$no++;
		}

	}


}
?>