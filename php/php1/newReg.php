<?PHP
class newReg{
	function __construct(){
		global $db;
		global $html;
		global $array_pref;
		$this->db   = $db;
		$this->html = $html;
		$this->pref = $array_pref;
	}
	public function index(){
		$html[ 'pref' ] = $this->pref;
		return $html;
	}

}
?>