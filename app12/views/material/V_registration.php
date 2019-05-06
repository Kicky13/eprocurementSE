<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<!-- <link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet"> -->
<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">


<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Registrasi Material", "Material Registrasi") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Master Material", "Master Material") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Registrasi Material", "Material Registrasi") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-header">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <div class="heading-elements">
                                            <h5 class="title pull-right">
                                                <!--<button aria-expanded="false" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></button>-->
                                                <button aria-expanded="false" onclick="add()" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "Add") ?></button>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                                <tfoot>
                                                    <tr>
                                                <th><center>No</center></th>
                                                <th><center>Req No</center></th>
                                                <th><center>Description Material</center></th>
                                                <th><center>Material UOM</center></th>
                                                <th><center>Status</center></th>
                                                <th><center><?= lang("Aksi", "Action") ?></center></th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                            <!-- <label class="form-group" style="font-weight:300" id="info">Showing 1 to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!--change data-->

<div id="modal-filter" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class=" modal-content">
            <form id="form" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-filter"></h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label col-md-6" for="field-1">Material Name</label>
                                <label class="form-label col-md-6" for="field-1"><?= lang("Description", "Description") ?></label>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_matr" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_desc" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <label class="form-label col-md-6" for="field-1"><?= lang("UOM", "Long Description") ?></label>
                                <label class="form-label col-md-6" for="field-1">Model/Type</label>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_long" multiple data-role="tagsinput">
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_group" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <label class="form-label col-md-6" for="field-1"><?= lang("Equipment GrupID", "Material Group") ?></label>
                                <label class="form-label col-md-6" for="field-1"><?= lang("EquipmentNo", "Material Type") ?></label>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_type" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_uom" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <label class="form-label col-md-6" for="field-1"><?= lang("Manufacturer", "Material Type") ?></label>
                                <label class="form-label col-md-6" for="field-1">Part No</label>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_type" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_uom" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <label class="form-label col-md-6" for="field-1"><?= lang("Sequence Grup", "Material Type") ?></label>
                                <label class="form-label col-md-6" for="field-1">Indicator Materials</label>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_type" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_uom" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <label class="form-label col-md-12" for="field-1"><?= lang("Batas Data", "Limit Data") ?></label>
                                <div class="col-md-12 m-b">
                                    <div class="input-group">
                                        <input class="touchspin3" type="text" value="10" id="limit" name="demo3">
                                        <span class="input-group-addon" id="total"></span>
                                    </div>
                                </div>
                                <label class="form-label col-md-12" for="field-1">Status</label>
                                <div class="col-md-12">
                                    <div class="i-checks col-md-6">
                                        <label><input type="checkbox" value="aktif" id="status1"> <i></i> <?= lang("Aktif", "Active") ?> </label>
                                    </div>
                                    <div class="i-checks col-md-6">
                                        <label><input type="checkbox" value="tidak" id="status2"> <i></i> <?= lang("Tidak Aktif", "NotActive") ?> </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"><?= lang('Tutup', 'Close') ?></button>
                    <button type="button" onclick="get()" class="btn btn-info" id="save"><?= lang('Filter', 'Filter') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="myModal" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class=" modal-content">
            <form class="form-horizontal m_registration" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1"></h4>
                    <button type="button" class="close closemyModal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-md-2">Material Description</label>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control" id="m_desc" name="m_desc" rows="5" maxlength="500" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2">Material UOM</label>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <div class="controls">
                                        <select name="m_uom" id="optmaterial_uom" style="width: 350px !important;" required>
                                            <?php foreach ($material_uom as $arr) { ?>
                                                <option value="<?= $arr['material_uom']; ?>"><?= $arr['material_uom']; ?></option>
                                            <?php } ?>
                                        </select>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <div class="form-group row">
                  <label class="col-md-2">User Requestor</label>
                  <div class="col-md-10">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" id="user_requestor" name="user_requestor" value="" class="form-control ff" disabled/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-2">Departement Requestor</label>
                  <div class="col-md-10">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" id="department_requestor" name="department_requestor" value="" class="form-control ff" disabled/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                    <div class="form-group row">
                        <label class="col-md-2">Material Image</label>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-1">
                                    <a href="#" id="img_material" data-lightbox="lightbox" data-title="MATERIAL DRAWING"><img id="image_upload" src="<?= base_url() ?>ast11/img/showimg.png" alt="your image" style="height:60px;width:60px;" /></a>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="file" id="material_image" name="material_image" value="" class="form-control ff" accept="image/jpeg, image/png" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2">Material Drawing</label>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-1">
                                    <a href="#" id="img_mdrawing" data-lightbox="lightbox" data-title="MATERIAL DRAWING"><img id="image_upload2" src="<?= base_url() ?>ast11/img/showimg.png" alt="your image" style="height:60px;width:60px;" /></a>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="file" id="material_drawing" name="material_drawing" value="" class="form-control ff" accept="image/jpeg, image/png" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2">Other</label>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-1">
                                    <a href="#" id="image_upload_location"><img id="image_upload3" src="<?= base_url() ?>ast11/img/showimg.png" alt="other file" style="height:60px;width:60px;" /></a>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="file" id="material_other" name="material_other" value="" class="form-control ff" accept="application/pdf, application/ms-excel, application/msword"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="material_id" name="material_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default closemyModal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="submit" onclick="" class="btn btn-info" id="save"><?= lang('Save', 'Save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<script src="<?= base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

      $(document).on('click', '.closemyModal', function(e) {
        swal({
          title: "Are you sure?",
          text: "You will close this form, you inserted data might be remove!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#0072cf',
          confirmButtonText: 'Oke',
          closeOnConfirm: true,
          closeOnCancel: true
        },
        function(){
          $("#myModal").modal("hide");
        });
      });

      //select2
      if ($.isFunction($.fn.select2)) {
        $("#optmaterial_uom").select2({
            placeholder: 'select',
            required : true,
            allowClear: true
        }).on('select2-open', function() {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
            // $('#tbl').DataTable().ajax.reload();
        });
      }

      function readURL(input, idorclass) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(idorclass).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
          }
        }

        // validasi file_uploads
        $("#material_image").change(function () {
          var fileExtension = ['jpeg', 'jpg', 'png'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
              msg_danger("Format allowed : "+fileExtension.join(', '));
              // alert("Format allowed : "+fileExtension.join(', '));
              $(this).val("")
            } else {
              readURL(this, '#image_upload');
            }
        });

        $("#material_drawing").change(function () {
          var fileExtension = ['jpeg', 'jpg', 'png'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
              msg_danger("Format allowed : "+fileExtension.join(', '));
              // alert("Format allowed : "+fileExtension.join(', '));
              $(this).val("")
            } else {
              readURL(this, '#image_upload2');
            }
        });

        $("#material_other").change(function () {
          var fileExtension = ['jpeg', 'jpg', 'png', 'pdf', 'docx', 'xlsx', 'doc'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
              msg_danger("Format allowed : "+fileExtension.join(', '));
              // alert("Format allowed : "+fileExtension.join(', '));
              $(this).val("")
            } else {
              readURL(this, '#image_upload3');
            }
        });

        // CKEDITOR.replace("m_desc");
        // ajax_loader();
        CKEDITOR.replace('m_desc', {
            toolbar: [
                {name: 'document', items: ['-', 'NewPage', 'Preview', '-', 'Templates', 'Bold', 'Italic']}, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
                ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
            ]
        });

        // $('#myModal').modal('show');
        $(".touchspin3").TouchSpin({
            verticalbuttons: true,
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // delete
        $(document).on('click', '#delete', function (e) {
            e.preventDefault();
            // var idnya = $(e.relatedTarget).data("id");
            var idnya = $(this).data("id");
            // alert(idnya)
            if (idnya != "") {
              swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#0072cf',
                confirmButtonText: 'Yes, Delete it!',
                closeOnConfirm: false,
                //closeOnCancel: false
              },
              function(){
                var elm = modal_start($('.sweet-alert'));
                $.ajax({
                  url: '<?= base_url('material/Registration/delete_material') ?>',
                  type: 'post',
                  dataType: 'json',
                  data: {idnya: idnya},
                  success: function(res){
                    window.location.href = "<?= base_url() ?>/material/registration";
                  }
                });

              });
            }
        });

        // $('select').select2();


        $('.m_registration').submit(function (e) {
            e.preventDefault();
            var data = new FormData(this);
            data.append('m_desc', CKEDITOR.instances['m_desc'].getData());
            var material_other = $("#material_other").val();
            // alert(material_other)
            var material_id = $("#material_id").val();

            var messageLength = CKEDITOR.instances['m_desc'].getData().replace(/<[^>]*>/gi, '').length;
            if( !messageLength ) {
              msg_danger("Description Cannot be empty!")
            } else {
              if (document.getElementById("material_image").files.length == 0 || document.getElementById("material_drawing").files.length == 0) {
                  var xmodalx = modal_start($("#myModal").find(".modal-content"));
                  save_material(data);
                  // modal_stop(xmodalx);
              } else {
                  if (fileSize("#material_image") > 1048576) {
                      alert("Ukuran material image harus kurang dari 1mb")
                  } else if (fileSize("#material_drawing") > 1048576) {
                      alert("Ukuran material drawing harus kurang dari 1mb")
                  } else if (material_other != "") {
                      if (fileSize("#material_other") > 1048576) {
                          alert("Ukuran material file harus kurang dari 1mb")
                      } else {
                          var xmodalx = modal_start($("#myModal").find(".modal-content"));
                          save_material(data);
                          // modal_stop(xmodalx);
                      }
                  } else {
                      var xmodalx = modal_start($("#myModal").find(".modal-content"));
                      save_material(data);
                      // modal_stop(xmodalx);
                  }
              }
            }

        });

        $("#myModal").on('shown.bs.modal', function (e) {
            var xmodalx = modal_start($("#myModal").find(".modal-content"));
            var idnya = $(e.relatedTarget).data("id");
            $("#image_upload").attr('src', '<?= base_url() ?>ast11/img/showimg.png')
            $("#image_upload2").attr('src', '<?= base_url() ?>ast11/img/showimg.png')
            $("#image_upload3").attr('src', '<?= base_url() ?>ast11/img/showimg.png')
            $("#img_material").attr('href', '<?= base_url() ?>ast11/img/showimg.png');
            $("#img_mdrawing").attr('href', '<?= base_url() ?>ast11/img/showimg.png');
            $("#material_id").val("")
            $("#material_image").prop('required', true);
            $("#material_drawing").prop('required', true);
            $("#image_upload_location").attr('href', '#')
            $("#optmaterial_uom").select2('val', '0');
            // alert(idnya)
            if (idnya != "") {
                $.ajax({
                    url: '<?= base_url('material/Registration_catalog/get_data_requestor') ?>',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        idnya: idnya
                    },
                    success: function (res) {
                        // var res = res.replace("[", "");
                        // var res = res.replace("]", "");
                        // var sel = JSON.parse(res);
                        modal_stop(xmodalx);
                        $.each(res, function (index, el) {
                            // console.log(el.uom);
                            var content = CKEDITOR.instances['m_desc'].setData(el.description);
                            $("#material_id").val(idnya)
                            $("#material").val(el.material)
                            $('#optmaterial_uom').val(el.uom).select2();
                            $('#user_requestor').val(el.data2.NAME);
                            $('#department_requestor').val(el.data2.DEPARTMENT_DESC);
                            // $("#optmaterial_uom").val(el.uom);

                            $("#image_upload").attr('src', '<?= base_url(); ?>upload/MATERIAL/img/small/small_' + el.img1_url)
                            $("#image_upload2").attr('src', '<?= base_url(); ?>upload/MATERIAL/img/small/small_' + el.img2_url)
                            $("#img_material").attr('href', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.img1_url);
                            $("#img_mdrawing").attr('href', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.img2_url);
                            $("#material_image").prop('required', false);
                            $("#material_drawing").prop('required', false);

                            if (el.file_url == "" || el.file_url == "-") {

                            } else {
                              var formatid = el.file_url.split(".").pop();
                              if (formatid == 'jpg' || formatid == 'png' || formatid == 'gif') {
                                  $("#image_upload3").attr('src', '<?= base_url(); ?>upload/MATERIAL/files/' + el.file_url)
                                  $("#image_upload_location").attr('href', '<?= base_url(); ?>upload/MATERIAL/files/' + el.file_url)
                                  $("#image_upload_location").attr('data-lightbox', 'lightbox')
                                  // data-lightbox="lightbox" data-title="MATERIAL DRAWING"
                              } else {
                                  $("#image_upload3").attr('src', '<?= base_url() ?>ast11/img/document-file-icon.png')
                                  $("#image_upload_location").attr('href', '<?= base_url(); ?>upload/MATERIAL/files/' + el.file_url)
                              }
                            }
                            // $("#material_other").val(el.file_url)

                        });
                    }
                })
            }

            $('#form').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('material/registration/change') ?>',
                    data: $('#form').serialize(),
                    success: function (m) {
                        if (m == 'sukses') {
                            $('#modal').modal('hide');
                            $('#tbl').DataTable().ajax.reload();
                            msg_info('Save successfuly');
                        } else {
                            msg_danger('Oops, Something Wrong!');
                        }
                    }
                });
            });
        })


        lang();
        $('#tbl tfoot th').each(function (i) {
            var title = $('#tbl thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" data-index="' + i + '" />');
        });
        var table = $('#tbl').DataTable({
            "ajax": {
                "url": "<?= base_url('material/Registration/datatable_regsitrasi_material') ?>",
                "dataSrc": ""
            },
            "paging": true,
            "columns": [
                {title: "<center>No</center>"},
                {title: "<center>Request No</center>"},
                {title: "<center>Description Material</center>"},
                {title: "<center>Material UOM</center>"},
                {title: "<center>Status</center>"},
                {title: "<center><?= lang("Aksi", "Action") ?></center>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
            ]
        });
        $(table.table().container()).on('keyup', 'tfoot input', function () {
            table.column($(this).data('index'))
                    .search(this.value)
                    .draw();
        });
    });

    function filter() {
        $('.modal-filter').html("<?= lang("Filter Data", "Filter Data") ?>");
        $('#total').text("dari " + "<?= (isset($total) != false ? $total : '0') ?>" + " Data");
        $('#modal-filter .modal-header').css('background-color', "#23c6c8");
        $('#modal-filter .modal-header').css('color', "#fff");
        $('#modal-filter').modal('show');
        lang();
    }
    function reject() {
        swal({
            title: "Are you sure?",
            text: "Data cannot be recover",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            closeOnConfirm: false
        }, function () {

        });
    }


    function add() {
        document.getElementById("form").reset();
        var content = CKEDITOR.instances['m_desc'].setData("");
        $('.modal-title').html("<?= lang("Formulir Pendaftaran", "Form Registration Material") ?>");
        $('#myModal .modal-header').css('background-color', "#1c84c6");
        $('#myModal .modal-header').css('color', "#fff");
        $('#myModal').modal('show');
        $('#id').val("");
        // document.getElementById("aktif").checked = true;
        lang();
    }

    function aktif_form() {
        document.getElementById("material_type").disabled = false;
    }

    function aktif_form2() {
        document.getElementById("material_uom").disabled = false;
    }

    function aktif_form3() {
        document.getElementById("mat_name").disabled = false;
        document.getElementById("desc").disabled = false;
        document.getElementById("als").disabled = false;
        document.getElementById("part_no").disabled = false;
        document.getElementById("model").disabled = false;
        document.getElementById("img_product").disabled = false;
        document.getElementById("img_drawing").disabled = false;
        $("#btnSave").attr("disabled", false);
    }



    function save_material(data) {
        $.ajax({
            url: '<?= base_url('material/Registration/save_material_requestor') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (res) {
                $.each(res, function (index, el) {
                    if (el.success === true) {
                        swal({
                            title: "Done",
                            text: "Data is successfuly saved.",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Oke",
                            closeOnConfirm: false
                        }, function () {
                            window.location.href = "<?= base_url() ?>/material/registration";
                        });
                    }
                });
            }
        })
    }


</script>
