<!--<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/switchery/switchery.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/> 
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet">-->

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Persetujuan Undangan", "Approval Invitation") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="<?= base_url() ?>home/">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Manajemen Supplier</a>
                        </li>
                        <li class="breadcrumb-item">Persetujuan Undangan
                        </li>
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
                                                <button style="display:none" aria-expanded="false" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></button>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tbl1" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                <th><center><?= lang('Nama Vendor', 'Vendor Name') ?></center></th>
                                                <th><center>Email</center></th>
                                                <th><center><?= lang('Masa Aktif Link', 'Activation Link') ?></center></th>
                                                <th><center><?= lang('Dibuat Oleh', 'Create By') ?></center></th>
                                                <th><center><?= lang('Waktu Dibuat', 'Create Time') ?></center></th>
                                                <th><center>Status</center></th>
                                                <th><center><?= lang('   Aksi    ', '    Action     ') ?></center></th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                <th><center><?= lang('Nama Vendor', 'Vendor Name') ?></center></th>
                                                <th><center>Email</center></th>
                                                <th><center><?= lang('Masa Aktif Link', 'Activation Link') ?></center></th>
                                                <th><center><?= lang('Dibuat Oleh', 'Create By') ?></center></th>
                                                <th><center><?= lang('Waktu Dibuat', 'Create Time') ?></center></th>
                                                <th><center>Status</center></th>
                                                <th><center><?= lang('Aksi', 'Action') ?></center></th>
                                                </tr>
                                                </tfoot>
                                            </table>  
                                            <label class="form-group" style="font-weight:300" id="info">Showing 1 to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label>
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
<div class="modal fade" id="modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="formfield1"><?= lang('Nama Vendor', 'Vendor Name') ?></label>                                    
                    <div class="controls">
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield2">Email</label>
                    <span class="desc">e.g. "some@example.com"</span>
                    <div class="controls">
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield2"><?= lang("Masa Aktif Link", "Expired Link") ?></label>
                    <div class="controls">
                        <div class="input-group m-b">
                            <input type="number" name="limit" id="limit" class="form-control" required value="2">
                            <span class="input-group-addon"><?= lang('hari', 'day') ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                <button type="submit" class="btn btn-success" id="save"><?= lang('Simpan', 'Save') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" data-backdrop="static" id="Modal-detail" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="Modal-detail"> <?= lang('Rincian', 'Detail') ?></h4>
            </div>
            <div class="modal-body">
                <div class="ibox-content" style="height:420px">
                    <table id="table-detail" class="display" width="100%"></table> 
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>        
            </div>
        </div>
    </div>
</div>
<!--<div id="modal-filter" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class=" modal-content">
            <form id="form_filter" class="form-horizontal" novalidate="novalidate" action="javascript:;">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">Filter Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label for="roundText"><?= lang("Nama Vendor", "Vendor Name") ?></label>
                                        <input  maxlength="20" type="text" class="form-control" id="search_name" required data-validation-required-message="This field is required">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label for="roundText">Email</label>
                                        <input  maxlength="20" type="text" class="form-control" id="search_email" required data-validation-required-message="This field is required">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label for="roundText"><?= lang("Masa Aktif Link", "Link Activation Period") ?></label>
                                        <input  maxlength="20" type="text" class="form-control" id="search_link" required data-validation-required-message="This field is required">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label for="roundText">Status</label>
                                        <div class="i-checks col-md-6">
                                            <label><input type="checkbox" value="aktif" id="status1" required data-validation-required-message="This field is required"> <i></i> <?= lang("Aktif", "Active") ?> </label>
                                        </div>
                                        <div class="i-checks col-md-6">
                                            <label><input type="checkbox" value="tidak" id="status2" required data-validation-required-message="This field is required"> <i></i> <?= lang("Tidak Aktif", "NotActive") ?> </label>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset>
                                        <div class="input-group">
                                            <input  maxlength="10" type="text" class="touchspin" value="100" id="limit2" name="demo3" required data-validation-required-message="This field is required">
                                            <span class="input-group-addon" id="total"></span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="submit" class="btn btn-info" id="save"><?= lang('Filter', 'Filter') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>-->
