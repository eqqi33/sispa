<?php
class Data_backend extends CI_Model {
	function __construct(){
		$this->load->database();
	}
	function cek_login_admin($data){
		return $this->db->get_where("admin",$data);
	}
	function get_connection(){
        $CI =& get_instance();
        $CI->load->database();
        $db = $CI->db->database; // give the config name here (database).
        $host = $CI->db->hostname; // give the config name here (hostname).
        $user = $CI->db->username; // give the config name here (username).
        $pass = $CI->db->password; // give the config name here (password).        
		return $conn = array(
			'db' => $db,
            'host' => $host,
            'user' => $user,
            'pass' => $pass            
            );
	}
    public function getMaxId($field,$table){   
        $this->db->select('ifnull(max('.$field.')+1,1) as no');
        $this->db->from($table);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function save($table,$data){
        $q = $this->db->insert($table, $data);
        return $q;
    }
    public function update($table,$data,$where){
        $q = $this->db->update($table, $data, $where);
        return $q;
    }    
    public function updatewc($table,$data){
        $q = $this->db->update($table, $data);
        return $q;
    }    
    public function delete($table,$field,$id){
        $q = $this->db->query("DELETE FROM $table WHERE $field = '$id'");
        return $q;
    }    
    public function getData($field, $table) {
        $q = $this->db->query("SELECT $field FROM $table");
        return $q;
    }
    public function getSpesific($field, $table, $condition) {
        $q = $this->db->query("SELECT $field FROM $table WHERE $condition");
        return $q;    
    }    
    public function getDataByID($field, $table, $key, $data) {
        $q = $this->db->query("SELECT $field FROM $table WHERE $key='$data'");
        return $q;    
    }
    public function getJointable($field, $table, $tablejoin) {
        $q = $this->db->query("SELECT $field FROM $table INNER JOIN $tablejoin");
        return $q;    
    }
    public function getJointableSpesific($field, $table, $tablejoin, $condition) {
        $q = $this->db->query("SELECT $field FROM $table INNER JOIN $tablejoin WHERE $condition");
        return $q;    
    }
    public function makeOwnQuery($query) {
        $q = $this->db->query($query);
        return $q;    
    }
	public function get_menu() {
		$q = $this->db->query("SELECT id_menu,controller_name,name_menu,modul_menu,authority,position_menu,icon_menu,sub_menu FROM menu ORDER BY position_menu ASC");
		return $q->result();
	}
	public function get_sub_menu() {
		$q = $this->db->query("SELECT id_sub_menu,controller_name,id_menu,name_menu,modul_menu,authority,position_menu FROM sub_menu  ORDER BY position_menu ASC");
		return $q->result();
	}
	public function getAllChartBarYear($table) {
		$tahun_system = date("Y");
		$q = $this->db->query("SELECT MONTHNAME(tanggal) AS bulan, YEAR(tanggal) tahun, COUNT(id_visitor) AS total_perbulan FROM $table WHERE tanggal LIKE '%".$tahun_system."%'GROUP BY MONTH(tanggal)");
		return $q->result();
	}
	public function getAllChartBarMonth($table) {
		$bulan_system = date("m");
		$tahun_system = date("Y");
		$q = $this->db->query("SELECT CONCAT_WS('-',DAYNAME(tanggal),DAY(tanggal)) AS tanggal, COUNT(*) AS total_per_hari FROM $table WHERE MONTH(tanggal) = MONTH(CURDATE()) GROUP BY DAY(tanggal) ASC");
		return $q->result();
	}
	public function getAllChartBarWeek($table) {
		$hari_system = date("d");
		$bulan_system = date("m");
		$tahun_system = date("Y");
		$q = $this->db->query("SELECT YEARWEEK(tanggal) AS tahun_minggu, COUNT(id_visitor) AS total_perminggu FROM $table WHERE YEARWEEK(tanggal)=YEARWEEK(NOW()) GROUP BY YEARWEEK(tanggal)");
		return $q->result();
	}
	public function getAllChartBarDay($table) {
		$q = $this->db->query("SELECT DAYNAME(CURDATE()) AS hari_ini, COUNT(id_visitor) AS total_hari_ini FROM $table WHERE tanggal = DATE(NOW())");
		return $q->result();
	}
	public function get_hits_product($table){
    	$this->db->select('name_product,hits');
    	$this->db->from($table);
    	$this->db->order_by('hits','desc');
    	$this->db->limit(10);
    	$q = $this->db->get();
        return $q;
	}
	
	public function get_hits_group_product($table){
    	$this->db->select('name_group_product,hits');
    	$this->db->from($table);
    	$this->db->order_by('hits','desc');
    	$this->db->limit(10);
    	$q = $this->db->get();
        return $q;
	}
	
	public function get_hits_promo($table){
    	$this->db->select('name_promo,hits');
    	$this->db->from($table);
    	$this->db->order_by('hits','desc');
    	$this->db->limit(5);
    	$q = $this->db->get();
        return $q;
	}
	
	public function get_data_maps($table) {
		$q = $this->db->query("SELECT ip_address, hits, position FROM $table");
		return $q;
	}
}
?>