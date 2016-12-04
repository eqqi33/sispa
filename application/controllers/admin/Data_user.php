<?php if (! defined('BASEPATH')) exit('No direct script accses allowed');
class Data_user extends CI_Controller {
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
		$m['main']	= "setting/v_data_user";
		$m['bottom']= "bottom";
        $m['cat_privilege'] = $this->data_backend->getData('id_privilege,name_privilege','privilege')->result();
		$this->load->view('backend/tampil',$m);
	}

    public function ajax_tabel_data_user(){
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
    //            panggil dulu library datatablesnya

            $this->load->library('datatables_ssp');

    //            atur name tablenya disini
            $table = 'v_data_user';
            // Table's primary key
            $primaryKey = 'id_user';
            // Array of database columns which should be read and sent back to DataTables.
            // The `db` parameter represents the column name in the database, while the `dt`
            // parameter represents the DataTables column identifier. In this case simple
            // indexes
            $columns = array(
                array('db' => 'id_user', 'dt' => 'id_user'),
                array('db' => 'username', 'dt' => 'username'),
                array('db' => 'name', 'dt' => 'name'),
                array('db' => 'status', 'dt' => 'status'),
                array('db' => 'last_login', 'dt' => 'last_login'),
                array('db' => 'privilege', 'dt' => 'privilege'),
                array(
                    'db' => 'id_user',
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
                                    //$set_privillege_dt .= '<a id="btn_preview_'.$d.'" class="btn btn-xs btn btn-success" title="Read" onclick="preview('."'".$d."'".')" style="margin:5px !important;"><i class="glyphicon glyphicon-comment"></i>';  
                                // }
                                // if($privilege_data[$i]['edit'] === "true"){
                                    $set_privillege_dt .= '<br><a id="btn_edit_'.$d.'" class="btn btn-xs btn btn-warning" title="Edit" onclick="edit_ajax('."'".$d."'".')" style="margin:5px !important"><i class="glyphicon glyphicon-pencil"></i>';
                                // }
                                // if($privilege_data[$i]['delete'] === "true"){
                                    $set_privillege_dt .= '<br><a class="btn btn-xs btn-danger" title="Hapus" onclick="delete_ajax('."'".$d."'".')" style="margin:5px !important"><i class="glyphicon glyphicon-trash"></i></a>';
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

    // public function ajax_preview($id){
    //     $data = $this->data_backend->getDataByID('type_sop,name_category_sop,title_sop,num_document,detail_sop,date_created,date_effective,number_revision,made_by,checked_by,approval_by,username_created','v_sop','id_sop',$id)->row();
    //     echo json_encode($data);
    // }	
    public function ajax_edit($id){
        $data = $this->data_backend->getDataByID('id_user,username,password,name,status,id_privilege','user','id_user',$id)->row();
        echo json_encode($data);
    }
    public function ajax_add(){
        $now=now();
        $primary_id = 'id_user';
        $getId = $this->data_backend->getMaxId($primary_id,'user');
        $id_sop = $getId['no'];
        $data = array(
                'id_user' => $id_sop,
                'username' => $this->input->post('username', TRUE),
                'password' =>  sha1(replaceWordChars($this->input->post('username', TRUE)).replaceWordChars($this->input->post('password', TRUE))),
                'name' => replaceWordChars($this->input->post('name', TRUE)),
                'status' => $this->input->post('status', TRUE),
                'create_on' => $now,
                'id_privilege' => $this->input->post('id_privilege', TRUE)
            );
        $insert = $this->data_backend->save('user',$data);
        if($insert){           
            echo json_encode(array("status" => TRUE,"message"=>"Success save data"));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed save data, please check your network connection"));
        }
    }
    public function ajax_update(){
        $primary_id = $this->input->post('id_user');
        $verifypass = replaceWordChars($this->input->post('getpass'));
        $password = sha1(replaceWordChars($this->input->post('username', TRUE)).replaceWordChars($this->input->post('password', TRUE)));
        if(replaceWordChars($this->input->post('password')) != NULL || replaceWordChars($this->input->post('password')) != ""){
            if(replaceWordChars($this->input->post('password')) != $verifypass){
                if($verifypass != $password){
                    $data = array(
                        'username' => $this->input->post('username', TRUE),
                        'password' =>  $password,
                        'name' => replaceWordChars($this->input->post('name', TRUE)),
                        'status' => $this->input->post('status', TRUE),
                        'id_privilege' => $this->input->post('id_privilege', TRUE)               
                    );                    
                }else{
                    $data = array(
                        'username' => $this->input->post('username', TRUE),
                        'name' => replaceWordChars($this->input->post('name', TRUE)),
                        'status' => $this->input->post('status', TRUE),
                        'id_privilege' => $this->input->post('id_privilege', TRUE)               
                    );
                }
            }else{
                $data = array(
                    'username' => $this->input->post('username', TRUE),
                    'name' => replaceWordChars($this->input->post('name', TRUE)),
                    'status' => $this->input->post('status', TRUE),
                    'id_privilege' => $this->input->post('id_privilege', TRUE)               
                );
            }
        }else{
            $data = array(
                'username' => $this->input->post('username', TRUE),
                'name' => replaceWordChars($this->input->post('name', TRUE)),
                'status' => $this->input->post('status', TRUE),
                'id_privilege' => $this->input->post('id_privilege', TRUE)               
            );
        }        
        $update = $this->data_backend->update('user',$data,array('id_user' => $primary_id));
        if($update){      
            echo json_encode(array("status" => TRUE,"message"=>"Success update data"));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed update data, please check your network connection"));
        }        
    }
    public function ajax_delete($id){
        $delete = $this->data_backend->delete('user','id_user',$id);
        if($delete){
            echo json_encode(array("status" => TRUE,"message"=>"Success delete data"));
        }else{
            echo json_encode(array("status" => FALSE,"message" => "Sorry failed delete data, please check your network connection"));
        }         
    }
}
