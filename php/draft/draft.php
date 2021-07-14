<?php
class draft{
    function __construct(){
		global $db;
        $this->db = $db;
		ini_set( 'display_errors', 1 );
        //現在の利用確認
        $status = $this->db->getKagakuUser();
        $this->errorfile = "";
        
        if($status["draft_status"] == 1){
            //エラーページ
            $this->errorfile = "error";
            $this->index();
            
        }
        session_start();
    }
    
    public function index(){
        //エラーページ
        
        if($this->errorfile){
            $data[ 'file' ] = $this->errorfile;
            return $data;
        }

        if(isset($_SESSION[ 'draft' ][ 'login' ] ) && $_SESSION[ 'draft' ][ 'login' ] == "on"){
            //一覧ページに遷移
            header("Location:/draft/list");
            exit();
            
        }else{
            //ログインしていないとき
            $data = $this->logincheck();
        }
        return $data;
    }
    /********
     * 一覧
     */
    public function download(){
        //ログインしているときのみ
        if($_SESSION[ 'draft' ][ 'login' ] == "on"){
            
            //ディレクトリのパス
            $dir_path = D_PATH_HOME."allpdf/";
            //ファイルタイプ（MIMEタイプ）を指定
            header('Content-Type: application/pdf');
            //ダウンロードタイプと保存時のファイル名
            header('Content-Disposition: attachment; filename='.time().'.pdf');
            //ファイルサイズを取得
            header('Content-Length: '.filesize($dir_path . 'R02genkou.pdf'));
            //ファイルの読み込み
            readfile($dir_path . "R02genkou.pdf");

            exit();
        }else{
            header("Location:/draft/");
            exit();
        }
    }
    public function logincheck(){
        //ログインチェック
        $data = [];
        if(filter_input(INPUT_POST,"login")){    
            $_SESSION['draft'] = [];
            $user = $this->db->getMovieLogin();
            if($user){
                $_SESSION[ 'draft' ][ 'login' ] = "on";
                $_SESSION[ 'draft' ][ 'id' ] = $user[ 'id' ];
                $_SESSION[ 'draft' ][ 'num' ] = $user[ 'num' ];
                
                header("Location:/draft/download");
                exit();
            }else{
                $data['errmsg'] = "ダウンロードに失敗しました";
            }

        }
        return $data;
        
    }
    /***************
     * チャット
     */
    public function chat(){
        
        
    }

}