<?PHP
class csv{
	function __construct(){
		global $db;     //DB接続
		$this->db = $db;

		global $array_address;
		$this->array_address = $array_address;
		global $array_join_type;
		$this->array_join_type = $array_join_type;
		global $array_join_type;
		$this->array_konshinkai_sts = $array_konshinkai_sts;
		global $array_pay_sts;
		$this->array_pay_sts = $array_pay_sts;
		global $array_syozoku;
		$this->array_syozoku = $array_syozoku;
		global $array_happyo;
		$this->array_happyo = $array_happyo;
		global $array_ippanKouenkouto;
		$this->array_ippanKouenkouto = $array_ippanKouenkouto;
		global $array_ippanKouenposter;
		$this->array_ippanKouenposter = $array_ippanKouenposter;  //DB  SELECT * FROM `ippankouenposter_mst`
		global $array_pc;
		$this->array_pc = $array_pc;
		global $array_saitaku;
		$this->array_saitaku = $array_saitaku;
		global $endaiform;
		global $array_syotai;
		$this->array_syotai = $array_syotai;
		global $array_korokiumu;
		$this->array_korokiumu = $array_korokiumu;
	}


	public function index(){
	    $data = $this->db->getCSVDataList();
		// 出力

		$fileName = "endai_" . date("YmdHis") . ".csv";
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $fileName);
		//echo $csv;

