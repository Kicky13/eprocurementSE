<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/validation/form-validation.css">

<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-1">
              <h3 class="content-header-title"><?= lang("Supplier Management", "Supplier Management") ?></h3>
          </div>
          <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
              <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="<?= base_url() ?>vn/info/greetings">Home</a></li>
                      <li class="breadcrumb-item active"><?= lang("Supplier Management", "Supplier Management") ?></li>
                      <li class="breadcrumb-item active"><?= lang("Supplier Account", "Supplier Account") ?></li>
                  </ol>
              </div>
          </div>
      </div>
      <div class="content-body">
        <div class="col-xl-12 col-md-12 col-12">
            <div class="card profile-card-with-cover">
              <!--<img class="card-img-top img-fluid" src="../../../app-assets/images/carousel/18.jpg" alt="Card cover image">-->
              <div class="card-img-top img-fluid bg-cover height-200" style="background: url('<?= base_url('ast11/app-assets/images/backgrounds/bg-2.jpg')?>');" style="height:60px;width:60px;" alt="x1"></div>
              <div class="card-profile-image">
              </div>
              <div class="profile-card-with-cover-content text-center">
                <div class="card-body">
                  <h4 class="card-title"><?php if ($data_vendor->NAMA != ""){ echo strtoupper($data_vendor->NAMA); } else { echo "-"; } ?></h4>
                  <ul class="list-inline clearfix mt-2">
                    <li class="mr-3">
                      <h5 class="block"><b>Email</b> </h5><?php if ($data_vendor->ID_VENDOR != ""){ echo strtolower($data_vendor->ID_VENDOR); } else { echo "-"; } ?>
                    </li>
                    <li class="mr-3">
                      <h5 class="block"><b>Classification</b> </h5><?php if ($data_vendor->CLASSIFICATION != ""){ echo strtoupper($data_vendor->CLASSIFICATION); } else { echo "-"; } ?></li>
                    <li class="mr-3">
                      <h5 class="block"><b>Qualification</b> </h5><?php if ($data_vendor->CUALIFICATION != ""){ echo strtoupper($data_vendor->CUALIFICATION); } else { echo "-"; } ?>
                    </li>
                    <li class="mr-3">
                      <h5 class="block"><b>Company Type</b> </h5><?php if ($data_vendor->PREFIX != ""){ echo strtoupper($data_vendor->PREFIX); } else { echo "-"; } ?>
                    </li>

                  </ul>
                  <ul class="list-inline clearfix mt-2">
                    <li class="mr-3">
                      <h5 class="block"><b>Company Sub Type</b> </h5><?php if ($data_vendor->SUFFIX != ""){ echo strtoupper($data_vendor->SUFFIX); } else { echo "-"; } ?>
                    </li>
                    <li class="mr-3">
                      <h5 class="block"><b>SLKA</b> </h5><?php if ($data_vendor->NO_SLKA != ""){ echo strtoupper($data_vendor->NO_SLKA); } else { echo "-"; } ?>
                    </li>
                    <li class="mr-3">
                      <h5 class="block"><b>JDE No</b> </h5><?php if ($data_vendor->ID_EXTERNAL != ""){ echo strtoupper($data_vendor->ID_EXTERNAL); } else { echo "-"; } ?>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <button class="btn btn-social btn-min-width mr-1 mb-1 btn-facebook" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit"></i> Update</button>
                </div>
              </div>
            </div>
          </div>

      </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade text-left" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel9" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary white">
        <h4 class="modal-title" id="myModalLabel9"><i class="fa fa-user"></i> Update Account</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="update_account" action="#">
      <div class="modal-body">
        <div class="form-group">
            <label class="form-label"><?= lang('Email', 'Email') ?></label>
            <div class="controls">
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label"><?= lang('Password', 'Password') ?></label>
            <div class="controls">
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label"><?= lang('Retype Password', 'Retype Password') ?></label>
            <div class="controls">
                <input type="password" name="re_password" id="re_password" class="form-control" required>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/js/scripts/forms/validation/form-validation.js"type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('show.bs.modal', '#myModal', function(e) {
      $('form :input').prop('disabled', false);
      $('.btn').prop('disabled', false);
      $.ajax({
        url: '<?= base_url('vn/info/supplier_account/get_supplier_account') ?>',
        type: 'POST',
        dataType: 'JSON',
        data: {param: '' },
      })
      .done(function() {
        console.log("success");
      })
      .fail(function() {
        console.log("error");
      })
      .always(function(resx) {
        $("#email").val(resx.ID_VENDOR);
      });

    })

    $(".update_account").submit(function(e){
      e.preventDefault();
      var resultx;
      $.ajax({
        url: '<?= base_url('vn/info/supplier_account/update') ?>',
        type: 'POST',
        dataType: 'JSON',
        data: $(this).serialize(),
      })
      .done(function() {
        resultx = true;
      })
      .fail(function() {
        resultx = false;
      })
      .always(function(res) {
        if (resultx == true) {
          if (res.success == true && res.password == true) {
            swal({
              title: "Success",
              text: "Data is updated",
              type: "success",
              showCancelButton: false,
              confirmButtonColor: "#3085d6",
              confirmButtonText: "OK",
              closeOnConfirm: true
            },function () {
              window.location.href = '<?= base_url('vn/info/supplier_account') ?>';
            })
          } else {
            msg_danger("Oops", "Retype password is not match");
          }
        } else {
          // window.location.href = '<?= base_url('vn/info/supplier_account') ?>';
          msg_danger("Oops", "Retype password is not match");
        }
      });

    })
  });
</script>
