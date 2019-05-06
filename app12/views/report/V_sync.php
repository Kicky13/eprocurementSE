<?php $this->load->view('report/partials/filter_sync_script') ?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title">Syncrhonize Activity</h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Laporan", "Report") ?></li>
                        <li class="breadcrumb-item active">Syncrhon Activity</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <?php $this->load->view('report/partials/filter_sync') ?>
                        <div class="row">
                            <div class="col-md-3">
                                <h4 class="card-title">Syncrhonize Last Execution Time</h4>
                                <?php foreach ($rs_sync as $r_sync) { ?>
                                    <div id="sync-<?= $r_sync->doc ?>" class="media border-0">                    
                                        <div class="media-body w-100">
                                            <h6 class="list-group-item-heading"><?= $r_sync->doc ?><button type="button" class="btn btn-primary btn-sm float-right btn-sync" onclick="sync('<?= base_url($r_sync->url) ?>', '<?= $r_sync->doc ?>')"><i class="fa fa-refresh"></i></button></h6>
                                            <small><span class="fa fa-clock-o fa-fw"></span> <i id="sync-time-<?= $r_sync->doc ?>"><?= $r_sync->last_execution_time ?></i></small>
                                        </div>
                                    </div>
                                    <hr>
                                <?php } ?>
                            </div>
                            <div class="col-md-9">
                                <h4 class="card-title">Syncrhonize Document</h4>
                                <table id="data-table" class="table table-bordered" style="width:100%; font-size: 14px;">
                                    <thead>
                                        <tr>                                        
                                            <th>Document</th>
                                            <th>Type</th>
                                            <th>Status</th>                                    
                                            <th>Date</th>
                                            <th></th>                                 
                                        </tr>                                
                                    </thead>    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var dataTable;
    $(function() {
        $('#btn-filter').click(function() {
            dataTable.api().ajax.url('?'+$('[name*="filter"]').serialize()).load();
        });

        dataTable = $('#data-table').dataTable({
            processing : true,
            serverSide : true,
            ajax : '?'+$('[name*="filter"]').serialize(),
            columns : [
                {data : 'doc_no'},
                {data : 'doc_type'},
                {data : 'isclosed', render : function(data) {
                    if (data == 1) {
                        return '<label class="badge badge-pill badge-success">Finished</label';
                    } else {
                        return '<label class="badge badge-pill badge-danger">Unfinished</label';
                    }
                }, class : 'text-center'},
                {data : 'createdate'},
                {data : 'id', render : function(data, type, row) {
                    return actionColumn.create('resync', {
                        template : function() {
                            if (row.isclosed == 1) {
                                return '<button class="btn btn-primary" onclick="resync(\''+data+'\')">Resync</button>'
                            } else {
                                return '';
                            }
                        }
                    }).render('{resync}', {url : '<?= base_url('report/sync') ?>'})
                }, class : 'text-center'}
            ],
            order: [[2, 'ASC'], [3, 'DESC']]
        });
    });

    function resync(id) {
        var answer = confirm('Are you sure resynchron this data ?');
        if (answer) {
            $.ajax({
                url : '<?= base_url('report/sync/resync') ?>/'+id,
                dataType : 'json',
                success : function(response) {
                    if (response.success) {
                        dataTable.api().ajax.reload();
                    }
                    alert(response.message);
                }
            });
        }   
    }

    function sync(url, doc_type) {        
        var answer = confirm('Are you sure run this synchronize ?');
        if (answer) {
            $('.btn-sync').prop('disabled', true);
            $.ajax({
                url : url,                
                success : function(response) {   
                    $('#sync-time-'+doc_type).html(Localization.datetime(new Date()));
                    alert(response);
                },
                error: function(jqXHR, status){
                    if(status === 'timeout') {     
                        alert('Error request timeout');                                 
                    }
                }
            }).done(function(data) {
                $('.btn-sync').prop('disabled', false);    
                 dataTable.api().ajax.reload();                    
            });
        }
    }
</script>