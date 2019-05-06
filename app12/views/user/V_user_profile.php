<link rel="stylesheet" type="text/css" href="<?= base_url()?>ast11/app-assets/vendors/css/extensions/unslider.css">
  <!-- END VENDOR CSS-->
  <!-- BEGIN STACK CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>ast11/app-assets/css/app.css">
  <!-- END STACK CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>ast11/app-assets/css/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>ast11/app-assets/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url()?>ast11/app-assets/css/pages/users.css">

<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-1">
              <h3 class="content-header-title"><?= lang("Profil User", "User Profile") ?></h3>
          </div>
          <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
              <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                      <li class="breadcrumb-item active"><?= lang("Managemen Pengguna", "Management User") ?></li>
                      <li class="breadcrumb-item active"><?= lang("Profil User", "User Profile") ?></li>
                  </ol>
              </div>
          </div>
      </div>
        <div class="content-body">
          <div class="col-xl-12 col-md-12 col-12">
              <div class="card profile-card-with-cover">
                <div class="card-content">
                  <!--<img class="card-img-top img-fluid" src="../../../app-assets/images/carousel/18.jpg" alt="Card cover image">-->
                  <div class="card-img-top img-fluid bg-cover height-200" style="background: url('<?= base_url('ast11/app-assets/images/backgrounds/bg-2.jpg')?>') 0 30%;"></div>
                  <div class="card-profile-image">
                    <a data-lightbox="lightbox" data-title="PROFILE IMAGE" href="<?php if ($data_user->IMG != ""){ echo base_url('upload/').$data_user->IMG; } else { echo base_url('ast11/app-assets/images/portrait/small/user-2517433_960_720.png'); } ?>" style="height:60px;width:60px;" alt="x1">
                      <img src="<?php if ($data_user->IMG != ""){ echo base_url('upload/').$data_user->IMG; } else { echo base_url('ast11/app-assets/images/portrait/small/user-2517433_960_720.png'); } ?>" class="rounded-circle img-border box-shadow-1" alt="Card image" style="width:121px; height:123px;">
                    </a>
                  </div>
                  <div class="profile-card-with-cover-content text-center">
                    <div class="profile-details mt-2">

                      <h4 class="card-title"><?php if ($data_user->NAME != ""){ echo strtolower($data_user->NAME); } else { echo "-"; } ?></h4>
                      <ul class="list-inline clearfix mt-2">
                        <li class="mr-3">
                          <h5 class="block">Email </h5><?php if ($data_user->EMAIL != ""){ echo strtolower($data_user->EMAIL); } else { echo "-"; } ?></li>
                        <li class="mr-3">
                          <h5 class="block">Username </h5><?php if ($data_user->USERNAME != ""){ echo strtolower($data_user->USERNAME); } else { echo "-"; } ?></li>
                        <li class="mr-3">
                          <h5 class="block"><?= lang('Telepon', 'Telephone') ?> </h5><?php if ($data_user->CONTACT != ""){ echo strtolower($data_user->CONTACT); } else { echo "-"; } ?></li>
                        <li class="mr-3">
                          <h5 class="block"><?= lang('Perusahaan', 'Company') ?> </h5> <p id="company_name"></p></li>
                      </ul>
                      <!-- <ul class="list-inline clearfix mt-2">
                        <li class="mr-12">
                          <h5 class="block"><?= lang('Perusahaan', 'Company') ?> </h5> <h5 id="company_name"></h5></li>
                      </ul> -->
                    </div>
                    <div class="card-body">
                      <button onclick="update(<?= $this->session->userdata['ID_USER']; ?>)" class="btn btn-social btn-min-width mr-1 mb-1 btn-facebook"><i class="fa fa-edit"></i> <span class="pl-1">EDIT</span></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<!--change data-->
