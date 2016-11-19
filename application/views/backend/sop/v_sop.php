  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/summernote/summernote.css')?>">
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/sweetalert/css/sweetalert.css')?>">
  <link rel="stylesheet" type="text/css" href="<?=base_URL('assets/backend/lib/datatables/dataTables.bootstrap.css')?>"/>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Text Editors
        <small>Advanced form element</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Editors</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Data SOP</h3>
          <button class="btn btn-primary pull-right" id="add_button"><i class="glyphicon glyphicon-plus"></i> Add Data</button><button class="btn btn-default pull-right" id="reload_button" style="margin-right:10px !important;"><i class="glyphicon glyphicon-refresh"></i> Reload Table</button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table id="table" class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Title SOP</th>
                  <th>Date Created</th>
                  <th>Last Edited</th>
                  <th>Create By</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>            
            </table>
          </div>
        </div>
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>
  <script src="<?=base_URL('assets/backend/lib/summernote/summernote.min.js')?>"></script>
  <script src="<?=base_URL('assets/backend/lib/sweetalert/js/sweetalert.min.js')?>" type="text/javascript"></script>
  <script type="text/javascript">
  var save_method,table;
  $(document).ready(function() {
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
        "ajax": "<?php echo site_url('sop/c_sop/ajax_tabel_sop'); ?>",
        "columns": [
            {
                "data": "id_sop",
                "class": "text-center",
                "orderable": false
            },
            {"data": "title_sop"},
            {"data": "date_created"},
            {"data": "last_edited"},
            {"data": "username_created"},
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
    $('#modal_form').modal({
      keyboard:false,
      backdrop:'static',
      show:false,
    });
    $('#modal_form').on('hidden.bs.modal', function (e) {
      //$('#form')[0].reset(); // reset form on modals
      //$('#tag').tagsinput('removeAll');
    });    
    var $summernote = $('#editor').summernote({
          height: 300,
          callbacks: {
              onImageUpload: function (files) {
                  sendFile($summernote, files[0]);
              }
          }
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
  function preview(id){
      $('#btn_preview_'+id).html('<i class="glyphicon glyphicon-comment"> Wait...</i>');
      $('#btn_preview_'+id).attr('disabled',true); //set button enable
      //$("#loading-2").html('<div style="margin-top:-265px;margin-left:-150px;width:150%; height:110%;z-index: 1040;position:fixed;background-color:rgba(0, 0, 0, 0.37);""><div style="margin:10% 35%;"><img src="<?php echo site_url()?>assets/img/default.svg" style="width:150px;height:150px;"></div></div>');
      //Ajax Load data from ajax
      $.ajax({
          url : "<?php echo site_url('sop/c_sop/ajax_preview/')?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
              var type_sop = data.type_sop;
              var title_sop = data.title_sop;
              var detail_sop = data.detail_sop;
              var date_created = data.date_created;
              var username_created = data.username_created
              if(detail_sop === "" || detail_sop === null){
                detail_sop = "Sorry not available for detail SOP";
              }else{
                detail_sop = detail_sop;
              }
              $('#type_sop-preview').html('<b>: '+type_sop+'</b>');
              $('#title_sop-preview').html('<b>: '+title_sop+'</b>');
              $('#detail_sop-preview').html(detail_sop);
              $('#date_created-preview').html('<b>: '+date_created+'</b>');
              $('#user_created-preview').html('<b>: '+username_created+'</b>');
              $('#btn_preview_'+id).html('<i class="glyphicon glyphicon-comment"><font style="margin-left:3px;font-family: Open Sans,sans-serif;">Preview SOP</font></i>');
              $('#btn_preview_'+id).attr('disabled',false); //set button enable
              $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
              $('#preview').show();
              $('#form_input').hide();
              $('.modal-title').text('Preview SOP : '+title_sop); // Set Title to Bootstrap modal title
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              $('#btn_preview_'+id).html('<i class="glyphicon glyphicon-comment"><font style="margin-left:3px;font-family: Open Sans,sans-serif;">Preview SOP</font></i>');
              $('#btn_preview_'+id).attr('disabled',false); //set button enable
              $("#loading-2").html('');
              swal("Oops...","sorry error get data from server : "+errorThrown, "error");
          }
      });
  }

  function edit(id){
      save_method = 'update';
      $('#form')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('.btn_edit_'+id).html('<i class="glyphicon glyphicon-pencil"> Wait...</i>');
      $('.btn_edit_'+id).attr('disabled',true); //set button enable
      $("#loading-2").html('<div style="margin-top:-265px;margin-left:-150px;width:150%; height:110%;z-index: 1040;position:fixed;background-color:rgba(0, 0, 0, 0.37);""><div style="margin:10% 35%;"><img src="<?php echo site_url()?>assets/img/default.svg" style="width:150px;height:150px;"></div></div>');
      //Ajax Load data from ajax
      $.ajax({
          url : "<?php echo site_url('real-adm/master_data/group_product/ajax_edit/')?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
              $('#preview-tag').show();
              $('[name="id"]').val(data.id_group_product);
              $('[name="group_product_name"]').val(data.name_group_product);
              $('[name="id_group"]').val(data.id_group);
              $('#editor1').summernote('code', data.description);
              $('#editor2').summernote('code', data.description_ind);
              $('[name="description"]').val(data.description);
              $('[name="description_ind"]').val(data.description_ind);
              $('[name="recent_tag"]').val(data.tag);
              var data_picture = data.picture;
              $('#fileupload-preview').html(data_picture);
              $('#fileupload-preview-1').val(data_picture);                              
              $('#loading-2').html('');
              $('#progress-bar').text("0%");
              $('#progress-bar').css({width: "0%"});                               
              $('#btn_edit_'+id).html('<i class="glyphicon glyphicon-pencil"><font style="margin-left:3px;font-family: Open Sans,sans-serif;">Edit</font></i>');
              $('#btn_edit_'+id).attr('disabled',false); //set button enable
              $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Edit Group Product'); // Set title to Bootstrap modal title
              $('#preview').hide();
              $('#form_input').show();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              $('#btn_edit_'+id).html('<i class="glyphicon glyphicon-pencil"> Edit</i>');
              $('#btn_edit_'+id).attr('disabled',false); //set button enable
              $("#loading-2").html('');
              swal("Oops...","sorry error get data from server : "+errorThrown, "error");
          }
      });
  }
  function add(){
    save_method = 'add';
    //$('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add SOP'); // Set Title to Bootstrap modal title
    $('#form_input').show();
    $('#preview').hide();
    $('#editor').summernote('code', '');                      
    $('#editor').summernote({placeholder: 'write here...'});
  }
  function reload_table(){
      table.ajax.reload(null,false); //reload datatable ajax
  }
  function sendFile($summernote, file) {
    var formData = new FormData($('#form')[0]);
    formData.append("file_upload", file);
    $.ajax({
      data: formData,
      type: "POST",
      url: '<?php echo site_url('sop/c_sop/saveuploadedfile')?>',
      cache: false,
      contentType: false,
      processData: false,
      enctype: 'multipart/form-data',
      dataType: "JSON",
      success: function(data) {
        $summernote.summernote('insertImage', data.url, function ($image) {
                $image.attr('src', data.url);
            });
      }
    });
  }
  function save(){
      var form,formData,url,file;
      $('#save_button').text('saving...'); //change button text
      $('#save_button').attr('disabled',true); //set button disable
      if(save_method == 'add') {
          url = "<?php echo site_url('sop/c_sop/ajax_add')?>";
      } else if(save_method == 'update'){
          url = "<?php echo site_url('sop/c_sop/ajax_update')?>";                          
      }
      formData = new FormData($('#form')[0]);
      formData.append('file', $('input[type=file]')[0].files[0]);
      // ajax adding data to database
      var title_sop = $('[name="title_sop"]').val();
      var type_sop = $('[name="type_sop"]').val();
      if(title_sop === null || title_sop === ""){
          swal("Oops...", "Sorry Title SOP can't be empty", "warning");
          $('#save_button').text('Save'); //change button text
          $('#save_button').attr('disabled',false); //set button enable
      }else if(type_sop === null || type_sop === ""){
          swal("Oops...", "Sorry Type SOP can't be empty", "warning");
          $('#save_button').text('Save'); //change button text
          $('#save_button').attr('disabled',false); //set button enable
      }else{
        $.ajax({
            url : url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
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
                      //reload_table();                           
                  },2000);
                });
              }else{
                swal("Oops...","Pesan error : "+data.message, "error");
              }
              $('#save_button').text('Save'); //change button text
              $('#save_button').attr('disabled',false); //set button enable
            },                           
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal("Oops...","sorry error save data from server : "+errorThrown, "error");
                $("#loading").html('');
                $('#save_button').text('Save'); //change button text
                $('#save_button').attr('disabled',false); //set button enable

            }
        });
      }
  }
  function delete_sop(id){
    swal({
      title: "Are you sure?",
      text: "Are you sure you want to delete this data?",
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
        url :  "<?php echo site_url('sop/c_sop/ajax_delete')?>/"+id,
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
        <h4 class="modal-title">SOP Form</h4>
      </div>
      <div id="form_input">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <!-- /.box-header -->
                <div class="box-body pad">
                  <form action="#" method="post"  id="form">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-group">
                      <label>Type for SOP</label>
                      <select name="type_sop" class="form-control" required>
                        <option value="">- Select -</option>
                        <option value="ca">CA</option>
                        <option value="bn">BN</option>
                        <option value="other">Other</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Title SOP</label>
                      <input type="text" class="form-control" name="title_sop" placeholder="Entry Title SOP" required>
                    </div>
                    <div class="form-group">
                      <label>Description SOP</label>                
                      <textarea id="editor" name="detail_sop" rows="18"></textarea> 
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
      <div id="preview">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <!-- /.box-header -->
                <div class="box-body pad">
                  <div class="col-md-12">
                    <div class="col-md-3">Type SOP</div><div id="type_sop-preview" class="col-md-9"></div>
                    <div class="col-md-3">Title SOP</div><div id="title_sop-preview" class="col-md-9"></div>
                    <div class="col-md-3">Date On Created</div><div id="date_created-preview" class="col-md-9"></div>
                    <div class="col-md-3">Created By</div><div id="user_created-preview" class="col-md-9"></div>
                    <div class="col-md-12">Detail SOP</div>
                    <div class="col-md-12" style="margin-top:10px !important;margin-bottom:10px !important;"><hr></div>
                    <div class="col-md-12">
                      <div id="detail_sop-preview" style="padding:10px;"></div>
                    </div> 
                  </div>
                </div>
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col-->
          </div>            
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>        
      </div>
    </div>
  </div>
</div>
