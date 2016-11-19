<?php if (! defined('BASEPATH')) exit('No direct script accses allowed');
class C_sop extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('encrypt'));
		$this->load->helper(array('url','security'));
		$this->load->model('data_backend');
	}
	public function index(){
		if(!($this->session->userdata('validated'))){
			redirect('admin/login');
		}
		$m['top']	= "top";
		$m['left']	= "left";
		$m['right']	= "right";
		$m['main']	= "sop/v_sop";
		$m['bottom']= "bottom";
		$this->load->view('backend/tampil',$m);
	}

	public function saveuploadedfile(){
		$new_name = replaceWordChars(strtolower(date("YmdHms")."_sop"));
		//konfigurasi upload file
		$config['file_name'] = $new_name;
		$config['upload_path'] 		= 'assets/media/sop';
		$config['allowed_types'] 	= 'jpeg|gif|png|ico|jpg';
		$config['max_size']			= '5000'; //2mb
		$this->load->library('upload', $config);
		if(!empty($_FILES['file']['name'])){
			if($this->security->xss_clean($_FILES['file'], TRUE)){
				if($this->upload->do_upload('file') === TRUE){
					$up_data	 	= $this->upload->data();
					echo json_encode(array("status" => TRUE,"message"=>"Success save data","url"=>base_url('assets/media/sop/'.$up_data['file_name'])));
				}else{
					echo json_encode(array("status" => FALSE, "message"=>"error bagian upload image, silahkan cek tipe file dan ukuran file yang di upload","message_error :"=>$this->upload->display_errors()));
				}
			}else{
				echo json_encode(array("status" => FALSE, "message"=>"error bagian upload image, silahkan cek nama file atau tipe file, dicurigai mengandung karakter tertentu"));
			}
		}else{
			echo json_encode(array("status" => FALSE,"message" => "Sorry failed save data, please check your network connection"));				
		}
	}

    public function ajax_preview($id){
        $data = $this->data_backend->getDataByID('code_position,name_position,description,description_ind,available','careers_position','id_position',$id)->row();
        echo json_encode($data);
    }	
    public function ajax_edit($id){
        $data = $this->data_backend->getDataByID('id_position,code_position,name_position,description,description_ind,available','careers_position','id_position',$id)->row();
        echo json_encode($data);
    }
    public function ajax_add(){
        $primary_id = 'id_position';
        $getId = $this->data_backend->getMaxId($primary_id,'careers_position');
        $id_position = $getId['no'];
        $data = array(
                'id_position' => $id_position,
                'code_position' => replaceWordChars($this->input->post('code_position', TRUE)),
                'name_position' => replaceWordChars($this->input->post('name_position', TRUE)),
                'description' => replaceWordChars($this->input->post('description', TRUE)),
                'description_ind' => replaceWordChars($this->input->post('description_ind', TRUE)),
                'available' => $this->input->post('available', TRUE)
            );
        $insert = $this->data_backend->save("careers_position",$data);
        if($insert){
            echo json_encode(array("status" => TRUE,"message"=>"Success save data"));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed save data, please check your network connection"));
        }
    }
    public function ajax_update(){
        $primary_id = $this->input->post('id_position');
        $data = array(
                'code_position' => replaceWordChars($this->input->post('code_position', TRUE)),
                'name_position' => replaceWordChars($this->input->post('name_position', TRUE)),
                'description' => replaceWordChars($this->input->post('description', TRUE)),
                'description_ind' => replaceWordChars($this->input->post('description_ind', TRUE)),
                'available' => $this->input->post('available', TRUE)
            );
        $update = $this->data_backend->update('careers_position',$data,array('id_position' => $primary_id));
        if($update){
            echo json_encode(array("status" => TRUE,"message"=>"Success update data"));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed update data, please check your network connection"));
        }        
    }
    public function ajax_delete($id){
        $delete = $this->data_backend->delete('careers_position','id_position',$id);
        if($delete){
            echo json_encode(array("status" => TRUE,"message"=>"Success delete data"));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed delete data, please check your network connection"));
        }         
    }
}
