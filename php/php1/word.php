<?PHP
class word{
	function __construct(){
		global $db;
		$this->db = $db;
		global $PHPWord;
		global $first;
		global $sec;

		global $array_happyo;
		global $array_studentPoster;
		global $array_ippanKouenposter;		
		global $array_ippanKouenkouto;
	}
	public function index(){
		global $PHPWord;
		global $array_happyo;
		global $array_studentPoster;
		global $array_ippanKouenkouto;
		global $array_ippanKouenposter;
		global $first;
		global $sec;
		global $three;


		if($sec){
			preg_match("/[0-9]/",$sec,$keys);
			if(preg_match("/^happyo/",$sec)){
				//ポスター編成用
				$data = $this->db->getIndivi($keys[0]);
				
					switch($keys[0]){ //一般公演ポスターの処理を一般公演口頭でも使えるようにする

								case 4:
								$ko_po = "ippanKouenkouto";
								$array_ko_po = $array_ippanKouenkouto;
								$cnt = 4;
								break;
								
								case 5:
								$ko_po = "ippanKouenposter";
								$array_ko_po = $array_ippanKouenposter;
								$cnt = 5;
								break;	
							default:
				}

				//一般講演ポスターの分類
				if($keys[0] == $cnt){
					foreach($data as $key=>$valueposter){
						$poster[ $valueposter[$ko_po] ][$key] = $valueposter;
					}
				}
				$date = date("Y-m-d");
				header("Content-type: application/vnd.ms-word");
				$date = date("Y-m-d");
				header("Content-Disposition: attachment;Filename=/data/download/invite-".$date.".doc");
				echo "<html>";
				echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
				echo "<body>";
				//一般講演ポスターの分類
				if($keys[0] == $cnt){
					foreach($poster as $pkeys=>$values){
						echo "<p align='center'><b>";
						echo "【";
						echo $array_ko_po[$pkeys][ 'name' ];
						echo "】";
						echo "</b><p />";
						foreach($values as $key=>$val){
							echo $val[ 'code' ];
							if($val[ 'studentPoster' ]){
								echo " ";
								echo $array_studentPoster[ $val[ 'studentPoster' ] ];
							}
							echo "<br />";
							$endai = preg_replace("/\<br \/\>$/","",$val[ 'endainame' ]);
							$endai = strip_tags($endai,"<em><br /><sup><sub><strong><b><u><i>");
							echo $endai."(".$val[ 'ryaku' ].")".$val[ 'tyosyaname' ];
							echo "<br />";
							echo "<br />";
						}
					}
				}else{
					foreach($data as $key=>$val){
						echo $val[ 'code' ];
						if($val[ 'studentPoster' ]){
							echo " ";
							echo $array_studentPoster[ $val[ 'studentPoster' ] ];
						}
						echo "<br />";
						$endai = preg_replace("/\<br \/\>$/","",$val[ 'endainame' ]);
						$endai = strip_tags($endai,"<em><br /><sup><sub><strong><b><u><i>");
						echo $endai."(".$val[ 'ryaku' ].")".$val[ 'tyosyaname' ];
						echo "<br />";
						echo "<br />";
					}
				}
				echo "</body>";
				echo "</html>";

				exit();
			}else{
				//予稿原稿用のときは発表番号があるもののみ取得
				$data = $this->db->getIndivi($keys[0],1);

				//一般講演ポスターの分類
				if($keys[0] == $cnt){
					foreach($data as $key=>$val){
						$poster[ $val[ $ko_po ] ][$key] = $val;
					}
				}
				$date = date("Y-m-d");
				header("Content-type: application/vnd.ms-word");
				$date = date("Y-m-d");
				header("Content-Disposition: attachment;Filename=/data/download/yoko-".$date.".doc");
				echo "<html>";
				echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
				echo "<body>";

				//一般講演ポスターの分類
				if($keys[0] == $cnt){
					foreach($poster as $keys=>$value){
						echo "<p align='center'><b>";
						echo "【";
						echo $array_ko_po[$keys][ 'name' ];
						echo "】";
						echo "</b><p />";
						foreach($value as $key=>$val){

							echo "<table style='border:none;'>";
							echo "<tr>";
							echo "<td style='vertical-align:top;border:none;' >".$val[ 'publication' ]."</td>";
							$endai = strip_tags($val[ 'endainame' ],"<b><i><u><em><SUP><SUB>");
							echo "<td style='vertical-align:top;border:none;'>".$endai."(".$val[ 'ryaku' ].")".$val[ 'tyosyaname' ]."</td>";
							echo "</tr>";
							echo "</table>";
/*
							echo $val[ 'publication' ];
							echo "　";
							//$endai = preg_replace("/\<br \/\>$/","",$val[ 'endainame' ]);
							$endai = strip_tags($val[ 'endainame' ],"<b><i><u><em><SUP><SUB>");
							if($_REQUEST[ 'flg' ] == "en"){
								//英語の時は所属を出さない
								echo $endai.$val[ 'tyosyaname' ];
							}else{
								echo $endai."(".$val[ 'ryaku' ].")".$val[ 'tyosyaname' ];
							}
							echo "<br />";
							//echo "<br />";
*/
						}
					}
				}else{
					//var_dump($data);exit;
					
					foreach($data as $key=>$val){
						echo $val[ 'publication' ];
						echo "　";
						//$endai = preg_replace("/\<br \/\>$/","",$val[ 'endainame' ]);
						$endai = strip_tags($val[ 'endainame' ],"<b><i><u><SUP><em><SUB>");
						if($_REQUEST[ 'flg' ] == "en"){
							//英語の時は所属を出さない
							echo $endai.$val[ 'tyosyaname' ];
						}else{
							echo $endai."(".$val[ 'ryaku' ].")".$val[ 'tyosyaname' ];
						}
						echo "<br />";
						//echo "<br />";
					}
				}
				echo "</body>";
				echo "</html>";

				exit();

			}
		}
		$html[ 'array_happyo' ] = $array_happyo;
		return $html;
	}

}
?>