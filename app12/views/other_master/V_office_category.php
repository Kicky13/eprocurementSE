<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Kategori Kantor", "Office Categories") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home">Home</a>
                        </li>
                        <li class="breadcrumb-item"><?= lang("Master lain", "Other Master") ?>
                        </li>
                        <li class="breadcrumb-item"><?= lang("Kategori Kantor", "Office Categories") ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="description" class="card">          
                <div class="card-header">
                    <h5 class="title pull-right">
                        <button aria-expanded="false" onclick="add()" class="btn btn-success"><i class="ft-plus-circle"></i> Tambah</button>   
                    </h5>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="card-text">
                            <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%"></table>                 
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>


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
                <input name="id" id="id" hidden>
                <!--end hide value-->                                    
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label"><?= lang('Kategori Kantor (INDONESIA)', 'Office Category (INDONESIA)') ?></label>                                    
                        <div class="controls">
                            <input type="text" name="office_ind" id="office_ind" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('Office Category (INDONESIA)', 'Office Category (ENGLISH)') ?></label>
                        <div class="controls">
                            <input type="text" name="office_eng" id="office_eng" class="form-control" required>
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="submit" class="btn btn-success" id="save"><?= lang('Simpan', 'Save') ?></button>
                </div>
            </form>

        </div>
    </div>
</div> 




<script type="text/javascript">
//    lang();
    $(function() {
        $('#form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('other_master/office_category/change') ?>',
                data: $('#form').serialize(),
                success: function(msg) {
                    var msg = msg.replace("[", "");
                    var msg = msg.replace("]", "");
                    var d = JSON.parse(msg);
                    if (d.msg == 'sukses') {
                        $('#modal').modal('hide');
                        $('#tbl').DataTable().ajax.reload();
                        msg_info('Sukses tersimpan');
                    } else {
                        msg_danger(d.msg);
                    }
                }
            });
        });
    });


    function update(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('other_master/office_category/get_office_category/') ?>' + id,
            success: function(msg) {
                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#id').val(id);
                $('#office_ind').val(d.DESKRIPSI_IND);
                $('#office_eng').val(d.DESKRIPSI_ENG);
                $('#modal').modal('show');
                lang();
            }
        });
    }

    function add() {
        document.getElementById("form").reset();
        $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
        $('#modal').modal('show');
        $('#id').val("");
        lang();
    }

    function office_delete(id) {
        swal({
            title: "Apakah Anda yakin?",
            text: "Ingin menghapus Kategori Kantor ?",
            type: "info",
            confirmButtonColor: "#d93d36",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (!isConfirm)
                return;
            $.ajax({
                type: 'POST',
                url: '<?= base_url('other_master/office_category/delete/') ?>',
                data: {id: id},
                success: function() {
                    $('#tbl').DataTable().ajax.reload();
                    swal.close();
                    toastr.success('User berhasil dihapus', 'Success');
                }
            });
        });
    }

    $('#tbl').DataTable({
        ajax: {
            url: '<?= base_url('other_master/office_category/show') ?>',
            dataSrc: ''
        },
        scrollX: true,
        scrollY: '300px',
        scrollCollapse: true,
        paging: false,
        filter: false,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        },
        columns: [
            {title: "<center>No</center>", "width": "20px"},
            {title: "<center><?= lang("Kategori Kantor (INDONESIA)", "Office Category (INDONESIA)") ?></center>"},
            {title: "<center><?= lang("Kategori Kantor (ENGLISH)", "Office Category (ENGLISH)") ?></center>"},
            {title: "<center><?= lang("Aksi", "Action") ?></center>"}
        ],
        "columnDefs": [
            {"className": "dt-right", "targets": [0]}
        ]
    });
</script>