<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Usulan Undangan Registrasi Supplier", "Proposed Supplier Registration Invitation") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active">Manajemen Supplier</li>
                        <li class="breadcrumb-item active"><?= lang("Usulan Undangan", "Proposed Supplier") ?></li>
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
                                                <button aria-expanded="false" onclick="email_temp()" id="email-temp" class="btn btn-primary"><i class="fa fa-envelope-open-o"></i> <?= lang("Template Email", "Template Email") ?></button>
                                                <!-- <button aria-expanded="false" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></button> -->  
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
                                                <thead>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                <th><center><?= lang('&nbsp&nbsp&nbsp&nbsp&nbspNama Supplier&nbsp&nbsp&nbsp&nbsp', '&nbsp&nbsp&nbsp&nbsp&nbspSupplier Name&nbsp&nbsp&nbsp&nbsp&nbsp') ?></th>
                                                    <th><center>Email</center></th>
                                                    <th><center><?= lang("Masa Aktif Link", "Days Expired Link") ?></center></th>
                                                    <th><center><?= lang("Link Kadaluarsa", "Expired Link") ?></center></th>
                                                    <th><center>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspStatus&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</center></th>
                                                    <th><center><?= lang("&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp") ?></center></th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Supplier</th>
                                                            <th>Email</th>
                                                            <th>Masa Aktif Link</th>
                                                            <th>Link Kadaluarsa</th>
                                                            <th>Status</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>

                                                    </tbody>
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
<div class="modal fade" id="modal"  tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" action="javascript:;" class="modal-content" novalidate="novalidate">
            <div class="modal-header bg-primary white">        
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="formfield1"><?= lang('Nama Supplier', 'Supplier Name') ?></label>                                    
                    <div class="controls">
                        <input type="text" name="nama" id="nama" class="form-control" required data-validation-required-message="This field is required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield2">Email</label>
                    <span class="desc">e.g. "some@example.com"</span>
                    <div class="controls">
                        <input type="email" name="email" id="email" class="form-control" required data-validation-required-message="This field is required">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield2"><?= lang("Masa Aktif Link", "Expired Link") ?></label>
                    <div class="controls">
                        <div class="input-group m-b">
                            <input type="number" name="limit" id="limit" class="form-control" value="2" required data-validation-required-message="This field is required">
                            <span class="input-group-addon"><?= lang('hari', 'day') ?></span>
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
<div class="modal fade" id="Modal-detail" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header bg-primary white">        
                <h4 class="modal-title"><?= lang('Riwayat', 'History') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="ibox-content" style="height:420px">
                    <div class="row">                                
                        <div class="col-sm-12">
                            <table id="table-detail" class="table table-striped table-bordered table-hover display" width="100%"></table> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>        
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Modal-update" tabindex="-1" role="dialog">
    <div class="modal-dialog" >
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> </h4>
            </div> -->
            <div class="modal-header bg-primary white">        
                <h4 class="modal-title"><?= lang('Perbarui', 'Update') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">        
                <form action="#" id="form-edit" class="form-horizontal">
                    <input type="hidden" value="" name="id_edit"/> 
                    <div class="form-body">                            
                        <div class="form-group">
                            <label class="form-label" for="formfield2">Nama Supplier</label>
                            <div class="controls">
                                <input name="nama_vendor_edit" placeholder="Nama Supplier" class="form-control" type="text">                        
                            </div>
                        </div>    
                        <div class="form-group">
                            <label class="form-label" for="formfield2">Email</label>
                            <span class="desc">e.g. "some@example.com"</span>
                            <div class="controls">
                                <input type="email" name="email_edit" id="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="formfield2"><?= lang("Masa Aktif Link", "Expired Link") ?></label>
                            <div class="controls">
                                <div class="input-group m-b">
                                    <input type="number" name="limit_edit" id="limit" class="form-control" required value="2">
                                    <span class="input-group-addon"><?= lang('hari', 'day') ?></span>
                                </div>
                            </div>
                        </div> 
                    </div>
                </form>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button> 
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><?= lang('Simpan', 'Save') ?></button>               
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Modal-email" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">        
                <h4 class="modal-title"><?= lang('Template Email', 'Template Email') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">        
                <form id="form-email" class="form-horizontal" action="javascript:;" novalidate="novalidate">            
                    <div class="form-body">                            
                        <div class="form-group">
                            <label class="form-label" for="formfield2"><?= lang('Judul', 'Title') ?></label>
                            <div class="controls">
                                <input name="title_edit" id="TitleEdit" class="form-control" type="text">                        
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="formfield2"><?= lang('Pembuka', 'Open') ?></label>
                            <div class="controls">
