<?php if (! defined('BASEPATH')) exit('No direct script accses allowed');
class C_sop extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library(array('encrypt'));
		$this->load->helper(array('url','security','date'));
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
        $m['cat_sop'] = $this->data_backend->getData('id_cat_sop,name_category_sop','category_sop')->result();
		$this->load->view('backend/tampil',$m);
	}

    public function ajax_tabel_sop(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
    //            panggil dulu library datatablesnya

            $this->load->library('datatables_ssp');

    //            atur nama tablenya disini
            $table = 'v_sop';
            // Table's primary key
            $primaryKey = 'id_sop';
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(
                array('db' => 'id_sop', 'dt' => 'id_sop'),
                array('db' => 'title_sop', 'dt' => 'title_sop'),
                array('db' => 'date_created', 'dt' => 'date_created'),
                array('db' => 'last_edited', 'dt' => 'last_edited'),
                array('db' => 'username_created', 'dt' => 'username_created'),
                array(
                    'db' => 'id_sop',
                    'dt' => 'action',
                    'formatter' => function( $d ) {
                        // $id_level = $this->session->userdata('level');
                        // $level = $this->session->userdata('name_level');
                        // $get_p = $this->data_backend->getSpesific('privilege','level'," id_level='".$id_level."' AND name_level='".$level."'")->row();
                        // $privilege_data = json_decode($get_p->privilege,true);
                        // $sum_dt = count($privilege_data);
                        $set_privillege_dt = "";
                        // $get_menu_name = $this->data_backend->getSpesific('name_menu','sub_menu',"controller_name='careers_position'")->row();
                        // for($i=0;$i<$sum_dt;$i++){
                        //     if($privilege_data[$i]['page'] === $get_menu_name->name_menu){
                        //         if($privilege_data[$i]['create'] === "true"){
                        //             $set_privillege_dt .= "";
                        //         }
                        //         if($privilege_data[$i]['read'] === "true"){
                                    $set_privillege_dt .= '<a id="btn_preview_'.$d.'" class="btn btn-xs btn btn-success" title="Read" onclick="preview('."'".$d."'".')" style="margin:5px !important;"><i class="glyphicon glyphicon-comment"></i>';  
                                // }
                                // if($privilege_data[$i]['edit'] === "true"){
                                    $set_privillege_dt .= '<br><a id="btn_edit_'.$d.'" class="btn btn-xs btn btn-warning" title="Edit" onclick="edit('."'".$d."'".')" style="margin:5px !important"><i class="glyphicon glyphicon-pencil"></i>';
                                // }
                                // if($privilege_data[$i]['delete'] === "true"){
                                    $set_privillege_dt .= '<br><a class="btn btn-xs btn-danger" title="Hapus" onclick="delete_sop('."'".$d."'".')" style="margin:5px !important"><i class="glyphicon glyphicon-trash"></i></a>';
                                // }
                                // if($privilege_data[$i]['create'] !== "true" && $privilege_data[$i]['read'] !== "true" && $privilege_data[$i]['edit'] !== "true" && $privilege_data[$i]['delete'] !== "true"){
                                    // $set_privillege_dt .= '<a class="btn btn-sm" href="javascript:void(0);">No Action</a>';
                                // }
                                return $set_privillege_dt;
                                break;
                           // }
                       // }
                    }                    
                ),
            );
            $sql_connection = $this->data_backend->get_connection();
            echo json_encode(
                    Datatables_ssp::simple($_GET, $sql_connection, $table, $primaryKey, $columns)
            );
        }
    }

	public function saveuploadedfile(){
		$new_name = replaceWordChars(strtolower(date("YmdHms")."_sop"));
		//konfigurasi upload file
		$config['file_name'] = $new_name;
		$config['upload_path'] 		= 'assets/media/tmp';
		$config['allowed_types'] 	= 'jpeg|gif|png|ico|jpg';
		$config['max_size']			= '5000'; //2mb
		$this->load->library('upload', $config);
		if(!empty($_FILES['file_upload']['name'])){
			if($this->security->xss_clean($_FILES['file_upload'], TRUE)){
				if($this->upload->do_upload('file_upload') === TRUE){
					$up_data	 	= $this->upload->data();
					echo json_encode(array("status" => TRUE,"message"=>"Success save data","url"=>base_url('assets/media/sop/'.$up_data['file_name'])));
				}else{
					echo json_encode(array("status" => FALSE, "message"=>"error bagian upload image, silahkan cek tipe file dan ukuran file yang di upload","message_error :"=>$this->upload->display_errors()));
				}
			}else{
				echo json_encode(array("status" => FALSE, "message"=>"error bagian upload image, silahkan cek nama file atau tipe file, dicurigai mengandung karakter tertentu"));
			}
		}else{
			echo json_encode(array("status" => FALSE,"message" => "Sorry failed save data, please check your network connection  ".$_FILES['file_upload']['name']));				
		}
	}

    public function ajax_preview($id){
        $data = $this->data_backend->getDataByID('type_sop,name_category_sop,title_sop,num_document,detail_sop,date_created,date_effective,number_revision,made_by,checked_by,approval_by,username_created','v_sop','id_sop',$id)->row();
        echo json_encode($data);
    }	
    public function ajax_edit($id){
        $data = $this->data_backend->getDataByID('id_sop,id_cat_sop,type_sop,title_sop,num_document,detail_sop,date_format(date_effective,\'%e-%m-%Y\') as date_effective,made_by,checked_by,approval_by','sop','id_sop',$id)->row();
        echo json_encode($data);
    }
    public function ajax_add(){
        $now = now();
        $primary_id = 'id_sop';
        $getId = $this->data_backend->getMaxId($primary_id,'sop');
        $id_sop = $getId['no'];
        $data = array(
                'id_sop' => $id_sop,
                'type_sop' => replaceWordChars($this->input->post('type_sop', TRUE)),
                'id_cat_sop' => replaceWordChars($this->input->post('cat_sop', TRUE)),
                'title_sop' => replaceWordChars($this->input->post('title_sop', TRUE)),
                'num_document' => replaceWordChars($this->input->post('num_doc', TRUE)),
                'detail_sop' => replaceWordChars($this->input->post('detail_sop', FALSE)),
                'date_effective' => replaceWordChars($this->input->post('effective_date', TRUE)),
                'date_created' => unix_to_human($now, TRUE, 'ind'),
                'id_user_created' => $this->session->userdata('id'),
                'made_by' => replaceWordChars($this->input->post('made_by', TRUE)),
                'checked_by' => replaceWordChars($this->input->post('checked_by', TRUE)),
                'approval_by' => replaceWordChars($this->input->post('approv_by', TRUE))
            );
        $insert = $this->data_backend->save("sop",$data);
        if($insert){
            //post your preg_match code in 
        $text=$this->input->post('detail_sop', FALSE);
        $test = preg_match_all('/'.base_url('assets/media/temp').'/i', $text, $matches);            
            echo json_encode(array("status" => TRUE,"message"=>"Success save data "));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed save data, please check your network connection"));
        }
    }
    public function ajax_update(){
        $now = now();
        $primary_id = $this->input->post('id_sop');
        $data = array(
                'type_sop' => replaceWordChars($this->input->post('type_sop', TRUE)),
                'id_cat_sop' => replaceWordChars($this->input->post('cat_sop', TRUE)),                
                'title_sop' => replaceWordChars($this->input->post('title_sop', TRUE)),
                'num_document' => replaceWordChars($this->input->post('num_doc', TRUE)),                
                'detail_sop' => replaceWordChars($this->input->post('detail_sop', FALSE)),
                'date_effective' => replaceWordChars($this->input->post('effective_date', TRUE)),                
                'last_edited' => unix_to_human($now, TRUE, 'ind'),
                'number_revision' => 'number_revision+1',
                'id_user_edited' => $this->session->userdata('id'),
                'made_by' => replaceWordChars($this->input->post('made_by', TRUE)),
                'checked_by' => replaceWordChars($this->input->post('checked_by', TRUE)),
                'approval_by' => replaceWordChars($this->input->post('approv_by', TRUE))                
            );
        $update = $this->data_backend->update('sop',$data,array('id_sop' => $primary_id));
        if($update){
            //post your preg_match code in 
            $text=$this->input->post('detail_sop', FALSE);
            $test = preg_match_all('/http:\/\/localhost\/sispa-ci\/assets\/media\/temp/i', $text, $matches); //done, tinggal cari cara gimana supaya bisa dipindahkan dari folder folder temp ke sop        
            echo json_encode(array("status" => TRUE,"message"=>"Success update data","testing"=>$test));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed update data, please check your network connection"));
        }        
    }
    public function ajax_delete($id){
        $delete = $this->data_backend->delete('sop','id_sop',$id);
        if($delete){
            echo json_encode(array("status" => TRUE,"message"=>"Success delete data"));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed delete data, please check your network connection"));
        }         
    }
}
