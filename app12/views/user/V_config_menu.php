<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Konfigurasi Menu", "Configuration Menu") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Manajemen Pengguna", "User Management") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Konfigurasi Menu", "Configuration Menu") ?></li>
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
                                                <!-- <button aria-expanded="false" onclick="add()" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "Add") ?></button>  -->
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
                                                      <th><center>Menu</center></th>
                                                      <th><center>Patch</center></th>
                                                      <th><center>Aksi</center></th>
                                                  </tr>
                                              </tfoot>
                                            </table>
                                            <!--<label class="form-group" style="font-weight:300" id="info">Showing 1 to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label>-->
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
<div class="modal fade" id="modal"  tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" action="javascript:;" class="modal-content" novalidate="novalidate">
          <input type="hidden" name="idmenu" id="idmenu" value="">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="formfield1"><?= lang('Dekripsi Menu (IND)', 'Menu Description (IND)') ?></label>
                    <div class="controls">
                        <input type="text" name="desc_ind" id="desc_ind" value="" class="form-control" required data-validation-required-message="This field is required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield1"><?= lang('Dekripsi Menu (ENG)', 'Menu Description (ENG)') ?></label>
                    <div class="controls">
                        <input type="text" name="desc_eng" id="desc_eng" value="" class="form-control" required data-validation-required-message="This field is required">
                    </div>
                </div>
                <hr>

                <hr>
                <div id="show_menu_form">
                    <div class="form-group">
                        <label class="form-label" for="formfield2">Icon</label>
                        <div class="controls">
                          <!-- <label class="d-inline-block custom-control custom-radio">
                              <input type="radio" name="icon" id="icon-menu" class="custom-control-input" value="-">
                              <span class="custom-control-indicator"></span>
                              <span class="custom-control-description fa fa-times-circle"></span>
                          </label> -->
                            <?php
                            foreach ($icone as $k => $v) {
                                ?>
                                <label class="d-inline-block custom-control custom-radio">
                                    <input type="radio" name="icon" id="icon-menu-<?= $v->ICON ?>" class="custom-control-input" value="<?= $v->ICON ?>">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description fa <?= $v->ICON ?>"></span>
                                </label>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                <button type="submit" class="btn btn-success" id="save"><?= lang('Simpan', 'Save') ?></button>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/js/scripts/forms/validation/form-validation.js"type="text/javascript"></script>
<script type="text/javascript">
    $('#show_submenu_form').hide();
    $(function () {
        $(".touchspin").TouchSpin({
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            buttondown_txt: '<i class="ft-minus"></i>',
            buttonup_txt: '<i class="ft-plus"></i>'
        });

        $('#Modal-detail').on('shown.bs.modal', function () {
            $('#table-detail').DataTable().columns.adjust().draw();
        });

        $('#tbl tfoot th').each( function (i) {
          var title = $('#tbl thead th').eq( $(this).index() ).text();
          $(this).html( '<input type="text" placeholder="Search" data-index="'+i+'" />' );
        });
        var table = $('#tbl').DataTable({
            ajax: {
                url: '<?= base_url('users/config_menu/show') ?>',
                dataSrc: '',
            },
            scrollX: true,
            scrollY: '300px',
            scrollCollapse: true,
            paging: true,
            filter: true,
            info:true,
            columns: [
                {title: "<center>No</center>"},
                {title: "<center>Menu<center>"},
                {title: "<center>Patch<center>"},
                {title: "<center><?= lang("Aksi", "Action") ?></center>"}
            ],
            "columnDefs": [
                {"className": "dt-right", "targets": [0]},
                {"className": "dt-right", "targets": [1]},
                {"className": "dt-right", "targets": [2]},
                {"className": "dt-center", "targets": [3]}
            ]
        });
        $(table.table().container() ).on( 'keyup', 'tfoot input', function () {
                table.column( $(this).data('index') )
                .search( this.value )
                .draw();
        });
        lang();

        $('#form').on('submit', function (e) {
            var elm = start($('.modal').find('.modal-dialog'));
            $.ajax({
                url: "<?= base_url('users/config_menu/add') ?>/",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.success = true)
                    {
                        $('#tbl').DataTable().ajax.reload();
                        $('#modal').modal('hide');
                        msg_info('Berhasil Disimpan');
                    } else {
                        msg_danger("Can't Update Menu !");
                    }
                    stop(elm);
                }
            });
        });
    });


    function add() {
        //iwan add
        document.getElementById("form").reset();
        $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
        $('#modal').modal('show');
        $('#tbl').DataTable().columns.adjust().draw();
        lang();
    }

    function sort(status, id) {
        // $('#tbl').DataTable().ajax.reload();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('users/config_menu/sort/') ?>' + id + "/" + status,
            success: function (msg) {
                $('#tbl').DataTable().ajax.reload();
                lang();
            }
        });
    }

    function edit(id) {
        document.getElementById("form").reset();
        $("input[type='radio']").attr('checked', false);
        $.ajax({
            type: 'POST',
            url: '<?= base_url('users/config_menu/get/') ?>' + id,
            success: function (msg) {
                $('.modal-title').html("<?= lang("Show Data", "Show Data") ?>");
                $('#modal').modal('show');
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $("#idmenu").val(d.ID_MENU)
                $('#desc_ind').val(d.DESKRIPSI_IND);
                $('#desc_eng').val(d.DESKRIPSI_ENG);
                $('#icon-menu-'+d.ICON).attr('checked', true);
                lang();
            }
        });
    }

</script>
