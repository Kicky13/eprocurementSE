<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Prefix", "Prefix") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home">Home</a>
                        </li>
                        <li class="breadcrumb-item"><?= lang("Master lain", "Other Master") ?>
                        </li>
                        <li class="breadcrumb-item"><?= lang("Prefix", "Prefix") ?>
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
                            <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Prefix(ENGLISH)</th>
                                        <th>Prefix(INDONESIA)</th>
                                        <th>Parent</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>                 
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
                        <label class="form-label"><?= lang('Prefix (INDONESIA)', 'Prefix (INDONESIA)') ?></label>                                    
                        <div class="controls">
                            <input type="text" name="prefix_ind" id="prefix_ind" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('Prefix (ENGLISH)', 'Prefix (ENGLISH)') ?></label>
                        <div class="controls">
                            <input type="text" name="prefix_eng" id="prefix_eng" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?= lang('PARENT', 'PARENT') ?></label>
                        <div class="controls">
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="0">Main</option>
                                <?php foreach ($rs_prefix as $r_prefix) { ?>
                                    <option value="<?= $r_prefix->ID_PREFIX ?>"><?= $r_prefix->DESKRIPSI_ENG ?></option>
                                <?php } ?>
                            </select>
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
                url: '<?= base_url('other_master/prefix/change/') ?>',
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
            url: '<?= base_url('other_master/prefix/get_prefix/') ?>' + id,
            success: function(msg) {
                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#id').val(id);
                $('#prefix_ind').val(d.DESKRIPSI_IND);
                $('#prefix_eng').val(d.DESKRIPSI_ENG);
                $('#parent_id').val(d.PARENT_ID);
                $('.modal-title').html("<?= lang("Update Data", "Add Data") ?>");
                $('#modal').modal('show');
                lang();
            }
        });
    }

    function add() {
        document.getElementById("form").reset();
        $('#id').val("");
        $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
        $('#modal').modal('show');
        lang();
    }

    function prefix_delete(id) {
        swal({
            title: "Apakah Anda yakin?",
            text: "Ingin menghapus prefix ?",
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
                url: '<?= base_url('other_master/prefix/delete/') ?>',
                data: {id: id},
                success: function() {
                    $('#tbl').DataTable().ajax.reload();
                    swal.close();
                    toastr.success('Berhasil dihapus', 'Success');
                }
            });
        });
    }

    $('#tbl').DataTable({
        processing : true,
        serverSide : true,
        ajax : '<?= base_url('other_master/prefix') ?>',
        columns : [
            {data : 'ID_PREFIX', render : function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }},
            {data : 'DESKRIPSI_ENG', name : 'm_prefix.DESKRIPSI_ENG'},
            {data : 'DESKRIPSI_IND', name : 'm_prefix.DESKRIPSI_IND'},
            {data : 'PARENT_DESKRIPSI_ENG', name : 'parent.DESKRIPSI_ENG'},
            {data : 'ID_PREFIX', render : function(data) {
                return actionColumn.create('edit', {
                    template : "<a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='update(\""+data+"\")'><i class='fa fa-edit'></i></a>"
                }).
                create('delete', {
                    template : "<a class='btn btn-danger btn-sm' title='Hapus User' href='javascript:void(0)' onclick='prefix_delete(\""+data+"\")'><i class='fa fa-trash'></i></a>"
                })
                .render('{edit} {delete}', { url : '<?= base_url('other_master/prefix') ?>', key : data});
            }}
        ]
    });
</script>

