<?PHP
class prof{
	function __construct(){
		global $db;
		global $html;
		$this->db   = $db;
		$this->html = $html;
	}
	public function index(){
		$data = $this->getUser();
		$html = $data;
		if($_REQUEST[ 'back' ]){
			$html[ 'file' ] = "";
		}else
		if(isset($_REQUEST[ 'mod' ]) && $_REQUEST[ 'mod' ] == "regconf"){
			//---------------------------------------------------
			//確認画面表示
			//---------------------------------------------------
			$edit = array();
			$edit[ 'name'      ] = $_REQUEST[ 'name'      ];
			$edit[ 'email'     ] = $_REQUEST[ 'email'     ];
			$edit[ 'login_pw'  ] = $_REQUEST[ 'login_pw'  ];
			$edit[ 'logo'      ] = $_REQUEST[ 'logo'      ];
			$edit[ 'id'        ] = $data[0][ 'id'         ];
			$this->editData($edit);
			header("Location:".D_URL."prof/");
			exit();

		}
		//---------------------------------------------------
		//確認画面表示
		//---------------------------------------------------
		if(isset($_REQUEST[ 'mod' ]) && $_REQUEST[ 'mod' ] == "profconf"){
			//エラーチェック
			if(!$_REQUEST[ 'name' ]){
				$html[ 'error' ][0] = "名前が入力されていません。";
			}
			if(!$_REQUEST[ 'email' ] || !preg_match("/^[a-zA-Z0-9@\.\-]+$/",$_REQUEST[ 'email' ]) ){
				$html[ 'error' ][1] = "メールアドレスに誤りがあります。";
			}
			if(!$_REQUEST[ 'login_pw' ] || !preg_match("/^[a-zA-Z0-9]+$/",$_REQUEST[ 'login_pw' ])  ){
				$html[ 'error' ][1] = "パスワードに誤りがあります。";
			}
			if(strlen($_REQUEST[ 'login_pw' ]) > 8 || strlen($_REQUEST[ 'login_pw' ]) < 4){
				$html[ 'error' ][1] = "パスワードは4文字以上8文字以下で入力してください。";
			}

			if(strlen($_FILES[ 'images' ][ 'name' ]) > 0  && $_FILES[ 'images' ][ 'error' ] == 0){
				//画像保存
				$path = D_LOGO_PATH.$data[0][ 'id' ];
				$imgs = $this->db->imageResize($_FILES,$path);
				$html[ 'confimg' ] = basename($imgs);

			}
			if(count($html[ 'error' ]) == 0 ){
				//読み込みテンプレート
				$html[ 'file' ] = $_REQUEST[ 'mod' ];
			}
			//画像登録
			
		}
		return $html;
	}
	private function editData($edit){
		$name     = $edit[ 'name'      ];
		$email    = $edit[ 'email'     ];
		$login_pw = $edit[ 'login_pw'  ];
		$logo     = $edit[ 'logo'      ];
		$id       = $edit[ 'id'        ];
		$sql = "
				UPDATE  t_user SET 
					name = '".mysql_real_escape_string($name)."'
					,email = '".mysql_real_escape_string($email)."'
					,login_pw = '".mysql_real_escape_string($login_pw)."'
					,logo = '".mysql_real_escape_string($logo)."'
				WHERE
					id = ".$id."
				";
		mysql_query($sql);
	}
	private function getUser(){
		$sql = "
				SELECT * FROM t_user
					WHERE
					id='".mysql_real_escape_string($this->html[ 'id' ])."'
				";
		$r   = mysql_query($sql);
		$i = 0;
		while($rst = mysql_fetch_assoc($r)){
			$rlt[$i] = $rst;
			$i++;
		}
		return $rlt;
	}
}
?>