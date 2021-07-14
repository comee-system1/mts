<?PHP

class preview{
	function __construct(){
		global $db;
		$this->db = $db;
		global $third;
		$this->third = $third;
		
		global $array_movie;
		$this->array_movie=$array_movie;
		global $array_movie_date;
		$this->array_movie_date=$array_movie_date;
	}
	public function index(){
		//動画データ取得
		$movie = [];
		if($_REQUEST['d']){
			$where = [];
			$where[ 'date'] = $_REQUEST[ 'd' ];
			$movie = $this->db->getMovieData($where);
			$html['session'] = $movie[ 'session' ];
			$html['zoom'] = $movie[ 'zoom' ];
		}

		//動画データ登録
		if($this->third == "set"){
			if(!$this->set()){
				$html[ 'errormsg' ] = $this->errormsg;
			}else{
				$_SESSION[ 'message' ] = "登録に成功しました";
				header("Location:/preview/preview/");
				exit();
			}
			
		}
		if($_SESSION[ 'message' ]){
			$html['message'] = $_SESSION[ 'message' ];
			$_SESSION[ 'message' ] = "";
		}

		$html['array_movie'] = $this->array_movie;
		$html['array_movie_date'] = $this->array_movie_date;
		$html['test'] = "aaaaddd";
		return $html;
	}
	/************
	 * 動画データ登録
	 */
	public function set(){
		if($_REQUEST[ 'regist' ] ){
			
			//エラーチェック
			if($_REQUEST[ 'date' ] == "-"){
				$this->errormsg = "日付が指定されていません。";
				return false;
			}
			$date = $_REQUEST[ 'date' ];
			$delete = [];
			$delete[ 'date' ] = $date;
			if(!$this->db->deleteUserData($delete)){
				$this->errormsg = "データの更新に失敗しました。";
				return false;
			}
			$session = $_REQUEST[ 'session' ];
			$zoom = $_REQUEST[ 'zoom' ];
			$table = "movie";
			foreach($session as $key=>$values){
				foreach($values['am'] as $k=>$value){
					$set = [];
					$set['date'] = $date;
					$set['place'] = $key;
					$set['number']=$k;
					$set['type']="am";
					$set['session'] = $value;
					$set['zoom']=$zoom[$key]['am'][$k];
					$set['regist_ts'] = date("Y-m-d H:i:s");
					$this->db->setUserData($table,$set);
				}
				foreach($values['pm'] as $k=>$value){
					$set = [];
					$set['date'] = $date;
					$set['place'] = $key;
					$set['number']=$k;
					$set['type']="pm";
					$set['session'] = $value;
					$set['zoom']=$zoom[$key]['pm'][$k];
					$set['regist_ts'] = date("Y-m-d H:i:s");
					$this->db->setUserData($table,$set);
				}
			}
			
			
			return true;
		}
		return false;
		
	}

}
?>