<div id="modal-edit" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form id="email_kirim" class="form-horizontal">
            <div class=" modal-content">            
                <div class="modal-header bg-primary white">        
                    <h4 class="edit-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input name="id" id="id" hidden>                               
                    <div class="form-group">             
                        <div class="col-md-12">                                
                            <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                            <label id="label_kirim" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                            <input type="hidden" name="id_data" id="id_data" class="form-control" required>
                            <input type="hidden" name="url_id" id="url_id" class="form-control" required>
                            <input type="hidden" name="email_id" id="email_id" class="form-control" required>
                            <input type="hidden" name="nama_id" id="nama_id" class="form-control" required>
                            <textarea placeholder="Isi komentar anda" class="form-control" rows="5" id="note" name="note"></textarea>
                        </div>
                    </div>
                </div>  
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                    <button type="submit" class="btn btn-primary" id="finish"><?= lang("Setujui dan Kirim Undangan", "Approve and send invitation") ?></button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="modal-reject" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form id="tolak" class="form-horizontal" novalidate="novalidate" action="javascript:;">
            <div class=" modal-content">            
                <div class="modal-header white">        
                    <h4 class="reject-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="id" id="id" hidden>                                
                    <div class="form-group">             
                        <div class="controls col-md-12">                                
                            <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                            <label id="label_rej" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                            <input type="hidden" name="id_email" id="id_email" class="form-control" required>
                            <input type="hidden" name="email_edit" id="email_edit" class="form-control" required>
                            <input type="hidden" name="email_edit" id="email_edit" class="form-control" required>
                            <textarea placeholder="Isi komentar anda" class="form-control" rows="5" id="note" name="note" required data-validation-required-message="This field is required"></textarea>
                        </div>
                    </div>
                </div>  
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                    <button type="submit" class="btn btn-danger" id="reject_inv"><?= lang("Tolak", "Reject") ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/js/scripts/forms/validation/form-validation.js"type="text/javascript"></script>

