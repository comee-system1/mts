<?PHP

class result{
	function __construct(){
		global $db;
		$this->db = $db;
		global $array_movie;
		$this->array_movie=$array_movie;
		global $array_movie_date;
		$this->array_movie_date=$array_movie_date;
	}
	public function index(){
		
		$lists = $this->db->getCsvResult();

		// 出力情報の設定
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".date('Ymd').".csv");
		header("Content-Transfer-Encoding: binary");
		//1行目ラベルを作成
		$csv = '"分野","審査員名","","発表番号","審査結果","賞推薦","該当なし","備考","演題",';
		for($i=1;$i<=15;$i++){
			$csv .= "所属".$i.",";
		}
		for($i=1;$i<=15;$i++){
			$csv .= "著者".$i.",";
		}
		$csv .= "著者名"."\n";

		foreach($lists as $key=>$value){
			$csv .= "\"".$value['ippanKouenposterName']."\",";
			$csv .= "\"".$value['name1'].$value[ 'name2' ]."\",";
			$csv .= "\"".$value['code']."\",";
			$csv .= "\"".$value['judge_publication']."\",";
			$csv .= "\"".$value['result_select']."\",";
			$csv .= "\"".$value['recomen']."\",";
			$csv .= "\"".$value['recomCheck']."\",";
			$csv .= "\"".$value['other']."\",";
			$csv .= "\"".$value['endainame']."\",";

			$syozoku_name = $value[ 'syozoku_name' ];
			for($i=1;$i<=15;$i++){
				if($syozoku_name[$i]){
					$csv .= "\"".$syozoku_name[$i]."\",";
				}else{
					$csv .= ",";
				}
			}

			$tyosya_list = $value[ 'tyosya_list' ];
			for($i=1;$i<=15;$i++){
				if($tyosya_list[$i]){
					$csv .= "\"".$tyosya_list[$i]."\",";
				}else{
					$csv .= ",";
				}
			}
			
			$csv .= "\"".$value[ 'tyosya_main' ]."\",";
			$csv .= "\n";
		}

		// CSVファイル出力
		echo mb_convert_encoding($csv,"SJIS", "UTF-8");

		exit();
		
	}

}
?>