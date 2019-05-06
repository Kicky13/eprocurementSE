<?php
function date_mdy($data){
  return date('d-m-Y', strtotime($data));
}
$date = date('d-m-Y');
$tomorrow = date('d-m-Y',strtotime($date . "+1 days"));
 ?>
<div class="app-content content">
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0"><?= lang("Informasi Umum", "General Information") ?></h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url($menu[0][1]['URL']);?>"><?= lang("Dashboard", "Dashboard"); ?></a>
                        </li>
                        <li class="breadcrumb-item active"><?= lang("Informasi Umum", "General Information") ?>
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
                    <div class="card-header" id="GENERAL1">
                        <h4 class="card-title"><?= lang("Info Perusahaan", "Company Info"); ?></h4>
                        <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                        <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Info Perusahaan ditolak", "Company information data is rejected") ?></div>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <!--<li><button aria-expanded="false" onclick="activate('company_info')" class="btn btn-outline-info"><i class="fa fa-edit"></i><?= lang(" Perbaiki data", "Fix data") ?></button></li>-->
                                <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content GENERAL1">
                        <div class="card-body">
                            <form id="company_info" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                                <div class="form-group row row">
                                    <label class="col-sm-2 label-control" for="PREFIX">
                                        <?= lang("Tipe Perusahaan", "Company Type"); ?>
                                    </label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="prefix" name="PREFIX" required>
                                          <option value="">Select</option>
                                          <?php foreach ($prefix[0] as $row) { ?>
                                            <option value="<?= $row->ID_PREFIX ?>"><?= $row->DESKRIPSI_ENG ?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row row bopak">
                                    <label class="col-sm-2 label-control" for="PREFIX">
                                        <?= lang("Awalan", "Prefix"); ?>
                                    </label>
                                    <div class="col-sm-3 awalan">
                                        <!-- <div class="main_company">
                                          <select class="form-control" id="company" name="company">
                                            <option value="PT">PT</option>
                                            <option value="CV">CV</option>
                                          </select>
                                        </div>
                                        <div class="main_individual">
                                          <select class="form-control" id="individual" name="individual">
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                          </select>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 label-control" for="NAMA">
                                        <?= lang("Nama Perusahaan", "Company Name"); ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama" name="NAMA" value="<?php echo(isset($all[0]->NAMA) != false ? $all[0]->NAMA : '') ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 label-control" for="klasifikasi">
                                        <?= lang("Klasifikasi Perusahaan", "Company Classification"); ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <div class="controls">
                                            <div class="c-inputs-stacked">
                                                <!--<label class="inline custom-control custom-checkbox">-->
                                                <div class="i-checks">
                                                    <?php
                                                    foreach ($act as $k => $v) {
                                                        if ($act[$k]['tambahan'] == "checked") {
                                                            echo'<input type="checkbox" value="' . $act[$k]['value'] . '" id="klasifikasi" name="klasifikasi" checked> <i></i>' . lang($act[$k]['value'], $act[$k]['value']) . '
                                                ';
                                                        } else {
                                                            echo'<input type="checkbox" value="' . $act[$k]['value'] . '" id="klasifikasi" name="klasifikasi"> <i></i>' . lang($act[$k]['value'], $act[$k]['value']) . '
                                                ';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 label-control" for="KATEGORI">
                                        <?= lang("Kualifikasi Perusahaan", "Company qualifications"); ?>
                                    </label>
                                    <div class="col-sm-10">
                                        <div class="controls">
                                            <div class="c-inputs-stacked">
                                                <!--<label class="inline custom-control custom-checkbox">-->
                                                <div class="i-checks">
                                                    <?php
                                                    $data = $this->db->select("DESKRIPSI_IND,DESKRIPSI_ENG")
                                                            ->from("m_supp_cualification")
                                                            ->where("status=", 1)
                                                            ->get()
                                                            ->result();
                                                    foreach ($data as $k => $v) {

                                                        if (isset($all[0]->CUALIFICATION) && ($v->DESKRIPSI_IND == $all[0]->CUALIFICATION)) {
                                                            echo'&nbsp<input type="radio" value="' . $v->DESKRIPSI_IND . '" id="kualifikasi" name="kualifikasi" checked> <i></i>' . lang($v->DESKRIPSI_IND, $v->DESKRIPSI_ENG) . '
                                                        ';
                                                        } else {

                                                            echo'&nbsp<input type="radio" value="' . $v->DESKRIPSI_IND . '" id="kualifikasi" name="kualifikasi"> <i></i>' . lang($v->DESKRIPSI_IND, $v->DESKRIPSI_ENG) . '
                                                    ';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="text-center">
                                        <!--<button type="submit" id="" class="btn btn-primary"><?= lang("Tambah Data", "Save") ?></button>-->
                                        <button type="submit" id="info" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Simpan data", "Save Data") ?></button>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </section>
            <section id="address">
                <div class="card">
                    <div class="card-header" id="GENERAL2">
                        <h4 class="card-title"><?= lang("Alamat Perusahaan", "Company Address"); ?></h4>
                        <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                        <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Alamat Perusahaan ditolak", "Company Address data is rejected") ?></div>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <!--<li><button aria-expanded="false" onclick="activate('company_address_update')" class="btn btn-outline-info"><i class="fa fa-edit"></i><?= lang(" Perbaiki data", "Fix data") ?></button></li>-->
                                <li><button aria-expanded="false" onclick="add_tambah_addres()" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <table id="dataalamat" class="table table-striped table-bordered table-hover display" width="100%">
                                <thead>
                                    <tr>
                                        <th><span>No</span></th>
                                        <th><?= lang("Tipe Kantor", "Branch Office") ?></th>
                                        <th><?= lang("Alamat", "Address") ?></th>
                                        <th><?= lang("Alamat 2", "Address 2") ?></th>
                                        <th><?= lang("Alamat 3", "Address 3") ?></th>
                                        <th><?= lang("Alamat 4", "Address 4") ?></th>
                                        <th><?= lang("Kode Negara", "Country") ?></th>
                                        <th><?= lang("Provinsi", "Province") ?></th>
                                        <th><?= lang("Kota", "City") ?></th>
                                        <th><?= lang("Kode Pos", "Postal Code") ?></th>
                                        <th><?= lang("Telp", "Telp") ?></th>
                                        <!--<th><?= lang("No. Hp", "No. Hp") ?></th>-->
                                        <th><?= lang("Fax", "Fax") ?></th>
                                        <th><?= lang("Website", "Website") ?></th>
                                        <th><?= lang("&nbsp&nbsp&nbsp   Aksi   &nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp   Action   &nbsp&nbsp&nbsp") ?></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section id="contact">
                <div class="card">
                    <div class="card-header" id="GENERAL3">
                        <h4 class="card-title"><?= lang("Kontak Perusahaan", "Contact Person") ?></h4>
                        <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                        <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Kontak Perusahaan ditolak", "Company Contact data is rejected") ?></div>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <!--<li><button aria-expanded="false" onclick="activate('company_contact_update')" class="btn btn-outline-info"><i class="fa fa-edit"></i><?= lang(" Perbaiki data", "Fix data") ?></button></li>-->
                                <li><button aria-expanded="false" onclick="add_tambah_kontak()" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <table id="datakontak" class="table table-striped table-bordered table-hover display" width="100%">
                                <thead>
                                <th><span>No</span></th>
                                <th><?= lang("Nama Pegawai", "Employee Name") ?></th>
                                <th><?= lang("Jabatan", "Position") ?></th>
                                <th><?= lang("Telp", "Telp") ?></th>
                                <th><?= lang("Ekstensi", "Ekstention") ?></th>
                                <th><?= lang("Email", "Email") ?></th>
                                <th><span>Hp</span></th>
                                <th><?= lang("&nbsp&nbsp&nbsp   Aksi   &nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp    Action   &nbsp&nbsp&nbsp") ?></th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
            <section id="ktp">
                <div class="card">
                    <div class="card-header" id="KTP">
                        <h4 class="card-title">KTP</h4>
                        <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                        <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Info Perusahaan ditolak", "KTP data is rejected") ?></div>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <?php
                                // echopre($KTP->file_url);
                                if (isset($KTP->file_url)) {
                                    echo lang("Lihat File", "Preview File");
                                    echo '
                                <li><div class="col-4">
                                <a class="btn btn-outline-success" title="Lihat File" onclick=review("KTP")><i class="fa fa-file-o"></i></a>
                                </div></li>';
                                }
                                ?>
                                <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content KTP">
                        <div class="card-body">
                          <form id="ktp_form" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                            <input type="hidden" class="form-control" id="ktp_id" name="ktp_id" value="<?php echo(isset($KTP->id) != false ? $KTP->id : '') ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label " for="issued_by_ktp"><?= lang("Nama ", "Name"); ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="issued_by_ktp" name="issued_by_ktp" value="<?php echo(isset($KTP->name) != false ? $KTP->name : '') ?>">
                                        </div>
                                        <label class="col-sm-2 control-label" for="file_ktp"><?= lang("Berkas", "File Attachment"); ?></label>
                                        <div class="col-sm-4">
                                            <input type="file" name="file_ktp" id="file_ktp" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label" for="nomor_ktp"><?= lang("NIK", "NIK") ?></label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="nomor_ktp" name="nomor_ktp" value="<?php echo(isset($KTP->nik) != false ? $KTP->nik : '') ?>">
                                        </div>
                                        <label class="col-sm-2 control-label" for="city"><?= lang("Kota", "City"); ?></label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="city" name="city" value="<?php echo(isset($KTP->city) != false ? $KTP->city : '') ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 control-label" for="valid_to_ktp"><?= lang("Valid Hingga", "Expiry Date") ?></label>
                                        <div class="col-sm-4">
                                            <div class="input-group date validto">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="valid_to_ktp" value="<?php echo(isset($KTP->expired_date) != false ? date_mdy($KTP->expired_date) : '' ) ?>">
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
            </section>
        </div>
    </div>
    <?php
    $this->load->view('V_side_menu', $menu);
    ?>
</div>
</div>
<?php
$this->load->view('vn/info/V_company_management');
?>
<div class="modal fade bs-example-modal-lg" data-backdrop="static" id="modal_address" role="dialog" aria-labelledby="myLargeModalLabel">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?= lang("Perbarui Data Alamat", "Update Data Address") ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body GENERAL2">
            <div class="col-md-12">
                <form id="company_address_update" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                    <div class="form-body">
                        <!-- <div class="col-md-12"> -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-md-2 label-control " for="BRANCH_TYPE"><?= lang("Tipe Kantor", "Branch Type"); ?></label>
                            <div class="col-sm-5 col-md-5" >
                                <select class="form-control" id="BRANCH_TYPE" name="BRANCH_TYPE">
                                    <?= langoption("HEAD OFFICE", "HEAD OFFICE"); ?>
                                    <?= langoption("BRANCH OFFICE", "BRANCH OFFICE"); ?>
                                    <?= langoption("WORKSHOP", "WORKSHOP"); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 label-control" for="hp"><?= lang("Alamat", "Address") ?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ADDRESS" name="ADDRESS" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 label-control" for="hp"><?= lang("Alamat 2", "Address 2") ?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ADDRESS2" name="ADDRESS2" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 label-control" for="hp"><?= lang("Alamat 3", "Address 3") ?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ADDRESS3" name="ADDRESS3" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 label-control" for="hp"><?= lang("Alamat 4", "Address 4") ?></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ADDRESS4" name="ADDRESS4" >
                            </div>
                        </div>
                        <!-- </div> -->
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group row">
                                    <label class="col-4 label-control" for="COUNTRY"><?= lang("Negara", "Country"); ?></label>
                                    <div class="col-8">
                                        <select class="form-control" id="COUNTRY" name="COUNTRY" onchange="getdata()" style="width: 100%" required data-validation-required-message="This field is required">
                                            <option value="">Select Country</option>
                                            <?= opcountry() ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 label-control" for="CITY"><?= lang("Kota", "City"); ?></label>
                                    <div class="col-sm-8">
                                        <select class="select2 form-control m-b" id="CITY" name="CITY" tabindex="2" style="width: 100%" >
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="TELP">Telp</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="TELP" name="TELP" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-4 label-control" for="FAX"><span>Fax</span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="FAX" name="FAX" >
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-4 label-control" for="PROVINCE"><?= lang("Provinsi", "Province"); ?></label>
                                        <div class="col-8">
                                            <select class="select2 form-control m-b" id="PROVINCE" name="PROVINCE"  onchange="getcities()" tabindex="2" style="width: 100%" >
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 label-control" for="POSTAL_CODE"><?= lang("Kode POS", "Postal Code"); ?></label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="POSTAL_CODE" name="POSTAL_CODE" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-4 label-control" for="WEBSITE"><span>Website</span></label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="WEBSITE" name="WEBSITE" >
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class=" col-sm-12 text-right">
                            <hr style="margin-bottom:10px;border-color:#d5d5d5"></hr>
                            <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                            <button type="submit" id="keys1" name="keys" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Tambah data", "Add Data") ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade bs-example-modal-lg" data-backdrop="static" id="modal_kontak" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?= lang("Tambah Data Kontak", "Add Address Data") ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body GENERAL3">
            <div class="col-12">
                <form id="company_contact_update" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-2 label-control" for="kontak_nama"><?= lang("Nama Lengkap", "Full Name"); ?></label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="kontak_nama" name="kontak_nama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 label-control" for="kontak_jabatan"><?= lang("Jabatan", "Position"); ?></label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="kontak_jabatan" name="kontak_jabatan" value="<?php echo(isset($all[0]->jabatan) != false ? $all[0]->jabatan : '') ?>" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="kontak_telp"><?= lang("Telp", "Telp"); ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="kontak_telp" name="kontak_telp" value="<?php echo(isset($all[0]->telp) != false ? $all[0]->telp : '') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="ekstensi"><?= lang("Ekstensi", "Extention"); ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="kontak_eks" name="kontak_eks" value="<?php echo(isset($all[0]->extention) != false ? $all[0]->extention : '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 label-control" for="kontak_email"><span>Email</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="kontak_email" name="kontak_email" value="<?php echo(isset($all[0]->email) != false ? $all[0]->email : '') ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 label-control" for="kontak_hp"><?= lang("No.HP", "Mobile Number"); ?></label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="kontak_hp" name="kontak_hp"value="<?php echo(isset($all[0]->hp) != false ? $all[0]->hp : '') ?>">
                            </div>
                        </div>
                        <hr style="margin-bottom:10px;border-color:#d5d5d5"></hr>
                        <div class=" col-12 text-right">
                            <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                            <button type="submit" id="keys" name="keys" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Tambah data", "Add Data") ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>


<div id="modalfile" class="modal fade bs-example-modal-xl" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title">Preview File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <iframe id="ref2" style="width:100%; height:600px;" frameborder="0">
                </iframe>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>ast11/assets/js/forms/select/select2.full.min.js" type="text/javascript"></script>
<script type="text/javascript">
var rs_prefix = <?= json_encode($prefix) ?>;
$(function () {
    $(".company_management").hide();
    lang();
    $("#PROVINCE").select2({
        placeholder: "Please Select Province"
    });
    $("#CITY").select2({
        placeholder: "Please Select City"
    });

    $('#PROVINCE').prop('disabled', true);
    $('#CITY').prop('disabled', true);
//                                            check();
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
//        $('#company_address #COUNTRY').val("Pilih").trigger("chosen:updated.chosen");
    $("[name='COUNTRY']").on("change", function () {
        // $("[name='phone']").val($(this).find("option:selected").data("code"));
        var code_telp = $(this).find("option:selected").data("code");
        // console.log(code_telp);
        $("#TELP").val(code_telp)
    });

    $("#TELP").on("keyup", function(){
      if ($(this).val() <= $("#COUNTRY").find("option:selected").data("code")) {
        $(this).val($("#COUNTRY").find("option:selected").data("code"))
      }
    })

    $("[name='country']").on("change", function () {
        $("[name='phone']").val($(this).find("option:selected").data("code"));
    });


    date_moment(".date", true);
    date_moment(".input-group.date", false);

    var result;
    $.ajax({
      url: '<?=base_url('vn/info/general_data/get_info_perusahaan')?>',
      type: 'POST',
      dataType: 'JSON',
    })
    .done(function() {
      result = true;
    })
    .fail(function() {
      result = false;
    })
    .always(function(res) {
      // console.log(res);
	  if (res.data.PREFIX == '' || res.data.PREFIX == null){

	  } else {
		var val1 = res.data.PREFIX.split(".");
		// console.log(val1[0]);
		$("#prefix").val(val1[0]);
		var prefix = val1[0];
		get_subprefix(val1[1]);
	  }

    });


    $(".bopak").hide()
    $("#prefix").on('change', function(e) {
        get_subprefix();
    });

    var tabel = $('#datakontak').DataTable({
        "processing": true,
        "serverSide": true,
        ajax: {
            url: '<?= base_url('vn/info/general_data/show') ?>',
            type: 'POST'
        },
        "scrollX": true,
        "selected": true,
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        },
        "columns": [
            {"data": "NO"},
            {"data": "NAMA"},
            {"data": "JABATAN"},
            {"data": "TELP"},
            {"data": "EXTENTION"},
            {"data": "EMAIL"},
            {"data": "HP"},
            {"data": "AKSI"}
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},
            {"className": "dt-center", "targets": [5]},
            {"className": "dt-center", "targets": [6]},
            {"className": "dt-center", "targets": [7]}
        ]
    });
    $('#datakontak tbody').on('click', 'tr .update', function () {
        var data2 = tabel.row($(this).parents('tr')).data();
        $('#company_contact_update #kontak_nama').val(data2.NAMA);
        $('#company_contact_update #kontak_jabatan').val(data2.JABATAN);
        $('#company_contact_update #kontak_telp').val(data2.TELP);
        $('#company_contact_update #kontak_eks').val(data2.EXTENTION);
        $('#company_contact_update #kontak_email').val(data2.EMAIL);
        $('#company_contact_update #kontak_hp').val(data2.HP);
        $('#company_contact_update #keys').val(this.id);
        $('#company_contact_update #keys').html("<?= lang("Perbarui data", "Update data") ?>");
        $('#modal_kontak .modal-title').html("<?= lang("Perbarui Data kontak", "Update Contact Data") ?>");
        lang();
        $('#modal_kontak').modal('show');
        lang();
    });
//                                            check();
    var tabel2 = $('#dataalamat').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: '<?= base_url('vn/info/general_data/show_address') ?>',
            "type": "POST"
        },
        "scrollX": true,
        "selected": true,
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        },
        "columns": [
            {"data": "NO"},
            {"data": "BRANCH_TYPE"},
            {"data": "ADDRESS"},
            {"data": "ADDRESS2"},
            {"data": "ADDRESS3"},
            {"data": "ADDRESS4"},
            {"data": "COUNTRY"},
            {"data": "PROVINCE"},
            {"data": "CITY"},
            {"data": "POSTAL_CODE"},
            {"data": "TELP"},
            {"data": "FAX"},
            {"data": "WEBSITE"},
            {"data": "AKSI"}
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
            {"className": "dt-center", "targets": [10]},
            {"className": "dt-center", "targets": [11]},
            {"className": "dt-center", "targets": [12]},
            {"className": "dt-center", "targets": [13]},
        ]
    });
    $('#dataalamat tbody').on('click', 'tr .update-alamat', function () {
        var data2 = tabel2.row($(this).parents('tr')).data();
        // console.log(data2);

        var id_prov = get_dt_wparam(data2.PROVINCE);
        console.log(id_prov);
        $('#BRANCH_TYPE').val(data2.BRANCH_TYPE);
        $('#company_address_update #ADDRESS').val(data2.ADDRESS);
        $('#company_address_update #ADDRESS2').val(data2.ADDRESS2);
        $('#company_address_update #ADDRESS3').val(data2.ADDRESS3);
        $('#company_address_update #ADDRESS4').val(data2.ADDRESS4);
        $('#company_address_update #COUNTRY').val(data2.COUNTRY).trigger('change');

        setTimeout(function(){
          setTimeout(function(){
            // $('#company_address_update #CITY').trigger('change');
            $('#company_address_update #CITY').val(data2.CITY).select2();
          }, 100)
          $('#company_address_update #PROVINCE').val(id_prov).select2().trigger('change');
        }, 100)

        // $('#company_address_update #COUNTRY').val('<option>'+data2.COUNTRY+'</option>');
        //$('#company_address_update #COUNTRY').val(data2.COUNTRY).select2();
        //$('#company_address_update #PROVINCE').html('<option>' + data2.PROVINCE + '</option>');
        // $('#company_address_update #CITY').html('<option>' + data2.CITY + '</option>');


        // $('#PROVINCE').prop("disabled", false);
        // $('#CITY').prop("disabled", false);
        $('#company_address_update #POSTAL_CODE').val(data2.POSTAL_CODE);
        $('#company_address_update #TELP').val(data2.TELP);
//                                                $('#company_address_update #HP').val(data2.HP);
        $('#company_address_update #FAX').val(data2.FAX);
        $('#company_address_update #WEBSITE').val(data2.WEBSITE);
        $('#company_address_update #keys1').val(this.id);
        $('#company_address_update #keys1').html("<?= lang("Perbarui data", "Update data") ?>");
        $('#modal_address .modal-title').html("<?= lang("Perbarui Data Alamat", "Update Address Data") ?>");
        lang();
        $('#modal_address').modal('show');
        lang();
    });
//                                            check();
    $('#company_info').validate({
        focusInvalid: false,
        rules: {
            PREFIX: {required: true},
            NAMA: {required: true, maxlength: 40},
            klasifikasi: {required: true},
            kualifikasi: {required: true},
        },
        errorPlacement: function (label, element) { // render error placement for each input type
            // console.log(label);
            var elmnt = element[0].id;
            if ((elmnt !== "kualifikasi") && (elmnt !== "klasifikasi"))
                $('<span class="error"></span>').insertAfter(element).append(label);
            else
                $('<span class="error"></span>').insertAfter($(element).parent('.col-md-10')).append(label);
            parent = $(element).parent().parent('.form-group');
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
            var elm = start($('#GENERAL1').parent('.card'));
            var obj = {};
            $.each($("#company_info").serializeArray(), function (i, field) {
                obj[field.name] = field.value;
            });
            delete obj['klasifikasi'];
            var checkboxes = document.getElementsByName('klasifikasi');
            for (var i = 0, n = checkboxes.length; i < n; i++)
            {
                if (checkboxes[i].checked)
                {
                    if (typeof obj['klasifikasi'] !== 'undefined')
                        obj['klasifikasi'] += "," + checkboxes[i].value;
                    else
                    {
                        obj['klasifikasi'] = checkboxes[i].value;
                    }
                }
            }
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/general_data/add_info'); ?>",
                data: obj,
                cache: false,
                success: function (res)
                {

                    if (res == true)
                    {
                        msg_info("Sukses", "Data sukses disimpan");
                    } else {
                        msg_danger("Error", "Data gagal disimpan");
                    }
                    stop(elm);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    stop(elm);
                    msg_danger("Gagal", "Oops,Terjadi kesalahan");
                    swal("Data Gagal di hapus", "", "failed");
                }
            });
        }

    });

    $('#ktp_form').validate({
        focusInvalid: false,
        rules: {
            issued_by_ktp: {required: true, maxlength: 50},
            file_ktp: {required: true},
            nomor_ktp: {required: true, maxlength: 20},
            city: {required: true},
            valid_to_ktp: {required: true},
        },
        errorPlacement: function (label, element) { // render error placement for each input type
            // console.log(label);
            $('<span class="error"></span>').insertAfter($(element).parent('.col-md-10')).append(label);
            parent = $(element).parent().parent('.form-group');
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
            var elm = start($('#GENERAL_KTP').parent('.card'));
            var obj = {};
            var formData = new FormData($('#ktp_form')[0]);

            $.ajax({
                type: "POST",
                url: "<?= site_url('vn/info/general_data/add_info_ktp'); ?>",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (res)
                {

                    if (res.success == true && res.file == true)
                    {
                      msg_info("Sukses", "Data sukses disimpan");
                      setTimeout(function(){
                        window.location.reload();
                      },1000)
                    } else {
                      if (res.file == false) {
                        msg_danger("Error", "Only PDF files are allowed");
                      } else {
                        msg_danger("Error", "Data gagal disimpan");
                      }

                    }
                    stop(elm);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    stop(elm);
                    msg_danger("Gagal", "Oops,Terjadi kesalahan");
                    swal("Data Gagal di hapus", "", "failed");
                }
            });
        }

    });
    $('#company_contact_update').validate({
        focusInvalid: false,
        rules: {
            kontak_nama: {required: true, maxlength: 40},
            kontak_jabatan: {required: true, maxlength: 30},
            // kontak_telp: {required: true, maxlength: 30, number: true},
            // kontak_eks: {required: true, maxlength: 10, number: true},
            kontak_hp: {required: true, maxlength: 30, number: true},
            kontak_email: {required: true,
                email: true,
                maxlength: 50
            },
        },
        errorPlacement: function (label, element) { // render error placement for each input type
            // console.log(label);
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
            var elm = start($('#modal_kontak').find('.modal-content'));
            var obj;
            obj = {
                NAMA: $('#company_contact_update #kontak_nama').val(),
                JABATAN: $('#company_contact_update #kontak_jabatan').val(),
                TELP: $('#company_contact_update #kontak_telp').val(),
                EXTENTION: $('#company_contact_update #kontak_eks').val(),
                HP: $('#company_contact_update #kontak_hp').val(),
                KEYS: $('#company_contact_update #keys').val(),
                EMAIL: $('#company_contact_update #kontak_email').val(),
                api: "insert",
            }
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/general_data/add_kontak'); ?>",
                data: obj,
                cache: false,
                success: function (res)
                {
                    if (res == true)
                    {
//                                                                load.ladda('stop');
                        if ($('#company_contact_update #keys').val() != 0)
                            $('#company_contact_update #keys').val(0);
                        $('#modal_kontak').modal('hide');
                        document.getElementById("company_contact_update").reset();
                        $('#datakontak').DataTable().ajax.reload();
                        msg_info("Sukses", "Data berhasil disimpan");
                    } else {
                        msg_danger("Error", "Data gagal disimpan");
                    }
                    stop(elm);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    stop(elm);
                    msg_danger("Gagal", "Oops,Terjadi kesalahan");
                    swal("Data Gagal di hapus", "", "failed");
                }
            })

        }
    });
    $('#company_address_update').validate({
        focusInvalid: false,
        rules: {
            BRANCH_TYPE: {required: true},
            ADDRESS: {required: true, maxlength: 40},
            ADDRESS2: {required: false, maxlength: 40},
            ADDRESS3: {required: false, maxlength: 40},
            ADDRESS4: {required: false, maxlength: 40},
            PROVINCE: {required: true},
            CITY: {required: true},
            COUNTRY: {required: true},
            POSTAL_CODE: {required: true,
                number: true,
                maxlength: 10,
            },
            TELP: {required: true, number: true, maxlength: 20},
//                                                    HP: {required: true, number: true,maxlength:20},
            FAX: {required: false, number: true, maxlength: 20},
            WEBSITE: {required: false, maxlength: 40},
        },
        errorPlacement: function (label, element) { // render error placement for each input type
            // console.log(label);
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
            var elm = start($('#modal_address').find('.modal-content'));
            var obj = {};
            $.each($("#company_address_update").serializeArray(), function (i, field) {
                obj[field.name] = field.value;
            });
            obj.KEYS = $('#company_address_update #keys1').val();
            if (obj.keys)
                delete obj.keys;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/general_data/add_address'); ?>",
                data: obj,
                cache: false,
                success: function (res)
                {
                    if (res == true) {
                        $('#modal_address').modal("hide");
                        document.getElementById("company_address_update").reset();
                        $('#company_address_update #keys1').val("0");
                        $('#dataalamat').DataTable().ajax.reload();
                        msg_info("sukses", "Data sukses diupdate");
                        window.location.href = '<?= base_url('vn/info/general_data'); ?>';
                    } else
                    {
                        msg_danger("Error", "Data gagal diupdate");
                    }
                    stop(elm);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    stop(elm);
                    msg_danger("Gagal", "Oops,Terjadi kesalahan");
                    swal("Data Gagal di hapus", "", "failed");
                }
            });
        }
    });
    $('#saveall').click(function (e)
    {
        $('#company_info').submit();
    });

    $('.demo3').click(function () {
        swal({
            title: "Apakah anda yakin?",
            text: "Pastikan Data umum dan Data Legal Telah Terisi,Data tidak akan bisa dirubah lagi",
            type: "warning",
            showCancelButton: true,
            CancelButtonColor: "#DD6B55",
            confirmButtonColor: "#337ab7",
            confirmButtonText: "Ya, simpan",
            closeOnConfirm: false
        }, function () {
            var obj = {};
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/general_data/finish'); ?>",
                data: obj,
                cache: false,
                success: function (res)
                {
                    if (res == true)
                    {
                        swal("Data Tersimpan!", "Anda Tidak bisa mengganti data hingga ada pemberitahuan", "success");
                        check(2);
                    } else {
                        swal("Failed!", "Oops, There is some errors,please try again", "failed");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    msg_danger("Gagal", "Oops,Terjadi kesalahan");
                }
            });
        });
    });