<script>
    $(function () {
        $(".touchspin").TouchSpin({
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            buttondown_txt: '<i class="ft-minus"></i>',
            buttonup_txt: '<i class="ft-plus"></i>'
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('#form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('vendor/invite_acc/add') ?>',
                data: $('#form').serialize(),
                success: function (m) {
                    if (m == 'sukses') {
                        $('#modal').modal('hide');
                        $('#tbl1').DataTable().ajax.reload();
                        msg_info('Sukses tersimpan');
                    } else {
                        msg_danger('Email atau Nama Vendor Sudah ada, silahkan coba yang lain!');
                    }
                }
            });
        });
        $("#modal-edit").on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('vendor/invite_acc/update_vendor_kirim_email') ?>/",
                type: "POST",
                data: $('#email_kirim').serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.status) //if success close modal and reload ajax table
                    {
                        $('#tbl1').DataTable().ajax.reload();
                        $('#modal-edit').modal('hide');
                        msg_info('Berhasil Dikirim');
                    } else {
                        $('#modal-edit').modal('hide');
                        msg_danger('Gagal Dikirim!');
                    }
                }
            });
        });
        $("#modal-reject").on('submit', function (e) {
            e.preventDefault();
            var elm = start($('#modal-reject').find('.modal-content'));
            $.ajax({
                url: "<?= base_url('vendor/invite_acc/delete_data') ?>/",
                type: "POST",
                data: $('#tolak').serialize(),
                dataType: "JSON",
                success: function (data) {
                    stop(elm);
                    if (data.status) //if success close modal and reload ajax table
                    {
                        $('#tbl1').DataTable().ajax.reload();
                        $('#modal-reject').modal('hide');
                        msg_info('Berhasil Ditolak', 'Sukses');
                    } else {
                        $('#modal-reject').modal('hide');
                        msg_danger('Oops, terjadi kesalahan!', 'Gagal');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown)
                {
                    stop(elm);
                    msg_danger("Gagal", "Oops,Terjadi kesalahan pengambilan data");
                }
            });
        });
        $('#tbl1 tfoot th').each(function (i) {
			if(i<7){
				var title = $('#tbl1 thead th').eq( $(this).index() ).text();
				$(this).html( '<input type="text" placeholder="Search " data-index="'+i+'" />' );
			}else{
				var title = $('#tbl1 thead th').eq( $(this).index() ).text();
				$(this).html( '' );
			}
        });
        var table = $('#tbl1').DataTable({
            ajax: {
                url: '<?= base_url('vendor/invite_acc/show') ?>',
                "type": "json"
            },
            scrollX: true,
            scrollY: '300px',
            scrollCollapse: true,
            paging: true,
            filter: true,
            info: false,
            destroy: true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            "columns": [
                {"data": "NO"},
                {"data": "NAMA"},
                {"data": "EMAIL"},
                {"data": "URL_BATAS_HARI"},
                {"data": "CREATE_BY"},
                {"data": "CREATE_TIME"},
                {"data": "STATUS"},
                {"data": "AKSI"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]}
            ]
        });
        $(table.table().container()).on('keyup', 'tfoot input', function () {
            table.column($(this).data('index'))
                    .search(this.value)
                    .draw();
        });
        lang();
        $("#modal_filter").on('submit', function (e)
        {
            var open = $('#search_open').val();
            var close = $('#search_close').val();
            var obj = {};
//                    if (open !== null) {
//            open.map((data, index) = > {
//            obj["open" + index] = data;
//            });
//            }
//            else
//            {
//            obj["open"] = null;
//            }
//            if (close !== null){
//            close.map((data, index) = > {
//            obj["close" + index] = data;
//            });
//            }
//            else{
//            obj["close"] = null;
//            }
            if ($('#status1').is(":checked"))
                obj.status1 = 1;
            else
                obj.status1 = "none";
            if ($('#status2').is(":checked"))
                obj.status2 = 0;
            else
                obj.status2 = "none";
            obj.limit = $('#limit2').val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vendor/invite_acc/filter_data'); ?>",
                data: obj,
                cache: false,
                success: function (res)
                {
                    $('#tbl1').DataTable().clear().draw();
                    $('#tbl1').DataTable().rows.add(res).draw();
                    var tamp = 0;
                    if (res.length > 0)
                        tamp = 1;
                    $('#info').text("Showing " + tamp + " to " + res.length + " data from " +<?= (isset($total) != false ? $total : '0') ?>)
                    $('#modal-filter').modal('hide');
                }
            });
        });
    });
    function add() {
        $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
        $('#modal').modal('show');
        lang();
    }

    function filter() {
        $('.modal-filter').html("<?= lang("Filter Data", "Filter Data") ?>");
        $('#total').text("dari " + "<?= (isset($total) != false ? $total : '0') ?>" + " Data");
        $('#modal-filter .modal-header').css('background-color', "#23c6c8");
        $('#modal-filter .modal-header').css('color', "#fff");
        $('#modal-filter').modal('show');
        lang();
    }

    function tabel_detail(id) {
        $('#table-detail').DataTable({
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('vendor/invite_acc/list_tabel_detail') ?>/" + id,
                dataSrc: '',
            },
            destroy: true,
            paging: true,
            columns: [
                {title: "No"},
                {title: "<?= lang('Nama Vendor', 'Vendor Name') ?>"},
                {title: "<?= lang('Email', 'Email') ?>"},
                {title: "<?= lang('Status', 'Status') ?>"},
                {title: "<?= lang('Catatan', 'Note') ?>"},
                {title: "<?= lang('Dibuat Oleh', 'Create By') ?>"},
                {title: "<?= lang('Waktu Dibuat', 'Create Time') ?>"}
            ],
            "columnDefs": [
                {"className": "dt-left", "targets": [0]},
                {"className": "dt-left", "targets": [1]},
                {"className": "dt-left", "targets": [2]},
                {"className": "dt-left", "targets": [3]},
                {"className": "dt-left", "targets": [4]},
                {"className": "dt-left", "targets": [5]},
                {"className": "dt-left", "targets": [6]}
            ],
            "scrollX": true,
            "scrollY": '300px',
            "scrollCollapse": true,
        });
        $('#Modal-detail').modal('show');
        lang();
    }
    ;

    function accept(id) {
        //Ajax Load data from ajax
        $.ajax({
            url: "<?= base_url('vendor/invite_acc/show_update') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                $('[name="url_id"]').val(data.url);
                $('[name="nama_id"]').val(data.nama);
                $('[name="email_id"]').val(data.email);
                $('[name="id_data"]').val(data.id);
                $('#modal-edit .edit-title').text("Setujui Usulan Undangan");
                $('#modal-edit .modal-header').css("background", "#347ab5");
                $('#modal-edit .modal-header').css("color", "#fff");
                $('#modal-edit #reject_inv').hide();
                $('#modal-edit #finish').show();
                $('#modal-edit #label_kirim').hide();
                $('#modal-edit').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function reject(id) {
        //Ajax Load data from ajax
        //$("#reject_inv").attr("disabled", true);
        $.ajax({
            url: "<?= base_url('vendor/invite_acc/show_update') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                $('[name="email_edit"]').val(data.email);
                $('[name="id_email"]').val(data.id);
                $('#modal-reject .reject-title').text("Tolak Usulan Undangan");
                $('#modal-reject .modal-header').css("background-color", "#FF6275");
                $('#modal-reject .modal-header').css("color", "#fff");
                $('#modal-reject #finish').hide();
                $('#modal-reject #reject_inv').show();
                $('#modal-reject #label_rej').show();
                $('#modal-reject').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function aktif_form() {
        $("#reject_inv").attr("disabled", false);
    }

    jQuery(function ($) {

        if ($.isFunction($.fn.select2)) {

            $("#filter").select2({
                placeholder: 'Countries',
                allowClear: true
            }).on('select2-open', function () {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
            });
        }
    });
</script>
<!--<script src="<?php echo base_url() ?>ast11/filter/perfect-scrollbar.min.js" type="text/javascript"></script>     
<script src="<?php echo base_url() ?>ast11/filter/select2.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url() ?>ast11/filter/scripts.js" type="text/javascript"></script> 
<script src="<?php echo base_url() ?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>-->
<script>
//    $("#e1").select2();
//    $("#button").click(function(){
//       alert($("#e1").val());
//    });

</script>




