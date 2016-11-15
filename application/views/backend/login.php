<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/bootstrap/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/font-awesome/css/font-awesome.min.css')?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/ionicons/css/ionicons.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/css/AdminLTE.min.css')?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/iCheck/square/blue.css')?>">
  <!-- sweetalert -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/sweetalert/css/sweetalert.css')?>">  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="<?=base_URL('assets/backend/js/html5shiv.min.js')?>"></script>
  <script src="<?=base_URL('assets/backend/js/respond.min.js')?>"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="#" method="post" id="form-login" enctype="application/x-www-form-urlencoded" onkeypress="return runScript(event)">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" id="username" name="username" value="<?=$u;?>" autocomplete="on">
        <span class="glyphicon glyphicon-envelope form-control-feedback" style="color:#3C8DBC;"></span>
        <div class="error" id="username-alert" style="color:#ef6262;display:none;">
          <center>The Username field is required.</center>
        </div>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?=$p;?>">
        <span class="glyphicon glyphicon-lock form-control-feedback" style="color:#3C8DBC;"></span>
        <div class="error" id="password-alert" style="color:#ef6262;display:none;">
          <center>The Password field is required.</center>
        </div>        
      </div>
      <div class="row">
        <div class="col-xs-6">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" id="remember" name="remember" value="true" <?=$set_remember;?>> Remember Me <span class="glyphicon glyphicon-exclamation-sign" style="color:red;"></span>
            </label>
          </div>
        </div>       
        <div class="col-xs-6">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" id="showPassword"> Show Password
            </label>
          </div>
        </div>       
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="button" class="btn btn-primary btn-block btn-flat" id="login-btn">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

<!--     <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
    <!-- /.social-auth-links -->

<!--     <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?=base_URL('assets/backend/lib/jQuery/jquery-2.2.3.min.js')?>"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?=base_URL('assets/backend/lib/bootstrap/js/bootstrap.min.js')?>"></script>
<!-- iCheck -->
<script src="<?=base_URL('assets/backend/lib/iCheck/icheck.min.js')?>"></script>
<!-- sweet alert -->
<script src="<?=base_URL('assets/backend/lib/sweetalert/js/sweetalert.min.js')?>" type="text/javascript"></script>
<script>
  $(document).ready(function(){
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
    $('#login-btn').on('click',function(){
      login();
    });
  });

  $('#showPassword').on('click',function(){
      if($('#password').attr('type') == 'password'){
        $('#password').attr('type', 'text');
        $('#showPassword').hide().html('<i class="icon s7-close-circle"></i>').fadeIn('1500');
      }else if($('#password').attr('type') == 'text'){
        $('#password').attr('type', 'password');
        $('#showPassword').hide().html('<i class="icon icon s7-look"></i>').fadeIn('1500');
      }
  });
  function runScript(e) {
      if (e.keyCode == 13 || e.which == 13) {
          login();
          return false;
      }
  }
  function login(){        
    $('#login-btn').attr('disabled',true);
    var formData = new FormData($('form')[0]);
    var url = "<?php echo site_url('admin/index/auth_login/')?>";
    var user = $('[name="username"]').val();
    var pass = $('[name="password"]').val();
    if((user === null || user === "") && (pass === null || pass === "")){
      $('#username-alert').fadeIn(500);
      setTimeout("$('#username-alert').fadeOut(2500);",3000 );
      $('#password-alert').fadeIn(500);
      setTimeout("$('#password-alert').fadeOut(2500);",3000 );                    
      $('#login-btn').text('Sign In'); //change button text
      $('#login-btn').attr('disabled',false); //set button enable 
    }else if((user === null || user === "") && (pass !== null || pass !== "")){
      $('#username-alert').fadeIn(500);
      setTimeout("$('#username-alert').fadeOut(2500);",3000 );
      $('#login-btn').text('Sign In'); //change button text
      $('#login-btn').attr('disabled',false); //set button enable 
    }else if((user !== null || user !== "") && (pass === null || pass === "")){
      $('#password-alert').fadeIn(500);
      setTimeout("$('#password-alert').fadeOut(2500);",3000 );
      $('#login-btn').text('Sign In'); //change button text
      $('#login-btn').attr('disabled',false); //set button enable           
    }else{
      $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "JSON",
        beforeSend: function(data){
          $('#login-btn').html('<center>Wait Validated <img src="<?php echo site_url()?>assets/backend/img/default.gif" style="width:auto;height:30px;margin-left:10px;"></center>');
          $('#login-btn').css({'background-color': "#fff"});
          $('#login-btn').css({'color': "#3C8DBC"});
        },            
        success: function(data){
          if(data.status){                   
            swal({
              title: "Login Success!",
              type: "success",
              text: "We will directing you !",
              html:true,
              animation: "slide-from-left",
              showConfirmButton: false
            });
            setTimeout("location.href = '<?=base_url()?>admin/index/index';",2000);
          }else{
            swal({
              title: "Oops... Sorry",
              type: "error",
              text: "Login failed, please check your username and password",
              html:true,
              animation: "slide-from-left",
              showConfirmButton: true
            });              
            $('#login-btn').text('Sign In'); //change button text
            $('#login-btn').attr('disabled',false); //set button enable
            $('#login-btn').css({'background-color': "#3C8DBC"});
            $('#login-btn').css({'color': "#fff"}); 
          }
        },
        error: function (jqXHR, textStatus, errorThrown){   
            swal("Oops...", "Something went wrong!", "error");
            $('#login-btn').text('Sign In'); //change button text
            $('#login-btn').attr('disabled',false); //set button enable
            $('#login-btn').css({'background-color': "#3C8DBC"});
            $('#login-btn').css({'color': "#fff"});
        }
      });
    }
  }
</script>
</body>
</html>