//                                            check();
});
function add_tambah_addres() {
    document.getElementById("company_address_update").reset();
    $('.modal-title').html("<?= lang("Tambah Data Alamat", "Add Address Data") ?>");
    $('#company_address_update #keys1').val("0");
    $('#company_address_update #keys1').html("<?= lang("Tambah data", "Add data") ?>");
    lang();
    $('#modal_address').modal('show');
    lang();
    $("#COUNTRY").select2({
        placeholder: "Please Select Country"
    });
    $("#PROVINCE").find('option').remove();
    $("#PROVINCE").prop('disabled', true);
    $("#CITY").find('option').remove();
    $("#CITY").prop('disabled', true);
}

function add_tambah_kontak() {
    document.getElementById("company_contact_update").reset();
    $('.modal-title').html("<?= lang("Tambah Data Kontak", "Add Contact Data") ?>");
    $('#company_contact_update #keys').val("0");
    $('#company_contact_update #keys').html("<?= lang("Tambah data", "Add data") ?>");
    lang();
    $('#modal_kontak').modal('show');
    lang();
}
function delete_kontak(key, id)
{
    var obj;
    obj = {
        ID: id,
        KEYS: key
    };
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('vn/info/all_vendor/check_vendor'); ?>",
        cache: false,
        success: function (res)
        {
            if (res == true)
            {
                msg_danger("Error", "Data not allowed to change");
                return;
            }
            else
                delete_data(obj, "delete_contact");
        }
    });
}
function delete_data(obj, dt)
{
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
        msg_default('Proses', "Data Sedang dihapus");

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('vn/info/general_data/') ?>" + dt,
            data: obj,
            cache: false,
            success: function (res)
            {
                if (res == true)
                {
                    if (dt === "delete_address")
                        $('#dataalamat').DataTable().ajax.reload();
                    else
                        $('#datakontak').DataTable().ajax.reload();
                    swal("Data Berhasil dihapus", "", "success");
                } else {
                    swal("Data Gagal dihapus", "", "failed");
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                msg_danger("Gagal", "Oops,Terjadi kesalahan");
            }
        });
    });
}
function delete_addr(key, id)
{
    var obj;
    obj = {
        ID: id,
        KEYS: key
    };
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('vn/info/all_vendor/check_vendor'); ?>",
        cache: false,
        success: function (res)
        {
            if (res == true)
            {
                msg_danger("Error", "Data tidak diperbolehkan untuk diubah");
                return;
            }
            else
                delete_data(obj, "delete_address");
        }
    });
}

