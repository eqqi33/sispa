<link rel="stylesheet" href="<?=base_URL('assets/backend/lib/sweetalert/css/sweetalert.css')?>">
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Profile
      <small><?=$this->session->userdata('name')?></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-cog"></i> Profile</a></li>
      <li class="active"><?=$this->session->userdata('name')?></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div id="profile">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="" alt="<?=$this->session->userdata('user')?>">
              <h3 class="profile-username text-center"><?=$this->session->userdata('user')?></h3>
              <!--<p class="text-muted text-center">Software Engineer</p>-->
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Username</b> <a class="pull-right"><?=$this->session->userdata('user')?></a>
                </li>                
                <li class="list-group-item">
                  <b>Name</b> <a class="pull-right"><?=$this->session->userdata('name')?></a>
                </li>
                <li class="list-group-item">
                  <b>Last Login On</b> <a class="pull-right"><?=time_elapsed_string($this->session->userdata('time'));?></a>
                </li>
              </ul>
              <a href="#" class="btn btn-primary btn-block" id="setting_page"><b>Setting Account</b></a>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <div id="form_setting_profile" style="display:none;">
        <div class="col-md-12">
          <div class="box box-info">
            <!-- /.box-header -->
            <div class="box-body pad">
              <form action="#" method="post"  id="form">
                <input type="hidden" name="id_user" value="<?=$this->session->userdata('id')?>">
                <input type="hidden" name="getpass" value="<?=$this->session->userdata('pass')?>"> 
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" name="username" placeholder="Username" readonly="true" value="<?=$this->session->userdata('user')?>">
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
                  <input type="text" class="form-control" name="name" placeholder="Name" value="<?=$this->session->userdata('name')?>">
                </div>
                <div class="modal-footer">
                  <div class="col-md-6 pull-left">
                    <div id="loading"></div>
                  </div>
                  <div class="col-md-6 pull-right">
                    <button type="button" class="btn btn-default" id="cancel_button">Cancel</button>
                    <button type="button" class="btn btn-primary" id="save_button">Save</button>              
                  </div>
                </div>                                                                         
              </form>
            </div>
          </div>
          <!-- /.box -->
        </div>      
      </div>
    </div>
  </section>    
</div>
<script src="<?=base_URL('assets/backend/lib/sweetalert/js/sweetalert.min.js')?>" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#vpassword').keyup(verifyPass);
    $('#setting_page').on('click',function(){
      $('#profile').hide();
      $('#form_setting_profile').show();
    });
    $('#cancel_button').on('click',function(){
      $('#profile').show();
      $('#form_setting_profile').hide();
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
  function save(){
      var form,formData,url;
      $('#save_button').text('saving...'); //change button text
      $('#save_button').attr('disabled',true); //set button disable
      url = "<?php echo site_url('admin/data_user/ajax_update');?>";
      // ajax adding data to database
      var password = $('[name="password"]').val();
      var vpassword = $('[name="vpassword"]').val();
      var name = $('[name="name"]').val();     
      if(password === null || password === ""){
          swal("Oops...", "Maaf Password Tidak boleh kosong", "warning");
          $('#save_button').text('Save'); //change button text
          $('#save_button').attr('disabled',false); //set button enable 
      }else if(vpassword === null || vpassword === ""){
          swal("Oops...", "Maaf Verify Password Tidak boleh kosong", "warning");
          $('#save_button').text('Save'); //change button text
          $('#save_button').attr('disabled',false); //set button enable
      }else if(name === null || name === ""){
          swal("Oops...", "Maaf Nama Tidak boleh kosong", "warning");
          $('#save_button').text('Save'); //change button text
          $('#save_button').attr('disabled',false); //set button enable
      }else if($("#password").val() != $("#vpassword").val()){
          swal("Oops...", "Maaf password anda tidak sama", "warning");
          $('#save_button').attr('disabled',false); //set button enable
          $('#save_button').text('Save'); //change button text
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
                  setTimeout("location.href = \"<?=base_url('admin/profile/index');?>\";",2000);
                });
              }else{
                swal("Oops...","Pesan error : "+data.message, "error");
              }
              $('#save_button').attr('disabled',false); //set button enable
              $('#save_button').text('Save'); //change button text
            },                           
            error: function (jqXHR, textStatus, errorThrown)
            {
                swal("Oops...","sorry error save data from server : "+errorThrown, "error");
                $("#loading").html('');
                $('#save_button').attr('disabled',false); //set button enable
                $('#save_button').text('Save'); //change button text
            }
        });
      }
  }
</script>
