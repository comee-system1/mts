<?PHP
class mail{
	function __construct(){
		global $db;
		$this->db = $db;
		global $array_mail;
		$this->array_mail = $array_mail;
		global $array_mailEdit;
		$this->array_mailEdit = $array_mailEdit;
		global $array_mailEdit2;
		$this->array_mailEdit2 = $array_mailEdit2;

	}
	public function index(){
		//メール内容登録
		if($_REQUEST[ 'regist' ]){
			$set = array();
			$set[ 'mailtype' ] = $_REQUEST[ 'mailtype' ];
			$set[ 'title'    ] = $_REQUEST[ 'title' ];
			$set[ 'titleEdit'    ] = $_REQUEST[ 'titleEdit' ];
			$set[ 'note'     ] = $_REQUEST[ 'note' ];
			$this->db->setMailData($set);
		}
		//メールデータ取得
		$get = array();
		$get[ 'mailtype' ] = 3;
		$rlt = $this->db->getMailData($get);
		//メール内容selectのselected
		$html[ 'sel'     ] = 3;
		$html[ 'rlt'     ] = $rlt;
		$html[ 'arymail' ] = $this->array_mail;
		$html[ 'array_mailEdit'  ] = $this->array_mailEdit;
		$html[ 'array_mailEdit2' ] = $this->array_mailEdit2;
		return $html;
	}


}
?>