<div class="modal fade" id="modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form">
                <!--hide value-->
                <input name="id" id="id" type="hidden">
                <input name="status" id="status" type="hidden">
                <!--end hide value-->
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label"><?= lang('Nama', 'Name') ?></label>
                        <div class="controls">
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('Username', 'Username') ?></label>
                        <div class="controls">
                            <input type="text" name="username" id="username" class="form-control" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('Password', 'Password') ?></label>
                        <div class="controls">
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('Email', 'Email') ?></label>
                        <div class="controls">
                            <input type="text" name="email" id="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('Perusahaan', 'Company') ?></label>
                        <div class="controls">
                            <select id="company" name="company[]" class="select2 form-control" multiple="multiple" style="width: 100%" required data-validation-required-message="This field is required">
                            <!-- <select id="company"  name="company[]" class="form-control" multiple="multiple" required="true"> -->
                                <!-- <option value=""></option> -->
                                <?php
                                $company = $this->db->get("m_company where STATUS = '1'");
                                foreach ($company->result() as $value) {
                                    ?>
                                    <option value="<?php echo $value->ID_COMPANY; ?>"><?php echo $value->DESCRIPTION; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('Departemen', 'Departement') ?></label>
                        <div class="controls">
                            <select id="departement" name="departement[]" class="select2 form-control" style="width: 100%" required data-validation-required-message="This field is required">
                                <!-- <?php
                                $departement = $this->db->get("m_departement where STATUS = '0'");
                                foreach ($departement->result() as $value) {
                                    ?>
                                    <option value="<?php echo $value->ID_DEPARTMENT; ?>"><?php echo $value->DEPARTMENT_DESC; ?></option>
                                <?php } ?> -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('Cost Center', 'Cost Center') ?></label>
                        <div class="input-group">
                            <select id="cost_center" name="cost_center" class="select2 form-control" style="width: 100%" required data-validation-required-message="This field is required">
                                <!-- <option value=""></option> -->
                                <?php
                                // ambil data dari database
                                $cost_center = $this->db->get("m_costcenter where STATUS = '0'");
                                foreach ($cost_center->result() as $value) {
                                    ?>
                                    <option value="<?php echo $value->ID_COSTCENTER; ?>"><?php echo $value->COSTCENTER_ABR." - ".$value->COSTCENTER_DESC; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="input-group-btn">

                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('Telepon', 'Telephone') ?></label>
                        <div class="controls">
                            <input type="text" name="contact" id="contact" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('Roles', 'Roles') ?></label>
                        <div class="input-group">
                            <select id="roles" name="roles[]" class="select2 form-control" multiple="multiple" style="width: 100%" required data-validation-required-message="This field is required">
                                <!-- <option value=""></option> -->
                                <?php
                                // ambil data dari database
                                $roles = $this->db->get("m_user_roles where STATUS = '1'");
                                foreach ($roles->result() as $value) {
                                    ?>
                                    <option value="<?php echo $value->ID_USER_ROLES; ?>"><?php echo $value->DESCRIPTION; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="input-group-btn">
                                <!-- <button data-toggle="modal" onclick="//show_roles()" id="add" class="btn btn-primary"><i class="fa fa-list-ol"></i> <?= lang("Lihat", "View") ?></button> -->
                            </span>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="form-label"><?= lang('Gambar Profil', 'Image Profile')?></label>
                        <div class="row">
                          <div class="col-md-2">
                            <a href="#" data-title="IMAGE PROFILE"><img id="images_profile" src="<?= base_url()?>ast11/img/showimg.png" alt="other file" style="height:50px;width:70px;" /></a>
                          </div>
                          <div class="col-md-10">
                            <input type="file" id="img_profile" name="img_profile" value="" class="form-control ff" accept="image/jpeg, image/png"/>
                          </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="submit" class="btn btn-primary" id="save"><?= lang('Simpan', 'Save') ?></button>
                </div>
            </form>

        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/forms/selects/select2.min.css">
<script src="<?php echo base_url() ?>ast11/app-assets/vendors/js/forms/select/select2.full.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
    $('#form').on('submit', function (e) {
    $("select").prop("disabled", false);
        e.preventDefault();
        var xmodalx = modal_start($("#modal").find(".modal-content"));
        var data = new FormData(this);
        $.ajax({
            type: 'POST',
            url: '<?= base_url('users/view_user/change') ?>',
            //data: $('#form').serialize(),
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (m) {
              modal_stop(xmodalx);
                if (m == 'sukses') {
                    msg_info('Sukses tersimpan');
                    setTimeout(function(){ window.location.href = "<?= base_url('users/user_profile')?>"; }, 100)
                } else {
                    msg_danger(m);
                }
            }
        });
    });


    $('#roles_form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            success: function (m) {
                $('#roles_modal').modal('hide');
                $('#modal').modal('show');
                oTable.api().ajax.reload()
                $('#tbl_roles').DataTable().ajax.reload();
            }
        });
    });
    lang();

    $('#company').on("change", function(e) {
      // alert("no")
      var valuex = $(this).val();
      var arr = [];
      // console.log();
      $.each(valuex, function(index, el) {
        console.log(el);
        arr.push(el);
      });
      var result;
      $.ajax({
        url: '<?= base_url('users/view_user/get_departement') ?>',
        type: 'POST',
        dataType: 'html',
        data: {id_comp: arr}
      })
      .done(function() {
        result = true;
      })
      .fail(function() {
        result = false;
      })
      .always(function(res) {
        $("#departement").html(res);
        console.log("TAMBAH : "+arr);
      });
    });
});

