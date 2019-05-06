<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Pre Bid Location", "Pre Bid Location") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Setting", "Setting") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Pre Bid Location", "Pre Bid Location") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="text-right" style="margin-bottom: 20px">
                            <button type="button" class="btn btn-primary" onclick="create()">Add New Data</button>
                        </div>
                        <table id="data-table" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>                                        
                                    <th>Index</th>
                                    <th>Name</th>
                                    <th>Address</th>                                     
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="form-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class=" modal-content">
            <form id="form-modal" class="form-horizontal">                
                <input type="hidden" name="id" id="id" value="">
                <div class="modal-header bg-primary white">
                    <h4 class="modal-title">Form Pre Bid Location</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="form-label col-md-3"><?= lang("Nama Lokasi", "Location Name") ?></label>
                        <div class="col-md-9">
                            <input name="nama" id="nama" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3"><?= lang("Alamat", "Address") ?></label>
                        <div class="col-md-9">
                            <input type="text" name="alamat" id="alamat" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row" id="status_thinker">
                        <label class="col-md-3">Status</label>
                        <div class="col-md-9">
                            <select name="active" id="active" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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

<script>
    var dataTable;
    $(function() {
        dataTable = $('#data-table').dataTable({
            serverSide : true,
            processing : true,
            ajax : '<?= base_url('setting/pre_bid_location') ?>',
            columns : [         
                {data : 'id', render : function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }, class : 'text-center'},
                {data : 'nama'},
                {data : 'alamat'},                     
                {data : 'active', render : function(data) {
                    return data == 1 ? 'Active' : 'Inactive';
                }, class : 'text-center'},
                {data : 'id', render : function(data) {
                    return actionColumn.create('edit', {
                        template : '<button type="button" class="btn btn-primary btn-sm" title="Edit" onclick="edit(\''+data+'\')"><i class="fa fa-edit"></i></button>'
                    })
                    // .create('delete', {
                    //     template : '<button type="button" class="btn btn-danger btn-sm" title="Delete" onclick="remove(\''+data+'\')"><i class="fa fa-trash"></i></button>'
                    // })
                    .render('{edit}', {url : '<?= base_url('setting/pre_bid_location') ?>', key : data});
                }, orderable : false, searchable : false, class : 'text-right'}                
            ],
            order : [[1, 'ASC']]
        });

        $('#modal').bind('hidden.bs.modal', function () {
            $('[name="id"]').val('');
            $('[name="nama"]').val('');
            $('[name="alamat"]').val('');            
            $('[name="active"]').val(1);
        });

        $('#form-modal').submit(function() {
            var id = $('[name="id"]').val();
            if (id) {
                save('<?= base_url('setting/pre_bid_location/update') ?>/'+id);
            } else {
                save('<?= base_url('setting/pre_bid_location/create') ?>');
            }
            return false;            
        });
    });

    function create() {
        $('[name="active"]').val(1);
        $('#status_thinker').hide();
        $('#modal').modal('show');
    }  

    function edit(id) {
        $.ajax({
            url : '<?= base_url('setting/pre_bid_location/find') ?>/'+id,             
            dataType : 'json',
            success : function(response) {
                if (response.success) {
                    $('[name="id"]').val(response.data.id);
                    $('[name="nama"]').val(response.data.nama);
                    $('[name="alamat"]').val(response.data.alamat);
                    $('[name="active"]').val(response.data.active);
                    $('#status_thinker').show();
                    $('#modal').modal('show');
                } else {
                    msg_danger(response.message, 'Error');
                }
            }
        });
    }  

    function save(url) {
        $.ajax({
            url : url,
            type : 'post',
            data : $('#form-modal').serialize(),
            dataType : 'json',
            success : function(response) {
                if (response.success) {
                    msg_info(response.message, 'Success');
                    $('#modal').modal('hide');
                    dataTable.api().ajax.reload();
                } else {
                    msg_danger(response.message, 'Error');
                }
            }
        });
    }

    function remove(id) {
        var answer = confirm('Are you sure to delete this data?');
        if (answer) {
            $.ajax({
                url : '<?= base_url('setting/pre_bid_location/delete') ?>/'+id,             
                dataType : 'json',
                success : function(response) {
                    if (response.success) {
                        msg_info(response.message, 'Success');
                        dataTable.api().ajax.reload();
                    } else {
                        msg_danger(response.message, 'Error');
                    }
                }
            });
        }
    }  
</script>