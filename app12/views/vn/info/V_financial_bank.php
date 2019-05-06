<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0"><?= lang("Data Bank dan Keuangan", "Bank and Financial Data") ?></h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=base_url($menu[0][1]['URL']);?>"><?= lang("Dashboard", "Dashboard"); ?></a>
                            </li>
                            <li class="breadcrumb-item active"><?= lang("Data Bank dan Keuangan", "Bank and Financial Data") ?>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="verif_gen"><i class=" fa fa-check success"></i><?= lang(" Data Terverifikasi, Menunggu verifikasi berikutnya", "Data is verified, Waiting for next verification") ?></div>
                <div class="verif_app"><i class=" fa fa-check success"></i><?= lang("Data Telah Terverifikasi, SLKA terbit", "Data is verified, SLKA has been published") ?></div>
                <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Anda ditolak, Mohon perbaiki data anda", "Your Data is rejected, Please update your data ") ?></div>
            </div>
        </div>
        <div class="content-detached content-left">
            <div class="content-body">
                <section id="description">
                    <div class="card">
                        <div class="card-header" id="BNF1">
                            <h4 class="card-title"><?= lang("Neraca Keuangan", "Balance Sheet") ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Neraca Keuangan ditolak", "Balance Sheet data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><button aria-expanded="false" onclick="add_tambah_bank()" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table id="databank1" class="table table-striped table-bordered table-hover display" width="100%">
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="description">
                    <div class="card">
                        <div class="card-header" id="BNF2">
                            <h4 class="card-title"><?= lang("Daftar Rekening Bank", "Bank Account List") ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Rekening Bank ditolak", "Bank Account data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><button aria-expanded="false" onclick="daftar_rekening_bank()" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table id="databank2" class="table table-striped table-bordered table-hover display" width="100%">
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="description">
                    <div class="card">
                        <div class="card-header" id="CNE2">
                            <h4 class="card-title"><?= lang("Pengalaman Perusahaan", "Company Experience") ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Pengalaman Umum ditolak", "Company Experience data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><button id="modal2" aria-expanded="false" class="btn btn-outline-primary" onclick="add_tambah_kontak()" id="keys1"  ><i class="ft-plus-circle"></i><?= lang("Tambah Data", "Add Data") ?></button>
                                    </li>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-content">
                            <div class="card-body">

                                <table id="tabel_pengalaman" name="tabel_pengalaman" class="table table-striped table-bordered table-hover display" width="100%">
                                    <thead>
                                        <tr>
                                            <th><span>No.</span></th>
                                            <th><?= lang("Nama Pelanggan", "Customers Name") ?></th>
                                            <th><?= lang("Nama Projek", "Project Name") ?></th>
                                            <th><?= lang("Projek Description", "Project Description") ?></th>
                                            <th><?= lang("Nilai Project", "Project Value") ?></th>
                                            <th><?= lang("No. Kontrak", "Contract Number") ?></th>
                                            <th><?= lang("Tanggal Mulai", "Start Date") ?></th>
                                            <th><?= lang("Tanggal Selesai", "Finish Date") ?></th>
                                            <th><?= lang("Contact Person", "Contact Person") ?></th>
                                            <th><?= lang("No. Tlpn", "No. Tlpn") ?></th>
                                            <th><?= lang("&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbspAction&nbsp&nbsp") ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php
        $this->load->view('V_side_menu', $menu);
        ?>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" data-backdrop="static" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang("Tambah Data Neraca Keuangan", "Add Financial Balance Data") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body BNF1">
                <form id="bank_data" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 control-label " for="tahun"><?= lang("Tahun Laporan", "Report Year "); ?></label>
                                    <div class="col-8">
                                        <div class="input-group datetahun_laporan">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="tahun_laporan" name="tahun_laporan" value="<?php echo date("Y"); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="hp"><?= lang("Jenis Laporan", "Report Type") ?></label>
                                    <div class="col-8">
                                        <select class="form-control" id="jenis_laporan" name="jenis_laporan" tabindex="2">
                                            <?php
                                            foreach ($lpn as $k => $v) {
                                                if ($v->BALANCE_SHEET_TYPE != "")
                                                    echo '<option class="form-control" value="' . $v->BALANCE_SHEET_TYPE . '">' . $v->BALANCE_SHEET_TYPE . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="valuta"><?= lang("Valuta", "Valuta"); ?></label>
                                    <div class="col-8">
                                        <select class="form-control" id="valuta" name="valuta" tabindex="2">
                                            <?php
                                            foreach ($crn as $k => $v) {
                                                if ($v->CURRENCY != "")
                                                    echo '<option class="form-control" value="' . $v->CURRENCY . '">' . $v->CURRENCY . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="nilai_aset"><?= lang("Nilai Aset", "Asset Value"); ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control m-b" id="nilai_aset" name="nilai_aset" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="hutang"><span><?= lang("Hutang", "Debt") ?></span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="hutang" name="hutang" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="pend_kotor"><?= lang("Pendapatan Kotor", "Gross Income") ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="pend_kotor" name="pend_kotor" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="laba_bersih"><span><?= lang("Labah Bersih", "Net Income") ?></span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="laba_bersih" name="laba_bersih" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="hutang"><?= lang("File Neraca Keuangan", "Financial Balance File") ?></label>
                                    <div class="col-8">
                                        <input type="file" name="file_bank" id="file_bank" class="form-control">
                                        <input type="text" name="keys_update" id="keys_update" style="display:none" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-12 text-right">
                            <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                            <button type="submit" id="btn_update" name="btn_update" style="width:115px" class="btn btn-primary update"><?= lang("Perbarui data", "Update data") ?></button>
                            <button type="submit" id="keys1" name="keys1" value="0" style="width:115px" class="btn btn-primary add"><?= lang("Tambah data", "Update data") ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg modal2" data-backdrop="static" id="" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang("Tambah Daftar Rekening Bank", "Tambah Finance and Bank Data ") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body BNF2">
                <form id="daftar_rekening" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 label-control " for="tahun"><?= lang("Nama Bank", "Bank Name "); ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control m-b" id="bank_name" name="bank_name" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="hp"><?= lang("Alamat", "Address") ?></label>
                                    <div class="col-8">
                                        <input type="text" name="address" id="address" class="form-control" rows="3" required="required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="branch"><?= lang("Cabang", "Branch"); ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control m-b" id="branch" name="branch" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 label-control" for="nilai_aset"><?= lang("Nomor Rekening", "Account Number"); ?></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control m-b" id="acc_num" name="acc_num" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="hutang"><span><?= lang("Nama Akun", "Name") ?></span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="name" name="name" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="currency"><?= lang("Mata Uang", "Currency") ?></label>
                                    <div class="col-8">
                                        <select class="form-control" id="currency" name="currency" tabindex="2">
                                            <?php
                                                foreach ($crn as $k => $v) {
                                                if ($v->CURRENCY != "")
                                                    echo '<option class="form-control" value="' . $v->CURRENCY . '">' . $v->CURRENCY . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="hutang"><?= lang("Scan Buku Tabungan", "File Scan") ?></label>
                                    <div class="col-8">
                                        <input type="file" name="file_scan" id="file_scan" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-sm-12 text-right">
                        <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                        <button type="submit" id="keys1" name="keys" value="0" style="width:115px" class="btn btn-primary"><?= lang("Tambah data", "Save data") ?></button>
                        <button type="submit" id="update_keys1" name="update_keys1" value="0" style="width:115px" class="btn btn-primary"><?= lang("Perbarui data", "Update data") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal_ref" class="modal fade bs-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title">Preview File</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <iframe
                    id="ref"
                    style="width:100%; height:600px;" frameborder="0">
                </iframe>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('vn/info/V_certification_experience'); ?>
<script>
    $(document).ready(function () {
      $(".Certification_experience").hide();
        $('.input-group.date').datetimepicker({
            format: 'YYYY'
        });
        $('.input-group.datetahun_laporan').datetimepicker({
            viewMode: 'years',
            format: 'YYYY'
        });
        $('#bank_data').validate({
            focusInvalid: false,
            rules: {
                tahun_laporan: {required: true},
                jenis_laporan: {required: true},
                valuta: {required: true},
                nilai_aset: {required: true, number: true, maxlength: 100},
                hutang: {required: true, number: true, maxlength: 100},
                pend_kotor: {required: true, number: true, maxlength: 100},
                laba_bersih: {required: true, number: true, maxlength: 100},
            },
            errorPlacement: function (label, element) { // render error placement for each input type
                var elmnt = element[0].id;
                if ((elmnt !== "pengesahan") && (elmnt !== "tanggal_akta") && (elmnt !== "berita"))
                    $('<span class="error"></span>').insertAfter(element).append(label)
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },
            highlight: function (element) { // hightlight error inputs
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },
            success: function (label, element) {
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-error').addClass('has-success');
                label.parent().removeClass('error');
                label.remove();
            },
            submitHandler: function (form)
            {
                var elm = start($('#modal').find('.modal-content'));
                msg_default("Info", "Data dalam proses upload");
                var formData = new FormData($('#bank_data')[0]);
                formData.append('keys_update', $('#keys_update').val());
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('vn/info/financial_bank_data/add_data_bank') ?>',
                    data: formData,
                    cache: "false",
                    processData: false,
                    contentType: false,
                    success: function (m)
                    {
                        stop(elm);
                        if (m.status != 'Error') {
                            $('#modal').modal('hide');
                            $('#databank1').DataTable().ajax.reload();
                            msg_info('Success', m.msg);
                            $('#databank1').DataTable().columns.adjust().draw();
                        } else {
                            msg_danger('Error', m.msg);
                        }
                    }
                });
            }
        });
        var tabel = $('#databank1').DataTable({
            ajax: {
                url: '<?= base_url('vn/info/Financial_bank_data/show_financial_bank_data') ?>',
                dataSrc: ''
            },
            "scrollX": true,
            "scrollY": '300px',
            "scrollCollapse": true,
            "paging": false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            "columns": [
                {title: "<center><span>No.</span></center>"},
                {title: "<center><?= lang("Tahun Laporan", "Report Year") ?></center>"},
                {title: "<center><?= lang("Jenis Laporan", "Report Type") ?></center>"},
                {title: "<center><?= lang("Valuta", "Valuta") ?></center>"},
                {title: "<center><?= lang("Nilai Asset", "Asset Value") ?></center>"},
                {title: "<center><?= lang("Hutang", "Debt") ?></center>"},
                {title: "<center><?= lang("Pendapatan Kotor", "Gross Income") ?></center>"},
                {title: "<center><?= lang("Labah Bersih", "Clean Laba") ?></center>"},
                {title: "<center><?= lang("File", "File") ?></center>"},
                {title: "<center><?= lang("&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp") ?></center>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]},
                {"className": "dt-center", "targets": [7]},
                {"className": "dt-center", "targets": [8]},
                {"className": "dt-center", "targets": [9]}],
        });
        lang();
        $('#databank1 tbody').on('click', 'tr .update-finance', function () {
            var data2 = tabel.row($(this).parents('tr')).data();
            document.getElementById("bank_data").reset();
            $('#bank_data #tahun_laporan').val(data2[1]);
            $('#bank_data #jenis_laporan').val(data2[2]);
            $('#bank_data #valuta').val(data2[3]);
            $('#bank_data #nilai_aset').val(data2[4]);
            $('#bank_data #hutang').val(data2[5]);
            $('#bank_data #pend_kotor').val(data2[6]);
            $('#bank_data #laba_bersih').val(data2[7]);
            $('#keys_update').val(this.id);
            $('.modal-title').html("<?= lang("Perbarui Data Neraca Keuangan", "Update Neraca Data") ?>");
            $('.add').hide();
            $('#btn_update').show();
            $('#modal').modal('show');
            lang();
        });
        $('#daftar_rekening').validate({
            focusInvalid: false,
            rules: {
                bank_name: {required: true},
                address: {required: false, maxlength: 100},
                branch: {required: true},
                acc_num: {required: true, number: true},
                name: {required: true, maxlength: 60},
                currency: {required: true},
            },
            errorPlacement: function (label, element) { // render error placement for each input type
                var elmnt = element[0].id;
                if ((elmnt !== "pengesahan") && (elmnt !== "tanggal_akta") && (elmnt !== "berita"))
                    $('<span class="error"></span>').insertAfter(element).append(label)
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },
            highlight: function (element) { // hightlight error inputs
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },
            success: function (label, element) {
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-error').addClass('has-success');
                label.parent().removeClass('error');
                label.remove();
            },
            submitHandler: function (form)
            {
                var elm = start($('.modal2').find('.modal-content'));
                msg_default("Info", "Data dalam proses upload");
                var formData = new FormData($('#daftar_rekening')[0]);
                formData.append('update_keys1', $('#update_keys1').val());
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('vn/info/financial_bank_data/add_data_account') ?>',
                    data: formData,
                    cache: "false",
                    processData: false,
                    contentType: false,
                    success: function (m)
                    {
                        stop(elm);
                        if (m.status != 'Error') {
                            $('.modal2').modal('hide');
                            $('#databank2').DataTable().ajax.reload();
                            $('#databank2').DataTable().columns.adjust().draw();
                            msg_info('Success', m.msg);
                        } else {
                            msg_danger('Error', m.msg);
                        }
                    }
                });
            }
        });
        var tabel2 = $('#databank2').DataTable({
            ajax: {
                url: '<?= base_url('vn/info/Financial_bank_data/show_vendor_bank_account') ?>',
                dataSrc: ''
            },
            "paging": false,
            "scrollX": true,
            "scrollY": '300px',
            "scrollCollapse": true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            "columns": [
                {title: "<span>No.</span>"},
                {title: "<?= lang("Bank", "Bank") ?>"},
                {title: "<?= lang("Alamat", "Address") ?>"},
                {title: "<?= lang("Cabang", "Branch") ?>"},
                {title: "<?= lang("Nomor. Rekening", "Account No") ?>"},
                {title: "<?= lang("Nama Akun", "Account Name") ?>"},
                {title: "<?= lang("Mata Uang", "Currency") ?>"},
                {title: "<?= lang("File", "File") ?>"},
                {title: "<?= lang("&nbsp&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp&nbsp&nbsp") ?>"},
            ],
            "columnDefs": [
                {"className": "dt-right", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]},
                {"className": "dt-center", "targets": [7]},
                {"className": "dt-center", "targets": [8]},
            ],
        });
        lang();
        $('.modal2').modal('hide');
        $('#databank2 tbody').on('click', 'tr .update', function () {
          var btn_id = $(".update").data("id");
            var data2 = tabel2.row($(this).parents('tr')).data();
            $('.modal2 #bank_name').val(data2[1]);
            $('.modal2 #address').val(data2[2]);
            $('.modal2 #branch').val(data2[3]);
            $('.modal2 #acc_num').val(data2[4]);
            $('.modal2 #name').val(data2[5]);
            $('.modal2 #currency').val(data2[6]);
            $('.modal2 #update_keys1').val(this.id);
            $('.modal2 #update_keys1').show();
            $('.modal2 #keys1').hide();
            $('.modal2 .modal-title').html("<?= lang("Perbarui Daftar Rekening Bank", "Update Bank Account List") ?>");
            lang();
            $('.modal2').modal('show');
        });
    });
    function add_tambah_bank() {
        document.getElementById("bank_data").reset();
        $('.modal-title').html("<?= lang("Tambah Data Neraca Keuangan", "Add Balance Sheet") ?>");
        $('.add').show();
        $('#btn_update').hide();
        $('#modal').modal('show');
        lang();
    }

    function update(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('vn/info/financial_bank_data/get_financial_bank_data/') ?>' + id,
            success: function (msg) {
                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#id').val(d.ID);
                $('#tahun_laporan').val(d.YEAR);
                $('#jenis_laporan').val(d.TYPE);
                $('#valuta').val(d.CURRENCY);
                $('#nilai_aset').val(d.ASSET_VALUE);
                $('#hutang').val(d.DEBT);
                $('#pend_kotor').val(d.BRUTO);
                $('#laba_bersih').val(d.NETTO);
                $('#file_bank').val(d.FILE_URL);
                $('#btn_update').show();
                $('.add').hide();
                $('#modal').modal('show');
                lang();
            }
        });
    }

    function daftar_rekening_bank() {
        document.getElementById("daftar_rekening").reset();
        $('.modal2 .modal-title').html("<?= lang("Tambah Daftar Rekening Bank", "Add Bank Account") ?>");
        $('.modal2 #keys1').show();
        $('.modal2 #update_keys1').hide();
        $("#update_keys1").val('0');
        $('.modal2').modal('show');
        lang();
    }

    function update2(id)
    {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('vn/info/financial_bank_data/get_vendor_bank_account/') ?>' + id,
            success: function (msg) {
                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#id').val(d.ID);
                $('#tahun_laporan').val(d.NAMA_BANK);
                $('#jenis_laporan').val(d.CABANG);
                $('#valuta').val(d.ALAMAT);
                $('#nilai_aset').val(d.NOREK);
                $('#hutang').val(d.ATAS_NAMA);
                $('#pend_kotor').val(d.CURRENCY);
                $('#btn_update').show();
                $('.add').hide();
                $('#modal2').modal('show');
                lang();
            }
        });
    }
    function modal()
    {
        $('#keys1').show();
        $('#btn_update').hide();
        $('#modal').modal('show');
    }

    function review_akta(data)
    {
        $('#ref').attr('src', data);
        $('#modal_ref').modal('show');
        $('#modal_ref .modal-title').html("Preview File");

    }

    function delete_acc(key)
    {
        var disb =<?php echo isset($all[0]->STATUS) ? $all[0]->STATUS : 0 ?>;
        if (disb == 5)
        {
            return;
        }
        swal({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus data ini",
            type: "warning",
            showCancelButton: true,
            CancelButtonColor: "#DD6B55",
            confirmButtonColor: "#d9534f",
            confirmButtonText: "Ya, hapus",
            closeOnConfirm: false
        }, function () {
            msg_default('Processing', "Data is being delete");
            var obj;
            obj = {
                KEYS: key,
            }
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/financial_bank_data/delete_data_acc'); ?>",
                data: obj,
                cache: false,
                success: function (res)
                {
                    if (res == true)
                    {
                        $('#databank2').DataTable().ajax.reload();
                        swal("Data Berhasil dihapus", "", "success");
                    } else {
                        swal("Data Gagal dihapus", "", "failed");
                    }
                }
            });
        });
    }

    function delete_bank(key)
    {
        var disb =<?php echo isset($all[0]->STATUS) ? $all[0]->STATUS : 0 ?>;
        if (disb == 5)
        {
            return;
        }
        swal({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus data ini",
            type: "warning",
            showCancelButton: true,
            CancelButtonColor: "#DD6B55",
            confirmButtonColor: "#d9534f",
            confirmButtonText: "Ya, hapus",
            closeOnConfirm: false
        }, function () {
            msg_default('Processing', "Data is being delete");
            var obj;
            obj = {
                KEYS: key,
            }
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/financial_bank_data/delete_data_bank'); ?>",
                data: obj,
                cache: false,
                success: function (res)
                {
                    if (res == true)
                    {
                        $('#databank1').DataTable().ajax.reload();
                        swal("Data Berhasil dihapus", "", "success");
                    } else {
                        swal("Data Gagal dihapus", "", "failed");
                    }
                }
            });
        });
    }
</script>