function readURL(input, idorclass) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $(idorclass).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

$("#img_profile").change(function() {
    var fileExtension = ['jpeg', 'jpg', 'png'];
      if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
        msg_danger("Format yang diizinkan hanya : "+fileExtension.join(', '));
        // alert("Format yang diizinkan hanya : "+fileExtension.join(', '));
        $(this).val("")
      } else {
        readURL(this, '#images_profile');
      }
  });

$("#company").select2({
    placeholder: "Please Select"
});
$("#departement").select2({
    placeholder: "Please Select"
});
$("#roles").select2({
    placeholder: "Please Select"
});
$("#cost_center").select2({
    placeholder: "Please Select"
});



function show_roles() {
    $('.modal-title').html("<?= lang("Lihat Roles", "View Roles") ?>");
    $('#modal').modal('hide');
    $('#roles_modal').modal('show');
    $('#tbl').DataTable().ajax.reload();
    lang();
}

function update(id) {
    document.getElementById("form").reset();
    $.ajax({
        type: 'POST',
        url: '<?= base_url('users/view_user/get/') ?>' + id,
        success: function (msg) {
            $('.modal-title').html("<?= lang("Perbarui Data", "Update Data") ?>");
            var msg = msg.replace("[", "");
            var msg = msg.replace("]", "");
            var d = JSON.parse(msg);
            console.log(d);
            $('#id').val(d.ID_USER);
            $('#name').val(d.NAME);
            $('#username').val(d.USERNAME);
            $('#email').val(d.EMAIL);
            $('#company').val(d.COMPANY.split(',')).select2();
            $('#cost_center').val(d.COST_CENTER).select2();

            // var valuex = $(this).val();
            var arr = [];
            var result;
            // console.log();
            $.each(d.COMPANY.split(','), function(index, el) {
              console.log(el);
              arr.push(el);
            });
            $.ajax({
              url: '<?= base_url('users/view_user/get_departement') ?>',
              type: 'POST',
              dataType: 'html',
              data: {id_comp: arr}
            })
            .done(function() {
              result = true;
            })
            .fail(function() {
              result = false;
            })
            .always(function(res) {
              $("#departement").html(res);
              setTimeout(function(){ $('#departement').val(d.ID_DEPARTMENT).select2(); }, 100);
              // console.log(arr);
            });

            $.ajax({
                url: '<?= base_url('users/view_user/get_costcenter') ?>',
                type: 'POST',
                dataType: 'HTML',
                data: {id_comp: arr},
                success: function(res){
                  $("#cost_center").html(res);
                  setTimeout(function(){ $('#cost_center').val(d.COST_CENTER).select2(); }, 100);
                }
              });



            // $('#company').select2('val', d.COMPANY.split(','));
            $('#contact').val(d.CONTACT);
            $('#roles').val(d.ROLES.split(',')).select2();
            $('#status').val(d.STATUS);
            if (d.IMG != "" || d.IMG == "-") {
              $("#images_profile").attr('src', '<?=base_url('upload/')?>'+d.IMG);
            } else {
              $("#images_profile").attr('src', '<?= base_url('ast11/img/showimg.png')?>');
            }
            lang();
            $('#modal').modal('show');
      $("select").prop("disabled", true);
        }
    });
}

</script>
