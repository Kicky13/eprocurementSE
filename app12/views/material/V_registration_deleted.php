<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<!-- <link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet"> -->
<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<!-- <link href="<?= base_url() ?>ast11/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/> -->
<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">


<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Material Ditolak & Dihapus", "Material Denied & Deleted") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Master Material", "Master Material") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Material Ditolak & Dihapus", "Material Denied & Deleted") ?></li>
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
                                                <!-- <button aria-expanded="false" onclick="add()" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "Add") ?></button> -->
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
                                                <th><center>Description Material</center></th>
                                                <th><center>Material UOM</center></th>
                                                <th><center>Status</center></th>
                                                <th><center>Action</center></th>
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

<div id="myModal" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class=" modal-content">
            <form class="form-horizontal m_registration" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                        <textarea class="form-control" id="m_desc" name="m_desc" rows="5" maxlength="500" required disabled></textarea>
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
                                        <select name="m_uom" id="optmaterial_uom" style="width: 350px !important;" required disabled>
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
                        <label class="col-md-2">Material Image</label>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-1">
                                    <a href="#" id="img_material" data-lightbox="lightbox" data-title="MATERIAL DRAWING"><img id="image_upload" src="<?= base_url() ?>ast11/img/showimg.png" alt="your image" style="height:60px;width:60px;" /></a>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="file" id="material_image" name="material_image" value="" class="form-control ff" accept="image/jpeg, image/png" required disabled/>
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
                                        <input type="file" id="material_drawing" name="material_drawing" value="" class="form-control ff" accept="image/jpeg, image/png" required disabled/>
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
                                        <input type="file" id="material_other" name="material_other" value="" class="form-control ff" accept="application/pdf, application/ms-excel, application/msword" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="material_id" name="material_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <!-- <button type="submit" onclick="" class="btn btn-info" id="save"><?= lang('Save', 'Save') ?></button> -->
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

        $("#material_image").change(function () {
            readURL(this, '#image_upload');
        });
        $("#material_drawing").change(function () {
            readURL(this, '#image_upload2');
        });
        $("#material_other").change(function () {
            readURL(this, '#image_upload3');
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

        // restore
        $(document).on('click', '#restore', function (e) {
            e.preventDefault();
            // var idnya = $(e.relatedTarget).data("id");
            var idnya = $(this).data("id");
            // alert(idnya)
            if (idnya != "") {
              swal({
                title: "Restore this data?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#0072cf',
                confirmButtonText: 'Yes, Restore it!',
                closeOnConfirm: false,
                //closeOnCancel: false
              },
              function(){
                var elm = modal_start($('.sweet-alert'));
                $.ajax({
                  url: '<?= base_url('material/Registration_deleted/restore_material') ?>',
                  type: 'post',
                  dataType: 'json',
                  data: {idnya: idnya},
                  success: function(res){
                    window.location.href = "<?= base_url() ?>/material/registration_deleted";
                  }
                });

              });
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
                                  $("#image_upload_location").attr('href', '#')
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


        })


        lang();
        $('#tbl tfoot th').each(function (i) {
            var title = $('#tbl thead th').eq($(this).index()).text();
            if ($(this).text() == 'No') {
              $(this).html('');
            } else if ($(this).text() == 'Action') {
              $(this).html('');
            } else {
              $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
            }
        });
        var table = $('#tbl').DataTable({
            "ajax": {
                "url": "<?= base_url('material/Registration_deleted/datatable_regsitrasi_material') ?>",
                "dataSrc": ""
            },
            "paging": true,
            "columns": [
                {title: "<center>No</center>"},
                {title: "<center>Description Material</center>"},
                {title: "<center>Material UOM</center>"},
                {title: "<center>Status</center>"},
                {title: "<center>Action</center>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]}
            ]
        });
        $(table.table().container()).on('keyup', 'tfoot input', function () {
            table.column($(this).data('index'))
                    .search(this.value)
                    .draw();
        });
    });



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







</script>
