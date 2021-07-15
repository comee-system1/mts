<?php
class movie{
    function __construct(){
        date_default_timezone_set('Asia/Tokyo');
		global $db;
        $this->db = $db;
		global $array_movie_date;
        $this->array_movie_date = $array_movie_date;
		global $array_movie;
        $this->array_movie = $array_movie;
        global $array_ippanKouenposter;
        $this->array_ippanKouenposter = $array_ippanKouenposter;
        global $array_judge;
        $this->array_judge = $array_judge;
        global $five;
        $this->five = $five;
        global $four;
        $this->four = $four;
        global $third;
        $this->third = $third;
        global $first;
        $this->first = $first;
        global $sec;
        $this->sec = $sec;

        global $tcpdf;
        $this->tcpdf = $tcpdf;
        global $pdf;
        $this->pdf = $pdf;

        //現在の利用確認
        $this->status = $this->db->getKagakuUser();
        $this->errorfile = "";
        /*
        if($status ["movie_status"] == 1){
            //エラーページ
            $this->errorfile = "error";
            $this->index();
            
        }
        */
        


        $key = 0;

        //キーは7日の9時とする
        $array_times[7][9][$key++] = [
            'code'=>'',
            'date'=>'9-7',
            'endainame'=>"開会の挨拶",
            'sub'=>"",
            'zatyo_name'=>"〇佐藤太郎",
            'zatyo_group'=>"東北大学",
            'tyosya_name'=>"",
            'syozokuKikanRyaku'=>"",
            'time'=>'09:00～09:10',
            'number'=>'',
            'other'=>'',
            'url'=>'',
            'pdf'=>'',
            'publication'=>'',
            'chat'=>0,
            'top'=>0,
            'height'=>''
        ];

        
        $array_times[7][9][$key++] = [
            'date'=>'9-7',
            'endainame'=>"【依頼講演：1. ニューノーマルと分析化学】",
            'sub'=>"呼気オミックスによる新型コロナ感染診断法と未来型医療",
            'zatyo_name'=>"〇赤池 孝章",
            'zatyo_group'=>"東北大医",
            'tyosya_name'=>"",
            'syozokuKikanRyaku'=>"",
            'time'=>'09:10～09:40',
            'number'=>'',
            'other'=>'',
            'url'=>'http://yahoo.com',
            'pdf'=>'7a79c35f7ce0704dec63be82440c8182.pdf',
            'dl'=>'sample.mp4',
            'publication'=>'A0001',
            'chat'=>1,
            'top'=>50,
            'height'=>''
        ];
        $array_times[7][9][$key++] = [
            'date'=>'9-7',
            'endainame'=>"【依頼講演：1. ニューノーマルと分析化学】",
            'sub'=>"ニューノーマルと体外診断薬",
            'zatyo_name'=>"〇佐藤 貴哉",
            'zatyo_group'=>"日立化成DS",
            'tyosya_name'=>"",
            'syozokuKikanRyaku'=>"",
            'time'=>'09:40～10:10',
            'number'=>'',
            'other'=>'',
            'url'=>'http://google.com',
            'pdf'=>'7a79c35f7ce0704dec63be82440c8182.pdf',
            'dl'=>'sample.mp4',
            'publication'=>'A0002',
            'chat'=>1,
            'top'=>100,
            'height'=>''
        ];
        $array_times[7][10][$key++] = [
            'date'=>'9-7',
            'endainame'=>"",
            'sub'=>"ナフタレンジイミド誘導体によるウイルス4本鎖RNAの検出",
            'zatyo_name'=>"〇竹中 繁織",
            'zatyo_group'=>"九工大院工",
            'tyosya_name'=>"○竹中 繁織 ・ 佐藤 しのぶ ・ Zou Tingting ・ 安川 瑠依 ・ 佐藤 友香 ・ 金好 秀馬",
            'syozokuKikanRyaku'=>"九工大院工",
            'time'=>'10:10～10:40',
            'number'=>'',
            'other'=>'',
            'url'=>'http://google.com',
            'pdf'=>'7a79c35f7ce0704dec63be82440c8182.pdf',
            'dl'=>'sample.mp4',
            'publication'=>'A0003',
            'chat'=>1,
            'top'=>30,
            'height'=>60
        ];

        $array_times[8][9][$key++] = [
            'date'=>'9-8',
            'endainame'=>"",
            'sub'=>"ナフタレンジイミド誘導体によるウイルス4本鎖RNAの検出",
            'zatyo_name'=>"〇竹中 繁織",
            'zatyo_group'=>"九工大院工",
            'tyosya_name'=>"○竹中 繁織 ・ 佐藤 しのぶ ・ Zou Tingting ・ 安川 瑠依 ・ 佐藤 友香 ・ 金好 秀馬",
            'syozokuKikanRyaku'=>"九工大院工",
            'time'=>'09:10～09:40',
            'number'=>'',
            'other'=>'',
            'url'=>'http://google.com',
            'pdf'=>'7a79c35f7ce0704dec63be82440c8182.pdf',
            'dl'=>'sample.mp4',
            'publication'=>'B0001',
            'chat'=>1,
            'top'=>20,
            'height'=>80
        ];

        $array_times_session = [];
        $n=0;
        foreach($array_times as $values){
            foreach($values as $val){
                foreach($val as $k=>$v){
                    $array_times_session[$v[ 'date' ]][$n] = $v;
                    $n++;
                }
            }
        }

        $this->array_times = $array_times;
        $this->array_times_session = $array_times_session;


        //ポスターデータ
        $array_poster[] = [
            'publication'=>'p0001',
            'endainame'=>'ポスターサンプル',
            'sub'=>'',
            'syozokuKikanRyaku'=>'九工大院工',
            'tyosya_name'=>'○竹中 繁織 ・ 佐藤 しのぶ ・ Zou Tingting',
            'fileUpdate_flash_ext'=>'sample1.mp4',
            'fileUpdate_poster_ext'=>'PC112-P0227-CSJ-TOHOKU20-20200824152633.pdf',
            'fileUpdate_ext'=>'7a79c35f7ce0704dec63be82440c8182.pdf',
        ];
        //ポスターデータ
        $array_poster[] = [
            'publication'=>'p0002',
            'endainame'=>'ポスターサンプル2',
            'sub'=>'',
            'syozokuKikanRyaku'=>'九工大院工2',
            'tyosya_name'=>'○竹中 繁織 ・ 佐藤 しのぶ ・ Zou Tingting',
            'fileUpdate_flash_ext'=>'sample1.mp4',
            'fileUpdate_poster_ext'=>'PC112-P0227-CSJ-TOHOKU20-20200824152633.pdf',
            'fileUpdate_ext'=>'7a79c35f7ce0704dec63be82440c8182.pdf',
        ];

        $this->array_poster = $array_poster;
    }
    
