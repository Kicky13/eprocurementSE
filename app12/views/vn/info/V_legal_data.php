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
                <h3 class="content-header-title mb-0 legal_data_title"><?= lang("Data Legal", "Legal Data") ?></h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=base_url($menu[0][1]['URL']);?>"><?= lang("Dashboard", "Dashboard"); ?></a>
                            </li>
                            <li class="breadcrumb-item active legal_data_title"><?= lang("Data Legal", "Legal Data") ?>
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
                <section class="legal_data" id="deed">
                    <div class="card">
                        <div class="card-header" id="LEGAL1">
                            <h4 class="card-title"><?= lang("Akta", "Deed"); ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Akta ditolak", "Deed data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><button aria-expanded="false" onclick="add_tambah_akta()" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table id="akta_table" class="table table-striped table-bordered table-hover display" width="100%" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th><?= lang("No. Akta", "Deed Number") ?></th>
                                            <th><?= lang("Tanggal Akta", "Date of Issue") ?></th>
                                            <th><?= lang("Jenis Akta", "Deed Type") ?></th>
                                            <th><?= lang("Nama Notaris", "Notary Name") ?></th>
                                            <th><?= lang("Alamat Notaris", "Notary Address") ?></th>
                                            <th><?= lang("Tanggal Terbit<br/>Pengesahan Kehakiman", "Judges Verification<br/>Date") ?></th>
                                            <th><?= lang("Tanggal Terbit<br/>Berita Negara", "Country Note<br/>Date") ?></th>
                                            <th><?= lang("Dok.<br/>Akta", "Deed<br/>File") ?></th>
                                            <th><?= lang("Dok.<br/>Pengesahan<br/>Kehakiman", "Judges Verification<br/>File") ?></th>
                                            <th><?= lang("Dok.<br/>Berita", "Country Note<br/>File") ?></th>
                                            <th><?= lang("&nbsp&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp", "&nbspAction&nbsp") ?></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="legal_data" id="description">
                    <div class="card">
                        <div class="card-header" id="LEGAL2">
                            <h4 class="card-title"><?= lang("Izin Usaha", "Business License"); ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data SIUP ditolak", "SIUP data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <?php
                                    if (isset($SIUP[0]["FILE_URL"])) {
                                        echo lang("Lihat File", "Preview File");
                                        echo '
                                        <li><div class="col-3 siup">
                                        <a class="btn btn-outline-primary" title="Lihat File" onclick=review("SIUP")><i class="fa fa-file-o"></i></a>
                                        </div>
                                        </li>';
                                    }
                                    if (isset($BKPM[0]["FILE_URL"])) {
                                        echo '
                                        <li><div class="col-3 nonsiup">
                                        <a class="btn btn-outline-primary" title="Lihat File" onclick=review("BKPM")><i class="fa fa-file-o"></i></a>
                                        </div>
                                        </li>';
                                    }
                                    ?>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content LEGAL2">
                            <div class="card-body">
                                <form id="company_siup" class="form" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label " for="created_by"><?= lang("Pilih Tipe Izin", "Choose License Type"); ?></label>
                                                <div class="col-sm-4">
                                                    <select class="form-control m-b" id="pilih_izin" name="pilih_izin" onchange="izin_change(this.value)">
                                                        <option value="1">SIUP</option>
                                                        <option value="2">BKPM</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label " for="created_by"><?= lang("Dibuat Oleh ", "Issued by"); ?></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="created_by_siup" name="created_by_siup" value="<?php echo(isset($SIUP[0]["CREATOR"]) != false ? $SIUP[0]["CREATOR"] : (isset($BKPM[0]["CREATOR"]) != false ? $BKPM[0]["CREATOR"] : '')) ?>">
                                                </div>
                                                <label class="col-sm-2 control-label" for="file"><?= lang("Berkas", "File Attachment"); ?></label>
                                                <div class="col-sm-4">
                                                    <input type="file" name="file_siup" id="file_siup" class="form-control" value="<?php echo(isset($SIUP[0]["SIUP_FILE"]) != false ? $SIUP[0]["SIUP_FILE"] : '') ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label" for="nomor_siup"><?= lang("Nomor", "Number") ?></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="nomor_siup" name="nomor_siup" value="<?php echo(isset($SIUP[0]["NO_DOC"]) != false ? $SIUP[0]["NO_DOC"] : (isset($BKPM[0]["NO_DOC"]) != false ? $BKPM[0]["NO_DOC"] : '')) ?>" >
                                                </div>
                                                <label class="col-sm-2 control-label siup" for="valid_from"><?= lang("Valid Sejak", "Issued Date"); ?></label>
                                                <div class="col-sm-4 siup">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="valid_from_siup" value="<?php echo(isset($SIUP[0]["VALID_SINCE"]) != false ? date_mdy($SIUP[0]["VALID_SINCE"]) : '') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label siup" for="tipe_siup"><?= lang("Tipe SIUP", "SIUP Type") ?></label>
                                                <div class="col-sm-4 siup">
                                                    <select class="form-control m-b" id="tipe_siup" name="tipe_siup">
                                                      <option value="Small SIUP">Small SIUP</option>
                                                      <option value="Middle SIUP">Middle SIUP</option>
                                                      <option value="BIG SIUP">BIG SIUP</option>
                                                        <!-- <?= langoption("Small SIUP", "Small SIUP"); ?>
                                                        <?= langoption("Middle SIUP", "Middle SIUP"); ?>
                                                        <?= langoption("BIG SIUP", "BIG SIUP"); ?> -->
                                                    </select>
                                                </div>
                                                <label class="col-sm-2 control-label siup" for="valid_to"><?= lang("Valid Hingga", "Expiry Date") ?></label>
                                                <div class="col-sm-4 siup">
                                                    <div class="input-group date validto">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="valid_to_siup" value="<?php echo(isset($SIUP[0]["VALID_UNTIL"]) != false ? date_mdy($SIUP[0]["VALID_UNTIL"]) : '' ) ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                           <!--<button type="submit" style="width:115px" class="btn btn-primary"><?= lang("Simpan Data", "Save") ?></button>-->
                                            <button type="submit" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Simpan data", "Save Data") ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="legal_data" id="description">
                    <div class="card">
                        <div class="card-header" id="LEGAL3">
                            <h4 class="card-title"><?= lang("TDP", "TDP"); ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data TDP ditolak", "TDP data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <?php
                                    if (isset($TDP[0]["FILE_URL"])) {
                                        echo lang("Lihat File", "Preview File");
                                        echo '
                                <li><div class="col-4">
                                <a class="btn btn-outline-primary" title="Lihat File" onclick=review("TDP")><i class="fa fa-file-o"></i></a>
                                </div></li>';
                                    }
                                    ?>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content LEGAL3">
                            <div class="card-body">
                                <form id="company_tdp" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label " for="created_by"><?= lang("Dibuat Oleh ", "Issued by"); ?></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="created_by_tdp" name="created_by_tdp" value="<?php echo(isset($TDP[0]["CREATOR"]) != false ? $TDP[0]["CREATOR"] : '') ?>">
                                                </div>
                                                <label class="col-sm-2 control-label" for="file_tdp"><?= lang("Berkas", "File Attachment"); ?></label>
                                                <div class="col-sm-4">
                                                    <input type="file" name="file_tdp" id="file_tdp" class="form-control" value="<?php echo(isset($all[0]->TDP_FILE) != false ? $all[0]->TDP_FILE : '') ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label" for="nomor_tdp"><?= lang("Nomor", "Number") ?></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="nomor_tdp" name="nomor_tdp" value="<?php echo(isset($TDP[0]["NO_DOC"]) != false ? $TDP[0]["NO_DOC"] : '') ?>">
                                                </div>
                                                <label class="col-sm-2 control-label" for="valid_from_tdp"><?= lang("Valid Sejak", "Issued Date"); ?></label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="valid_from_tdp" value="<?php echo(isset($TDP[0]["VALID_SINCE"]) != false ? date_mdy($TDP[0]["VALID_SINCE"]) : '') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label" for="valid_to_tdp"><?= lang("Valid Hingga", "Expiry Date") ?></label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date validto">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="valid_to_tdp" value="<?php echo(isset($TDP[0]["VALID_UNTIL"]) != false ? date_mdy($TDP[0]["VALID_UNTIL"]) : '' ) ?>">
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

                <section class="legal_data" id="description">
                    <div class="card">
                        <div class="card-header" id="LEGAL5">
                            <h4 class="card-title"><?= lang("SKT Panas Bumi", "SKT Panas Bumi"); ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Direktorat Panas Bumi ditolak", "Geothermal Directories data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <?php
                                    if (isset($SKT_EBTKE[0]["FILE_URL"])) {
                                        echo lang("Lihat File", "Preview File");
                                        echo '
                                    <li><div class="col-sm-4">
                                    <a class="btn btn-outline-primary" title="Lihat File" onclick=review("SKT_EBTKE")><i class="fa fa-file-o"></i></a>
                                    </div></li>';
                                    }
                                    ?>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content LEGAL5">
                            <div class="card-body">
                                <form id="company_ebtke" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label " for="issued_by_ebtke"><?= lang("Dikeluarkan Oleh ", "Issued By"); ?></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="issued_by_ebtke" name="issued_by_ebtke" value="<?php echo(isset($SKT_EBTKE[0]["CREATOR"]) != false ? $SKT_EBTKE[0]["CREATOR"] : '') ?>">
                                                </div>
                                                <label class="col-sm-2 control-label" for="file_ebtke"><?= lang("Berkas", "File Attachment"); ?></label>
                                                <div class="col-sm-4">
                                                    <input type="file" name="file_ebtke" id="file_ebtke" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label" for="nomor_ebtke"><?= lang("Nomor", "Number") ?></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="nomor_ebtke" name="nomor_ebtke" value="<?php echo(isset($SKT_EBTKE[0]["NO_DOC"]) != false ? $SKT_EBTKE[0]["NO_DOC"] : '') ?>">
                                                </div>
                                                <label class="col-sm-2 control-label" for="valid_from_ebtke"><?= lang("Berlaku Sejak", "Issued Date"); ?></label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="valid_from_ebtke" value="<?php echo(isset($SKT_EBTKE[0]["VALID_SINCE"]) != false ? date_mdy($SKT_EBTKE[0]["VALID_SINCE"]) : '') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label" for="valid_to_ebtke"><?= lang("Berlaku Hingga", "Expiry Date") ?></label>
                                                <div class="col-sm-4">
                                                    <div class="input-group date validto">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="valid_to_ebtke" value="<?php echo(isset($SKT_EBTKE[0]["VALID_UNTIL"]) != false ? date_mdy($SKT_EBTKE[0]["VALID_UNTIL"]) : '') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-6"> -->
                                            <!-- <div class="form-group row">

                                            </div>
                                            <div class="form-group row">

                                            </div>

                                        </div> -->
                                        <hr>
                                        <div class="col-12">
                                            <div class='form-group row col-md-12'>
                                                <label class='control-label m-b' for='bidang_usaha_ebtke'><?= lang("Bidang Usaha yang didaftarkan", "Registered field of bussiness") ?></label>
                                                <textarea id='bidang_usaha_ebtke' name='bidang_usaha_ebtke' class='form-control' rows='5'><?php echo isset($SKT_EBTKE[0]["DESCRIPTION"]) ? $SKT_EBTKE[0]["DESCRIPTION"] : ''; ?></textarea>
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
                <section class="legal_data" id="description">
                    <div class="card">
                        <div class="card-header" id="LEGAL6">
                            <h4 class="card-title"><?= lang("SKT MIGAS", "SKT MIGAS"); ?></h4>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data SKT MIGAS ditolak", "Oil and Gas data is rejected") ?></div>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <?php
                                    if (isset($SKT_MIGAS[0]["FILE_URL"])) {
                                        echo lang("Lihat File", "Preview File");
                                        echo '
                                    <li><div class="col-4">
                                    <a class="btn btn-outline-success" title="Lihat File" onclick=review("SKT_MIGAS")><i class="fa fa-file-o"></i></a>
                                    </div></li>';
                                    }
                                    ?>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content LEGAL6">
                            <div class="card-body">
                                <form id="company_migas" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-sm-4 control-label " for="issued_by"><?= lang("Dikeluarkan Oleh ", "Issued By"); ?></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="issued_by_migas" name="issued_by_migas" value="<?php echo(isset($SKT_MIGAS[0]["CREATOR"]) != false ? $SKT_MIGAS[0]["CREATOR"] : '') ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 control-label" for="file_migas"><?= lang("Berkas", "File Attachment"); ?></label>
                                                <div class="col-sm-8">
                                                    <input type="file" name="file_migas" id="file_migas" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 control-label" for="nomor_migas"><?= lang("Nomor", "Number") ?></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="no_migas" name="no_migas" value="<?php echo(isset($SKT_MIGAS[0]["NO_DOC"]) != false ? $SKT_MIGAS[0]["NO_DOC"] : '') ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 control-label" for="valid_from_migas"><?= lang("Berlaku Sejak", "Issued Date"); ?></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="valid_from_migas" value="<?php echo(isset($SKT_MIGAS[0]["VALID_SINCE"]) != false ? date_mdy($SKT_MIGAS[0]["VALID_SINCE"]) : '') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-4 control-label" for="valid_to_migas"><?= lang("Berlaku Hingga", "Expiry Date") ?></label>
                                                <div class="col-sm-8">
                                                    <div class="input-group date validto">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="valid_to_migas" value="<?php echo(isset($SKT_MIGAS[0]["VALID_UNTIL"]) != false ? date_mdy($SKT_MIGAS[0]["VALID_UNTIL"]) : '') ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-6">
                                            <div class="form-group row">

                                            </div>
                                            <div class="form-group row">

                                            </div>

                                        </div> -->
                                        <hr>
                                        <div class="col-12">
                                            <div class='form-group row col-md-12'>
                                                <label class='control-label m-b' for='bidang_usaha_migas'><?= lang("Bidang Usaha yang didaftarkan", "Registered field of bussiness") ?></label>
                                                <textarea id='bidang_usaha_migas' name='bidang_usaha_migas' class='form-control' rows='5'><?php if (isset($SKT_MIGAS[0]["DESCRIPTION"])) echo $SKT_MIGAS[0]["DESCRIPTION"]; ?></textarea>
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

                <!-- SKT PAJAK -->
                <section class="legal_tax_data" id="description">
                    <div class="card">
                        <div class="card-header" id="">
                            <h4 class="card-title"><?= lang("Form Pajak", "Tax Form"); ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data SKT Pajak ditolak", "Tax Certificate data is rejected") ?></div>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><button aria-expanded="false" onclick="add_docType()" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table id="tabel_pajak" class="table table-striped table-bordered table-hover display">
                                    <!-- <thead>
                                        <tr>
                                            <th>No</th>
                                            <th><?= lang("No Dokumen", "No Document") ?></th>
                                            <th><?= lang("Dokumen Tipe", "Document Type") ?></th>
                                            <th><?= lang("Dokumen File", "Document File") ?></th>
                                        </tr>
                                    </thead> -->

                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- .// SKT PAJAK -->

                <!-- .// SKDP -->
                <section class="legal_data" id="sdkp">
                    <div class="card">
                        <div class="card-header" id="SDKP">
                            <h4 class="card-title">SKDP</h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Info Perusahaan ditolak", "SKDP data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <?php
                                    // echopre($SDKP->FILE_URL);
                                    if (isset($SDKP->FILE_URL)) {
                                        echo lang("Lihat File", "Preview File");
                                        echo '
                                    <li><div class="col-4">
                                    <a class="btn btn-outline-success" title="Lihat File" onclick=review("SDKP")><i class="fa fa-file-o"></i></a>
                                    </div></li>';
                                    }
                                    ?>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content SDKP">
                            <div class="card-body">
                              <form id="company_sdkp" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                                <input type="hidden" class="form-control" id="doc_id" name="doc_id" value="<?php echo(isset($SDKP->ID) != false ? $SDKP->ID : '') ?>">
                                <input type="hidden" class="form-control" id="doc_type" name="doc_type" value="SDKP">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label " for="issued_by_doc"><?= lang("Dibuat Oleh ", "Issued By"); ?></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="issued_by_doc" name="issued_by_doc" value="<?php echo(isset($SDKP->CREATOR) != false ? $SDKP->CREATOR : '') ?>">
                                            </div>
                                            <label class="col-sm-2 control-label" for="file_doc"><?= lang("Berkas", "File Attachment"); ?></label>
                                            <div class="col-sm-4">
                                                <input type="file" name="file_doc" id="file_doc" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label" for="nomor_doc"><?= lang("Nomor", "Document Number") ?></label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="nomor_doc" name="nomor_doc" value="<?php echo(isset($SDKP->NO_DOC) != false ? $SDKP->NO_DOC : '') ?>">
                                            </div>
                                            <label class="col-sm-2 control-label" for="issued_date_doc"><?= lang("Valid Sejak", "Issued Date"); ?></label>
                                            <div class="col-sm-4">
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="issued_date_doc" value="<?php echo(isset($SDKP->VALID_SINCE) != false ? date_mdy($SDKP->VALID_SINCE) : '') ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label" for="valid_to_doc"><?= lang("Valid Hingga", "Expiry Date") ?></label>
                                            <div class="col-sm-4">
                                                <div class="input-group date validto">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="valid_to_doc" value="<?php echo(isset($SDKP->VALID_UNTIL) != false ? date_mdy($SDKP->VALID_UNTIL) : '' ) ?>">
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
                <!-- .// SKDP -->

            </div>
        </div>
        <?php
        $this->load->view('V_side_menu', $menu);
        ?>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" data-backdrop="static" id="modal_akta" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang("Perbarui Data Akta", "Update Deed Data") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body col-12 LEGAL1">
                <form id="company_akta_update" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-2 control-label" for="no_akta">
                                <?= lang("No. Akta", "Deed Number"); ?>
                            </label>
                            <div class="col-4">
                                <input type="text" class="form-control" id="no_akta" name="no_akta">
                            </div>
                            <div class="col-4">
                                <input type="file" name="file_akta2" id="file_akta2" class="form-control">
                            </div>
                            <div class="col-2">
                                <label title="preview" id="akta_confirm" class="btn">
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="jenis_akta">
                                <?= lang("Jenis Akta", "Deed Type"); ?>
                            </label>
                            <div class="col-4">
                                <select class="form-control m-b" id="jenis_akta" name="jenis_akta">
                                    <?= langoption("Establishment", "Establishment") ?>
                                    <?= langoption("Change", "Change") ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="tanggal_akta">
                                <?= lang("Tanggal Akta", "Date of Issue"); ?>
                            </label>
                            <div class="col-4" id="data_3">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tanggal_akta" class="form-control" name="tanggal_akta" value="<?php echo date("Y-m-d"); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="nama_notaris">
                                <?= lang("Nama Notaris", "Notary Name"); ?>
                            </label>
                            <div class="col-4">
                                <input type="text" class="form-control" id="nama_notaris" name="nama_notaris">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="alamat_notaris">
                                <?= lang("Alamat Notaris", "Notary Address"); ?>
                            </label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="alamat_notaris" name="alamat_notaris" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="pengesahan">
                                <?= lang("Pengesahan kehakiman", "Judge Verification"); ?>
                            </label>
                            <div class="col-4" id="data_1">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="pengesahan" class="form-control" name="pengesahan" value="<?php echo date("Y-m-d"); ?>" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <input type="file" name="file_pengesahan2" id="file_pengesahan2" class="form-control">
                            </div>
                            <div class="col-2">
                                <label title="preview" id="verification_confirm" class="btn ">
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="berita">
                                <?= lang("Berita Negara", "Country Note"); ?>
                            </label>
                            <div class="col-4" id="data_2">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="berita" name="berita" value="<?php echo date("Y-m-d"); ?>" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <input type="file" name="file_berita2" id="file_berita2" class="form-control">
                            </div>
                            <div class="col-2">
                                <label title="preview" id="news_confirm" class="btn">
                                </label>
                            </div>
                        </div>
                        <hr style="margin-bottom:10px;border-color:#d5d5d5">
                        </hr>
                        <div class=" col-sm-12 text-right">
                            <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                            <button type="submit" id="keys" name="keys" value="0" style="width:115px" class="btn btn-primary"><?= lang("Perbarui data", "Update data") ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="modal2" class="modal fade bs-example-modal-lg" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title">Preview File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