function check(data = 1)
{
    if (data == 1)
    {
        var disb =<?php echo isset($all[0]->STATUS) ? $all[0]->STATUS : 0 ?>;
        if (disb >= 5)
        {
            $("#company_address :input").prop("disabled", true);
            $("#company_info :input").prop("disabled", true);
            $("#company_contact :input").prop("disabled", true);
            $("button .btn").attr("disabled", "disabled");
        }
    } else
    {
        $("#company_address :input").prop("disabled", true);
        $("#company_info :input").prop("disabled", true);
        $("#company_contact :input").prop("disabled", true);
        $("button .btn").attr("disabled", "disabled");
    }
}
function getdata()
{
    $('#PROVINCE').prop('disabled', true);
    var tamp = $('#COUNTRY').val();
    var obj = {};
    obj['COUNTRY'] = tamp;

    // setTimeout(function(){  }, 1000)
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('vn/info/general_data/get_province'); ?>",
        data: obj,
        cache: false,
        async:false,
        success: function (res)
        {

            $('#PROVINCE').prop('disabled', false);
            $('#PROVINCE').html(res);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {

            msg_danger("Gagal", "Oops,Terjadi kesalahan");
        }
    });
}

function get_dt_wparam(id)
{
    var obj = {};
    obj.id = id;
    var data;
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('vn/info/general_data/get_dt_wparam'); ?>",
        dataType: "JSOn",
        data: obj,
        cache: false,
        async:false,
        success: function(res){
          data = res.id;
        }
    });
    return data;
}

