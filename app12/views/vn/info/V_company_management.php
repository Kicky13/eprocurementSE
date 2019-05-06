<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row company_management">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0"><?= lang("Manajemen Perusahaan", "Company Management") ?></h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=base_url($menu[0][1]['URL']);?>"><?= lang("Dashboard", "Dashboard"); ?></a>
                            </li>
                            <li class="breadcrumb-item active"><?= lang("Manajemen Perusahaan", "Company Management") ?>
                            </li>
                        </ol>
                    </div>
                </div>
                <a href="V_company_management.php"></a>
                <div class="verif_gen"><i class=" fa fa-check success"></i><?= lang(" Data Terverifikasi, Menunggu verifikasi berikutnya", "Data is verified, Waiting for next verification") ?></div>
                <div class="verif_app"><i class=" fa fa-check success"></i><?= lang("Data Telah Terverifikasi, SLKA terbit", "Data is verified, SLKA has been published") ?></div>
                <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Anda ditolak, Mohon perbaiki data anda", "Your Data is rejected, Please update your data ") ?></div>
            </div>
        </div>
        <div class="content-detached content-left">
            <div class="content-body">
                <section id="description">
                    <div class="card">
                        <div class="card-header" id="MANAGEMENT1">
                            <h4 class="card-title"><?= lang("Daftar Dewan Direksi", "Board of Directors List") ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Direksi ditolak", "Board of Directors data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><button aria-expanded="false" onclick="add_data_dewan1()" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table id="dataDewanDireksi" class="table table-striped table-bordered table-hover display" width="100%">
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="description">
                    <div class="card">
                        <div class="card-header" id="MANAGEMENT2">
                            <h4 class="card-title"><?= lang("Daftar Pemilik Saham", "List of Shares Owners") ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Pemilik Saham ditolak", "Shares Owners data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><button aria-expanded="false" onclick="add_data_pemilik_saham()" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table id="databank" class="table table-striped table-bordered table-hover display" width="100%">
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="company_management">
          <?php
          $this->load->view('V_side_menu', $menu);
          ?>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body MANAGEMENT1">
                <form id="form" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                    <div class="form-body">
                        <input name="id" id="id" hidden>
                        <div class="col-12">
                            <div class="form-group row">
                                <label class="col-2 label-control" for="full_name"><?= lang("Nama Lengkap", "Full Name"); ?></label>
                                <div class="col-10">
                                    <input type="text" class="form-control" id="full_name" name="full_name" required="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label class="col-4 label-control" for="email"><?= lang("Jabatan", "Position"); ?></label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 label-control" for="no_tlpn"><?= lang("No. Tlpn", "Phone No"); ?></label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="no_tlpn" name="no_tlpn" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 label-control" for="email"><?= lang("Email", "Email"); ?></label>
                                        <div class="col-8">
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 label-control" for="no_ktp"><?= lang("NIK (KITAS/KIMS)", "NIK (KITAS/KIMS)"); ?></label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="no_ktp" name="no_ktp" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label class="col-4 label-control" for="scan_ktp"><?= lang("Scan KTP", "Scan KTP"); ?></label>
                                        <div class="col-8">
                                            <input type="file" name="scan_ktp" id="scan_ktp" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row valid_until">
                                        <label class="col-4 label-control" for="berlaku_sampai"><?= lang("Berlaku Sampai", "Valid Until"); ?></label>
                                        <div class="col-8">
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="berlaku_sampai" name="berlaku_sampai" value="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 label-control" for="npwp"><span>NPWP</span></label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="npwp" name="npwp" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 label-control" for="datanpwp"><span>Scan NPWP</span></label>
                                        <div class="col-8">
                                            <input type="file" name="datanpwp" id="datanpwp" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class=" col-12 text-right">
                        <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                        <button type="submit" id="save" style="width:115px" class="btn btn-primary add"><?= lang("Tambah data", "Save data") ?></button>
                        <button type="submit" name="keys" value="0" style="width:115px" class="btn btn-primary update"><?= lang("Perbarui data", "Update data") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" data-backdrop="static" id="tampil" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content MANAGEMENT2">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="pemilik_saham_form" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                <div class="modal-body">
                    <div class="row">
                        <input name="id" id="id" hidden>
                        <div class="col-md-12">
                            <div class="form-group row owner_of_shares">
                                <label class="col-sm-2 label-control " for="saham"><?= lang("Pemilik Saham", "Owner of Shares"); ?></label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="saham" name="saham" required="true">
                                        <?= langoption("MAIN OFFICE", "HEADQUARTERS"); ?>
                                        <?= langoption("BRANCH OFFICE", "BRANCH OFFICE"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 label-control" for="nama_lengkap"><?= lang("Nama Lengkap", "Full Name"); ?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required="true">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 label-control" for="tlpn"><?= lang("No. Tlpn", "Phone No"); ?></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="tlpn" name="tlpn" required="true">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 label-control" for="alamatemail"><?= lang("Email", "Email"); ?></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="alamatemail" name="alamatemail" required="true">
                                </div>
                            </div>
                            <div class="form-group row valid_until">
                                <label class="col-sm-4 label-control" for="belaku_sampai"><?= lang("Berlaku Sampai", "Valid Until"); ?></label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="berlaku_sampai2" name="berlaku_sampai" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-4 label-control" for="nonpwp"><span>NPWP</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nonpwp" name="nonpwp" required="true">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 label-control" for="npwpfile"><span>Scan NPWP</span></label>
                                <div class="col-sm-8">
                                    <input type="file" name="npwpfile" id="npwpfile" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class=" col-sm-12 text-right">
                        <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                        <button type="submit" id="save" value="0" style="width:115px" class="btn btn-primary add"><?= lang("Simpan data", "Save data") ?></button>
                        <button type="submit" name="keys" value="0" style="width:115px" class="btn btn-primary update"><?= lang("Perbarui data", "Update data") ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal_ref" class="modal fade bs-example-modal-xl" role="dialog"  >
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

<script>
    $(document).ready(function () {
        $('.input-group.date').datetimepicker({
            format: 'DD-MM-YYYY'
        });
        $(".owner_of_shares").hide();
        $(".valid_until").hide();
        $('#form').validate({
            focusInvalid: false,
            rules: {
                full_name: {required: true, maxlength: 50},
                jabatan: {required: true, maxlength: 30},
                no_telp: {required: true, number: true, maxlength: 30},
                email: {required: true, email: true, maxlength: 50},
                no_ktp: {required: true, number: true, maxlength: 60},
                berlaku_sampai: {required: true},
                npwp: {required: false, maxlength: 50}
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
                var formData = new FormData($('#form')[0]);
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('vn/info/Company_management/change_company_management') ?>',
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (m) {
                        stop(elm);
                        if (m.status != 'Error') {
                            $('#modal').modal('hide');
                            $('#dataDewanDireksi').DataTable().ajax.reload();
                            msg_info(m.status, m.msg);
                        } else {
                            msg_danger(m.status, m.msg);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Error", "Oops,Terjadi Kesalahan");
                    }
                });

            }
        });
        $('#pemilik_saham_form').validate({
            focusInvalid: false,
            rules: {
                nama_lengkap: {required: true, maxlength: 50},
                tlpn: {required: true, number: true, maxlength: 30},
                alamatemail: {required: true, email: true, maxlength: 50},
                berlaku_sampai: {required: true},
                saham: {required: true},
                nonpwp: {required: false, maxlength: 50}
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
            }, success: function (label, element) {
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-error').addClass('has-success');
                label.parent().removeClass('error');
                label.remove();
            },
            submitHandler: function (form)
            {
                var elm = start($('#tampil').find('.modal-content'));
                var formData = new FormData($('#pemilik_saham_form')[0]);
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('vn/info/Company_management/change_vendor_shareholders') ?>',
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (m) {
                        stop(elm);
                        if (m.status !== 'Error') {
                            $('#tampil').modal('hide');
                            $('#databank').DataTable().ajax.reload();
                            msg_info(m.status, m.msg);
                        } else {
                            msg_danger(m.status, m.msg);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Error", "Oops,Terjadi Kesalahan");
                    }
                });
            }
        });

        $('#dataDewanDireksi').DataTable({
            ajax: {
                url: '<?= base_url('vn/info/Company_management/show_company_management') ?>',
                dataSrc: ''
            },
            "scrollX": true,
            //            "scrollY": '300px',
            "scrollCollapse": true,
            "paging": false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            columns: [
                {title: "<center><span>No.</span></center>"},
                {title: "<center><?= lang("Nama Lengkap (Sesuai KTP)", "Full Name (As per ID)") ?></center>"},
                {title: "<center><?= lang("Jabatan", "Position") ?></center>"},
                {title: "<center><?= lang("Nomor Telepon", "Phone number") ?></center>"},
                {title: "<center><?= lang("Email", "Email") ?></center>"},
                {title: "<center><?= lang("Nomor KTP", "NIK (KITAS/KIMS)") ?></center>"},
                {title: "<center><?= lang("Scan KTP", "Scan KTP") ?></center>"},
                {title: "<center><?= lang("NPWP", "NPWP") ?></center>"},
                {title: "<center><?= lang("Scan NPWP", "Scan NPWP") ?></center>"},
                {title: "<center><?= lang("&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp") ?></center>"}
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
                {"className": "dt-center", "targets": [9]},
            ],
        });
        $('#dataDewanDireksi').DataTable().columns.adjust().draw();
        $('#databank').DataTable({
            ajax: {
                url: '<?= base_url('vn/info/Company_management/show_vendor_shareholders') ?>',
                dataSrc: ''
            },
            "paging": false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            columns: [
                {title: "<span>No.</span>"},
                /*{title: "<?= lang("Tipe Pemilik Saham", "Share Owner Type") ?>"},*/
                {title: "<?= lang("Nama Lengkap", "Full name") ?>"},
                {title: "<?= lang("Nomor Telepon", "Phone number") ?>"},
                {title: "<?= lang("Email", "Email") ?>"},
                {title: "<?= lang("NPWP", "NPWP") ?>"},
                {title: "<?= lang("Scan NPWP", "Scan NPWP") ?>"},
                {title: "<?= lang("&nbsp&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp&nbsp&nbsp") ?>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                /*{"className": "dt-center", "targets": [1]},*/
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]},
            ],
            "scrollX": true,
            //            "scrollY": '300px',
            "scrollCollapse": true
        });
        lang();
    });

    function update1(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('vn/info/Company_management/get_company_management/') ?>' + id,
            success: function (msg) {
                $('#modal .modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#id').val(d.ID);
                $('#full_name').val(d.NAME);
                $('#jabatan').val(d.POSITION);
                $('#no_tlpn').val(d.PHONE);
                $('#email').val(d.EMAIL);
                $('#no_ktp').val(d.NO_ID);
                //$('#scan_ktp').val(d.FILE_NO_ID);
                $('#berlaku_sampai').val(d.VALID_UNTIL);
                $('#npwp').val(d.NPWP);
                //$('#filenpwp').val(d.FILE_NPWP);
                $('.update').show();
                $('.add').hide();
                $('.file').show();
                $('#modal').modal('show');
                lang();
            }
        });
    }
    lang();


    function add_data_dewan1() {
        document.getElementById("form").reset();
        $('#modal .modal-title').html("<?= lang("Tambah Data Dewan", "Add Director") ?>");
        $('.add').show();
        $('.update').hide();
        $('.file').hide();
        $('#modal').modal('show');
        $('#id').val("");
        $('#dataDewanDireksi').DataTable().columns.adjust().draw();
        lang();
    }

    function delete_data(id)
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
            CancelButtonColor: "#d93d36",
            confirmButtonColor: "#d93d36",
            confirmButtonText: "Ya, hapus",
            closeOnConfirm: false
        }, function () {
            msg_info('Proses', "Data Sedang dihapus");
            var obj = {};
            obj ['ID'] = id;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/Company_management/delete_data/'); ?>" + id, data: obj,
                cache: false,
                success: function (res)
                {
                    if (res == true)
                    {
                        $('#dataDewanDireksi').DataTable().ajax.reload();

                        swal("Data Berhasil dihapus", "", "success");
                    } else {

                        swal("Data gagal dihapus", "", "failed");
                    }
                }
            });
        });
    }

    //-----------------------------------------------------------------------------------------------//

    function add_data_pemilik_saham() {
        document.getElementById("pemilik_saham_form").reset();
        $('#tampil .modal-title').html("<?= lang("Tambah Data Pemilik Saham", "Add Owner Shares Data") ?>");
        $('.add').show();
        $('.update').hide();
        $('#tampil').modal('show');
        $('#id').val("");
        lang();
    }

    function update_shareholders(id) {
        $.ajax({
            type: 'POST',
            url: '<?= site_url('vn/info/Company_management/get_vendor_shareholders/') ?>' + id,
            success: function (msg) {
                $('#tampil .modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#pemilik_saham_form ,#id').val(d.ID);
                $('#saham').val(d.TYPE);
                $('#nama_lengkap').val(d.NAME);
                $('#tlpn').val(d.PHONE);
                $('#alamatemail').val(d.EMAIL);
                $('#berlaku_sampai2').val(d.VALID_UNTIL);
                $('#nonpwp').val(d.NPWP);
                //$('#scan_npwp').val(d.FILE_NPWP);
                $('.update').show();
                $('.add').hide();
                $('#tampil').modal('show');
                lang();
            }
        });

    }

    function hapus_data(id)
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
            CancelButtonColor: "#d93d36",
            confirmButtonColor: "#d93d36",
            confirmButtonText: "Ya, hapus",
            closeOnConfirm: false
        }, function () {
            msg_info('Proses', "Data Sedang dihapus");
            var obj = {};
            obj ['ID'] = id;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/Company_management/hapus_data/'); ?>" + id,
                data: obj,
                cache: false,
                success: function (res)
                {
                    if (res == true)
                    {
                        $('#databank').DataTable().ajax.reload();
                        swal("Data Berhasil dihapus", "", "success");
                    } else {
                        swal("Data gagal dihapus", "", "failed");
                    }
                }
            });
        });
    }

    function review_gambar(data)
    {
        //$('.modal-title').html("Priview File") ?>");
        $('#ref').attr('src', data);
        $('#modal_ref').modal('show');
    }
</script>
