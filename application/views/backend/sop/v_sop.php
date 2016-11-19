  <!-- summernote -->
  <link rel="stylesheet" href="<?=base_URL('assets/backend/lib/summernote/summernote.css')?>">
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
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">CK Editor
                <small>Advanced and full of features</small>
              </h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
              <form>
                <textarea id="editor" name="detail_sop" rows="18"></textarea>                
              </form>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>
  <script src="<?=base_URL('assets/backend/lib/summernote/summernote.min.js')?>"></script>
  <script type="text/javascript">
  $(document).ready(function() {
  var $summernote = $('#editor').summernote({
        height: 300,
        callbacks: {
            onImageUpload: function (files) {
                sendFile($summernote, files[0]);
            }
        }
    });    
  });
  function sendFile($summernote, file) {
    var formData = new FormData();
    formData.append("file", file);
    $.ajax({
      data: formData,
      type: "POST",
      url: '<?php echo site_url('sop/c_sop/saveuploadedfile')?>',
      cache: false,
      contentType: false,
      enctype: 'multipart/form-data',
      processData: false,
      dataType: "JSON",
      success: function(data) {
        $summernote.summernote('insertImage', data.url, function ($image) {
                $image.attr('src', data.url);
            });
      }
    });
  }
  </script>