<!--                                <textarea id="open_edit" name="open_edit"></textarea>                                                -->
                                <textarea type="text" id="ckeditor" name="ckeditor" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5>Username: XXXXXXX</h5>
                            <h5>Password: XXXXXXX</h5>
                            <h5><u>Link</u></h5>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="formfield2"><?= lang('Penutup', 'End') ?></label>
                            <div class="controls">
                                <textarea name="close_edit" class="form-control" rows="5" id="close_edit"></textarea>                        
                            </div>
                        </div>                                    
                    </div>                      
                </form>
            </div>
            <div class="modal-footer">          
                <button type="button" class="btn" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>   
                <button type="submit" id="btnSave" class="btn btn-primary" onclick="save_email()"><?= lang('Simpan', 'Save') ?></button>     
            </div>
        </div>
    </div>
</div>


<div id="modal-filter" class="modal fade" data-backdrop="static" role="dialog">
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
                                    <div class="form-group">
                                        <label for="roundText"><?= lang("Nama Supplier", "Supplier Name") ?></label>
                                        <input  maxlength="20" type="text" class="form-control" id="search_name" required data-validation-required-message="This field is required">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="roundText">Email</label>
                                        <input  maxlength="20" type="text" class="form-control" id="search_email" required data-validation-required-message="This field is required">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="roundText"><?= lang("Masa Aktif Link", "Link Activation Period") ?></label>
                                        <input  maxlength="20" type="text" class="form-control" id="search_link" required data-validation-required-message="This field is required">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="roundText">Status</label>
                                        <div class="i-checks col-md-6">
                                            <label><input type="checkbox" value="aktif" id="status1" required data-validation-required-message="This field is required"> <i></i> <?= lang("Aktif", "Active") ?> </label>
                                        </div>
                                        <div class="i-checks col-md-6">
                                            <label><input type="checkbox" value="tidak" id="status2" required data-validation-required-message="This field is required"> <i></i> <?= lang("Tidak Aktif", "NotActive") ?> </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div>
                                        <div class="input-group">
                                            <input  maxlength="10" type="text" class="touchspin" value="100" id="limit2" name="demo3" required data-validation-required-message="This field is required">
                                            <span class="input-group-addon" id="total"></span>
                                        </div>
                                    </div>
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
</div>

