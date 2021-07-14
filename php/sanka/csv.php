<?PHP
class csv{
	function __construct(){
		global $db;
		$this->db = $db;

		global $array_address;
		$this->array_address = $array_address;
		global $array_join_type;
		$this->array_join_type = $array_join_type;
		global $array_konshinkai_sts;
		$this->array_konshinkai_sts = $array_konshinkai_sts;
		global $array_pay_sts;
		$this->array_pay_sts = $array_pay_sts;
	}
	public function index(){
	    $data = $this->db->getCsvData();
		// 出力
		$fileName = "join_" . date("YmdHis") . ".csv";
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $fileName);
		echo $csv;

		echo mb_convert_encoding("参加受付番号","SJIS","UTF-8");
		echo mb_convert_encoding(",登録者名(姓)","SJIS","UTF-8");
		echo mb_convert_encoding(",登録者名(名)","SJIS","UTF-8");
		echo mb_convert_encoding(",フリガナ(姓)","SJIS","UTF-8");
		echo mb_convert_encoding(",フリガナ(名)","SJIS","UTF-8");
		echo mb_convert_encoding(",所属機関 (大学 / 勤務先)","SJIS","UTF-8");
		echo mb_convert_encoding(",所属機関 (学部 / 部署)","SJIS","UTF-8");
		echo mb_convert_encoding(",所属機関 (研究室)","SJIS","UTF-8");
		echo mb_convert_encoding(",連絡先郵便番号","SJIS","UTF-8");
		echo mb_convert_encoding(",連絡先選択","SJIS","UTF-8");
		echo mb_convert_encoding(",連絡先住所","SJIS","UTF-8");
		echo mb_convert_encoding(",連絡先電話番号","SJIS","UTF-8");
		echo mb_convert_encoding(",内線","SJIS","UTF-8");
		echo mb_convert_encoding(",連絡先FAX番号","SJIS","UTF-8");
		echo mb_convert_encoding(",E-mail","SJIS","UTF-8");
		echo mb_convert_encoding(",パスワード","SJIS","UTF-8");
		echo mb_convert_encoding(",専門分野","SJIS","UTF-8");
		echo mb_convert_encoding(",専門分野(その他)","SJIS","UTF-8");
		echo mb_convert_encoding(",参加者の所属協会","SJIS","UTF-8");
		echo mb_convert_encoding(",参加者の所属協会(その他)","SJIS","UTF-8");
		echo mb_convert_encoding(",参加登録種別","SJIS","UTF-8");
		echo mb_convert_encoding(",懇親会参加","SJIS","UTF-8");
		echo mb_convert_encoding(",講演会参加費","SJIS","UTF-8");
		echo mb_convert_encoding(",懇親会参加費","SJIS","UTF-8");
		echo mb_convert_encoding(",合計","SJIS","UTF-8");
		echo mb_convert_encoding(",参加費確認","SJIS","UTF-8");
		echo mb_convert_encoding(",更新日","SJIS","UTF-8");
		echo "\n";

		foreach($data as $key=>$val){
			echo $val[ 'code' ];
			echo ",".mb_convert_encoding($val[ 'name1'         ],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'name2'         ],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'kana1'         ],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'kana2'         ],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'daigaku'       ],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'gakubu'        ],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'kenkyu'        ],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'post'           ],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($this->array_address[$val[ 'address_type'  ]],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'address'        ],"sjis-win","utf-8");
			echo ",=\"".mb_convert_encoding($val[ 'tel'            ],"sjis-win","utf-8")."\"";
			echo ",=\"".mb_convert_encoding($val[ 'naisen'         ],"sjis-win","utf-8")."\"";
			echo ",=\"".mb_convert_encoding($val[ 'fax'          ],"sjis-win","utf-8")."\"";
			echo ",=\"".mb_convert_encoding($val[ 'mail'         ],"sjis-win","utf-8")."\"";
			echo ",=\"".mb_convert_encoding($val[ 'password'        ],"sjis-win","utf-8")."\"";
			echo ",".mb_convert_encoding(preg_replace("/,/","，",$val[ 'sankaformselect'        ]),"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'sankaformselectother'        ],"sjis-win","utf-8");
			
			
			echo ",".mb_convert_encoding(preg_replace("/,/","，",$val[ 'syozokuSankaformselect'        ]),"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'syozokuSankaformselectOther'        ],"sjis-win","utf-8");
			
			echo ",".mb_convert_encoding($this->array_join_type[$val[ 'join_type'  ]],"sjis-win","utf-8");
			
			echo ",".mb_convert_encoding($this->array_konshinkai_sts[$val[ 'koushinkai'  ]],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'sanka_money'            ],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'konshinkai_monay'       ],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'total'            ],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($this->array_pay_sts[$val[ 'sanka_pay_status'  ]],"sjis-win","utf-8");
			echo ",".mb_convert_encoding($val[ 'regist_ts'            ],"sjis-win","utf-8");


			echo "\n";
		}
		exit();
	}

}
?>