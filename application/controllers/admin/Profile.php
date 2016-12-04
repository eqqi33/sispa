<?php if (! defined('BASEPATH')) exit('No direct script accses allowed');
class Profile extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url','file','security'));
		$this->load->model('data_backend');
	}

	public function index(){
		if(!($this->session->userdata('validated'))){
			redirect('admin/index/login');
		}
		$m['top']	= "top";
		$m['left']	= "left";
		$m['right']	= "right";
		$m['main']	= "v_profile";
		$m['bottom']= "bottom";
		$this->load->view('backend/tampil',$m);
	}
}
