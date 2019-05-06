<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Master Kode Permintaan", "Master Request Code") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengaturan", "Setting") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Master Kode Permintaan", "Master Request Code") ?></li>
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
                                                <button aria-expanded="false" onclick="add()" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "CREATE") ?></button>
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
                    <label class="form-label"><?= lang('Kode', 'Code') ?></label>
                    <div class="controls">
                        <input type="text" name="code" id="code" class="form-control" maxlength="2" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang('Deskripsi', 'Description') ?></label>
                    <div class="controls">
                        <input type="text" name="description" id="description" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="controls">
                        <div class="col-sm-10">
                            <input type="radio" value="1" name="status" id="active"> <i></i><?= lang('Aktif', 'Active') ?>
                            &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="0" name="status" id="inactive"> <i></i><?= lang('Nonaktif', 'Inactive') ?>
                        </div>
                    </div>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('setting/Master_requestfor/process') ?>',
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
                url: '<?= base_url('setting/Master_requestfor/show') ?>',
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
                {title: "<center><?= lang('Kode', 'Code') ?></center>", "width": "20%"},
                {title: "<center><?= lang('Deskripsi', 'Description') ?></center>", "width": "30%"},
                {title: "<center><?= lang('Status', 'Status') ?></center>", "width": "20%"},
                {title: "<center><?= lang('Aksi', 'Action') ?></center>", "width": "10%"}
            ],
            "columnDefs": [
                {"className": "dt-right", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]}
            ]
        });

        $(table.table().container() ).on( 'keyup', 'tfoot input', function () {
                table.column( $(this).data('index') )
                .search( this.value )
                .draw();
            } );
        lang();
    });

    function add() {
        document.getElementById("form").reset();
        $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
        $('#id').val("");
        $('#code').val("");
        $('#description').val("");
        $("#inactive").prop('checked', true);
        $('#modal .modal-header').css('background-color',"#1c84c6");
        $('#modal .modal-header').css('color',"#fff");
        $('#modal').modal('show');
        lang();
    }

    function update(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('setting/Master_requestfor/get/') ?>' + id,
            success: function (msg) {
                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                console.log(d);
                $('#id').val(d.ID_REQUESTFOR);
                $('#code').val(d.ID_REQUESTFOR);
                $('#description').val(d.REQUESTFOR_DESC);
                if (d.STATUS == "1") {
                   $("#active").prop('checked', true);
                } else {
                   $("#inactive").prop('checked', true);
                }
                // $('#status').val("0");
                $('#modal .modal-header').css('background-color',"#1ab394");
                $('#modal .modal-header').css('color',"#fff");
                $('#modal').modal('show');
                lang();
            }
        });
    }

</script>
