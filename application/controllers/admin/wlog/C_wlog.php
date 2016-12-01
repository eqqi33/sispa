<?php if (! defined('BASEPATH')) exit('No direct script accses allowed');
class C_wlog extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->library(array('encrypt'));
		$this->load->helper(array('url','security','date'));
		$this->load->model('data_backend');
	}
	public function index(){
		if(!($this->session->userdata('validated'))){
			redirect('admin/index/login');
		}
		$m['top']	= "top";
		$m['left']	= "left";
		$m['right']	= "right";
		$m['main']	= "wlog/v_wlog";
		$m['bottom']= "bottom";
        $m['cat_wlog'] = $this->data_backend->getData('id_cat_wlog,name_category_wlog','category_wlog')->result();
		$this->load->view('backend/tampil',$m);
	}

    public function ajax_tabel_wlog(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
    //            panggil dulu library datatablesnya

            $this->load->library('datatables_ssp');

    //            atur nama tablenya disini
            $table = 'v_wlog';
            // Table's primary key
            $primaryKey = 'id_wlog';
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(
                array('db' => 'id_wlog', 'dt' => 'id_wlog'),
                array('db' => 'componen', 'dt' => 'componen'),
                array('db' => 'name_category_wlog', 'dt' => 'name_category_wlog'),
                array('db' => 'impac', 'dt' => 'impac'),
                array('db' => 'description', 'dt' => 'description'),
                array('db' => 'action', 'dt' => 'aksi'),
                array('db' => 'req_date', 'dt' => 'req_date'),
                array('db' => 'due_date', 'dt' => 'due_date'),
                array('db' => 'pic', 'dt' => 'pic'),
                array('db' => 'status', 'dt' => 'status'),
                array('db' => 'username', 'dt' => 'username'),
                array(
                    'db' => 'id_wlog',
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
                                    $set_privillege_dt .= '<br><a class="btn btn-xs btn-danger" title="Hapus" onclick="delete_wlog('."'".$d."'".')" style="margin:5px !important"><i class="glyphicon glyphicon-trash"></i></a>';
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
		$new_name = replaceWordChars(strtolower(date("YmdHms")."_wlog"));
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
        $data = $this->data_backend->getDataByID('id_wlog,id_cat_wlog,name_category_wlog,componen,descriptiont,impac,action,req_date,due_date,pic,status,created_log_date,id_user','v_wlog','id_wlog',$id)->row();
        echo json_encode($data);
    }	
    public function ajax_edit($id){
        $data = $this->data_backend->getDataByID('id_wlog,id_cat_wlog,name_category_wlog,componen,descriptiont,impac,action,req_date,due_date,pic,status,created_log_date,id_user','wlog_activity','id_wlog',$id)->row();
        echo json_encode($data);
    }
    public function ajax_add(){
        $now = now();
        $primary_id = 'id_wlog';
        $getId = $this->data_backend->getMaxId($primary_id,'wlog_activity');
        $id_wlog = $getId['no'];
        $data = array(
                'id_wlog' => $id_wlog,
                'componen' => replaceWordChars($this->input->post('componen', TRUE)),
                'id_cat_wlog' => replaceWordChars($this->input->post('cat_wlog', TRUE)),
                'description' => replaceWordChars($this->input->post('description', TRUE)),
                'impac' => replaceWordChars($this->input->post('impac', TRUE)),
                'action' => replaceWordChars($this->input->post('action', TRUE)),
                'req_date' => replaceWordChars($this->input->post('req_date', FALSE)),
                'due_date' => replaceWordChars($this->input->post('due_date', TRUE)),
                'id_user' => $this->session->userdata('id'),
                'pic' => replaceWordChars($this->input->post('pic', TRUE)),
                'status' => replaceWordChars($this->input->post('status', TRUE)),
                
            );
        $insert = $this->data_backend->save("wlog_activity",$data);
        if($insert){
            //post your preg_match code in 
        $text=$this->input->post('detail_wlog', FALSE);
        //$test = preg_match_all('/'.base_url('assets/media/temp').'/i', $text, $matches);            
            echo json_encode(array("status" => TRUE,"message"=>"Success save data "));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed save data, please check your network connection"));
        }
    }
    public function ajax_update(){
        $now = now();
        $primary_id = $this->input->post('id_wlog');
        $data = array(
                'componen' => replaceWordChars($this->input->post('componen', TRUE)),
                'id_cat_wlog' => replaceWordChars($this->input->post('id_cat_wlog', TRUE)),                
                'description' => replaceWordChars($this->input->post('description', TRUE)),
                'impac' => replaceWordChars($this->input->post('impac', FALSE)),
                'action' => replaceWordChars($this->input->post('action', TRUE)),                
                'req_date' => replaceWordChars($this->input->post('req_date', TRUE)),                
                'due_date' => replaceWordChars($this->input->post('due_date', TRUE)),                
                'pic' => replaceWordChars($this->input->post('pic', TRUE)),                
                'status' => replaceWordChars($this->input->post('status', TRUE)),              
                               
            );
        $update = $this->data_backend->update('wlog_activity',$data,array('id_wlog' => $primary_id));
        if($update){
            //post your preg_match code in 
            $text=$this->input->post('detail_wlog', FALSE);
            $test = preg_match_all('/http:\/\/localhost\/sispa-ci\/assets\/media\/temp/i', $text, $matches); //done, tinggal cari cara gimana supaya bisa dipindahkan dari folder folder temp ke sop        
            echo json_encode(array("status" => TRUE,"message"=>"Success update data","testing"=>$test));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed update data, please check your network connection"));
        }        
    }
    public function ajax_delete($id){
        $delete = $this->data_backend->delete('wlog_activity','id_wlog',$id);
        if($delete){
            echo json_encode(array("status" => TRUE,"message"=>"Success delete data"));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed delete data, please check your network connection"));
        }         
    }
}
