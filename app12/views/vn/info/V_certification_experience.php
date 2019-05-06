<?php
function date_mdy($data){
  return date('d-m-Y', strtotime($data));
}
$date = date('d-m-Y');
$tomorrow = date('d-m-Y',strtotime($date . "+1 days"));
 ?>
<div class="app-content content Certification_experience">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0"><?= lang("Sertifikat dan Pengalaman", "Certification and Experience") ?></h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=base_url($menu[0][1]['URL']);?>"><?= lang("Dashboard", "Dashboard"); ?></a>
                            </li>
                            <li class="breadcrumb-item active"><?= lang("Sertifikat dan Pengalaman", "Certification and Experience") ?>
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
                        <div class="card-header" id="CNE1">
                            <h4 class="card-title"><?= lang("Sertifikasi Umum", "General Certification") ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Sertifikasi Umum ditolak", "General Certification data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><button id="modal1" aria-expanded="false" class="btn btn-outline-primary" id="keys1"  ><i class="ft-plus-circle"></i><?= lang("Tambah Data", "Add Data") ?></button>
                                    </li>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>

                        </div>

                        <div class="card-content">
                            <div class="card-body">

                                <table id="tabel_sertifikat" name="tabel_sertifikat" class="table table-striped table-bordered table-hover display" width="100%">
                                    <thead>
                                        <tr>
                                            <th><span>No.</span></th>
                                            <th><?= lang("Jenis Sertifikasi", "Certification Type") ?></th>
                                            <th><?= lang("Nama Sertifikasi", "Certification Name") ?></th>
                                            <th><?= lang("No. Sertifikasi", "Number Certification") ?></th>
                                            <th><?= lang("Dikeluarkan Oleh", "Issued By") ?></th>
                                            <th><?= lang("Berlaku Mulai", "Apply Start") ?></th>
                                            <th><?= lang("Berlaku Sampai", "Apply End") ?></th>
                                            <th><?= lang("File", "File") ?></th>
                                            <th><?= lang("&nbsp&nbspAksi&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp&nbspAction&nbsp&nbsp") ?></th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>
                        </div>
                    </div>
                </section>



                <section id="bpjs">
                    <div class="card">
                        <div class="card-header" id="BPJS">
                            <h4 class="card-title">BPJS Kesehatan</h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Info Perusahaan ditolak", "BPJS data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <?php
                                    // echopre($BPJS->FILE_URL);
                                    if (isset($BPJS->FILE_URL)) {
                                        echo lang("Lihat File", "Preview File");
                                        echo '
                                    <li><div class="col-4">
                                    <a class="btn btn-outline-success" title="Lihat File" onclick=review("BPJS")><i class="fa fa-file-o"></i></a>
                                    </div></li>';
                                    }
                                    ?>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content BPJS">
                            <div class="card-body">
                              <form id="bpjs_form" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                                <input type="hidden" class="form-control" id="doc_id" name="doc_id" value="<?php echo(isset($BPJS->ID) != false ? $BPJS->ID : '') ?>">
                                <input type="hidden" class="form-control" id="doc_type" name="doc_type" value="BPJS">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                          <label class="col-sm-2 control-label" for="nomor_doc"><?= lang("Nomor", "Document Number") ?></label>
                                          <div class="col-sm-4">
                                              <input type="text" class="form-control" id="nomor_doc" name="nomor_doc" value="<?php echo(isset($BPJS->NO_DOC) != false ? $BPJS->NO_DOC : '') ?>">
                                          </div>
                                            <label class="col-sm-2 control-label" for="file_doc"><?= lang("Berkas", "File Attachment"); ?></label>
                                            <div class="col-sm-4">
                                                <input type="file" name="file_doc" id="file_doc" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 control-label" for="issued_date_doc"><?= lang("Valid Sejak", "Issued Date"); ?></label>
                                            <div class="col-sm-4">
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="issued_date_doc" value="<?php echo(isset($BPJS->VALID_SINCE) != false ? date_mdy($BPJS->VALID_SINCE) : '') ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="text-center">
                                    <button type="submit" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Simpan data", "Save Data") ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                  </div>
                </section>

                <section id="bpjs_tk">
                    <div class="card">
                        <div class="card-header" id="BPJSTK">
                            <h4 class="card-title">BPJS Ketenagakerjaan</h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Info Perusahaan ditolak", "BPJS Ketenagakerjaan data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <?php
                                    // echopre($BPJS->FILE_URL);
                                    if (isset($BPJSTK->FILE_URL)) {
                                        echo lang("Lihat File", "Preview File");
                                        echo '
                                    <li><div class="col-4">
                                    <a class="btn btn-outline-success" title="Lihat File" onclick=review("BPJSTK")><i class="fa fa-file-o"></i></a>
                                    </div></li>';
                                    }
                                    ?>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content BPJSTK">
                            <div class="card-body">
                              <form id="bpjstk_form" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                                <input type="hidden" class="form-control" id="doc_id" name="doc_id" value="<?php echo(isset($BPJSTK->ID) != false ? $BPJSTK->ID : '') ?>">
                                <input type="hidden" class="form-control" id="doc_type" name="doc_type" value="BPJSTK">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                          <label class="col-sm-2 control-label" for="nomor_doc"><?= lang("Nomor", "Document Number") ?></label>
                                          <div class="col-sm-4">
                                              <input type="text" class="form-control" id="nomor_doc" name="nomor_doc" value="<?php echo(isset($BPJSTK->NO_DOC) != false ? $BPJSTK->NO_DOC : '') ?>">
                                          </div>
                                            <label class="col-sm-2 control-label" for="file_doc"><?= lang("Berkas", "File Attachment"); ?></label>
                                            <div class="col-sm-4">
                                                <input type="file" name="file_doc" id="file_doc" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <label class="col-sm-2 control-label" for="issued_date_doc"><?= lang("Valid Sejak", "Issued Date"); ?></label>
                                            <div class="col-sm-4">
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="issued_date_doc" value="<?php echo(isset($BPJSTK->VALID_SINCE) != false ? date_mdy($BPJSTK->VALID_SINCE) : '') ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="text-center">
                                    <button type="submit" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Simpan data", "Save Data") ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                  </div>
                </section>
            </div>
        </div>
    </div>
    <?php
    $this->load->view('V_side_menu', $menu);
    ?>
