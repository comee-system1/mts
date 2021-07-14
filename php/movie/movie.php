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
        global $third;
        $this->third = $third;

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
                $poster = $this->db->getPosterList();
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
            
            //チャット登録
            $id = $this->third;
            if($_REQUEST[ 'ajax' ] == "on"){
                $set = [];
                $set['note'] = $_REQUEST[ 'note' ];
                $set[ 'kagaku_sanka_code' ] = $_SESSION[ 'movies' ][ 'code' ];
                $set[ 'endai_code' ] = $id;
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