		echo mb_convert_encoding("講演番号",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("参加ＩＤ",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("講演者名",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("講演者名(かな)",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("メールアドレス",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("所属学協会",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("その他",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("入会申請中",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("発表形式",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("招待依頼講演のセッション",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("コロキウムのセッション",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("一般講演口頭の分類",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("一般講演ポスターの分類",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("学生ポスター賞審査希望",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("演題名",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("所属機関総数",'SJIS-WIN','UTF-8');
		for($i=1;$i<=15;$i++){
		    echo ",".mb_convert_encoding("所属機関(大学/勤務先)".$i,'SJIS-WIN','UTF-8');
		    echo ",".mb_convert_encoding("所属機関(学部/部署)".$i,'SJIS-WIN','UTF-8');
		    echo ",".mb_convert_encoding("所属機関(略名)".$i,'SJIS-WIN','UTF-8');
		    echo ",".mb_convert_encoding("所属機関(英語)(大学/勤務先)".$i,'SJIS-WIN','UTF-8');
		    echo ",".mb_convert_encoding("所属機関(英語)(学部/部署)".$i,'SJIS-WIN','UTF-8');
		}
		echo ",".mb_convert_encoding(",著者総数",'SJIS-WIN','UTF-8');

		for($i=1;$i<=15;$i++){
		    echo ",".mb_convert_encoding("著者名(和)(姓)".$i,'SJIS-WIN','UTF-8');
		    echo ",".mb_convert_encoding("著者名(和)(名)".$i,'SJIS-WIN','UTF-8');
		    echo ",".mb_convert_encoding("著者名(英)(姓)".$i,'SJIS-WIN','UTF-8');
		    echo ",".mb_convert_encoding("著者名(英)(名)".$i,'SJIS-WIN','UTF-8');
		    echo ",".mb_convert_encoding("所属番号".$i,'SJIS-WIN','UTF-8');
		}
		echo ",".mb_convert_encoding("PC情報",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("PCその他",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("備考",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("講演者ID",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("採択結果",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("採択テキスト",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("著者名",'SJIS-WIN','UTF-8');
		echo ",".mb_convert_encoding("受賞連絡先（指導教員）",'SJIS-WIN','UTF-8');


		echo "\n";


		foreach($data as $key=>$val){
			echo $val[ 'code' ];
			echo ",".$val[ 'scode' ];
			echo ",".mb_convert_encoding($val[ 'name1' ],'SJIS-WIN','UTF-8').mb_convert_encoding($val[ 'name2' ],'SJIS-WIN','UTF-8');
			echo ",".mb_convert_encoding($val[ 'kana1' ],'SJIS-WIN','UTF-8').mb_convert_encoding($val[ 'kana2' ],'SJIS-WIN','UTF-8');
			echo ",".$val[ 'emailaddress' ];
			echo ",".$this->db->commaEscape4csv($val[ 'syozoku' ]);
			echo ",".mb_convert_encoding($val[ 'other' ],'SJIS-WIN','UTF-8');
			echo ",".mb_convert_encoding($val[ 'nyukai' ],'SJIS-WIN','UTF-8');
			
			
			echo ",".mb_convert_encoding($this->array_happyo[$val[ 'happyo' ]][ 'name' ],'SJIS-WIN','UTF-8');

			echo ",".mb_convert_encoding($this->array_syotai[$val[ 'syoutai' ]][ 'name' ],'SJIS-WIN','UTF-8');
			echo ",".mb_convert_encoding($this->array_korokiumu[$val[ 'korokiumu' ]][ 'name' ],'SJIS-WIN','UTF-8');

			echo ",".mb_convert_encoding($this->array_ippanKouenkouto[$val[ 'ippanKouenkouto' ]]['name'],'SJIS-WIN','UTF-8');
			echo ",".mb_convert_encoding($this->array_ippanKouenposter[$val[ 'ippanKouenposter' ]][ 'name' ],'SJIS-WIN','UTF-8');//
			if($val[ 'studentPoster' ]){
				echo ",".mb_convert_encoding($val[ 'studentPoster' ],'SJIS-WIN','UTF-8');
			}else{
				echo ",";
			}

			echo ",".str_replace("\r\n","",str_replace(",","，",mb_convert_encoding(strip_tags($val[ 'endainame' ]),'SJIS-WIN','UTF-8')));
			echo ",".mb_convert_encoding($val[ 'syozoku_count' ],'SJIS-WIN','UTF-8');
			for($j=0;$j<15;$j++){
				echo ",".mb_convert_encoding($val[ 'syozokuKikanD_txt' ][$j],'SJIS-WIN','UTF-8');
				echo ",".mb_convert_encoding($val[ 'syozokuKikanG_txt' ][$j],'SJIS-WIN','UTF-8');
				echo ",".mb_convert_encoding($val[ 'syozokuKikanRyaku_txt' ][$j],'SJIS-WIN','UTF-8');
				echo ",".mb_convert_encoding($val[ 'syozokuKikanDEng_txt' ][$j],'SJIS-WIN','UTF-8');
				echo ",".mb_convert_encoding($val[ 'syozokuKikanGEng_txt' ][$j],'SJIS-WIN','UTF-8');
			}
			echo ",";
			echo ",".mb_convert_encoding($val[ 'tyosya_count' ],'SJIS-WIN','UTF-8');
			
			for($j=0;$j<15;$j++){
				echo ",".mb_convert_encoding($val[ 'tyosya_name1_txt' ][$j],'SJIS-WIN','UTF-8');
				echo ",".mb_convert_encoding($val[ 'tyosya_name2_txt' ][$j],'SJIS-WIN','UTF-8');
				echo ",".mb_convert_encoding($val[ 'tyosya_name1Eng_txt' ][$j],'SJIS-WIN','UTF-8');
				echo ",".mb_convert_encoding($val[ 'tyosya_name2Eng_txt' ][$j],'SJIS-WIN','UTF-8');
				echo ",".$this->db->commaEscape4csv($val[ 'tyosya_syozoku_txt' ][$j]);
				
			}
			echo ",".mb_convert_encoding($this->array_pc[$val[ 'pc' ]][ 'name' ],'SJIS-WIN','UTF-8');
			echo ",".mb_convert_encoding($this->db->commaEscape4csv($val[ 'otheros' ]),'SJIS-WIN','UTF-8');
			echo ",".mb_convert_encoding(str_replace("\r\n", '', $val[ 'bikou' ]),'SJIS-WIN','UTF-8');
			echo ",".mb_convert_encoding($val[ 'publication' ],'SJIS-WIN','UTF-8');
			echo ",".mb_convert_encoding($this->array_saitaku[$val[ 'vote' ]],'SJIS-WIN','UTF-8');
			echo ",".mb_convert_encoding(str_replace("\r\n", '',$val[ 'vote_text' ]),'SJIS-WIN','UTF-8');
			echo ",".mb_convert_encoding($val[ 'tyosyaname' ],'SJIS-WIN','UTF-8');
			$teacher = "";
			if($val['teacher']){
				$teacher = mb_convert_encoding($val[ 'tyosya_name1_txt' ][$val[ 'teacher' ]-1],'SJIS-WIN','UTF-8');
				$teacher .= mb_convert_encoding($val[ 'tyosya_name2_txt' ][$val[ 'teacher' ]-1],'SJIS-WIN','UTF-8');
			}
			echo ",".$teacher;

			echo "\n";

		}
		exit();
	}

}
?>