    public function index(){
        //エラーページ
        if($this->errorfile){
            $data[ 'file' ] = $this->errorfile;
            unset($_SESSION[ 'movies' ]);
        }
        if($_SESSION[ 'movies' ][ 'login' ] == "on"){
            //一覧ページに遷移
            header("Location:/movie/list");
            exit();
            
        }else{
            unset($_SESSION[ 'movies' ]);
            //ログインしていないとき
            $data = $this->logincheck();
        }
        return $data;
    }
    public function logout(){
        unset($_SESSION[ 'movies' ]);
        header("Location:/movie/");
        exit();
    }
    /***********
     * mp4の表示
     */
    public function flash(){
        //拡張子を消す
        $ex = explode(".",$this->third);
        $mp4 = $ex[0].".mp4";

        $html['mp4'] = $mp4;
        return $html;
    }
    /********
     * 一覧
     */
    public function list(){

/*
        //ログインしているときのみ
        if($_SESSION[ 'movies' ][ 'selecter' ] != 1 ){
            if($this->status["movie_status"] == 1 ){
                //エラーページ
                $this->errorfile = "error";
                $this->index();
                
            }
        }
  */      
        if($_SESSION[ 'movies' ][ 'login' ] == "on"){
            if($_REQUEST[ 'ajax' ]){
                //ポスター発表データ取得
                //$poster = $this->db->getPosterList();
                $poster = $this->array_poster;
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($poster);
                exit();
            }
            //審査判定
            if($_REQUEST[ 'judgeAjax' ]){
                $table = "sanka_judge";
                //備考の登録
                if($_REQUEST[ 'other' ]){
                    $edit = [];
                    $edit[ 'where' ][ 'id' ] = $_REQUEST[ 'id' ];
                    $edit[ 'edit' ][ 'other' ] = $_REQUEST[ 'other' ];

                }else
                if(strlen($_REQUEST[ 'recommen' ]) > 0 ){
                    //一旦全てを0にする
                    $edit = [];
                    $edit[ 'where' ][ 'code' ] = $_SESSION['movies'][ 'code' ];
                    $edit[ 'edit' ][ 'recomen' ] = 0;
                    
                    $this->db->editUserData($table,$edit);

                    $edit = [];
                    $edit[ 'where' ][ 'id' ] = $_REQUEST[ 'id' ];
                    $edit[ 'edit' ][ 'recomen' ] = $_REQUEST[ 'recommen' ];
                }else{
                    $edit = [];
                    $edit[ 'where' ][ 'id' ] = $_REQUEST[ 'id' ];
                    $edit[ 'edit' ][ 'result_select' ] = $_REQUEST[ 'judge' ];
                }
                $this->db->editUserData($table,$edit);
                exit();
            }

            //出力確認
            //出力は一度のみ
            $where = [];
            $where[ 'code' ] = $_SESSION['movies'][ 'code' ];
            $check = $this->db->getRecipeLog($where);

            if(empty($check)){
                $html['recipeflag'] = true;
            }else{
                $html['recipeflag'] = false;
            }
            $html['array_movie'] = $this->array_movie;
            $html['array_movie_date'] = $this->array_movie_date;
            $html['array_ippanKouenposter'] = $this->array_ippanKouenposter;
            $html['array_judge'] = $this->array_judge;
            $html['array_times'] = $this->array_times;
            
            //説明文の取得
            $explain = $this->db->getMovieExplain();
            $html['explain'] = $explain;

            $list = $this->db->getMovieList();
            $html['list']=$list;

            //審査員のときのみ
            if($_SESSION[ 'movies' ][ 'judge' ] == "on"){
                $where = [];
                $where[ 'code' ] = $_SESSION[ 'movies' ][ 'code' ];
                $judgelist = $this->db->checkJudgeData($where);
                $html['judgelist']=$judgelist;
                  
            }

            return $html;
        }else{
            header("Location:/movie/");
            exit();
        }
    }
    /********
    * session画面
    */
    public function session(){
        if($_SESSION[ 'movies' ][ 'login' ] == "on"){
            //説明文
            $explain = $this->db->getMovieExplain();
            $html['explain'] = $explain[ 'sessionlist_text' ];

            /*
            //講演者データ取得
            $data=[];
            foreach($this->array_movie_date as $key=>$val){
                $ex = explode("-",$key);
                $day = $ex[2];
                $where = [];
                $where['day'] = $day;
                $data[$day] = $this->db->getSessionData($where);

            }
            //動画情報取得
            $html[ 'zoom' ] = $this->db->getMoveData();
            $html['list'] = $data;          
            */
            $html[ 'list' ] = $this->array_times_session;
            return $html;
        }else{
            header("Location:/movie/");
            exit();
        }
    }
    