</div>

<!--/////////////////  MODAL /////////////////-->
<!--sertifikasi perusahaan-->
<div class="modal fade text-left" id="modal_sertifikasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body col-12 CNE1">
                <form id="form_add" class="form" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="hp"><?= lang("Jenis Sertifikasi", "Certification Type") ?></label>
                                    <div class="col-8">
                                        <select class="form-control" id="ftype_sertifikasi" name="ftype_sertifikasi" tabindex="2">
                                            <?php
                                                foreach ($certificate_type as $k => $v) {
                                                    echo "<option value='$v->LEGAL_OTHER_TYPE'>$v->DESCRIPTION_IND</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="valuta"><?= lang("Nama Sertifikasi", "Certification Name") ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control m-b" id="name" name="name" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="valuta"><?= lang("No. Sertifikasi", "Number Certification") ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control m-b" id="number" name="number" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="valuta"><?= lang("Dikeluarkan Oleh", "Issued By") ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control m-b" id="issued" name="issued" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 control-label " for="tahun"><?= lang("Berlaku Mulai", "Apply Start") ?></label>
                                    <div class="col-8">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="start_apply" class="form-control" name="start_apply" value="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="pend_kotor"><?= lang("Berlaku Sampai", "Apply End") ?></label>
                                    <div class="col-8">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="start_end" class="form-control" name="start_end" value="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="hutang"><?= lang("File Doc.", "Doc. File") ?></label>
                                    <div class="col-8">
                                        <input type="file"  id="file_ebtke" name="file_ebtke" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-sm-12 text-right">
                        <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                        <button type="submit" id="keys_update" name="keys1" value="0" style="width:115px" class="ladda-button ladda-button btn btn-primary"  data-style="zoom-in"><?= lang("Perbarui data", "Update Data") ?></button>
                        <button type="submit" id="add" name="keys" value="0" style="width:115px" class="ladda-button ladda-button btn btn-primary"  data-style="zoom-in"><?= lang("Tambah data", "Add Data") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--pengalaman-->
<div class="modal fade text-left" id="modal_pengalaman" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content CNE2">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form id="form_add2" name="form_add2" class="form-horizontal" enctype="multipart/form-data" action="javascript:;" novalidate="novalidate">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group row">
                                <label class="col-4 control-label" for="hp"><?= lang("Nama Pelanggan", "Customers Name") ?></label>
                                <div class="col-8">
                                    <input type="text" class="form-control m-b" id="custumer" name="custumer" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 control-label" for="valuta"><?= lang("Nama Projek", "Project Name") ?></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control m-b" id="project" name="project" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-4 control-label" for="valuta"><?= lang("No. Kontrak", "Contract Number") ?></label>
                                <div class="col-8">
                                    <input type="text" class="form-control m-b" id="no_contract" name="no_contract" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-4 control-label" for="mata_uang"><?= lang("Nilai Project", "Project Value") ?></label>
                                <div class="col-4">
                                    <select class="form-control" id="currency" name="currency" tabindex="2">
                                        <?php
                                        foreach ($currency as $k => $v) {
                                            # code...
                                            echo "<option value='$v->CURRENCY'>" . $v->CURRENCY . "</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control m-b" id="project_value" name="project_value" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-4 control-label" for="hp"><?= lang("Keterangan Projek", "Description Project") ?></label>
                                <div class="col-8">
                                    <textarea class="form-control m-b" name="desc" id="desc"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group row">
                                <label class="col-4 control-label " for="tahun"><?= lang("Tanggal Mulai", "Start Date") ?></label>
                                <div class="col-8">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="start" class="form-control" name="start" value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-4 control-label " for="tgl_slsai"><?= lang("Tanggal Selesai", "End Date") ?></label>
                                <div class="col-8">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="end" class="form-control" name="end" value="<?= date('Y-m-d') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-4 control-label" for="kontak"><?= lang("Contact Person", "Contact Person") ?></label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="contact" name="contact" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-4 control-label" for="laba_bersih"><span><?= lang("No. Contact Person", "No. Contact Person") ?></span></label>
                                <div class="col-8">
                                    <input type="text" class="form-control" id="no_contact" name="no_contact" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-sm-12 text-right">
                        <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                        <button type="submit" id="update_keys" name="keys1" value="0" style="width:115px" class="ladda-button ladda-button btn btn-primary"  data-style="zoom-in"><?= lang("Perbarui data", "Update Data") ?></button>
                        <button type="submit" id="add" name="keys" value="0" style="width:115px" class="ladda-button ladda-button btn btn-primary"  data-style="zoom-in"><?= lang("Tambah data", "Add Data") ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="modal_file" class="modal fade bs-example-modal-lg" role="dialog"  >
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
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        lang();
        $('.input-group.date').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        //modal tambah
        $('#modal1').click(function (e) {
            document.getElementById("form_add").reset();
            $('#modal_sertifikasi #add').show();
            $('#modal_sertifikasi #keys_update').hide();
            $('#modal_sertifikasi .modal-title').html("<?= lang("Tambah Data Sertifikat", "Add Data Certificate") ?>");
            lang();
            $('#modal_sertifikasi').modal('show');
        });

        $('#modal2').click(function (e) {
            document.getElementById("form_add2").reset();
            $('#modal_pengalaman #add').show();
            $('#modal_pengalaman #update_keys').hide();
            $('#modal_pengalaman .modal-title').html("<?= lang("Tambah Data Pengalaman", "Add Data Experiences") ?>");
            lang();
            $('#modal_pengalaman').modal('show');
        });

        //show sertifikat
        var tbl_sertifikat = $('#tabel_sertifikat').DataTable({
            ajax: {
                url: '<?= base_url('vn/info/Certification_experience/get_certificate') ?>',
                dataSrc: ''
            },
            "scrollX": true,
            "selected": true,
            "scrollY": "300px", "scrollCollapse": true,
            "paging": false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            "columns": [
                {"data": "NO"},
                {"data": "CREATOR"},
                {"data": "TYPE"},
                {"data": "NO_DOC"},
                {"data": "CREATE_BY"},
                {"data": "VALID_SINCE"},
                {"data": "VALID_UNTIL"},
                {"data": "UPLOAD_CERTIFICATE"},
                {"data": "AKSI"},
            ], "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]},
                {"className": "dt-center", "targets": [7]},
                {"className": "dt-center", "targets": [8]},
            ]
        });

        $('#tabel_sertifikat tbody').on('click', 'tr .update', function () {
            var data = tbl_sertifikat.row($(this).parents('tr')).data();
            console.log(data);
            $('#modal_sertifikasi #update').show();
            $('#keys_update').val(this.id);
            $('#modal_sertifikasi #add').hide();
            $('#ftype_sertifikasi').val(data["TYPE"]);
            $('#name').val(data["CREATOR"]);
            $('#number').val(data["NO_DOC"]);
            $('#issued').val(data["CREATE_BY"]);
            $('#start_apply').val(data["VALID_SINCE"]);
            $('#start_end').val(data["VALID_UNTIL"]);
            $('.modal-title').html("<?= lang("Perbarui Data Sertifikat", "Update Data Certificate") ?>");
            lang();
            $('#modal_sertifikasi').modal('show');
        });

        var tbl_pengalaman = $('#tabel_pengalaman').DataTable({
            ajax: {
                url: '<?= base_url('vn/info/Certification_experience/get_experience') ?>',
                dataSrc: ''
            },
            "scrollX": true,
            "selected": true,
            "scrollY": "300px", "scrollCollapse": true,
            "paging": false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            "columns": [
                {"data": "NO"},
                {"data": "CUSTOMER_NAME"},
                {"data": "PROJECT_NAME"},
                {"data": "PROJECT_DESCRIPTION"},
                {"data": "PROJECT_VALUE"},
                {"data": "CONTRACT_NO"},
                {"data": "START_DATE"},
                {"data": "END_DATE"},
                {"data": "CONTACT_PERSON"},
                {"data": "PHONE"},
                {"data": "AKSI"},
            ], "columnDefs": [
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
                {"className": "dt-center", "targets": [10]},
            ]
        });


        $('#tabel_pengalaman tbody').on('click', 'tr .update', function () {
            var data = tbl_pengalaman.row($(this).parents('tr')).data();
            console.log(data);
            $('#update_keys').show();
            $('#update_keys').val(this.id);
            $('#form_add2 #add').hide();
            $('#custumer').val(data["CUSTOMER_NAME"]);
            $('#project').val(data["PROJECT_NAME"]);
            $('#project_value').val(data["PROJECT_VALUE"]);
            $('#no_contract').val(data["CONTRACT_NO"]);
            $('#desc').val(data["PROJECT_DESCRIPTION"]);
            $('#start').val(data["START_DATE"]);
            $('#end').val(data["END_DATE"]);
            $('#contact').val(data["CONTACT_PERSON"]);
            $('#no_contact').val(data["PHONE"]);
            $('#modal_pengalaman .modal-title').html("<?= lang("Perbarui Data Pengalaman", "Update Experience Data ") ?>");
            lang();
            $('#modal_pengalaman').modal('show');
        });

        $('#form_add').validate({
            rules: {
                ftype_sertifikasi: {required: true},
                name: {required: true, maxlength: 60},
                number: {required: true, maxlength: 50},
                issued: {required: true, maxlength: 60},
                start_apply: {required: false},
                start_end: {required: false}
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
                var elm = start($('#modal_sertifikasi').find('.modal-content'));
                var formData = new FormData($('#form_add')[0]);
                formData.append('KEY', $('#keys_update').val());

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/Certification_experience/add_certificate'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res.status !== 'Error') {
                            $('#modal_sertifikasi').modal('hide');
                            $('#tabel_sertifikat').DataTable().ajax.reload();
                            $('#tabel_sertifikat').DataTable().columns.adjust().draw();
                            msg_info("Sukses", res.msg);
                        } else {
                            msg_danger("Error", res.msg);
                        }

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Gagal", "Oops,Terjadi kesalahan");
                    }
                });
            }
        });

        $('#form_add2').validate({
            rules: {
                custumer: {required: true},
                project: {required: true, maxlength: 60},
                no_contract: {required: true, maxlength: 50},
                project_value: {required: true, number: true, maxlength: 60},
                contact: {required: true},
                desc: {required: true},
                start: {required: false},
                end: {required: false},
                no_contact: {required: true, number: true}
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
                var elm = start($('#modal_pengalaman').find('.modal-content'));
                var formData = new FormData($('#form_add2')[0]);
                formData.append('KEY', $('#update_keys').val());

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/Certification_experience/add_experience'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res == true) {
                            $('#modal_pengalaman').modal('hide');
                            $('#tabel_pengalaman').DataTable().ajax.reload();
                            $('#tabel_pengalaman').DataTable().columns.adjust().draw();
                            msg_info("Sukses", "Data sukses disimpan");
                        } else {
                            msg_danger(res.status,res.msg)
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Gagal", "Oops,Terjadi kesalahan");
                    }
                });
            }
        });

        $('#bpjs_form').validate({
            focusInvalid: false,
            rules: {
              nomor_doc: {required: true, maxlength: 30},
              file_doc: {required: true},
              issued_date_doc: {required: true},
            },
            errorPlacement: function (label, element) { // render error placement for each input type
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
                var elm=start($('#CN_BPJS').parent('.card'));
                var formData = new FormData($('#bpjs_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/Certification_experience/add_bpjs'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res.status === "Sukses"){
                            msg_info(res.status, res.msg);
                            setTimeout(function(){
                              window.location.reload();
                            },1000)
                        }else{
                            msg_danger(res.status, res.msg);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Warning", "Oops,Something wrong");
                    }
                });
            }
        });
        $('#bpjstk_form').validate({
            focusInvalid: false,
            rules: {
              nomor_doc: {required: true, maxlength: 30},
              file_doc: {required: true},
              issued_date_doc: {required: true},
            },
            errorPlacement: function (label, element) { // render error placement for each input type
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
                var elm=start($('#CN_BPJSTK').parent('.card'));
                var formData = new FormData($('#bpjstk_form')[0]);

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/Certification_experience/add_bpjs'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res.status === "Sukses"){
                            msg_info(res.status, res.msg);
                            setTimeout(function(){
                              window.location.reload();
                            },1000)
                        }else{
                            msg_danger(res.status, res.msg);}
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Warning", "Oops,Something wrong");
                    }
                });
            }
        });
    });

    function review_file(data)
    {
        $('#ref').attr('src', data);
        $('#modal_file').modal('show');
    }


    function hapus(id) {
        swal({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus data ini",
            type: "warning",
            showCancelButton: true,
            CancelButtonColor: "#DD6B55",
            confirmButtonColor: "#337ab7",
            confirmButtonText: "Ya, hapus",
            closeOnConfirm: false
        }, function () {
            var data = {};
            data.ID_VENDOR = this.id;
            data.API = "delete";
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/Certification_experience/delete_exp/'); ?>" + id,
                data: data,
                cache: false,
                success: function (res)
                {
                    if (res == true)
                    {
                        msg_info("Success", "Data Successfully Deleted");
                        swal("Data Berhasil dihapus", "", "success");
                        $('#tabel_pengalaman').DataTable().ajax.reload();
                        $('#tabel_pengalaman').DataTable().columns.adjust().draw();
                    }
                    else
                    {
                        msg_danger("Failed", "Oops,Data failed to Delete");
                        swal("Data Gagal di hapus", "", "failed");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    msg_danger("Gagal", "Oops,Terjadi kesalahan");
                    swal("Data Gagal di hapus", "", "failed");
                }
            });
        }
        );
    }
    function add_sertifikasi() {
        document.getElementById("form_add").reset();
        $('#modal_sertifikasi #keys_update').hide();
        $('#modal_sertifikasi #add').show();
        $('#modal_sertifikasi').modal('show');
    }

    function add_tambah_kontak() {
        document.getElementById("form_add2").reset();
        $('#modal_pengalaman #update_keys').hide();
        $('#modal_pengalaman #add').show();
        $('#modal_pengalaman').modal('show');
    }
    function hapuscert(id) {
        swal({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus data ini",
            type: "warning",
            showCancelButton: true,
            CancelButtonColor: "#DD6B55",
            confirmButtonColor: "#337ab7",
            confirmButtonText: "Ya, hapus",
            closeOnConfirm: false
        }, function () {
            var data = {};
            data.ID_VENDOR = this.id;
            data.API = "delete";
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/Certification_experience/delete_cert/'); ?>" + id,
                data: data,
                cache: false,
                success: function (res)
                {
                    if (res == true)
                    {
                        msg_info("Success", "Data Successfully Deleted");
                        swal("Data Berhasil dihapus", "", "success");
                        $('#tabel_sertifikat').DataTable().ajax.reload();
                        $('#tabel_sertifikat').DataTable().columns.adjust().draw();
                    }
                    else
                    {
                        msg_danger("Failed", "Oops,Data failed to Delete");
                        swal("Data Gagal di hapus", "", "failed");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    msg_danger("Gagal", "Oops,Terjadi kesalahan");
                    swal("Data Gagal di hapus", "", "failed");
                }
            });
        }
        );
    }

    function review(data)
    {
        var obj = {};
        obj['file'] = data;
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('vn/info/legal_data/get_file'); ?>",
            data: obj,
            cache: false,
            success: function (res)
            {
                $('#ref').attr('src',res);
                $('#modal_file').modal('show');
            }
        });
    }
</script>