<div class="modal fade bs-example-modal-lg" data-backdrop="static" id="modal_pengalaman" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang("Tambah data Akta", "Add Deed Data") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body col-12  LEGAL1">
                <form id="company_akta" class="form" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="no_akta">
                                        <?= lang("No. Akta", "Deed Number"); ?>
                                    </label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="no_akta" name="no_akta">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <div class="col-10">
                                        <input type="file" name="file_akta" id="file_akta" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="jenis_akta">
                                <?= lang("Jenis Akta", "Deed Type"); ?>
                            </label>
                            <div class="col-4">
                                <select class="form-control m-b" id="jenis_akta" name="jenis_akta">
                                    <?= langoption("Establishment", "Establishment") ?>
                                    <?= langoption("Change", "Change") ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="tanggal_akta">
                                <?= lang("Tanggal Akta", "Date of Issue"); ?>
                            </label>
                            <div class="col-4 form-group" id="data_3">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tanggal_akta" class="form-control" name="tanggal_akta" value="<?= $date; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="nama_notaris">
                                <?= lang("Nama Notaris", "Notary Name"); ?>
                            </label>
                            <div class="col-4">
                                <input type="text" class="form-control" id="nama_notaris" name="nama_notaris">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="alamat_notaris">
                                <?= lang("Alamat Notaris", "Notary Address"); ?>
                            </label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="alamat_notaris" name="alamat_notaris" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="pengesahan">
                                        <?= lang("Pengesahan kehakiman", "Judge Verification"); ?>
                                    </label>
                                    <div class="col-8 form-group" id="data_1">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="pengesahan" class="form-control" name="pengesahan" value="" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <input type="file" name="file_pengesahan" id="file_pengesahan" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="berita">
                                        <?= lang("Berita Negara", "Country Note"); ?>
                                    </label>
                                    <div class="col-8 form-group" id="data_2">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="berita" name="berita" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <input type="file" name="file_berita" id="file_berita" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>


                        </div>
                        <div class="modal-footer">
                            <div class=" col-12 text-right">
                                <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                                <button type="submit" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Tambah data", "Add Data") ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" data-backdrop="static" id="doc_type_form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?= lang("Form Data", "Form Data") ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body col-12">
                  <div class="form-body">
                    <div class="card">
                      <div class="card-content">
                        <div class="card-body">
                          <div class="form-group row">
                              <label class="col-4 control-label" for="doc_type">
                                  <p><?= lang("Pilih Tipe Dokumen", "Select Document Type") ?></p>
                              </label>
                              <div class="col-8">
                                <fieldset class="form-group position-relative">
                                    <select class="form-control form-control" id="doc_type_tax" name="doc_type">
                                        <option value="0">Select</option>
                                        <option value="NPWP_DOC">NPWP (Nomor Pokok Wajib Pajak)</option>
                                        <option value="SPPKP_DOC">SPPKP</option>
                                        <option value="SKTPAJAK_DOC">SKT Pajak</option>
                                    </select>
                                </fieldset>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    </div>

                    <div class="form-body">
                      <section id="main_npwp">
                          <div class="card">
                              <div class="card-header" id="LEGAL4">
                                  <h4 class="card-title"><?= lang("NPWP(Nomor Pokok Wajib Pajak)", "NPWP"); ?></h4>
                                  <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                                  <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data NPWP ditolak", "NPWP data is rejected") ?></div>
                                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                  <div class="heading-elements">
                                      <ul class="list-inline mb-0">
                                          <?php
                                          if (isset($all[0]->NPWP_FILE)) {
                                              echo lang("Lihat File", "Preview File");
                                              echo '
                                      <li><div class="col-4">
                                      <a class="btn btn-outline-primary" title="Lihat File" onclick=review("NPWP")><i class="fa fa-file-o"></i></a>
                                      </div></li>';
                                          }
                                          ?>
                                          <!-- <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li> -->
                                      </ul>
                                  </div>
                              </div>
                              <div class="card-content LEGAL4">
                                  <div class="card-body">
                                      <form id="company_npwp" class="form-horizontal" action="javascript:;" novalidate="novalidate" enctype="multipart/form-data">
                                          <!-- <div class="form-group row">
                                              <label class="col-2 control-label" for="no_npwp">
                                                  <?= lang("No. NPWP", "NPWP Number"); ?>
                                              </label>
                                              <div class="col-6">
                                                  <input type="text" class="form-control" id="nomor_npwp" name="nomor_npwp" value="<?php echo(isset($all[0]->NO_NPWP) != false ? $all[0]->NO_NPWP : '') ?>">
                                              </div>
                                              <div class="col-4">
                                                  <input type="file" name="file_npwp" id="file_npwp" class="form-control"  value="<?php echo(isset($all[0]->NPWP_FILE) != false ? $all[0]->NPWP_FILE : '') ?>">
                                              </div>
                                          </div>
                                          <div class="form-group row">
                                              <label class="col-sm-2 control-label" for="alamat_npwp">
                                                  <?= lang("Alamat ", " Address"); ?>
                                              </label>
                                              <div class="col-sm-10">
                                                  <input type="text" class="form-control" id="alamat_npwp" name="npwp_addr" value="<?php echo(isset($all[0]->NOTARIS_ADDRESS) != false ? $all[0]->NOTARIS_ADDRESS : '') ?>" >
                                              </div>
                                          </div>
                                          <div class="form-group row">
                                              <label class="col-sm-2 control-label" for="kodepos">
                                                  <?= lang("Kode Pos", "Postal Code"); ?>
                                              </label>
                                              <div class="col-sm-6">
                                                  <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo(isset($all[0]->POSTAL_CODE) != false ? $all[0]->POSTAL_CODE : '') ?>" >
                                              </div>
                                          </div>
                                          <div class="form-group row">
                                              <label class="col-sm-2 control-label" for="provinsi">
                                                  <?= lang("Provinsi", "Province"); ?>
                                              </label>
                                              <div class="col-sm-6">
                                                  <select class="chosen-select form-control" id="PROVINCE" name="npwp_province"  style="width:350px;" tabindex="2">
                                                      <?php echo(isset($all[0]->NPWP_PROVINCE) != false ? '<option value="'.$all[0]->NPWP_PROVINCE.'">'.$all[0]->NPWP_PROVINCE.'</option>' : '') ?>
                                                      <?= opprovinsi() ?>
                                                  </select>
                                              </div>
                                          </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label" for="kota">
                                                    <?= lang("Kota", "City"); ?>
                                                </label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="npwp_city" name="npwp_city" value="<?php echo(isset($all[0]->NPWP_CITY) != false ? $all[0]->NPWP_CITY : '') ?>" >
                                                </div>
                                            </div>
                                          <hr/> -->

                                          <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                                          <div class="form-body">
                                            <!-- <h4 class="form-section"><i class="fa fa-eye"></i> About User</h4> -->
                                            <div class="row">
                                               <div class="col-md-6">
                                                  <div class="form-group row">
                                                     <label class="col-md-3 label-control" for="userinput4">NPWP Number</label>
                                                     <div class="col-md-9">
                                                        <input type="text" class="form-control" id="nomor_npwp" name="nomor_npwp" value="<?php echo(isset($all[0]->NO_NPWP) != false ? $all[0]->NO_NPWP : '') ?>">
                                                     </div>
                                                  </div>
                                                  <div class="form-group row">
                                                     <label class="col-md-3 label-control" for="userinput4">Address</label>
                                                     <div class="col-md-9">
                                                        <input type="text" class="form-control" id="alamat_npwp" name="npwp_addr" value="<?php echo(isset($all[0]->NOTARIS_ADDRESS) != false ? $all[0]->NOTARIS_ADDRESS : '') ?>" >
                                                     </div>
                                                  </div>
                                                  <div class="form-group row">
                                                     <label class="col-md-3 label-control" for="userinput4">Postal Code</label>
                                                     <div class="col-md-9">
                                                        <input type="text" class="form-control" id="postal_code" name="postal_code" value="<?php echo(isset($all[0]->POSTAL_CODE) != false ? $all[0]->POSTAL_CODE : '') ?>" >
                                                     </div>
                                                  </div>
                                               </div>
                                               <div class="col-md-6">
                                                 <div class="form-group row">
                                                    <label class="col-md-3 label-control" for="userinput3">File</label>
                                                    <div class="col-md-9">
                                                       <input type="file" name="file_npwp" id="file_npwp" class="form-control"  value="<?php echo(isset($all[0]->NPWP_FILE) != false ? $all[0]->NPWP_FILE : '') ?>">
                                                    </div>
                                                 </div>
                                                  <div class="form-group row">
                                                     <label class="col-md-3 label-control" for="userinput4">City</label>
                                                     <div class="col-md-9">
                                                        <input type="text" class="form-control" id="npwp_city" name="npwp_city" value="<?php echo(isset($all[0]->NPWP_CITY) != false ? $all[0]->NPWP_CITY : '') ?>" >
                                                     </div>
                                                  </div>
                                                  <div class="form-group row">
                                                     <label class="col-md-3 label-control" for="userinput4">Province</label>
                                                     <div class="col-md-9">
                                                       <select class="chosen-select form-control" id="PROVINCE" name="npwp_province"  style="width:250px;" tabindex="2">
                                                           <?php echo(isset($all[0]->NPWP_PROVINCE) != false ? '<option value="'.$all[0]->NPWP_PROVINCE.'">'.$all[0]->NPWP_PROVINCE.'</option>' : '') ?>
                                                           <?= opprovinsi() ?>
                                                       </select>
                                                     </div>
                                                  </div>
                                               </div>
                                            </div>


                                            </div>
                                          <div class="text-center">
                                              <button type="submit" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Simpan data", "Save Data") ?></button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </section>

                      <!-- SPPKP -->
                      <section id="main_sppkp">
                          <div class="card">
                              <div class="card-header" id="LEGAL7">
                                  <h4 class="card-title"><?= lang("SPPKP", "SPPKP"); ?></h4>
                                  <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                                  <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data SPPKP ditolak", "SPPKP data is rejected") ?></div>
                                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                  <div class="heading-elements">
                                      <ul class="list-inline mb-0">
                                          <?php
                                          if (isset($SPPKP[0]["FILE_URL"])) {
                                              echo lang("Lihat File", "Preview File");
                                              echo '
                                          <li><div class="col-sm-4">
                                          <a class="btn btn-outline-primary" title="Lihat File" onclick=review("SPPKP")><i class="fa fa-file-o"></i></a>
                                          </div></li>';
                                          }
                                          ?>
                                          <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                      </ul>
                                  </div>
                              </div>
                              <div class="card-content LEGAL7">
                                  <div class="card-body">
                                      <form id="company_sppkp" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                                          <div class="row">
                                              <div class="col-6">
                                                  <div class="form-group row">
                                                      <label class="col-sm-4 control-label " for="issued_by_sppkp"><?= lang("Dikeluarkan Oleh ", "Issued By"); ?></label>
                                                      <div class="col-sm-8">
                                                          <input type="text" class="form-control" id="issued_by_sppkp" name="issued_by_sppkp" value="<?php echo(isset($SPPKP[0]["CREATOR"]) != false ? $SPPKP[0]["CREATOR"] : '') ?>">
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                      <label class="col-sm-4 control-label" for="nomor_sppkp"><?= lang("Nomor", "Number") ?></label>
                                                      <div class="col-sm-8">
                                                          <input type="text" class="form-control" id="nomor_sppkp" name="nomor_sppkp" value="<?php echo(isset($SPPKP[0]["NO_DOC"]) != false ? $SPPKP[0]["NO_DOC"] : '') ?>">
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-6">
                                                  <div class="form-group row">
                                                      <label class="col-4 control-label" for="file_sppkp"><?= lang("Berkas", "File Attachment"); ?></label>
                                                      <div class="col-8">
                                                          <input type="file" name="file_sppkp" id="file_sppkp" class="form-control">
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
                      <!-- .//SPPKP -->

                      <!-- SKT PAJAK -->
                      <section id="main_sktpajak">
                          <div class="card">
                              <div class="card-header" id="LEGAL8">
                                  <h4 class="card-title"><?= lang("SKT Pajak", "Tax Certificate"); ?></h4>
                                  <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                                  <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data SKT Pajak ditolak", "Tax Certificate data is rejected") ?></div>
                                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                  <div class="heading-elements">
                                      <ul class="list-inline mb-0">
                                          <?php
                                          if (isset($SKT_PAJAK[0]["FILE_URL"])) {
                                              echo lang("Lihat File", "Preview File");
                                              echo '
                                          <li><div class="col-sm-4">
                                          <a class="btn btn-outline-primary" title="Lihat File" onclick=review("SPPKP")><i class="fa fa-file-o"></i></a>
                                          </div></li>';
                                          }
                                          ?>
                                          <!-- <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li> -->
                                      </ul>
                                  </div>
                              </div>
                              <div class="card-content LEGAL8">
                                  <div class="card-body">
                                      <form id="company_pajak" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                                          <div class="row">
                                              <div class="col-6">
                                                  <div class="form-group row">

                                                        <label class="col-sm-4 control-label " for="issued_by_pajak"><?= lang("Dikeluarkan Pada Tanggal", "Issued By Date"); ?></label>
                                                        <div class="col-sm-8">
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="issued_by_pajak" class="form-control" name="issued_by_pajak" value="<?php echo(isset($SKT_PAJAK[0]["VALID_SINCE"]) != false ? date_mdy($SKT_PAJAK[0]["VALID_SINCE"]) : '') ?>">
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="issued_by_pajak" name="issued_by_pajak" value="<?php echo(isset($SKT_PAJAK[0]["CREATOR"]) != false ? $SKT_PAJAK[0]["CREATOR"] : '') ?>">
                                                        </div> -->
                                                  </div>
                                                  <div class="form-group row">
                                                      <label class="col-sm-4 control-label" for="nomor_pajak"><?= lang("Nomor", "Number") ?></label>
                                                      <div class="col-sm-8">
                                                          <input type="text" class="form-control" id="nomor_pajak" name="nomor_pajak" value="<?php echo(isset($SKT_PAJAK[0]["NO_DOC"]) != false ? $SKT_PAJAK[0]["NO_DOC"] : '') ?>">
                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="col-6">
                                                  <div class="form-group row">
                                                      <label class="col-4 control-label" for="file_pajak"><?= lang("Berkas", "File Attachment"); ?></label>
                                                      <div class="col-8">
                                                          <input type="file" name="file_pajak" id="file_sppkp" class="form-control">
                                                      </div>
                                                  </div>
                                              </div>
                                              <hr>

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
                      <!-- .// SKT PAJAK -->
                    </div>

                </div>
            </div>
        </div>
    </div>

