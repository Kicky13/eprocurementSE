<link href="<?= base_url() ?>ast11/app-assets/vendors/css/forms/selects/select2.min.css" rel="stylesheet" type="text/css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Struktur Organisasi", "Organizational Structure") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengaturan", "Setting") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Struktur Organisasi", "Organizational Structure") ?></li>
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
                                            </table>
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
<div class="modal fade" id="modal" data-backdrop="static" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class=" modal-content">
        <form id="form">
            <!--hide value-->
            <input name="id" id="id" hidden>
            <!--end hide value-->
            <div class="modal-header bg-primary white">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label"><?= lang('Nama', 'Name') ?></label>
                    <div class="controls">
                        <select name="name" id="name" class="select2 form-control" style="width: 100%" required>
                            <?php foreach($user as $dt) { ?>
                            <option value="<?= $dt->ID_USER ?>"><?= $dt->NAME ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang('Posisi', 'Position') ?></label>
                    <div class="controls">
                        <select name="position" id="position" class="select2 form-control" style="width: 100%" required>
                            <?php foreach($pos as $dt) { ?>
                            <option value="<?= $dt['description'] ?>"><?= $dt['description'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang('Jabatan', 'Title') ?></label>
                    <div class="controls">
                        <select name="title" id="title" class="select2 form-control" style="width: 100%" required>
                            <?php foreach($title as $dt) { ?>
                            <option value="<?= $dt['description'] ?>"><?= $dt['description'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang('Atasan', 'Supervisor') ?></label>
                    <div class="controls">
                        <select name="supervisor" id="supervisor" class="select2 form-control" style="width: 100%" required>
                            <option value="0">None</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang('Peran Dokumen MSR', 'Document MSR Role') ?></label>
                    <div class="controls">
                        <select name="role" id="role" class="select2 form-control" style="width: 100%" required>
                            <option value="1">Approver</option>
                            <option value="2">Primary</option>
                            <option value="3">Secondary</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 0">
                    <label class="form-label"><?= lang('Nominal Persetujuan MSR', 'Nominal Approval MSR') ?></label>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <div class="controls">
                            <select name="operand" id="operand" class="select2 form-control" style="width: 100%" required>
                                <option value=">">></option>
                                <option value="<=">&le;</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <input type="number" name="nominal" id="nominal" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang('Nominal Writeoff', 'Nominal Writeoff') ?></label>
                    <div class="controls">
                        <input type="number" name="writeoff" id="writeoff" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang('Nominal Intercompany', 'Nominal Intercompany') ?></label>
                    <div class="controls">
                        <input type="number" name="intercompany" id="intercompany" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang('Persetujuan Umum', 'Global Approval') ?></label>
                    <input style="margin-left: 0.5rem;" type="checkbox" name="global_approval" id="global_approval" value="1">
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                <button type="submit" class="btn btn-success" id="save"><?= lang('Simpan', 'Save') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>
<script src="<?php echo base_url() ?>ast11/app-assets/vendors/js/forms/select/select2.full.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#name").select2({
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        });

        $("#position").select2({
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        });

        $("#title").select2({
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        });

        $("#supervisor").select2({
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        });

        $("#role").select2({
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        });

        $("#operand").select2({
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        });

        $('#form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('setting/Organizational_structure/process') ?>',
                data: $('#form').serialize(),
                success: function(m) {
                    if (m == 'Success!') {
                        $('#modal').modal('hide');
                        $('#tbl').DataTable().ajax.reload();
                        msg_info('Success!');
                    } else {
                        msg_danger(m);
                    }
                }
            });
        });

        $('#tbl tfoot th').each( function (i) {
                var title = $('#tbl thead th').eq( $(this).index() ).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" data-index="'+i+'" />' );
        });

        var table = $('#tbl').DataTable({
            ajax: {
                url: '<?= base_url('setting/Organizational_structure/show') ?>',
                dataSrc: ''
            },
            scrollX: true,
            scrollY: '300px',
            scrollCollapse: true,
            paging: true,
            filter: true,
            info:false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            columns: [
                {title: "<center>No</center>", "width": "10%"},
                {title: "<center><?= lang('Nama', 'Name') ?></center>", "width": "20%"},
                {title: "<center><?= lang('Jabatan', 'Position') ?></center>", "width": "20%"},
                {title: "<center><?= lang('Gelar', 'Title') ?></center>", "width": "20%"},
                {title: "<center><?= lang('Atasan', 'Supervisor') ?></center>", "width": "20%"},
                {title: "<center><?= lang('Aksi', 'Action') ?></center>", "width": "10%"}
            ],
            "columnDefs": [
                {"className": "dt-right", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]}
            ]
        });

        $(table.table().container() ).on( 'keyup', 'tfoot input', function () {
                table.column( $(this).data('index') )
                .search( this.value )
                .draw();
            } );
        lang();
    });

    function getSupervisor(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('setting/Organizational_structure/get_supervisor/') ?>' + id,
            success: function (msg) {
                d = JSON.parse(msg);
                $('#supervisor').empty();
                $('#supervisor').select2({
                    data: d,
                    placeholder: "Please Select",
                    minimumResultsForSearch: 10
                });
            }
        });
    }

    function add() {
        document.getElementById("form").reset();
        $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
        $('#id').val("");
        $('#name').val("").select2({
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        }).on('change', function(e) {
            getSupervisor($('#name').val());
        });
        $('#position').val("<?= $pos[0]['description'] ?>").select2({
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        });
        $('#title').val("<?= $title[0]['description'] ?>").select2({
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        });
        $('#supervisor').empty();
        $('#supervisor').val("0").select2({
            data: [{id: '0', text: 'None'}],
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        });
        $('#role').val("1").select2({
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        });
        $('#operand').val(">").select2({
            placeholder: "Please Select",
            minimumResultsForSearch: 10
        });
        $('#nominal').val("");
        $('#writeoff').val("");
        $('#intercompany').val("");
        $('#global_approval').prop('checked', false);

        $('#modal .modal-header').css('background-color',"#1c84c6");
        $('#modal .modal-header').css('color',"#fff");
        $('#modal').modal('show');
        lang();
    }

    function update(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('setting/Organizational_structure/get/') ?>' + id,
            success: function (msg) {
                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var d = JSON.parse(msg);
                $('#id').val(d.id);
                $('#name').val(d.user_id).select2({
                    placeholder: "Please Select",
                    minimumResultsForSearch: 10
                }).on('change', function(e) {
                    getSupervisor($('#name').val());
                });
                $('#position').val(d.position).select2({
                    placeholder: "Please Select",
                    minimumResultsForSearch: 10
                });
                $('#title').val(d.title).select2({
                    placeholder: "Please Select",
                    minimumResultsForSearch: 10
                });
                $('#supervisor').empty().select2({
                    data: d.spv_list
                });
                $('#supervisor').val(d.parent_id).select2({
                    placeholder: "Please Select",
                    minimumResultsForSearch: 10
                });
                $('#role').val(d.user_role).select2({
                    placeholder: "Please Select",
                    minimumResultsForSearch: 10
                });
                $('#operand').val(d.operand).select2({
                    placeholder: "Please Select",
                    minimumResultsForSearch: 10
                });
                $('#nominal').val(d.nominal);
                $('#writeoff').val(d.nominal_writeoff);
                $('#intercompany').val(d.nominal_intercompany);
                if (d.first == 1)
                    $('#global_approval').prop('checked', true);
                else
                    $('#global_approval').prop('checked', false);

                $('#modal .modal-header').css('background-color',"#1ab394");
                $('#modal .modal-header').css('color',"#fff");
                $('#modal').modal('show');
                lang();
            }
        });
    }

</script>
