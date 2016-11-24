  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/summernote/summernote.css')?>">
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/sweetalert/css/sweetalert.css')?>">
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/datepicker/datepicker3.css')?>">
  <link rel="stylesheet" type="text/css" href="<?=base_URL('assets/backend/lib/datatables/dataTables.bootstrap.css')?>"/>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Work Log
        <small>SSR Work Log</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-laptop"></i> Service Platform</a></li>
        <li><a href="#">Broadcast Application</a></li>
        <li><a href="#">Work Log</a></li>
        <li class="active">SSR Work Log</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div id="data_table">
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title">Work Log SSR</h3>
            <button class="btn btn-primary pull-right" id="add_button"><i class="glyphicon glyphicon-plus"></i><!-- Add Data--></button><button class="btn btn-default pull-right" id="reload_button" style="margin-right:10px !important;"><i class="glyphicon glyphicon-refresh"></i><!--  Reload Table--></button>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table id="table" class="table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Date Req</th>
                    <th>Componen</th>
                    <th>Description</th>
                    <th>Impact</th>
                    <th>Action</th>
                    <th>Due Date</th>                    
                    <th>PIC User</th>
                    <th>PIC BA</th>
                    <th>Status</th>
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
            <h3 class="box-title" id="box-title-preview">Preview Work Log</h3>
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
                              <h3 style="font-weight: bold;" id="componen-preview"></h3>
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
                    <div id="detail_wlog-preview" style="padding:10px;"></div>
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
        "ajax": "<?php echo site_url('wlog/c_wlog/ajax_tabel_wlog'); ?>",
        "columns": [
            {
                "data": "id_wlog",
                "class": "text-center",
                "orderable": false
            },
            {"data": "req_date"},
            {"data": "componen"}, 
            {"data": "description"},
            {"data": "impac"},
            {"data": "aksi"},
            {"data": "due_date"},
            {"data": "pic"},
            {"data": "username"},
            {"data": "status"},
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
    $('#req_date').datepicker({
      autoclose: true
    }); 
    $('#due_date').datepicker({
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
          url : "<?php echo site_url('wlog/c_wlog/ajax_preview/')?>" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
              var num_document = data.num_document;
              var componen = data.componen;
              var detail_wlog = data.detail_wlog;
              var name_category_wlog = data.name_category_wlog;
              var impac = data.impac;
              var descriptiont = data.descriptiont;
              
              if(detail_wlog === "" || detail_wlog === null){
                detail_wlog = "Sorry not available for detail Work Log";
              }else{
                detail_wlog = detail_wlog;
              }
              $('#num_document-preview').text(num_document);
              $('#componen-preview').text(componen);
              $('#detail_wlog-preview').text(detail_wlog);
              $('#name_category_wlog-preview').text(name_category_wlog);
              $('#impac-preview').text(impac);
              $('#descriptiont-preview').text(descriptiont);
              
              $('#detail_wlog-preview').html(detail_wlog);
              $('#btn_preview_'+id).html('<i class="glyphicon glyphicon-comment"></i>');
              $('#btn_preview_'+id).attr('disabled',false); //set button enable
              $('#data_preview').show();
              $('#data_table').hide();
              $('#box-title-preview').text('Preview Work Log : '+componen); // Set Title to Bootstrap modal title
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
          url : "<?php echo site_url('wlog/c_wlog/ajax_edit/')?>" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
              $('[name="id_wlog"]').val(data.id_wlog);
              $('[name="name_category_wlog"]').val(data.name_category_wlog);
              $('[name="componen"]').val(data.componen);
              $('[name="descriptiont"]').val(data.descriptiont);
              $('[name="impac"]').val(data.impac);
              $('[name="action"]').val(data.action);
              $('#req_date').datepicker('update', data.req_date);
              $('#due_date').datepicker('update', data.due_date);
              $('[name="pic"]').val(data.pic);
              $('[name="status"]').val(data.status);
              $('#editor').summernote('code', data.detail_wlog);                               
              $('#btn_edit_'+id).html('<i class="glyphicon glyphicon-pencil"></i>');
              $('#btn_edit_'+id).attr('disabled',false); //set button enable
              $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
              $('.modal-title').text('Edit Work Log'); // Set title to Bootstrap modal title
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
    $('.modal-title').text('Add Work Log'); // Set Title to Bootstrap modal title
    $('#data_preview').hide();
    $('#data_table').show();
    $('#editor').summernote('code', '');                      
    $('#editor').summernote({placeholder: 'write here...'});
    $('#req_date').datepicker('update', new Date());
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
      url: '<?php echo site_url('wlog/c_wlog/saveuploadedfile')?>',
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
          url = "<?php echo site_url('wlog/c_wlog/ajax_add');?>";
      } else if(save_method == 'update'){
          url = "<?php echo site_url('wlog/c_wlog/ajax_update');?>";                          
      }
      // ajax adding data to database
      var componen = $('[name="componen"]').val();
      var description = $('[name="description"]').val();
      if(componen === null || componen === ""){
          swal("Oops...", "Sorry Componen can't be empty", "warning");
          $('#save_button').attr('disabled',false); //set button enable
      }else if(description === null || description === ""){
          swal("Oops...", "Sorry Description can't be empty", "warning");
          $('#save_button').attr('disabled',false); //set button enable
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
  function delete_wlog(id){
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
        url :  "<?php echo site_url('wlog/c_wlog/ajax_delete')?>/"+id,
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
        <h4 class="modal-title">Work Log Form</h4>
      </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <!-- /.box-header -->
                <div class="box-body pad">
                  <form action="#" method="post"  id="form">
                    <input type="hidden" value="" name="id_wlog"/>
                    
                    <div class="form-group">
                      <label>Category Work Log</label>
                      <select name="cat_wlog" class="form-control" required>
                        <option value="">- Select -</option>
                        <?php foreach($cat_wlog as $c){
                          echo '<option value="'.$c->id_cat_wlog.'">'.$c->name_category_wlog.'</option>';
                        } ?>                        
                      </select>
                    </div>
                     <div class="form-group">
                      <label>Request Date</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="req_date" name="req_date">
                      </div>
                      <!-- /.input group -->
                    </div>
                    <div class="form-group">
                      <label>Componen</label>
                      <textarea class="form-control" name="componen" rows="3" placeholder="Componen"></textarea>
                    </div>
                     
                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" name="description" rows="3" placeholder="Description"></textarea>
                    </div>
                      
                    <div class="form-group">
                      <label>Impact</label>
                      <textarea class="form-control" name="impact" rows="3" placeholder="Impact"></textarea>
                    </div>

                    <div class="form-group">
                      <label>Action</label>
                      <input type="text" class="form-control" name="action" placeholder="Action" required>
                    </div> 

                    <div class="form-group">
                      <label>Due Date</label>
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="due_date" name="due_date">
                      </div>
                      
                    </div>
                    <div class="form-group">
                      <label>PIC</label>
                      <input type="text" class="form-control" name="picuser" placeholder="PIC User" required>
                    </div> 

                    <div class="form-group">
                      <label>PIC BA</label>
                      <input type="text" class="form-control" name="picba" value="<?=$this->session->userdata('name');?>" readonly="readonly" required>
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