<script>
    function add_tambah_akta() {
        $('.add').show();
        $('#modal_pengalaman').modal('show');
    }
    function izin_change(e)
    {
        $('#pilih_izin').val(e);
        if(e == '2')
        {
            $(".siup").hide();
            $(".nonsiup").show();
        }
        else
        {
            $(".siup").show();
            $(".nonsiup").hide();
        }
    }

    function add_docType() {
        document.getElementById("company_npwp").reset();
        document.getElementById("company_sppkp").reset();
        document.getElementById("company_pajak").reset();
        $('.add').show();
        $('#doc_type_form').modal('show');
        $("#main_npwp").hide();
        $("#main_sppkp").hide();
        $("#main_sktpajak").hide();
        $("#doc_type_tax").val("0");

        $(document).on('change', '#doc_type_tax', function(e) {
          // e.preventDefault();
          // alert($(this).val())
          var doc_type = $(this).val();
          console.log(doc_type);

          if (doc_type == "0") {
            $("#main_npwp").hide();
            $("#main_sppkp").hide();
            $("#main_sktpajak").hide();
          } else if (doc_type == "NPWP_DOC") {
            $("#main_npwp").fadeIn();
            $("#main_sppkp").hide();
            $("#main_sktpajak").hide();
          } else if (doc_type == "SPPKP_DOC") {
            $("#main_npwp").hide();
            $("#main_sppkp").fadeIn();
            $("#main_sktpajak").hide();
          } else if (doc_type == "SKTPAJAK_DOC") {
            $("#main_npwp").hide();
            $("#main_sppkp").hide();
            $("#main_sktpajak").fadeIn();
          } else {
            $("#main_npwp").hide();
            $("#main_sppkp").hide();
            $("#main_sktpajak").hide();
          }

        });
    }

    function edit_docType(vendor, tpye) {
        document.getElementById("company_npwp").reset();
        document.getElementById("company_sppkp").reset();
        document.getElementById("company_pajak").reset();
        $('.add').show();
        $('#doc_type_form').modal('show');
        $("#main_npwp").hide();
        $("#main_sppkp").hide();
        $("#main_sktpajak").hide();
        $("#doc_type_tax").val("0");

        console.log(tpye);

        setTimeout(function(){
          $("#doc_type_tax").val(tpye.replace('_', '')+'_DOC').trigger('change');
        },700);
        $("#doc_type_tax").on('change', function(e) {
          // e.preventDefault();
          // alert($(this).val())
          var doc_type = $(this).val();

          if (doc_type == "0") {
            $("#main_npwp").hide();
            $("#main_sppkp").hide();
            $("#main_sktpajak").hide();
          } else if (doc_type == "NPWP_DOC") {
            $("#main_npwp").fadeIn();
            $("#main_sppkp").hide();
            $("#main_sktpajak").hide();
          } else if (doc_type == "SPPKP_DOC") {
            $("#main_npwp").hide();
            $("#main_sppkp").fadeIn();
            $("#main_sktpajak").hide();
          } else if (doc_type == "SKTPAJAK_DOC") {
            $("#main_npwp").hide();
            $("#main_sppkp").hide();
            $("#main_sktpajak").fadeIn();
          } else {
            $("#main_npwp").hide();
            $("#main_sppkp").hide();
            $("#main_sktpajak").hide();
          }

        });
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

    $(document).ready(function () {
      var siupx = '<?php if(!empty($SIUP[0]["TYPE"])){ echo $SIUP[0]["TYPE"]; } else { echo ''; } ?>';
      // console.log("SIUP = "+siupx);
      $("#tipe_siup").val(siupx);

      $(".legal_tax_data").hide();
        date_moment(".validto", true);
        date_moment(".input-group.date", false);
        // $('.input-group.date').datetimepicker({
        //     format: 'DD-MM-YYYY',
        //     minDate:  moment(),
        //     // minDateTime: new Date()
        // });

        $('input[type="file"]').change(function () {
            var filename = $("#" + this.id)[0].files[0];
            var ext = String(filename.name).split(".")
            if (ext[ext.length-1] != "pdf")
                msg_danger("Warning", "Only PDF and Max 15MB");
        });
        lang();
        check();



        var tabel_pajak = $('#tabel_pajak').DataTable({
            ajax: {
                url: '<?= base_url('vn/info/legal_data/show_data_pajak') ?>',
                dataSrc: ''
            },
            scrollX: false,
            scrollY: false,
            scrollCollapse: false,
            paging: false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            columns: [
                {title: "NO"},
                {title: "NO DOCUMENT"},
                {title: "DOCUMENT TYPE"},
                {title: "FILE DOCUMENT"},
                {title: "AKSI"},
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
            ]
        });

        var tabel = $('#akta_table').DataTable({
            "processing": true,
            "serverSide": true,
            ajax: {
                url: '<?= base_url('vn/info/legal_data/show') ?>',
                type: 'POST'
            },
            scrollX: true,
            scrollY: "300px",
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            columns: [
                {"data": "NO"},
                {"data": "NO_AKTA"},
                {"data": "AKTA_DATE"},
                {"data": "AKTA_TYPE"},
                {"data": "NOTARIS"},
                {"data": "ADDRESS"},
                {"data": "VERIFICATION"},
                {"data": "NEWS"},
                {"data": "AKTA_FILE"},
                {"data": "VERIF_FILE"},
                {"data": "NEWS_FILE"},
                {"data": "AKSI"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [8]},
                {"className": "dt-center", "targets": [9]},
                {"className": "dt-center", "targets": [10]}
            ]
        });

        $('#akta_table tbody').on('click', 'tr .update', function () {
            var data2 = tabel.row($(this).parents('tr')).data();
            $('#company_akta_update #no_akta').val(data2.NO_AKTA);
            $('#company_akta_update #jenis_akta').val(data2.AKTA_TYPE);
            $('#company_akta_update #tanggal_akta').val(data2.AKTA_DATE);
            $('#company_akta_update #nama_notaris').val(data2.NOTARIS);
            $('#company_akta_update #alamat_notaris').val(data2.ADDRESS);
            $('#company_akta_update #pengesahan').val(data2.VERIFICATION);
            $('#company_akta_update #berita').val(data2.NEWS);
            //            $('#company_akta_update #data_akta').val(data2.AKTA_FILE);
            $('#company_akta_update #akta_confirm').text("File Terupload");
            //            $('#company_akta_update #data_verif').val(data2.VERIFICATION_FILE);
            $('#company_akta_update #verification_confirm').text("File Terupload");
            //            $('#company_akta_update #data_news').val(data2.NEWS_FILE);
            $('#company_akta_update #news_confirm').text("File Terupload");
            $('#company_akta_update #keys').val(this.id);
            $('#modal_akta').modal('show');
        });
        lang();
        // $('#save').click(function (e)
        // {
        //     msg_default("Uploading", "File anda sedang diupload");
        //     $('#company_siup').submit();
        //     $('#company_tdp').submit();
        //     $('#company_npwp').submit();
        // });
        $('#company_akta').validate({
            focusInvalid: false,
            rules: {
                no_akta: {required: true, maxlength: 40},
                file_akta: {required: true},
                jenis_akta: {required: true},
                tanggal_akta: {required: true},
                nama_notaris: {required: true, maxlength: 40},
                alamat_notaris: {required: true, maxlength: 100},
                pengesahan: {required: false},
//                file_pengesahan: {required: true},
                berita: {required: false},
//                file_berita: {required: true}
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
                var elm=start($('#modal_pengalaman').find('.modal-content'));
                msg_default("Uploading", "Uploading File");
                var formData = new FormData($('#company_akta')[0]);

                formData.append('KEYS', $('#data').val());
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/legal_data/add_akta'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        if (res.status === "Sukses") {
                            if ($('#data').val !== "0")
                            {
                                $('#data').val("0");
                                document.getElementById("company_akta").reset();
                            }
                            $('#akta_table').DataTable().ajax.reload();
                            $('#modal_pengalaman').modal('hide');
                            msg_info("Success", "Data Saved");
                            setTimeout(function(){
                              window.location.reload();
                            },1000)
                        }
                        else
                        {
                            msg_danger("Warning",res.msg);
                        }
                        stop(elm);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Warning", "Oops,Something wrong");
                    }
                });
            }
        });
        $('#company_akta_update').validate({
            focusInvalid: false,
            rules: {
                no_akta: {required: true, maxlength: 40},
                file_akta: {required: true},
                jenis_akta: {required: true},
                tanggal_akta: {required: true},
                nama_notaris: {required: true, maxlength: 40},
                alamat_notaris: {required: true, maxlength: 100},
                pengesahan: {required: true},
//                file_pengesahan: {required: true},
                berita: {required: true},
//                file_berita: {required: true}
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
                var formData = new FormData($('#company_akta_update')[0]);
                var elm=start($('#modal_akta').find('.modal-content'));
                formData.append('KEYS', $('#keys').val());
                for (var key of formData.entries()) {
                    console.log(key[1]);
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/legal_data/add_akta'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        if (res.status === "Sukses") {
                            if ($('#keys').val !== "0")
                            {
                                $('#keys').val("0");
                                $('#modal_akta').modal('hide');
                                document.getElementById("company_akta_update").reset();
                            }
                            $('#akta_table').DataTable().ajax.reload();

                            msg_info(res.status, res.msg);
                            setTimeout(function(){
                              window.location.reload();
                            },1000)
                        }
                        else{
                            msg_danger(res.status, res.msg)
                        };
                        stop(elm);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Warning", "Oops,Something wrong");
                    }
                });
            }
        });
        $('#company_siup').validate({
            focusInvalid: false,
            rules: {
                created_by_siup: {required: true, maxlength: 40},
                nomor_siup: {required: true, maxlength: 40},
                tipe_siup: {required: true},
                valid_from_siup: {required: true},
                valid_to_siup: {required: true},
                <?php echo(isset($SIUP[0]["NO_DOC"]) != false ? "" : "file_siup: {required: true}") ?>
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
                var elm=start($('#LEGAL2').parent('.card'));
                var formData = new FormData($('#company_siup')[0]);

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/legal_data/add_siup'); ?>",
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
        $('#company_tdp').validate({
            focusInvalid: false,
            rules: {
                created_by_tdp: {required: true, maxlength: 40},
                nomor_tdp: {required: true, maxlength: 40},
                valid_from_tdp: {required: true},
                valid_to_tdp: {required: true},
                <?php echo(isset($TDP[0]["NO_DOC"]) != false ? "" : "file_tdp: {required: true}") ?>
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
                var elm=start($('#LEGAL3').parent('.card'));
                var formData = new FormData($('#company_tdp')[0]);

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/legal_data/add_tdp'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        if (res.status === "Sukses"){
                            msg_info(res.status, res.msg);
                            setTimeout(function(){
                              window.location.reload();
                            },1000)
                        }else{
                            msg_danger(res.status, res.msg);
                        }
                        stop(elm);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        msg_danger("Warning", "Oops,Something wrong");
                        stop(elm);
                    }
                });
            }
        });
        $('#company_npwp').validate({
            focusInvalid: false,
            rules: {
                alamat_npwp: {required: true, maxlength: 100},
                nomor_npwp: {required: true, maxlength: 40},
                npwp_province: {required: true},
                npwp_city: {required: true},
//                file_npwp: {required: true},
                postal_code: {required: true, maxlength: 10},
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
                var elm=start($('#LEGAL4').parent('.card'));
                var formData = new FormData($('#company_npwp')[0]);

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/legal_data/add_npwp'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res.status == 'Exist') {
                          msg_danger(res.status, res.msg);
                        } else {
                          if (res.status === "Sukses"){
                            msg_info(res.status, res.msg);
                            $('#doc_type_form').modal('hide');
                            $('#tabel_pajak').DataTable().ajax.reload();
                            setTimeout(function(){
                              window.location.reload();
                            },1000)
                          } else {
                            msg_danger(res.status, res.msg);
                            $('#doc_type_form').modal('hide');
                            $('#tabel_pajak').DataTable().ajax.reload();
                            setTimeout(function(){
                              window.location.reload();
                            },1000)
                          }
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        msg_danger("Warning", "Oops,Something wrong");
                        stop(elm);
                    }
                });
            }
        });
        $('#company_migas').validate({
            focusInvalid: false,
            rules: {
                issued_by_migas: {required: false, maxlength: 40},
                no_migas: {required: true, maxlength: 40},
                valid_from_migas: {required: false},
                valid_to_migas: {required: false},
                bidang_usaha_migas: {required: false, maxlength: 500},
                <?php echo(isset($SKT_MIGAS[0]["NO_DOC"]) != false ? "" : "file_migas: {required: false},") ?>
            },
            errorPlacement: function (label, element) { // render error placement for each input type
                var elmnt = element[0].id;
                if ((elmnt !== "valid_to_migas") && (elmnt !== "valid_from_migas"))
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
                var elm=start($('#LEGAL6').parent('.card'));
                var formData = new FormData($('#company_migas')[0]);

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/legal_data/add_migas'); ?>",
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
        $('#company_ebtke').validate({
            focusInvalid: false,
            rules: {
                issued_by_ebtke: {required: false, maxlength: 40},
                nomor_ebtke: {required: true, maxlength: 40},
                valid_from_ebtke: {required: false},
                valid_to_ebtke: {required: false},
                bidang_usaha_ebtke: {required: false, maxlength: 500},
                <?php echo(isset($SKT_EBTKE[0]["NO_DOC"]) != false ? "" : "file_ebtke: {required: false}") ?>
            },
            errorPlacement: function (label, element) { // render error placement for each input type
                var elmnt = element[0].id;
                if ((elmnt !== "valid_to_migas") && (elmnt !== "valid_from_migas"))
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
                var elm=start($('#LEGAL5').parent('.card'));
                var formData = new FormData($('#company_ebtke')[0]);

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/legal_data/add_ebtke'); ?>",
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
        $('#company_sppkp').validate({
            focusInvalid: false,
            rules: {
                issued_by_sppkp: {required: true, maxlength: 40},
                nomor_sppkp: {required: true, maxlength: 40},
                valid_from_sppkp: {required: true},
                valid_to_sppkp: {required: true},
                bidang_usaha_sppkp: {required: true, maxlength: 500},
                <?php echo(isset($SPPKP[0]["NO_DOC"]) != false ? "" : "file_sppkp: {required: true},") ?>
            },
            errorPlacement: function (label, element) { // render error placement for each input type
                var elmnt = element[0].id;
                if ((elmnt !== "valid_to_sppkp") && (elmnt !== "valid_from_sppkp"))
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
                var elm=start($('#LEGAL7').parent('.card'));
                var formData = new FormData($('#company_sppkp')[0]);

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/legal_data/add_sppkp'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res.status === "Sukses") {
                            msg_info(res.status, res.msg);
                            $('#doc_type_form').modal('hide');
                            $('#tabel_pajak').DataTable().ajax.reload();
                            setTimeout(function(){
                              window.location.reload();
                            },1000)
                        }else {
                            msg_danger(res.status, res.msg);
                            $('#doc_type_form').modal('hide');
                            $('#tabel_pajak').DataTable().ajax.reload();
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Warning", "Oops,Something wrong");
                    }
                });
            }
        });
        $('#company_pajak').validate({
            focusInvalid: false,
            rules: {
                issued_by_pajak: {required: true},
                nomor_pajak: {required: true, maxlength: 40},
                valid_from_pajak: {required: true},
                valid_to_pajak: {required: true},
                bidang_usaha_pajak: {required: true, maxlength: 500},
                <?php echo(isset($SKT_PAJAK[0]["NO_DOC"]) != false ? "" : "file_pajak: {required: true},") ?>
            },
            errorPlacement: function (label, element) { // render error placement for each input type
                var elmnt = element[0].id;
                if ((elmnt !== "valid_to_pajak") && (elmnt !== "valid_from_pajak"))
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
                var elm=start($('#LEGAL8').parent('.card'));
                var formData = new FormData($('#company_pajak')[0]);
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/legal_data/add_pajak'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res.status === "Sukses"){
                            msg_info(res.status, res.msg);
                            $('#doc_type_form').modal('hide');
                            $('#tabel_pajak').DataTable().ajax.reload();
                            setTimeout(function(){
                              window.location.reload();
                            },1000)
                        } else {
                            msg_danger(res.status, res.msg);
                            $('#doc_type_form').modal('hide');
                            $('#tabel_pajak').DataTable().ajax.reload();
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Warning", "Oops,Something wrong");
                    }
                });
            }
        });
        $('#company_sdkp').validate({
            focusInvalid: false,
            rules: {
              issued_by_doc: {required: true, maxlength: 50},
              nomor_doc: {required: true, maxlength: 60},
              issued_date_doc: {required: true},
              valid_to_doc: {required: true},
            },
            errorPlacement: function (label, element) { // render error placement for each input type
                var elmnt = element[0].id;
                if ((elmnt !== "valid_to_doc") && (elmnt !== "issued_date_doc"))
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
                var elm=start($('#LEGAL_SDKP').parent('.card'));
                var formData = new FormData($('#company_sdkp')[0]);

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/legal_data/add_sdkp'); ?>",
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
                        } else {
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
    });
    function delete_data(obj)
    {
        swal({
            title: "Are you sure?",
            text: "deleting this data",
            type: "warning",
            showCancelButton: true,
            CancelButtonColor: "#DD6B55",
            confirmButtonColor: "#d9534f",
            confirmButtonText: "Yes",
            closeOnConfirm: false
        }, function () {
            msg_default('Proses', "Deleting Data");
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/legal_data/delete_akta'); ?>",
                data: obj,
                cache: false,
                success: function (res)
                {
                    if (res == true)
                    {
                        $('#akta_table').DataTable().ajax.reload();
                        swal("Saved!", "Successfuly deleted Data", "success");
                        // msg_info("Sukses", "Data berhasil dihapus");
                    } else {
                        swal("Warning!", "Error deleteing Data", "failed");
                        // msg_danger("Warning", "Data gagal dihapus");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    msg_danger("Warning", "Oops,Something wrong");
                }
            });
        });
    }
    function delete_akta(key, id)
    {
        var obj;
            obj = {
                ID: id,
                KEYS: key,
            }
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
                    delete_data(obj);
            }
        });
    }
    function check()
    {

        var disb = <?php echo $stat[0]->STATUS ?>;
        console.log("disb", disb);
        if (disb == 5)
        {
            $("#company_akta :input").prop("disabled", true);
            $("#company_siup :input").prop("disabled", true);
            $("#company_tdp :input").prop("disabled", true);
            $("#company_npwp :input").prop("disabled", true);
        }
    }

    function review_akta(data)
    {

        $('#ref').attr('src', data);
        $('#modal2').modal('show');
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
                $('#modal2').modal('show');
            }
        });
    }

    function delete_data_pajak(id, no){
      console.log(id);
      console.log(no);
      var result;
      swal({
          title: "Are you sure?",
          text: "deleting this data",
          type: "warning",
          showCancelButton: true,
          CancelButtonColor: "#DD6B55",
          confirmButtonColor: "#d9534f",
          confirmButtonText: "Yes",
          closeOnConfirm: false
      }, function () {
          // msg_default('Proses', "Data Sedang dihapus");
          $.ajax({
            url: '<?= base_url('vn/info/legal_data/delete_pajak_doc'); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
              id_vendor: id,
              no_doc: no,
            }
          })
          .done(function() {
            result = true;
          })
          .fail(function() {
            result = false
          })
          .always(function(res) {
            if (res.success == true) {
              swal.close();
              msg_info("Done");
              $('#doc_type_form').modal('hide');
              $('#tabel_pajak').DataTable().ajax.reload();
            } else {
              swal.close();
              msg_danger("Ooops, Something Wrong, Please Call the admin !");
              $('#doc_type_form').modal('hide');
              $('#tabel_pajak').DataTable().ajax.reload();
            }
          });

      });
    }
</script>