    public function logincheck(){
        //ログインチェック
        $data = [];
        if(filter_input(INPUT_POST,"login")){    


            $user = $this->db->getMovieLogin();

            if($user){
                $_SESSION[ 'movies' ][ 'login' ] = "on";
                $_SESSION[ 'movies' ][ 'id' ] = $user[ 'id' ];
                $_SESSION[ 'movies' ][ 'num' ] = $user[ 'num' ];
                $_SESSION[ 'movies' ][ 'code' ] = $user[ 'code' ];
                $_SESSION[ 'movies' ][ 'selecter' ] = $user[ 'selecter' ];
                //審査員かどうかの確認
                if($this->db->checkJudgeMan($user)){
                    $_SESSION[ 'movies' ][ 'judge' ] = "on";
                }
                
                header("Location:/movie/list");
                exit();
            }else{
                $data['errmsg'] = "ログインに失敗しました。";
            }

        }
        
        return $data;
        
    }
    
    /***************
     * チャット
     */
    public function chat(){
        if($_SESSION[ 'movies' ][ 'login' ] == "on"){
            
            //ポスターの時
            if($this->third == "poster"){
                $id = $this->four;
                $list_station_cd= array_column($this->array_poster, 'publication');
                $key = array_search($id, $list_station_cd);
                $posterdata = $this->array_poster[$key];
            }else{
                //チャット登録
                $id = $this->five;
                //取得データの保存を行う
                $posterdata = $this->array_times_session[$this->third][$this->four];
            }
            

            $set = [];
            $set[ 'code' ] = $posterdata[ 'publication' ];
            $set[ 'snum' ] = $posterdata[ 'publication' ];
            $set[ 'num' ] = $posterdata[ 'publication' ];
            $set[ 'endainame' ] = $posterdata[ 'endainame' ]."<br />".$posterdata[ 'sub' ];
            $set[ 'publication' ] = $posterdata[ 'publication' ];
            $table = "kagaku_endai";
            //ポスター発表データ取得
            $_SESSION[ 'movies' ][ 'endai_code' ] = $id;       

            if(!$this->db->getPosterList($id)){
                $this->db->setUserData($table,$set);
            }
            
            if($_REQUEST[ 'ajax' ] == "on"){
                $set = [];
                $set['note'] = $_REQUEST[ 'note' ];
                $set[ 'kagaku_sanka_code' ] = $_SESSION[ 'movies' ][ 'code' ];
                $set[ 'endai_code' ] = $this->third;
                $set[ 'regist_date' ] = date("Y-m-d H:i:s");
                $set[ 'regist_ts' ] = date("Y-m-d H:i:s");
                $table = "question";
                $this->db->setUserData($table,$set);
                exit();
            }
            //一覧表示
            if($_REQUEST[ 'ajax' ] == "list"){
                $where = [];
                $where[ 'code' ] = $_REQUEST[ 'code' ];
                $list = $this->db->getQuestionData($where);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($list);
                exit();
            }
            
            //チャット削除
            if($_REQUEST[ 'ajax' ] == "delete"){
                $edit=[];
                $edit['where']['id'] = $_REQUEST[ 'id' ];
                $edit['where']['kagaku_sanka_code'] =$_SESSION[ 'movies' ][ 'code' ];
                $edit[ 'edit' ]['status'] = 0;
                $table = "question";
                $this->db->editUserData($table,$edit);
                exit();
            }
            //ポスター発表データ取得            
            $poster = $this->db->getPosterList($id);


            //返答登録
            if($_REQUEST[ 'ajax' ] == "replay"){
                $set = [];
                //演題発表者が返答をするとき
                if($_SESSION['movies'][ 'num' ] == $poster[0][ 'snum' ]){
                    $set['replay_flag'] = 1;
                    $set['replay_pcode'] = $poster[0][ 'code' ];
                }

                
                $set['note'] = $_REQUEST[ 'note' ];
                $set[ 'kagaku_sanka_code' ] = $_SESSION[ 'movies' ][ 'code' ];
                $set[ 'question_id' ] = $_REQUEST[ 'question_id' ];
                $set[ 'regist_date' ] = date("Y-m-d H:i:s");
                $set[ 'regist_ts' ] = date("Y-m-d H:i:s");
                $table = "replay";
                $this->db->setUserData($table,$set);
                exit();
            }
            //返答表示
            if($_REQUEST[ 'ajax' ] == "replaylist"){
                $where = [];
                $where[ 'question_id' ] = $_REQUEST[ 'question_id' ];
                $list = $this->db->getReplayData($where);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($list);
                exit();
            }
            //説明文
            $explain = $this->db->getMovieExplain();

            $html['id'] = $id;
            $html['code'] = $_SESSION['movies'][ 'code' ];
            $html['explain'] = $explain['chat_text'];
            $html['endainame'] = $poster[0]['endainame'];
            $html['tyosya_name'] = $poster[0]['tyosya_name'];
            $html['syozokuKikanRyaku'] = $poster[0]['syozokuKikanRyaku'];
            $html['publication'] = $poster[0]['publication'];
            return $html;
            
        }else{
            header("Location:/movie/");
            exit();
        }
        
    }