function getcities()
{
    var tamp = $('#PROVINCE').val();
    var obj = {};
    obj['PROVINCE'] = tamp;

    $.ajax({
        type: "POST",
        url: "<?php echo site_url('vn/info/general_data/get_city'); ?>",
        data: obj,
        cache: false,
        async:false,
        success: function (res)
        {

            $('#CITY').prop("disabled", false);
            $('#CITY').html(res);
//                $('#CITY').trigger("chosen:updated");
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {

            msg_danger("Gagal", "Oops,Terjadi kesalahan");
        }
    });
}

function get_subprefix(selected) {
    var company_type = $('#prefix').val();
    if (rs_prefix[company_type]) {
        var html = '<div class="main_company"><select class="form-control" id="subprefix" name="SUB_PREFIX">';
        $.each(rs_prefix[company_type], function(i, row) {
            html += '<option value="'+row.ID_PREFIX+'">'+row.DESKRIPSI_ENG+'</option>';
        });
        html += '</select></div>';
        $('.awalan').html(html);
        $('.bopak').fadeIn();
    } else {
        $('.awalan').html('');
        $('.bopak').fadeOut();
    }
    if (selected) {
        $('#subprefix').val(selected);
    }
}

function date_moment(idclass, bool){
  if (bool === true) {
    $(idclass).datetimepicker({
        format: 'DD-MM-YYYY',
        minDate:  moment(),
    });
  } else {
    $(idclass).datetimepicker({
        format: 'DD-MM-YYYY',
    });
  }
}

function review(data)
{
    var obj = {};
    obj['file'] = data;
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('vn/info/general_data/get_file'); ?>",
        data: obj,
        cache: false,
        success: function (res)
        {
          console.log(res);
          $('#ref2').attr('src', res);
          $('#modalfile').modal('show');
        }
    });
}
</script>
