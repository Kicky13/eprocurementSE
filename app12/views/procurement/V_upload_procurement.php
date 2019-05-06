<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Upload Procurement", "Upload Procurement") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item">Upload Procurement</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" action="<?= base_url('procurement/upload_procurement/store') ?>" id="form-upload-procurement">
                            <div class="form-group row">
                                <label class="col-md-3">Procurement Data</label>
                                <div class="col-md-6">
                                    <input type="file" name="upload" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary" id="upload-procurement">Submit</button>
                                </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-md-12" id="result-message" style="display: none;">
                                <div class="alert alert-dismissible alert-danger">
                                  <strong id="sheet"></strong> <label id="msg"></label>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                </div>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
      $("#upload-procurement").click(function(){
        var form = $("#form-upload-procurement")[0];
        var data = new FormData(form);
        $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "<?=base_url('procurement/upload_procurement/store')?>",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          beforeSend:function(){
            start($('.card'));
          },
          success: function (data) {
            var r = eval("("+data+")");
            if(r.status)
            {
              $("#sheet").html(r.sheet)
              $("#msg").html(r.msg)
              $("#result-message").show()
              stop($('.card'));
            }
            else
            {
              swal('Done',r.msg,'success');
            }
            stop($('.card'));
          },
          error: function (e) {
            swal('Ooopss','Something went wrong!','warning')
            stop($('.card'));
          }
        });
      })
    })
</script>