<?php if (! defined('BASEPATH')) exit('No direct script accses allowed');
class Index extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('encrypt'));
		$this->load->helper(array('url','security'));
		$this->load->model('data_backend');
	}
	public function index(){
		if(!($this->session->userdata('validated'))){
			redirect('admin/index/login');
		}
		$m['top']	= "top";
		$m['left']	= "left";
		$m['right']	= "right";
		$m['main']	= "v_dashboard";
		$m['bottom']= "bottom";
		$this->load->view('backend/tampil',$m);
	}
	public function login(){
		if($this->session->userdata('validated')){
			redirect('admin/index/index');
		}
		$m['robots'] = "noindex,nofollow,nosnippet,noarchive,noimageindex";
		if(isset($_COOKIE["cookielogin"])){
			$m['u'] = isset($_COOKIE['cookielogin']['u'])?$this->encrypt->decode($_COOKIE['cookielogin']['u']):'';
			$m['p'] = isset($_COOKIE['cookielogin']['p'])?$this->encrypt->decode($_COOKIE['cookielogin']['p']):'';
			$m['set_remember'] = isset($_COOKIE['cookielogin']['set_remember'])?$this->encrypt->decode($_COOKIE['cookielogin']['set_remember']):'';		
		}else{
			$m['u'] = '';
			$m['p'] = '';
			$m['set_remember'] = '';
		}	
		$this->load->view('backend/login', $m);
	}
	public function auth_login(){
	    if (!$this->input->is_ajax_request()) {
	        exit('No direct script access allowed');
	    }else{
			date_default_timezone_set('Asia/Jakarta');
			$this->load->helper('date');
			$username = replaceWordChars($this->input->post('username', TRUE));
			$password = sha1(replaceWordChars($this->input->post('username', TRUE)).replaceWordChars($this->input->post('password', TRUE)));
			$cek = $this->data_backend->getData("id_user,username,password,name,status,last_login,id_privilege","user WHERE username='".$username."' AND password='".$password."'");
			$remember=$this->input->post('remember');
	        $j_cek	= $cek->num_rows();
			$d_cek	= $cek->row();
			$now = now();
			$time=time();
	        if($j_cek > 0) {
	        	if($remember == "checked"){
	        		setcookie("cookielogin[u]",$this->encrypt->encode(replaceWordChars($this->input->post('username', TRUE))),$time+(3600*12));
	        		setcookie("cookielogin[p]",$this->encrypt->encode(replaceWordChars($this->input->post('password', TRUE))),$time+(3600*12));
	        		setcookie("cookielogin[set_remember]",$this->encrypt->encode("checked"),$time+(3600*12));
	        	}else{
					unset($_COOKIE['cookielogin']['u']);
					unset($_COOKIE['cookielogin']['p']);
					unset($_COOKIE['cookielogin']['set_remember']);	    		
					setcookie("cookielogin[u]",null,$time-1);
		    		setcookie("cookielogin[p]",null,$time-1);
		    		setcookie("cookielogin[set_remember]",null,$time-1);
	        	}
	            $data = array(
	            		'id'   => $d_cek->id_user,
	                    'user' => $d_cek->username,
	                    'name' => $d_cek->name,
	                    'pass' => $d_cek->password,	                    
	                    'level' => $d_cek->id_privilege,
	                    'time' => unix_to_human($now, TRUE, 'ind'),
						'validated' => TRUE
	                    );
	            $this->session->set_userdata($data);
	            // $update = $this->data_backend->update('admin', array('status' => '1','last_login'=>date("Y-m-d H:i:s"),'ip_login'=>ambil_ip()),array('id_admin' => $d_cek->id_admin));
		        echo json_encode(array("status" => TRUE));
	        } else {
				echo json_encode(array("status" => FALSE));
			}
	 	}
	}
	public function myprofile(){
		if(! $this->session->userdata('validated')){
			redirect('admin/index/login');
		}
		$m['top'] = "top";
		$m['left_side'] = "left_side";
		$m['main'] = "v_profile";
		$m['right_side'] = "right_side";
		$m['setting_theme'] = "setting_theme";
		$m['robots'] = "noindex,nofollow,nosnippet,noarchive,noimageindex";
		$m['menu_1'] = $this->data_backend->get_menu();
		$m['sub_menu'] = $this->data_backend->get_sub_menu();
		$m['data_admin'] = $this->data_backend->getDataByID('username,name,born,address,foto','admin','id_admin',$this->session->userdata('id'))->row();
$m['data_online_user'] = $this->data_backend->getData('name,foto,status,last_login','admin ORDER BY status DESC, last_login DESC, name DESC')->result();
		$this->load->view('backend/tampil',$m);
	}
	public function setting(){
		if(! $this->session->userdata('validated')){
			redirect('admin/index/login');
		}
		$m['top'] = "top";
		$m['left_side'] = "left_side";
		$m['main'] = "v_setting";
		$m['right_side'] = "right_side";
		$m['setting_theme'] = "setting_theme";
		$m['robots'] = "noindex,nofollow,nosnippet,noarchive,noimageindex";
		$m['menu_1'] = $this->data_backend->get_menu();
		$m['sub_menu'] = $this->data_backend->get_sub_menu();
		$m['data_setting'] = $this->data_backend->getDataByID('username,password','admin','id_admin',$this->session->userdata('id'))->row();
$m['data_online_user'] = $this->data_backend->getData('name,foto,status,last_login','admin ORDER BY status DESC, last_login DESC, name DESC')->result();
		$this->load->view('backend/tampil',$m);
	}
	public function logout(){
		date_default_timezone_set('Asia/Jakarta');
		// $update = $this->data_backend->update('admin', array('status' => '0','last_logout'=>date("Y-m-d H:i:s"),'ip_logout'=>ambil_ip()),array('id_admin' => $this->session->userdata('id')));
        	$this->session->sess_destroy();
        	redirect('admin/index/login');
    }
// 		public function c_su(){
// $getId = $this->data_backend->getMaxId($primary_id,'admin');
// 		$id_admin = $getId['no'];
// 			$data = array(
// 						'id_admin' => $id_admin,
// 						'username' => "user_testing",
// 						'password' => sha1("adminadmin"),
// 						'name' => "user testing",
// 						'born' => date("Y-m-d"),
// 						'address' => "testing",
// 						'status' => "0",
// 						'id_level' => "1",
// 						'feature_dashboard' => "1"
// 					);
// 			$insert = $this->data_backend->save("admin",$data);
// 			if($insert){
// 				echo json_encode(array("status" => TRUE));
// 			}else{
// 				echo json_encode(array("status" => FALSE));
// 			}
//     }
}