    /********************
     * 領収書出力
     */
    public function recipe(){
        if($_SESSION[ 'movies' ][ 'login' ] == "on"){
            //出力確認
            //出力は一度のみ
            $where = [];
            $where[ 'code' ] = $_SESSION['movies'][ 'code' ];
            $check = $this->db->getRecipeLog($where);

        

            //領収書出力データ保存
            $set = [];
            $set[ 'code' ] = $_SESSION['movies'][ 'code' ];
            $set[ 'regist_ts' ] = date('Y-m-d H:i:s');
            $table = "recipe_output";
            $this->db->setUserData($table,$set);

            $where = [];
            $where[ 'code' ] = $_SESSION['movies'][ 'code' ];
            $recipe = $this->db->getRecipe($where);
            
            $pdf = $this->pdf;
            $pdf->setSourceFile('./lib/recipe_tmp.pdf');
            
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage('L', 'A4');
            $importPage = $pdf->importPage(1);
            $pdf->useTemplate($importPage, 0, 0);
            $pdf->SetFont("kozminproregular", "", 12);
            $pdf->Text(48.8, 56.4, $recipe['name1'].$recipe['name2']);
            $pdf->Text(108.5, 70.8, number_format($recipe['total']));
            if(!empty($check)){
                $pdf->Text(149, 39, "再発行");
            }
            $day = date("d");
            $pdf->SetFontSize(11.5);
            $pdf->Text(204.0, 47.4, $day);
            
            $pdf->Output("rep-".date('Ymdhis').".pdf", "D");
            

            exit();
        }else{
            header("Location:/movie/");
            exit();
        }
    }

}