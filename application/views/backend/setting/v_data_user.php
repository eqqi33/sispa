  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/sweetalert/css/sweetalert.css')?>">
  <link rel="stylesheet" type="text/css" href="<?=base_URL('assets/backend/lib/datatables/dataTables.bootstrap.css')?>"/>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Setting
        <small>Data User</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cog"></i> Setting</a></li>
        <li class="active">Data User</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div id="data_table">
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title">Data User</h3>
            <button class="btn btn-primary pull-right" id="add_button"><i class="glyphicon glyphicon-plus"></i><!-- Add Data--></button><button class="btn btn-default pull-right" id="reload_button" style="margin-right:10px !important;"><i class="glyphicon glyphicon-refresh"></i><!--  Reload Table--></button>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table id="table" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Last Login</th>
                    <th>Privilege</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>            
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>
  <script src="<?=base_URL('assets/backend/lib/sweetalert/js/sweetalert.min.js')?>" type="text/javascript"></script>
  <script type="text/javascript">
  var save_method,table;
  $(document).ready(function() {
    //definition datatables
    $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings){
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };

    table = $('#table').DataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "buttons": [
                      {
                       "extend": "collection",
                       "text": "Export To",
                       "buttons": [ "pdfHtml5", "csvHtml5", "copyHtml5", "excelHtml5","print" ]
                      }
                  ],
        "lengthMenu": [
          [6, 10, 25, 50, -1],
          [6, 10, 25, 50, "All"]
        ],
        "dom": "<'row am-datatable-header'<'col-sm-3'l><'col-sm-6 text-right'B><'col-sm-3 text-right'f>><'row am-datatable-body'<'col-sm-12'tr>><'row am-datatable-footer'<'col-sm-5'i><'col-sm-7'p>>",
        "ajax": "<?php echo site_url('admin/data_user/ajax_tabel_data_user'); ?>",
        "columns": [
            {
                "data": "id_user",
                "class": "text-center",
                "orderable": false
            },
            {"data": "username"},
            {"data": "name"}, 
            {"data": "status"},
            {"data": "last_login"},
            {"data": "privilege"},
            {
                "class": "text-center",
                "data": "action"
            }
        ],
        "order": [[1, 'asc']],
        "rowCallback": function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        }
    });
    //end of datatables  
    $('#vpassword').keyup(verifyPass);  
    $('#modal_form').modal({
      keyboard:false,
      backdrop:'static',
      show:false,
    });
    $('#modal_form').on('hidden.bs.modal', function (e) {
      //$('#form')[0].reset(); // reset form on modals
      //$('#tag').tagsinput('removeAll');
    });
    $('#reload_button').on('click',function(){
      reload_table();
    });
    $('#add_button').on('click',function(){
      add();
    });
    $('#save_button').on('click',function(){
      save();
    });   
  });
  function verifyPass(){
    $('.info-verify').show();
    if($("#password").val() != $("#vpassword").val()){
        $('.info-verify').html('<span style="color: #EF6262;">Password Not Match <i class="fa fa-close"></i></span>');
    }else{
        $('.info-verify').html('<span style="color: #7ACCBE;">Password Match <i class="fa fa-check"></i></span>');
    }
  }
  function edit_ajax(id){
      save_method = 'update';
      $('.btn_edit_'+id).html('<i class="glyphicon glyphicon-pencil"> Wait...</i>');
      $('.btn_edit_'+id).attr('disabled',true); //set button enable
      //$("#loading-2").html('<div style="margin-top:-265px;margin-left:-150px;width:150%; height:110%;z-index: 1040;position:fixed;background-color:rgba(0, 0, 0, 0.37);""><div style="margin:10% 35%;"><img src="<?php echo site_url()?>assets/img/default.svg" style="width:150px;height:150px;"></div></div>');
      //Ajax Load data from ajax
      $.ajax({
          url : "<?php echo site_url('admin/data_user/ajax_edit/')?>" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
              $('[name="id_user"]').val(data.id_user);
              $('[name="username"]').val(data.username);
              $('[name="getpass"]').val(data.password);
              $('[name="name"]').val(data.name);
              $('[name="status"]').val(data.status);
              $('[name="id_privilege"]').val(data.id_privilege);                               
              $('#btn_edit_'+id).html('<i class="glyphicon glyphicon-pencil"></i>');
              $('#btn_edit_'+id).attr('disabled',false); //set button enable
              $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Edit Data User'); // Set title to Bootstrap modal title
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              $('#btn_edit_'+id).html('<i class="glyphicon glyphicon-pencil"></i>');
              $('#btn_edit_'+id).attr('disabled',false); //set button enable
              swal("Oops...","sorry error get data from server : "+errorThrown, "error");
          }
      });
  }
  function add(){
    save_method = 'add';
    //$('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Data User'); // Set Title to Bootstrap modal title
  }
  function reload_table(){
      table.ajax.reload(null,false); //reload datatable ajax
  }

  function save(){
      var form,formData,url,file;
      $('#save_button').text('saving...'); //change button text
      $('#save_button').attr('disabled',true); //set button disable
      if(save_method == 'add') {
          url = "<?php echo site_url('admin/data_user/ajax_add');?>";
      } else if(save_method == 'update'){
          url = "<?php echo site_url('admin/data_user/ajax_update');?>";                          
      }
      // ajax adding data to database
      var username = $('[name="username"]').val();
      var password = $('[name="password"]').val();
      var vpassword = $('[name="vpassword"]').val();
      var name = $('[name="name"]').val();
      var status = $('[name="status"]').val();
      var id_privilege = $('[name="id_privilege"]').val();      
      if(username === null || username === ""){
          swal("Oops...", "Maaf Username Tidak boleh kosong", "warning");
          $('#btnSave').attr('disabled',false); //set button enable 
      }else if(password === null || password === ""){
          swal("Oops...", "Maaf Password Tidak boleh kosong", "warning");
          $('#btnSave').attr('disabled',false); //set button enable 
      }else if(vpassword === null || vpassword === ""){
          swal("Oops...", "Maaf Verify Password Tidak boleh kosong", "warning");
          $('#btnSave').attr('disabled',false); //set button enable 
      }else if(name === null || name === ""){
          swal("Oops...", "Maaf Nama Tidak boleh kosong", "warning");
          $('#btnSave').attr('disabled',false); //set button enable 
      }else if(status === null || status === ""){
          swal("Oops...", "Maaf Status Tidak boleh kosong", "warning");
          $('#btnSave').attr('disabled',false); //set button enable 
      }else if(id_privilege === null || id_privilege === ""){
          swal("Oops...", "Maaf Privilege Tidak boleh kosong", "warning");
          $('#btnSave').attr('disabled',false); //set button enable 
      }else if($("#password").val() != $("#vpassword").val()){
          $('#btnSave').attr('disabled',false); //set button enable
          swal("Oops...", "Maaf password anda tidak sama", "warning");
      }else{
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            enctype: 'application/x-www-form-urlencoded',
            beforeSend: function(data)
            {
              $("#loading").html('<div style="float:right"><img src="<?php echo site_url('assets/backend/img/default.svg')?>" style="width:20%;height:20%;"></div>');
            },
            success: function(data)
            {
              $("#loading").html('');
              if(data.status){ //if success close modal and reload ajax table
                swal({
                  title:"Success",
                  text:data.message,
                  type:"success"
                },function(){
                  setTimeout(function(){
                      $('#modal_form').modal("hide");
                      reload_table();                           
                  },2000);
                });
              }else{
                swal("Oops...","Pesan error : "+data.message, "error");
              }
              $('#save_button').attr('disabled',false); //set button enable
            },                           
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal("Oops...","sorry error save data from server : "+errorThrown, "error");
                $("#loading").html('');
                $('#save_button').attr('disabled',false); //set button enable

            }
        });
      }
  }
  function delete_ajax(id){
    swal({
      title: "Are you sure?",
      text: "Do you want delete this data?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      closeOnConfirm: false
    },
    function(){
      swal.close();
      // ajax delete data to database
      $.ajax({
        url :  "<?php echo site_url('admin/data_user/ajax_delete')?>/"+id,
        type: "POST",
        dataType: "JSON",
        beforeSend: function(data){
         //$("#loading-2").html('<div style="margin-top:-265px;margin-left:-150px;width:150%; height:110%;z-index: 1040;position:fixed;background-color:rgba(0, 0, 0, 0.37);""><div style="margin:10% 35%;"><img src="<?php echo site_url()?>assets/img/default.svg" style="width:150px;height:150px;"></div></div>');
        },success: function(data){
          if(data.status){
              $("#loading-2").html('');
                    swal({
                      title:"Success",
                      text:data.message,
                      type:"success"
                    },function(){
                        setTimeout(function(){
                            reload_table();                          
                        },1000);
                    });               
          }else{
            swal("Oops...","Message error : "+data.message, "error");
            $("#loading-2").html('');
          }
        },error: function (jqXHR, textStatus, errorThrown){
            swal("Oops...","sorry error delete data from server : "+errorThrown, "error");
            $("#loading-2").html('');
        }
      });
    });
  }
  </script>
  <!-- Bootstrap modal -->
