  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/summernote/summernote.css')?>">
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/sweetalert/css/sweetalert.css')?>">
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/datepicker/datepicker3.css')?>">
  <link rel="stylesheet" type="text/css" href="<?=base_URL('assets/backend/lib/datatables/dataTables.bootstrap.css')?>"/>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SOP
        <small>SSR SOP</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-laptop"></i> Service Platform</a></li>
        <li><a href="#">Broadcast Application</a></li>
        <li><a href="#">SOP</a></li>
        <li class="active">SSR SOP</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div id="data_table">
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title">SOP SSR</h3>
            <button class="btn btn-primary pull-right" id="add_button"><i class="glyphicon glyphicon-plus"></i><!-- Add Data--></button><button class="btn btn-default pull-right" id="reload_button" style="margin-right:10px !important;"><i class="glyphicon glyphicon-refresh"></i><!--  Reload Table--></button>
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
      </div>
      <div id="data_preview">
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title" id="box-title-preview">Preview SOP</h3>
            <button class="btn btn-primary pull-right" id="show_table_button"><i class="glyphicon glyphicon-th"></i> Show Table</button>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="col-md-12">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="table" class="table table-bordered" width="100%">
                        <tr>
                          <th width="25%" rowspan="2" style="vertical-align: middle !important;">
                            <center>
                              <img src="<?=base_url('assets/backend/img/logo-indovision.jpg')?>" style="width:75% !important;">
                            </center>
                          </th>
                          <th width="50%" colspan="3">
                            <center>
                              <h4 style="font-weight: bold;">BIS DIV / BROADCAST DEVELOPMENT DEPT BROADCAST APPLICATION</h4>
                            </center>
                          </th>
                          <!--<td></td>-->
                          <th width="25%" rowspan="2" style="vertical-align: middle !important;">
                            <center>
                              <img src="<?=base_url('assets/backend/img/logo-globalmediacom.jpg')?>"  style="width:100% !important;">
                            </center>
                          </th>
                        </tr>                        
                        <tr>
                          <td colspan="2">
                            <center>
                              <h3 style="font-weight: bold;" id="title_sop-preview"></h3>
                            </center>
                          </td>
                          <td style="vertical-align: middle !important;">
                            <center>No. Dokumen : <span id="num_document-preview"></span></center>
                          </td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>
                            <center>
                              <h4 style="font-weight: bold;">PT. MNC SKY VISION, Tbk</h4>
                            </center>
                          </td>
                          <td>
                            <center>Mulai  berlaku tanggal :<br><span id="effective_date-preview"></span></center>
                          </td>
                          <td>
                            <center>Revisi :<br><span id="num_revision-preview"></span></center>
                          </td>
                          <td>
                            <center>Tgl revisi :<br><span id="date_revision-preview"></span></center>
                          </td>
                          <td>
                            <center>
                              <h4 style="font-weight: bold;">PT. GLOBAL MEDIACOM, Tbk</h4>
                            </center>
                          </td>
                        </tr>                        
                    </table>
                  </div>                  
                </div>
                <div class="col-md-12" style="margin-top:10px !important;margin-bottom:10px !important;"><hr></div>
                <div class="col-md-12">
                  <div class="img-responsive">
                    <div id="detail_sop-preview" style="padding:10px;"></div>
                  </div>
                </div>
                <div class="col-md-12" style="margin-top:10px !important;margin-bottom:10px !important;"><hr></div>
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="table" class="table table-bordered" width="100%">
                      <tr>
                        <th>Dibuat oleh:<br><br><span id="made_by-preview"></span></th>
                        <th>Diperiksa oleh:<br><br><span id="checked_by-preview"></span></th>
                        <th>Disetujui oleh:<br><br><span id="approv_by-preview"></span></th>
                      </tr>
                    </table>
                </div>
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col-->
          </div>
          </div>
        </div>
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>
  <script src="<?=base_URL('assets/backend/lib/summernote/summernote.min.js')?>"></script>
  <script src="<?=base_URL('assets/backend/lib/datepicker/bootstrap-datepicker.js')?>"></script>
  <script src="<?=base_URL('assets/backend/lib/sweetalert/js/sweetalert.min.js')?>" type="text/javascript"></script>
  <script type="text/javascript">
  var save_method,table;
  $(document).ready(function() {
    $('#data_preview').hide();

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
        "ajax": "<?php echo site_url('admin/sop/c_sop/ajax_tabel_sop'); ?>",
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
    //end of datatables    

    
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
        //Date picker
    $('#effective_date').datepicker({
      autoclose: true
    });
    $('#reload_button').on('click',function(){
      reload_table();
    });
    $('#show_table_button').on('click',function(){
      $('#data_preview').hide();
      $('#data_table').show();
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
          url : "<?php echo site_url('admin/sop/c_sop/ajax_preview/')?>" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
              var num_document = data.num_document;
              var title_sop = data.title_sop;
              var detail_sop = data.detail_sop;
              var effective_date = data.date_effective;
              var num_revision = data.number_revision;
              var date_revision = data.last_edited;
              var made_by = data.made_by;
              var checked_by = data.checked_by;
              var approv_by = data.approval_by;
              if(detail_sop === "" || detail_sop === null){
                detail_sop = "Sorry not available for detail SOP";
              }else{
                detail_sop = detail_sop;
              }
              $('#num_document-preview').text(num_document);
              $('#title_sop-preview').text(title_sop);
              $('#effective_date-preview').text(effective_date);
              $('#num_revision-preview').text(num_revision);
              $('#date_revision-preview').text(date_revision);
              $('#made_by-preview').text(made_by);
              $('#checked_by-preview').text(checked_by);
              $('#approv_by-preview').text(approv_by);
              $('#detail_sop-preview').html(detail_sop);
              $('#btn_preview_'+id).html('<i class="glyphicon glyphicon-comment"></i>');
              $('#btn_preview_'+id).attr('disabled',false); //set button enable
              $('#data_preview').show();
              $('#data_table').hide();
              $('#box-title-preview').text('Preview SOP : '+title_sop); // Set Title to Bootstrap modal title
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              $('#btn_preview_'+id).html('<i class="glyphicon glyphicon-comment"></i>');
              $('#btn_preview_'+id).attr('disabled',false); //set button enable
              $("#loading-2").html('');
              swal("Oops...","sorry error get data from server : "+errorThrown, "error");
          }
      });
  }

  function edit(id){
      save_method = 'update';
      $('.btn_edit_'+id).html('<i class="glyphicon glyphicon-pencil"> Wait...</i>');
      $('.btn_edit_'+id).attr('disabled',true); //set button enable
      //$("#loading-2").html('<div style="margin-top:-265px;margin-left:-150px;width:150%; height:110%;z-index: 1040;position:fixed;background-color:rgba(0, 0, 0, 0.37);""><div style="margin:10% 35%;"><img src="<?php echo site_url()?>assets/img/default.svg" style="width:150px;height:150px;"></div></div>');
      //Ajax Load data from ajax
      $.ajax({
          url : "<?php echo site_url('admin/sop/c_sop/ajax_edit/')?>" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
              $('[name="id_sop"]').val(data.id_sop);
              $('[name="type_sop"]').val(data.type_sop);
              $('[name="cat_sop"]').val(data.id_cat_sop);
              $('[name="num_doc"]').val(data.num_document);
              $('#effective_date').datepicker('update', data.date_effective);
              $('[name="made_by"]').val(data.made_by);
              $('[name="checked_by"]').val(data.checked_by);
              $('[name="approv_by"]').val(data.approval_by);
              $('[name="title_sop"]').val(data.title_sop);
              $('#editor').summernote('code', data.detail_sop);                               
              $('#btn_edit_'+id).html('<i class="glyphicon glyphicon-pencil"></i>');
              $('#btn_edit_'+id).attr('disabled',false); //set button enable
              $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Edit SOP'); // Set title to Bootstrap modal title
              $('#data_preview').hide();
              $('#data_table').show();
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
    $('.modal-title').text('Add SOP'); // Set Title to Bootstrap modal title
    $('#data_preview').hide();
    $('#data_table').show();
    $('#editor').summernote('code', '');                      
    $('#editor').summernote({placeholder: 'write here...'});
    $('#effective_date').datepicker('update', new Date());
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
      url: '<?php echo site_url('admin/sop/c_sop/saveuploadedfile')?>',
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
          url = "<?php echo site_url('admin/sop/c_sop/ajax_add')?>";
      } else if(save_method == 'update'){
          url = "<?php echo site_url('admin/sop/c_sop/ajax_update')?>";                          
      }
      formData = new FormData($('#form')[0]);
      formData.append('file', $('input[type=file]')[0].files[0]);
      // ajax adding data to database
      var title_sop = $('[name="title_sop"]').val();
      var type_sop = $('[name="type_sop"]').val();
      if(title_sop === null || title_sop === ""){
          swal("Oops...", "Sorry Title SOP can't be empty", "warning");
          $('#save_button').attr('disabled',false); //set button enable
      }else if(type_sop === null || type_sop === ""){
          swal("Oops...", "Sorry Type SOP can't be empty", "warning");
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
        url :  "<?php echo site_url('admin/sop/c_sop/ajax_delete')?>/"+id,
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
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <!-- /.box-header -->
                <div class="box-body pad">
                  <form action="#" method="post"  id="form">
                    <input type="hidden" value="" name="id_sop"/>
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
                      <label>Category SOP</label>
                      <select name="cat_sop" class="form-control" required>
                        <option value="">- Select -</option>
                        <?php foreach($cat_sop as $c){
                          echo '<option value="'.$c->id_cat_sop.'">'.$c->name_category_sop.'</option>';
                        } ?>                        
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Num. Document</label>
                      <input type="text" class="form-control" name="num_doc" placeholder="Entry Number Document" required>
                    </div>
                    <div class="form-group">
                      <label>Effective Date</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="effective_date" name="effective_date">
                      </div>
                      <!-- /.input group -->
                    </div>
                    <div class="form-group">
                      <label>Made By</label>
                      <input type="text" class="form-control" name="made_by" placeholder="Entry Made By" required>
                    </div>                                                           
                    <div class="form-group">
                      <label>Checked By</label>
                      <input type="text" class="form-control" name="checked_by" placeholder="Entry Checked By" required>
                    </div>
                    <div class="form-group">
                      <label>Approval By</label>
                      <input type="text" class="form-control" name="approv_by" placeholder="Entry Approval By" required>
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
  </div>
</div>
