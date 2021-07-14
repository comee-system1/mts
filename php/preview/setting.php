<?PHP

class setting{
	function __construct(){
		global $db;
		$this->db = $db;
		global $array_movie;
		$this->array_movie=$array_movie;
		global $array_movie_date;
		$this->array_movie_date=$array_movie_date;
	}
	public function index(){
		

		//データ更新
		if($_REQUEST[ 'regist' ]){
			$edit = [];
			$edit[ 'edit' ][ 'session_text' ] = $_REQUEST[ 'sessiontext' ];
			$edit[ 'edit' ][ 'poster_text' ] = $_REQUEST[ 'postertext' ];
			$edit[ 'edit' ][ 'judge_text' ] = $_REQUEST[ 'judgetext' ];
			$edit[ 'edit' ][ 'sessionlist_text' ] = $_REQUEST[ 'sessionlisttext' ];
			$edit[ 'edit' ][ 'chat_text' ] = $_REQUEST[ 'chattext' ];
			$edit[ 'where' ]['id'] = 1;
			$table = "movie_explain";
			$this->db->editUserData($table,$edit);
		}
		//データ取得
		$data = $this->db->getMovieExplain();
		$html['explain'] = $data;

		return $html;
	}

}
?>