<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/js/scripts/forms/validation/form-validation.js"type="text/javascript"></script>
<script>var ckeditor = CKEDITOR.replace('ckeditor');</script>
<script type="text/javascript">
    $(function () {
        $(".touchspin").TouchSpin({
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            buttondown_txt: '<i class="ft-minus"></i>',
            buttonup_txt: '<i class="ft-plus"></i>'
        });
        //        $(".touchspin3").TouchSpin({
        //            verticalbuttons: true,
        //            buttondown_class: 'btn btn-white',
        //            buttonup_class: 'btn btn-white'
        //        });
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('#Modal-detail').on('shown.bs.modal', function () {
            $('#table-detail').DataTable().columns.adjust().draw();
        });
        $('#form23').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('vendor/send_invitation/add1A') ?>',
                data: $('#form').serialize(),
                success: function (m) {
                    if (m == 'sukses') {
                        $('#modal').modal('hide');
                        $('#tbl').DataTable().ajax.reload();
                        msg_info('Sukses tersimpan');
                    } else {
                        msg_danger('Email atau Nama Supplier Sudah ada, silahkan coba yang lain!');
                        $('#tbl').DataTable().ajax.reload();
                    }
                }
            });
        });

        // Setup - add a text input to each footer cell

        $('#tbl tfoot th').each(function (i) {
            if (i < 6) {
                var title = $('#tbl thead th').eq($(this).index()).text();
                $(this).html('<input type="text" placeholder="Search" data-index="' + i + '" />');
            } else {
                var title = $('#tbl thead th').eq($(this).index()).text();
                $(this).html('');
            }

        });

        var table = $('#tbl').DataTable({
            // "ajax": {
            // url: '<?= base_url('vendor/send_invitation/show') ?>',
            // dataType: "json",
            // complete: function() {
            // alert("OK")
            // },
            // error: function (xhr, error, thrown) {
            // alert("An error occurred while attempting to retrieve data via ajax.\n"+thrown );
            // },
            // "dataSrc": function ( json ) {
            // console.log(json);
            // return json;
            // }
            // },
            ajax: {
                url: '<?= base_url('vendor/send_invitation/show') ?>',
            },
            scrollX: "100%",
            scrollY: '300px',
            scrollCollapse: true,
            paging: true,
            info: false,
            searching: true,
            destroy: true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            "columns": [
                {"data": "ID"},
                {"data": "NAMA"},
                {"data": "ID_VENDOR"},
                {"data": "STATUS"},
                {"data": "URL"},
                {"data": "URL_BATAS_HARI"},
                {"data": "AKSI"}
            ],
            "columnDefs": [
                {"className": "dt-right", "targets": [0]},
                {"className": "dt-right", "targets": [1]},
                {"className": "dt-right", "targets": [2]},
                {"className": "dt-right", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]}
            ]
        });
        lang();

        // Filter event handler
        $(table.table().container()).on('keyup', 'tfoot input', function () {
            console.log(table.column($(this).data('index'))
                    .search(this.value)
                    .draw());
        });


        lang();
        $('#form').on('submit', function (e) {
            var elm = start($('.modal').find('.modal-dialog'));
            $.ajax({
                url: "<?= base_url('vendor/send_invitation/add') ?>/",
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.status) //if success close modal and reload ajax table
                    {
                        $('#tbl').DataTable().ajax.reload();
                        $('#modal').modal('hide');
                        msg_info('Berhasil Disimpan');
                    } else {
                        msg_danger(data.msg);
                    }
                    stop(elm);
                }
            });
        });
        
    });

    jQuery(function ($) {

        if ($.isFunction($.fn.select2)) {
            $("#to_uom").select2({
                placeholder: 'Pilih',
                allowClear: true
            }).on('select2-open', function () {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                $('#tbl').DataTable().ajax.reload();
            });
        }
    });
    function filter() {
        $('.modal-filter').html("<?= lang("Filter Data", "Filter Data") ?>");
        $('#total').text("dari " + "<?= (isset($total) != false ? $total : '0') ?>" + " Data");
        $('#modal-filter .modal-header').css('background-color', "#23c6c8");
        $('#modal-filter .modal-header').css('color', "#fff");
        $('#modal-filter').modal('show');
        lang();
    }
    function add() {
        //iwan add
        document.getElementById("form").reset();
        $('#modal .modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
        $('#modal').modal('show');
        $('#tbl').DataTable().columns.adjust().draw();
        lang();
    }

    function edit_undangan(id) {

        //Ajax Load data from ajax
        $.ajax({
            url: "<?= base_url('vendor/send_invitation/show_edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {

                $('[name="nama_vendor_edit"]').val(data.nama);
                $('[name="email_edit"]').val(data.email);
                $('[name="limit_edit"]').val(data.limit);
                $('[name="id_edit"]').val(data.id);
                $('#Modal-update .modal-header').css("background-color", "#23c6c8");
                $('#Modal-update .modal-header').css("color", "#fff");
                $('#Modal-update').modal('show');
                lang(); // show bootstrap modal when complete loaded                
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function save() {
        swal({
            title: "Apakah kamu yakin?",
            text: "Mengubah data ini",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (!isConfirm)
                return;
            $('#btnSave').text('saving...');
            $('#btnSave').attr('disabled', true);
            $.ajax({
                url: "<?= base_url('vendor/send_invitation/update_vendor') ?>/",
                type: "POST",
                data: $('#form-edit').serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.status)
                    {
                        $('#Modal-update').modal('hide');
                        $('#tbl').DataTable().ajax.reload();
                    }
                    swal.close()
                    msg_info('Sukses tersimpan');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    swal.close()
                    msg_danger('Gagal Tersimpan!');
                }
            });
        });
    }

    function tabel_detail(id) {
        $('#table-detail').DataTable({
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('vendor/send_invitation/list_tabel_detail') ?>/" + id,
                dataSrc: '',
            },
            destroy: true,
            paging: false,
            columns: [
                {title: "No"},
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
                {"className": "dt-left", "targets": [4]}
            ],
            "scrollX": true,
            "scrollY": '300px',
            "scrollCollapse": true,
        });
        $('#Modal-detail .modal-header').css("background-color", "#1ab394");
        $('#Modal-detail .modal-header').css("color", "#fff");
        $('#Modal-detail').modal('show');
        lang();
    }
    ;
    function update(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('vendot/send_invitation/get/') ?>' + id,
            success: function (msg) {
                $('modal_show .modal-title').html("<?= lang("Show Data", "Show Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#id').val(d.ID);
                $('#status').val(d.STATUS);
                $('#catatan').val(d.NOTE);
                $('#dibuat_oleh').val(d.CREATE_BY);
                $('#waktu').val(d.CREATE_TIME);
                $('#modal_show').modal('show');
                lang();
            }
        });
    }

    function email_temp() {
        $.ajax({
            url: "<?= base_url('vendor/send_invitation/show_email_temp') ?>",
            type: "GET",
            dataType: "JSON",
            success: function (data)
            {
                CKEDITOR.instances.ckeditor.setData(data.ckeditor);
                //$('#open_edit').summernote('code', data.open);
                $('[name="title_edit"]').val(data.title);
                $('[name="close_edit"]').val(data.close);
                $('#Modal-email .modal-header').css('background-color', "#347ab5");
                $('#Modal-email .modal-header').css('color', "#fff");
                $('#Modal-email').modal('show');
                lang();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    $('#form-email22').validate({
        rules: {
            title_edit: {
                required: true
            },
            close_edit: {
                required: true
            }
        },
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    function save_email() {
        swal({
            title: "Apakah kamu yakin?",
            text: "Mengubah template email?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#0479fc",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (!isConfirm)
                return;
            $('#btnSave').text('saving...');
            $('#btnSave').attr('disabled', true);
            $.ajax({
                url: "<?= base_url('vendor/send_invitation/update_email') ?>/",
                type: "POST",
                data: $('#form-email').serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.status)
                    {
                        $('#Modal-email').modal('hide');
                        $('#tbl').DataTable().ajax.reload();
                    }
                    swal.close()
                    msg_info('Sukses tersimpan');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    swal.close()
                    msg_danger('Gagal Tersimpan!');
                }
            });
        });
    }

    function kirim_ulang($id) {
        swal({
            title: "Apakah anda yakin?",
            text: "ingin mengirim ulang undangan registrasi supplier",
            type: "info",
            confirmButtonColor: "#0479fc",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            closeOnConfirm: false

        }, function (isConfirm) {
            if (!isConfirm)
                return;
            $.ajax({
                url: "<?= base_url('vendor/send_invitation/resend_undangan') ?>/" + $id,
                type: "POST",
                data: $('#form-undangan-ulang').serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.status) //if success close modal and reload ajax table
                    {
                        $('#tbl').DataTable().ajax.reload();
                        swal.close();
                        msg_info('Undangan Berhasil Dikirim Ulang');
                    } else {
                        swal.close();
                        msg_danger('Undangan Gagal Dikirim Ulang!');
                    }
                }
            });
        });
    }
    function start(elmnt)
    {
        var block_ele = elmnt;
        $(block_ele).block({
            message: '<div class="semibold"><span class=" white fa fa-spinner fa-spin fa-3x fa-fw"></span><h2 class="white">&nbsp; Loading ...</h2></div>',
            overlayCSS: {
                backgroundColor: '#0072cf',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'transparent'
            }
        });
        return block_ele;
    }

    function stop(elmnt)
    {
        setTimeout(function () {
            $(elmnt).unblock();
        }, 1200);

    }

    function delete_data($id) {
        swal({
            title: "Apakah Anda yakin?",
            text: "Menghapus Supplier Ini",
            type: "info",
            confirmButtonColor: "#d93d36",
            showCancelButton: true,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            closeOnConfirm: false

        }, function (isConfirm) {
            if (!isConfirm)
                return;
            $.ajax({
                url: "<?= base_url('vendor/send_invitation/delete_data') ?>/" + $id,
                type: "POST",
                data: $('#form-delete_data').serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.status) //if success close modal and reload ajax table
                    {
                        $('#tbl').DataTable().ajax.reload();
                        swal.close();
                        msg_info('Supplier Berhasil Dihapus');
                    } else {
                        swal.close();
                        msg_danger('Supplier Gagal Dihapus!');
                    }
                }
            });
        });
    }



</script>
<!-- <script src="<?php echo base_url() ?>ast11/select2-master/dist/js/select2.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url() ?>ast11/filter/select2.min.js" type="text/javascript"></script>  -->