<!-- Modal -->
<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" style="overflow-y: scroll !important">
  <div class="modal-dialog" style="width:75%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Data User Form</h4>
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <!-- /.box-header -->
                <div class="box-body pad">
                  <form action="#" method="post"  id="form">
                    <input type="hidden" name="id_user" value="">
                    <input type="hidden" name="getpass" value=""> 
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label>Verification Password</label>
                      <input id="vpassword" type="password" class="form-control" name="vpassword" placeholder="Password">
                      <div class="info-verify" style="color:black;padding:10px 0px 10px 0px !important;display: none;"></div>
                    </div>
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                      <label>Account Status</label>
                      <select name="status" class="form-control" required>
                        <option value="">- Select -</option>
                        <option value="0">Not Active</option>
                        <option value="1">Active</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Level Privilege</label>
                      <select name="id_privilege" class="form-control" required>
                        <option value="">- Select -</option>
                        <?php foreach($cat_privilege as $c){
                          echo '<option value="'.$c->id_privilege.'">'.$c->name_privilege.'</option>';
                        } ?>                        
                      </select>
                    </div>                                                                           
                  </form>
                </div>
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col-->
          </div>            
          <div class="modal-footer">
            <div class="col-md-6 pull-left">
              <div id="loading"></div>
            </div>
            <div class="col-md-6 pull-right">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="save_button">Save</button>              
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
