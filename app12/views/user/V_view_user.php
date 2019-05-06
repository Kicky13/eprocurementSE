<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/forms/selects/select2.min.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Akses Pengguna
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="description" class="card">
                <div class="card-header">
                    <div class="form-group row">
                        <div class="col-6">
                            <h4 class="card-title"><?= lang("Lihat Pengguna", "View User") ?></h4>
                        </div>
                        <div class="col-6">
                            <div role="group" aria-label="Button group with nested dropdown" class="btn-group float-md-right">
                                <div role="group" class="btn-group">
                                    <button aria-expanded="false" onclick="add()" class="btn btn-outline-success"><i class="ft-plus-circle"></i> CREATE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="card-text">
                            <table id="tbl" class="table nowrap table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                <tfoot>
                                    <tr>
                                        <th><center>No</center></th>
                                        <th><center><?= lang('Nama', 'Name') ?></center></th>
                                        <th><center><?= lang("Username", "Username") ?></center></th>
                                        <th><center><?= lang("Email", "Email") ?></center></th>
                                        <th><center><?= lang("Perusahaan", "Company") ?></center></th>
                                        <th><center><?= lang("Kontak", "Contact") ?></center></th>
                                        <th><center><?= lang("Aktif", "Is Active") ?></center></th>
                                        <th><center>Action</center></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!--and of view roles-->
<div class="modal fade" id="roles_modal" width="200%" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <!--<form id="roles_form">-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" >
                <div class="col-lg-12">
                    <table id="tbl_roles" class="table table-striped table-bordered " width="100%"></table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn" id="save"><?= lang('Tutup', 'Close') ?></button>
            </div>
        </div>
        <!--</form>-->
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
                            <input type="text" name="username" id="username" class="form-control" required>
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
                        <label class="form-label">ID External</label>
                        <div class="input-group">
                          <input type="text" name="id_external" id="id_external" value="" class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Login with ID External</label>
                        <div class="input-group">
                            <select id="is_external" name="is_external" class="select2 form-control" style="width: 100%" required data-validation-required-message="This field is required">
                              <option value="0">Please Select .. </option>
                              <option value="0">Non Active</option>
                              <option value="1">Active</option>
                            </select>
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
                    <button type="submit" class="btn btn-primary" id="save"><?= lang('Simpan', 'Submit') ?></button>
                </div>
            </form>

        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>ast11/app-assets/vendors/js/forms/select/select2.full.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $(function () {
      $('#form').on('submit', function (e) {
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
                      $('#modal').modal('hide');
                      $('#tbl').DataTable().ajax.reload();
                      msg_info('Sukses tersimpan');
                  } else {
                      msg_danger(m);
                  }
              }
          });
      });
      $('#tbl tfoot th').each(function (i) {
        var title = $('#tbl thead th').eq($(this).index()).text();
        if ($(this).text() == 'No') {
          $(this).html('');
        } else if ($(this).text() == 'Action') {
          $(this).html('');
        } else {
          $(this).html('<input type="text" class="form-control" placeholder="Search " data-index="' + i + '" />');
        }
      });
      var table = $('#tbl').DataTable({
          ajax: {
              url: '<?= base_url('users/view_user/show') ?>',
              dataSrc: ''
          },
          scrollX: true,
          scrollY: '300px',
          scrollCollapse: true,
          paging: true,
          filter: true,
          autoWidth: false,
          fixedColumns: {
              leftColumns: 0,
              rightColumns: 1
          },
          columns: [
              {title: "<center>No</center>", "width": "20px"},
              {title: "<center><?= lang('Nama', 'Name') ?></center>"},
              {title: "<center><?= lang("Username", "Username") ?></center>"},
              {title: "<center><?= lang("Email", "Email") ?></center>"},
              {title: "<center><?= lang("Perusahaan", "Company") ?></center>", "width": "100%"},
              {title: "<center><?= lang("Telepon", "Telephone") ?></center>"},
              {title: "<center><?= lang("Aktif", "Is Active") ?></center>"},
              {title: "<center>Action</center>"}
          ],
          "columnDefs": [
              {"className": "dt-center", "targets": [0]},
              {"className": "dt-center", "targets": [1]},
              {"className": "dt-center", "targets": [2]},
              {"className": "dt-center", "targets": [3]},
              {"className": "dt-center", "targets": [4]},
              {"className": "dt-center", "targets": [5]},
              {"className": "dt-center", "targets": [6]},
              {"className": "dt-center", "targets": [7]},
          ]
      });
      $(table.table().container()).on('keyup', 'tfoot input', function () {
          table.column($(this).data('index'))
                  .search(this.value)
                  .draw();
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

        $.ajax({
          url: '<?= base_url('users/view_user/get_costcenter') ?>',
          type: 'POST',
          dataType: 'HTML',
          data: {id_comp: arr},
          success: function(res){
            $("#cost_center").html(res);
          }
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
  $("#is_external").select2({
      placeholder: "Please Select"
  });

  function show_roles() {
      $('.modal-title').html("<?= lang("Lihat Roles", "View Roles") ?>");
      $('#modal').modal('hide');
      $('#roles_modal').modal('show');
      $('#tbl').DataTable().ajax.reload();
      lang();
  }

  function add() {
      document.getElementById("form").reset();
      $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
      lang();
      $('#modal').modal('show');
      $('#id').val("");
      $('#company').val("").select2();
      $('#departement').val("").select2();
      $('#departement').find('option').remove().end();
      // $('#departement').find('option').remove().end().append('<option value="whatever">text</option>').val('whatever');
      $('#roles').val("").select2();
      $('#cost_center').val("").select2();
      $('#is_external').val("").select2();
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
              $('#is_external').val(d.is_external).select2();
              $('#id_external').val(d.id_external);

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
          }
      });
  }

  function user_delete(id, name) {
      swal({
          title: "Are you sure?",
          text: "Want to nonactive user :  \"" + name + "\" ?",
          type: "info",
          confirmButtonColor: "#d93d36",
          showCancelButton: true,
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false
      }, function (isConfirm) {
          if (!isConfirm)
              return;
          $.ajax({
              type: 'POST',
              url: '<?= base_url('users/view_user/delete/') ?>',
              data: {id_user: id},
              success: function () {
                  $('#tbl').DataTable().ajax.reload();
                  swal.close();
                  msg_info('User successfully nonactive', 'Success');
              }
          });
      });
  }

  function update_password(id, new_password) {

      swal({
          title: "Are you sure?",
          text: "Reset password :" + new_password,
          type: "info",
          confirmButtonColor: "#d93d36",
          showCancelButton: true,
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false,
      }, function (isConfirm) {
          if (isConfirm){
            var elm = start($('.sweet-alert'));
            $.ajax({
              type: 'POST',
              url: '<?= base_url('users/view_user/reset_password/') ?>',
              data: {id_user: id, password: new_password},
              success: function (m) {
                stop(elm);
                if (m == 'sukses') {
                  $('#tbl').DataTable().ajax.reload();
                  swal.close();
                  msg_info('Password successfully changed', 'Success');
                } else {
                  msg_danger(m, 'Warning');
                  swal("Password change failed", "", "failed");
                }
              },
              error: function (XMLHttpRequest, textStatus, errorThrown) {
                stop(elm);
                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                swal("Password Gagal diubah", "", "failed");
              }
            });
          }
      });
  }


</script>
