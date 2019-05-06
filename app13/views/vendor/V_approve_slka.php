<style>
    .tulisan{
        text-align:justify;
        vertical-align:top;
        /*        padding-left:10px;*/
    }

</style>

<div id="main" class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 class="title pull-right" style="margin:-10px -5px">
                        <a data-toggle="modal" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></a>
                    </h5>
                    <h5><?= lang("Review and Approve SLKA", "Vendor List") ?></h5>
                </div>
                <div class="ibox-content" style="height:420px">
                    <table id="tbl" class="table table-striped table-bordered table-hover display" width="100%"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="edit" class="wrapper wrapper-content animated fadeInRight white-bg">
    <div class="row">
        <div class="col-md-12">
            <div style="padding:10px">
                <div class="col-md-12">
                    <div class="pull-right">
                        <button type="button" class="btn btn-default" id="back" aria-hidden="true"><i class="fa fa-arrow-circle-o-left"></i>&nbsp<?= lang("Kembali", "Back") ?></button>
                    </div>
                    <h5 class="form-group pull-left"><?= lang("Tinjau Data", "Review Data") ?></h5>
                </div>
                <div class="col-md-12">
                    <hr class="m-b"></hr>
                </div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="dataumum" role="tab" data-toggle="tab"><?= lang("SLKA", "General Data") ?></a></li>
                    <li role="presentation"><a href="#profile" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Data Umum", "SLKA") ?></a></li>
                    <li role="presentation"><a href="#profile1" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Legal", "Legal") ?></a></li>
                    <li role="presentation"><a href="#profile2" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Barang & Jasa", "Goods & Service") ?></a></li>
                    <li role="presentation"><a href="#profile3" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Pengurus", "Board") ?></a></li>
                    <li role="presentation"><a href="#profile4" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Bank & Keuangan", "Bank & Financial") ?></a></li>
                    <li role="presentation"><a href="#profile5" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Sertifikasi & Pengalaman", "Certification & Experience") ?></a></li>
                    <li role="presentation"><a href="#profile6" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("CSMS", "CSMS") ?></a></li>
                </ul>
            </div>
            <div class="col-md-12">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="tulisan">
                                    <table>
                                        <tr>
                                            <td>To</td>
                                            <td>: PT VISILAND Eksekutif </td>
                                        </tr>
                                        <tr>
                                            <td>NPWP</td>
                                            <td>: 03.345.208.7-411.000</td>
                                        </tr>
                                        <tr>
                                            <td>Adress</td>
                                            <td>: Taman Ruko BSD City Sektor XI D No. 5    Kota Tanggerang – Banten 15314 </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="tulisan">
                                    <table>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Fax No.</td>
                                            <td>: 021 – 75874989</td>
                                        </tr>
                                        <tr>
                                            <td><p>Phone No.</td>
                                            <td>: 021 – 75874989</p></td>
                                        </tr>
                                    </table><br>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="tulisan">
                                    <table>
                                        <tr>
                                            <td><p>Subject</td>
                                            <td>: Company’s Letter of Administration Qualification / Surat Lulus Kualifikasi Administrasi Perusahaan (SLKA)</p></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="label-control col-md-4"></label>
                            <div class="col-md-8">

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="tulisan">
                                    <p>PT. Supreme Energy Muara Laboh; PT. Supreme Energy Rajabasa; PT. Supreme Energy Rantau Dedap (together called as “Company”) has registered and qualified your company as an Administratively Qualified Supplier at Company.<p>
                                    <p>Your Supplier Identification (S-ID) is XXXX-XXXX. Finance Qualification: Not Small Business. <p>
                                    <P>We have received all required legal and supporting documents. Supplier guarantees that the data given to “Company” are true. Supplier is obligated to inform and submit any changes or revisited documents without asked to “Company”.<P>
                                    <P>The SLKA is valid until your company submit written withdrawal letter or has been inactive for about 1 (One) year or if your documents in our database are no longer correct and valid.<P>
                                    <P>If you do not advise “Company” of your affiliated companies, and “Company” at a subsequent date becomes aware of such affiliations, we will reserve the right to discontinue immediately this SLKA or transactions with your company.<P>
                                    <P>“Company” shall have no liability whatsoever to such discontinuance of the SLKA or transactions with your company.<P>
                                    <P>Should you need further clarification, please contacts Mrs. Sandy Sahetapy telephone no 021 – 27882222.<P>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="tulisan">
                                    <p>Perusahaan saudara telah terdaftar dan memenuhi syarat kualifikasi sebagai Rekanan Lulus Administrasi di PT. Supreme Energy Muara Laboh; PT. Supreme Energy Rajabasa; PT. Supreme Energy Rantau Dedap (Bersamaan sebagai “Perusahaan”).<p>
                                    <p>Supplier ID anda (S-ID) adalah XXXX-XXXX Kualifikasi Keuangan: Bukan Usaha Kecil.<p>
                                    <p>Semua dokumen legal dan pendukung telah diterima. Rekanan menjamin kebenaran semua informasi yang disampaikan kepada “perusahaan”. Rekanan wajib memberitahukan dan menyerahkan dokumen yang telah berubah atau direvisi kepada “Perusahaan” tanpa diminta.<p>
                                    <p>SLKA ini berlaku hingga perusahaan saudara mengundurkan diri secara tertulis atau tidak aktif selama 1 (satu) tahun atau apabila dokumen yang ada dlaam database tidak benar atau sudah tidak sah.<p>
                                    <p>Bila rekanan tidak mengaku adanya perusahaan seafiliasi yang terdaftar di “Perusahaan” dan suatu saat “Perusahaan” menemukannya, maka “Perusahaan” berhak membatalkan dengan segera SLKA ini atau transaksi lebih lanjut dengan perusahaan anda.<p>
                                    <p>“Perusahaan” tidak akan mempunyai tanggung jawab apapun terhadap pembatalan SLKA ini atau transaksi lebih lanjut dengan perusahaan anda. Bila ada hal-hal yang kurang jelas, dapat menghubungi Sdri. Sandy Sahetay telephone no 021 - 27882222<p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <center>
                                <p>Jakarta, 30 March 2017<p>
                                <p>Ttd<p>
                                <p>Sally Edwina Prajoga<p>
                                <p>Head of Performance & Support SCM<p>
                            </center>
                        </div>
                        <div class="col-md-6">

                            <img src="<?php echo base_url(); ?>ast11/img/qr.jpg" height="100">
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5><?= lang("Informasi Perusahaan", "Company Information") ?></h5>
                                </div>
                                <div class="panel-body">
                                    <div class="col-sm-6">
                                        <label class="col-sm-6" for="PREFIX"><?= lang("Awalan", "Prefix"); ?></label>
                                        <span class="col-sm-4 control-label" id="PREFIX" for="PREFIX"><?php echo(isset($SIUP[0]["PREFIX"]) != false ? $SIUP[0]["PREFIX"] : '') ?>
                                        </span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-6 control-label" for="NAMA"><?= lang("Nama Perusahaan", "Company Name"); ?></label>
                                        <span class="col-sm-4 control-label" id="NAMA" for="NAMA"><?php echo(isset($vendor[0]->NAMA) != false ? $vendor[0]->NAMA : '') ?></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-6 control-label" for="SUFFIX"><?= lang("Klasifikasi Perusahaan", "Suffix"); ?></label>
                                        <span class="col-sm-4 control-label" id="SUFFIX" for="SUFFIX"><?php echo(isset($vendor[0]->SUFFIX) != false ? $vendor[0]->SUFFIX : '') ?></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-sm-6 control-label" for="KATEGORI"><?= lang("Kualifikasi Perusahaan", "Supplier Category"); ?></label>
                                        <span class="col-sm-4 control-label" id="KATEGORI" for="KATEGORI">l<?php echo(isset($vendor[0]->KATEGORI) != false ? $vendor[0]->KATEGORI : '') ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                                <div class="col-md-12 area">
                                    <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5><?= lang("Kontak Perusahaan", "Company Contact") ?></h5>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="datakontakperusahaan" class="table table-striped table-bordered table-hover display" width="100%">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5><?= lang("Alamat Perusahaan", "Company Address") ?></h5>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="alamatperusahaan" class="table table-striped table-bordered table-hover display" width="100%">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                                <div class="col-md-12 area">
                                    <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile1">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Akta</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="dataakta" class="table table-striped table-bordered table-hover display" width="100%">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                                <div class="col-md-12 area">
                                    <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>SIUP</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="col-sm-6" ><?= lang("Dibuat Oleh", "Created By"); ?></label>
                                            <span class="col-sm-4 control-label" id="CREATED_BY_SIUP" ><?php echo(isset($SIUP[0]["CREATOR"]) != false ? $SIUP[0]["CREATOR"] : '') ?></span>

                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-sm-6 control-label" >File</label>
                                            <button class="btn btn-sm btn-primary" id="SIUP_FILE"><?= lang("Lihat FILE", "File") ?><?php echo(isset($SIUP[0]["SIUP_FILE"]) != false ? $SIUP[0]["SIUP_FILE"] : '') ?></button>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-sm-6 control-label"><?= lang("Berlaku Sejak", "Valid From"); ?></label>
                                            <span class="col-sm-4 control-label"id="VALID_FROM_SIUP" ><?php echo(isset($SIUP[0]["VALID_SINCE"]) != false ? $SIUP[0]["VALID_SINCE"] : date("Y-m-d")) ?></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-sm-6 control-label" ><?= lang("Berlaku Hingga", "Valid To"); ?></label>
                                            <span class="col-sm-4 control-label" id="VALID_TO_SIUP"><?php echo(isset($SIUP[0]["VALID_UNTIL"]) != false ? $SIUP[0]["VALID_UNTIL"] : date("Y-m-d")) ?></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-sm-6 control-label"><?= lang("Nomor", "Number"); ?></label>
                                            <span class="col-sm-4 control-label" id="NO_SIUP"><?php echo(isset($SIUP[0]["NO_DOC"]) != false ? $SIUP[0]["NO_DOC"] : '') ?></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-sm-6 control-label"><?= lang("Kategori SIUP", "SIUP TYPE"); ?></label>
                                            <span class="col-sm-4 control-label" id="SIUP_TYPE" ><?php echo(isset($SIUP[0]["CATEGORY"]) != false ? $SIUP[0]["CATEGORY"] : '') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                                <div class="col-md-12 area">
                                    <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>TDP</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="col-sm-6" ><?= lang("Dibuat Oleh", "Created By"); ?></label>
                                            <span class="col-sm-4 control-label" id="CREATED_TDP_BY" ><?php echo(isset($SIUP[0]["CREATOR"]) != false ? $SIUP[0]["CREATOR"] : '') ?></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-sm-6 control-label" >File</label>
                                            <button class="btn btn-sm btn-primary" id="TDP_FILE"><?= lang("Lihat FILE", "File") ?><?php echo(isset($SIUP[0]["SIUP_FILE"]) != false ? $SIUP[0]["SIUP_FILE"] : '') ?></button>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-sm-6 control-label"><?= lang("Nomor", "Number"); ?></label>
                                            <span class="col-sm-4 control-label" id="NO_TDP" ><?php echo(isset($SIUP[0]["NO_DOC"]) != false ? $SIUP[0]["NO_DOC"] : '') ?></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-sm-6 control-label" ><?= lang("Berlaku Dari", "Valid From"); ?></label>
                                            <span class="col-sm-4 control-label" id="VALID_FROM_TDP"><?php echo(isset($SIUP[0]["VALID_SINCE"]) != false ? $SIUP[0]["VALID_SINCE"] : date("Y-m-d")) ?></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="col-sm-6 control-label"><?= lang("Berlaku Hingga", "Valid To"); ?></label>
                                            <span class="col-sm-4 control-label" id="VALID_TO_TDP"><?php echo(isset($SIUP[0]["VALID_UNTIL"]) != false ? $SIUP[0]["VALID_UNTIL"] : date("Y-m-d")) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                                <div class="col-md-12 area">
                                    <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>NPWP</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label class="col-sm-6 control-label"><?= lang("Nomor", "Number"); ?></label>
                                                    <span class="col-sm-4 control-label" id="NO_NPWP"><?php echo(isset($all[0]->NO_NPWP) != false ? $all[0]->NO_NPWP : '') ?></span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="col-sm-6 control-label" >File</label>
                                                    <button class="btn btn-sm  btn-primary" id="FILE_NPWP"><?= lang("Lihat FILE", "File") ?></button>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="col-sm-6" ><?= lang("Alamat", "Address"); ?></label>
                                                    <span class="col-sm-4 control-label" id="NPWP_NOTARIS"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="col-sm-6 control-label" ><?= lang("Provinsi NPWP", "NPWP PROVINCE") ?></label>
                                                    <span class="col-sm-4 control-label" id="NPWP_PROVINCE"></span>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="col-sm-6 control-label" ><?= lang("Kota", "City"); ?></label>
                                                    <span class="col-sm-4 control-label" id="NPWP_CITY"></span>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label class="col-sm-6 control-label"><?= lang("Kode Pos", "Postal Code"); ?></label>
                                                    <span class="col-sm-4 control-label" id="POSTAL_CODE"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                                <div class="col-md-12 area">
                                    <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile2">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Sertifikasi Keagenan dan Prinsipal</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <table id="datasertifikasi" class="table table-striped table-bordered table-hover display" width="100%">
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Daftar Jasa</h5>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <table id="daftarjasa" class="table table-striped table-bordered table-hover display" width="100%">
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Daftar Barang</h5>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <table id="daftarbarang" class="table table-striped table-bordered table-hover display" width="100%">
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="profile3">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Daftar Dewan direksi</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12" style="overflow:auto">
                                        <table id="dataDewanDireksi" class="table table-striped table-bordered table-hover display" width="100%">
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Daftar Pemilik Saham</h5>
                                </div>
                                <div class="panel-body">
                                    <table id="databank" class="table table-striped table-bordered table-hover display" width="100%">
                                    </table>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                            </div>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="profile4">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Neraca Keuangan</h5>
                                </div>
                                <div class="panel-body">
                                    <table id="neraca_keuangan_tabel" class="table table-striped table-bordered table-hover display" width="100%">

                                    </table>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Daftar Rekening Bank</h5>
                                </div>
                                <div class="panel-body">
                                    <table id="daftar_rekening_bank" class="table table-striped table-bordered table-hover display" width="100%">
                                    </table>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile5">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Sertifikasi Umum</h5>
                                </div>
                                <div class="panel-body">
                                    <table id="tabelsertifikasi" class="table table-striped table-bordered table-hover display" width="100%">

                                    </table>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5>Pengalaman Perusahaan</h5>
                                </div>
                                <div class="panel-body">
                                    <table id="data_pengalaman" class="table table-striped table-bordered table-hover display" width="100%">

                                    </table>
                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile6">
                        <div class="row">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Kepemimpinan Dan manajemen
                                </div>
                                <div class="panel-body">
                                    <span><strong>a) Bagaimana manajer senior di manajemen puncak terlibat secara pribadi dalam manajemen SHE?</strong></span><br/>
                                    <div class="form-group">
                                        <span>terlibat secara langsung</span><br/>
                                    </div>
                                    <span><strong>b) Berikan bukti komitmen di semua tingkat organisasi dengan:</strong></span><br/>
                                    <div class="form-group">
                                        <span>Kinerja SHE semakin dimaksimalkan</span><br/>
                                    </div>
                                    <div class="form-group">
                                        <span>SHE sudah menjadi SOP perusahaan</span><br/>
                                    </div>

                                    <span><strong>c) Bagaimana Anda mempromosikan budaya positif terhadap masalah SHE?</strong></span><br/>
                                    <div class="form-group">
                                        <span>Dengan melakukan training</span><br/>
                                    </div>
                                    <span><strong>d) Berikan bagan organisasi Anda saat ini</strong></span><br/>
                                    <div class="form-group">
                                        <span>Direksi->MAnajer->MAnajer Keuangan->Dll</span><br/>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Tujuan Kebijakan dan Strategi
                                </div>
                                <div class="panel-body">
                                    <span><strong>2.1. Kebijakan dan Dokumen SHE</strong></span><br/>
                                    <div class="form-group">
                                        <span>Dengan melakukan training</span><br/>
                                    </div>
                                    <div class="form-group">
                                        <span>SHE sudah menjadi SOP perusahaan</span><br/>
                                    </div>
                                    <div class="form-group">
                                        <span>Dengan melakukan training</span><br/>
                                    </div>
                                    <span><strong>2.2. Ketersediaan Kebijakan Pernyataan kepada karyawan</strong></span><br/>
                                    <div class="form-group">
                                        <span>SHE sudah menjadi SOP perusahaan</span><br/>
                                    </div>

                                </div>
                            </div>
                            <div class="row m-b">
                                <div class="col-md-5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-right">
                <!--<button class="btn btn-default btn-sm demo2"><?= lang("Tutup", "Close") ?></button>-->
                <button class="btn btn-danger btn-sm demo2"><?= lang("Batal", "Reject") ?></button>
                <button class="btn btn-primary btn-sm demo3"><?= lang("simpan", "Approve") ?></button>
            </div>
        </div>
    </div>
</div>
<!--change data-->
<!--<div class="modal fade bs-example-modal-lg" data-backdrop="static" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>-->
<div id="modal2" class="modal fade" role="dialog"  >
    <div class="modal-dialog" style="width:800px">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Preview File</h4>
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
<div id="modal-filter" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class=" modal-content">
            <form id="form" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-filter"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label class="form-label col-md-12" for="field-1"><?= lang("Nama Vendor", "Vendor Name") ?></label>
                            <div class="col-md-12">
                                <select style="width:100%" class="col-md-12" id="search_name" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-12" for="field-1">Email</label>
                            <div class="col-md-12">
                                <select style="width:100%" class="col-md-12" id="search_email" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <div class="form-label col-md-12">
                                <hr style="margin-bottom:5px;border:1px solid #e7eaec"/>
                            </div>
                            <label class="form-label col-md-12" for="field-1">Status</label>
                            <div class="col-md-12">
                                <div class="i-checks col-md-6">
                                    <label><input type="checkbox" value="aktif" id="status1"> <i></i> <?= lang("Aktif", "Active") ?> </label>
                                </div>
                                <div class="i-checks col-md-6">
                                    <label><input type="checkbox" value="tidak" id="status2"> <i></i> <?= lang("Tidak Aktif", "NotActive") ?> </label>
                                </div>
                            </div>

                            <label class="form-label col-md-6" for="field-1"><?= lang("Batas Data", "Limit Data") ?></label>
                            <div class="col-md-12 m-b">
                                <div class="input-group">
                                    <input class="touchspin3" type="text" value="100" id="limit2" name="demo3">
                                    <span class="input-group-addon" id="total"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="button" onclick="get()" class="btn btn-info" id="save"><?= lang('Filter', 'Filter') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--<div id="modal-rev" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                                <label id="label_rej" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                                <textarea class="form-control" rows="5" id="note" name="note"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default"><?= lang("Batal", "Cancel") ?></button>
                <button class="btn btn-primary" id="setuju_rev"><?= lang("Setuju", "Save") ?></button>
                <button class="btn btn-danger" id="tolak_rev"><?= lang("Tolak", "Save") ?></button>
            </div>
        </div>
    </div>
</div>-->

<div id="modal_ref" class="modal fade" role="dialog"  >
    <div class="modal-dialog" style="width:800px">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Preview File</h4>
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

<!--approve-->
<div id="modal_app" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="approve_mdl">
            <div class="modal-header">
                <?= lang("Persetujuan Data", "Approval Data") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input style="display:none" name="id_vendor" class="id_vendor" hidden>
                    <input style="display:none" name="email" class="email" hidden>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                                <textarea placeholder="Isi komentar anda" class="form-control" rows="5" id="note" name="note"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-primary"><?= lang("Setujui dan Kirim Undangan", "Approve and send invitation") ?></button>
            </div>
        </form>
    </div>
</div>

<!--reject-->
<div id="modal_rej" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="reject_mdl">
            <div class="modal-header">
                <?= lang("Tolak Data", "Reject Data") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input style="display:none" name="id_vendor" class="id_vendor" hidden>
                    <input style="display:none" name="email" class="email" hidden>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                                <label id="label_kirim" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                                <textarea placeholder="Isi komentar anda" class="form-control" rows="5" id="note" name="note" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-danger"><?= lang("Tolak Undangan", "Reject invitation") ?></button>
            </div>
        </form>
    </div>
</div>

<script>
    $(function() {
        lang();
        $('#approve_mdl').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('vendor/approve_slka/change_btn/7') ?>',
                data: $('#approve_mdl').serialize(),
                success: function (m) {
                    if (m == 'sukses') {
                        $('#modal_app').modal('hide');
                        msg_info('Approve Berhasil');
                        $('#tbl').DataTable().ajax.reload();
                    } else {
                        msg_danger(m);
                    }
                }
            });
        });
        $('#reject_mdl').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('vendor/approve_slka/change_btn/13') ?>',
                data: $('#reject_mdl').serialize(),
                success: function (m) {
                    if (m == 'sukses') {
                        $('#modal_rej').modal('hide');
                        msg_info('Reject Berhasil');
                        $('#tbl').DataTable().ajax.reload();
                    } else {
                        msg_danger(m);
                    }
                }
            });
        });

        $(".area label").hide();
        $("#back").click(function() {
            $('#edit').hide();
            $('#datakontakperusahaan').DataTable().destroy();
            $('#alamatperusahaan').DataTable().destroy();
            $('#dataakta').DataTable().destroy();
            $('#datasertifikasi').DataTable().destroy();
            $('#daftarjasa').DataTable().destroy();
            $('#daftarbarang').DataTable().destroy();
            $('#dataDewanDireksi').DataTable().destroy();
            $('#neraca_keuangan_tabel').DataTable().destroy();
            $('#daftar_rekening_bank').DataTable().destroy();
            $('#tabelsertifikasi').DataTable().destroy();
            $('#main').show();
        });
        $(".touchspin3").TouchSpin({
            verticalbuttons: true,
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        $('#edit').on('show', function() {
            console.log("tes");
            $('#datakontak').DataTable().columns.adjust().draw();
            $('#dataalamat').DataTable().columns.adjust().draw();
            $('#dataakta').DataTable().columns.adjust().draw();
        });

        $('#modal2').on('hidden.bs.modal', function(e) {
            if ($('#modal').hasClass('in')) {
                $('body').addClass('modal-open');
            }
        });
        $('#modal').modal('hide');
        $('#edit').hide();
        var selected = [];
        var table = $('#tbl').DataTable({
            "ajax": {
                "url": "<?= base_url('vendor/approve_slka/show') ?>",
                "dataSrc": ""
            },
            "data": null,
            "searching": false,
            "paging": false,
            "columns": [
                {title: "<center>No</center>"},
                {title: "<center><?= lang('Nama Vendor', 'Vendor Name') ?></center>"},
                {title: "<center>Email</center>"},
                {title: "<center>Status</center>"},
                {title: "<center><?= lang("Aksi", "Action") ?></center>"},
                {title: "<center><?= lang("Rincian", "Detail") ?></center>"}
            ],
            "columnDefs": [
                {"className": "dt-right", "targets": [0]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
            ],
            "scrollX": true,
            "scrollY": '300px',
            "scrollCollapse": true,
        });
        lang();
        $('#tbl tbody').on('click', 'tr', function() {
            var data = table.rows({selected: true}).data();
            var data2 = table.rows(this).data();
        });
        $('#home a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
        $('#profile a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
        $('#modal').on('shown.bs.modal', function() {
            $('#datakontak').DataTable().columns.adjust().draw();
            $('#dataalamat').DataTable().columns.adjust().draw();
            $('#dataakta').DataTable().columns.adjust().draw();
        });
    });
    function accept(id, id_vendor) {
        document.getElementById("form").reset();
        $('.id_vendor').val(id);
        $('#modal_app .email').val(id_vendor);
        $('#modal_app .id_vendor').val(id_vendor);
        $('#modal_app .modal-header').css("background", "#347ab5");
        $('#modal_app .modal-header').css("color", "#fff");
        $('#modal_app').modal('show');
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
    function check_list()
    {
        var supps=$('#supps').val();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('vendor/approve_slka/getlist/') ?>'+supps,
            success: function(msg) {
                $('#tbl_checklist').html(msg);
                $('#check_list_data .modal-header').css("background-color", "#1c84c6");
                $('#check_list_data .modal-header').css("color", "#fff");
                $('#check_list_data').modal('show');
                lang();
            }
        });
        lang();
    }

//    function accept(id) {
//        $('#modal_app').modal('show');
//    }

//        kirim email
//    function approve() {
//        $.ajax({
//            url: "<?= base_url('vendor/Approve_slka/approve_vendor/') ?>",
//            type: "POST",
//            data: $('#update_vendor').serialize(),
//            dataType: "JSON",
//            success: function(m) {
//                if (m) //if success close modal and reload ajax table
//                {
//                    $('#tbl').DataTable().ajax.reload();
//                    $('#modal_app').modal('hide');
//                    msg_info('Berhasil Dikirim');
//                } else {
//                    $('#modal_app').modal('hide');
//                    msg_danger('Gagal Dikirim!');
//                }
//            }
//        });
//    }

    function add(id,idvendor) {
        var obj = {};
        obj.ID_VENDOR = id;
        $('#supps').val(idvendor);
        $.ajax({
            type: "POST",
            url: "<?= site_url('vendor/approve_slka/get_data/'); ?>" + id,
            data: "",
            cache: false,
            processData: false,
            contentType: false,
            success: function(res){
                if (res != false){
                    tbl(id);
                    $('#NAMA').text(res[0]["GEN"][0]);
                    $('#PREFIX').text(res[0]["GEN"][1]);
                    $('#SUFFIX').text(res[0]["GEN"][2]);
                    $('#KATEGORI').text(res[0]["GEN"][3]);

                    // SIUP
                    $('#CREATED_BY_SIUP').text(res["SIUP"][3]);
                    $('#NO_SIUP').text(res["SIUP"][4]);
                    $('#VALID_FROM_SIUP').text(res["SIUP"][1]);
                    $('#VALID_TO_SIUP').text(res["SIUP"][2]);
                    $('#SIUP_TYPE').text(res["SIUP"][0]);
                    $('#SIUP_FILE').attr('onClick', 'review("' + res["SIUP"][5] + '","SIUP/")');
                    // TDP
                    $('#CREATED_TDP_BY').text(res["TDP"][3]);
                    $('#NO_TDP').text(res["TDP"][4]);
                    $('#VALID_FROM_TDP').text(res["TDP"][1]);
                    $('#VALID_TO_TDP').text(res["TDP"][2]);
                    $('#TDP_FILE').attr('onClick', 'review("' + res["TDP"][5] + '","TDP/")');
                    // EBTKE
                    $('#CREATED_EBTKE_BY').text(res["SKT_EBTKE"][3]);
                    $('#NO_EBTKE').text(res["SKT_EBTKE"][4]);
                    $('#VALID_FROM_EBTKE').text(res["SKT_EBTKE"][1]);
                    $('#VALID_TO_EBTKE').text(res["SKT_EBTKE"][2]);
                    $('#EBTKE_FILE').attr('onClick', 'review("' + res["SKT_EBTKE"][5] + '","TDP/")');
                    //MIGAS
                    $('#CREATED_MIGAS_BY').text(res["SKT_MIGAS"][3]);
                    $('#NO_MIGAS').text(res["SKT_MIGAS"][4]);
                    $('#VALID_FROM_MIGAS').text(res["SKT_MIGAS"][1]);
                    $('#VALID_TO_MIGAS').text(res["SKT_MIGAS"][2]);
                    $('#MIGAS_FILE').attr('onClick', 'review("' + res["SKT_MIGAS"][5] + '","TDP/")');

                    $('#NO_NPWP').text(res[0]["NPWP"][0]);
                    $('#NPWP_NOTARIS').text(res[0]['NPWP'][1]);
                    $('#NPWP_PROVINCE').text(res[0]["NPWP"][2]);
                    $('#NPWP_CITY').text(res[0]["NPWP"][3]);
                    $('#FILE_NPWP').attr('onClick', 'review("' + res[0]["NPWP"][5] + '","NPWP/")');
                    $('#POSTAL_CODE').text(res[0]["NPWP"][4]);

                    $('#main').hide();
                    $('#edit').show();
                    $('#datakontak').DataTable().columns.adjust().draw();
                    $('#dataalamat').DataTable().columns.adjust().draw();
                    $('#dataakta').DataTable().columns.adjust().draw();
                    lang();
                    $('.demo3').click(function() {
                        swal({
                            title: "Are you sure?",
                            text: "You will not be able to change this data!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, saved it!",
                            closeOnConfirm: false
                        }, function() {
                            var obj = {};
                            obj.ID_VENDOR = id;
                            $.ajax({
                                type: "POST",
                                url: "<?php echo site_url('vendor/show_vendor/approve'); ?>",
                                data: obj,
                                cache: false,
                                success: function(res)
                                {
                                    if (res == true) {
                                        swal("Saved!", "You cannot changed the data until there is further notice", "success");
                                    } else {
                                        swal("Failed!", "Oops, There is some errors,please try again", "failed");
                                    }
                                }
                            });
                        });
                    });
                    $('.demo2').click(function() {
                        swal({
                            title: "Are you sure?",
                            text: "You will not be able to change this data!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, saved it!",
                            closeOnConfirm: false
                        }, function() {
                            var obj = {};
                            obj.ID_VENDOR = id;
                            $.ajax({
                                type: "POST",
                                url: "<?php echo site_url('vendor/show_vendor/reject'); ?>",
                                data: obj,
                                cache: false,
                                success: function(res)
                                {
                                    if (res == true)
                                    {
                                        swal("Saved!", "You cannot changed the data until there is further notice", "success");
                                    } else {
                                        swal("Failed!", "Oops, There is some errors,please try again", "failed");
                                    }
                                }
                            });
                        });
                    });
                } else {
                    tbl(id);
                    lang();
                    //msg_danger("Peringatan", "Data tidak ditemukan");
                    //                    $('#modal').modal('show');
                    $('#main').hide();
                    $('#edit').show();
                    lang();
                }
            }
        });
    }
    function pilih(elem)
    {
        var id = elem.id;
        console.log(id);
        console.log($(elem).parent('label').css('display', 'initial'));
        var text = null;
        if (id == "info") {
            $("#info_text").show();
        } else if (id == "kontak") {
            $("#kontak_text").show();
        } else if (id == "address") {
            $("#address_text").show();
        } else if (id == "akta") {
            $("#akta_text").show();
        } else if (id == "siup") {
            $("#siup_text").show();
        } else if (id == "tdp") {
            $("#tdp_text").show();
        } else if (id == "npwp") {
            $("#npwp_text").show();
        }

    }
    function review(data, pilih)
    {
        $('#ref').attr('src', "<?php echo base_url() ?>upload/LEGAL_DATA/" + pilih + data);
        $('#modal2').modal('show');
    }
    function review_akta(data)
    {
        $('#ref').attr('src', data);
        $('#modal2').modal('show');
    }
    function tbl(id)
    {
        var obj = {};
        obj.ID_VENDOR = id;
        var tabel = $('#datakontakperusahaan').DataTable({
            ajax: {
                url: '<?= base_url('vendor/approve_slka/datakontakperusahaan/') ?>' + id,
                dataSrc: ''
            },
            "searching": false,
            "scrollX": true,
            "selected": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "destroy": true,
            // fixedColumns: {
            //     leftColumns: 1,
            //     rightColumns: 1
            // },
            "columns": [
                {title: "<center>No</center>"},
                {title: "<center><?= lang("Nama Pegawai", "Employee Name") ?></center>"},
                {title: "<center><?= lang("Jabatan", "Position") ?></center>"},
                {title: "<center><?= lang("Telp - Ekstensi", "Telp - Extention") ?></center>"},
                {title: "<center><?= lang("Email", "Email") ?></center>"},
                {title: "<center>Hp</center>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]}
            ],
        });
        lang();

        var tabel2 = $('#alamatperusahaan').DataTable({
            "ajax": {
                url: '<?= base_url('vendor/approve_slka/alamatperusahaan/') ?>' + id,
                "dataSrc": ""
            },
            "searching": false,
            "scrollX": true,
            "selected": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "destroy": true,
            // fixedColumns: {
            //     leftColumns: 1,
            //     rightColumns: 1
            // },
            "columns": [
                {title: "<center>No</center>"},
                {title: "<center><?= lang("Tipe Kantor", "Branch Office") ?></center>"},
                {title: "<center><?= lang("Alamat", "Address") ?></center>"},
                {title: "<center><?= lang("Negara", "Country") ?></center>"},
                {title: "<center><?= lang("Provinsi", "Province") ?></center>"},
                {title: "<center><?= lang("Kota", "Country") ?></center>"},
                {title: "<center><?= lang("Kode Pos", "Postal Code") ?></center>"},
                {title: "<center><?= lang("Telp", "Telp") ?></center>"},
                {title: "<center>No. Hp</center>"},
                {title: "<center>Fax</center>"},
                {title: "<center>Website</center"}
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
                {"className": "dt-center", "targets": [10]}
            ],
        });

        var tabel3 = $('#dataakta').DataTable({
            ajax: {
                url: '<?= base_url('vendor/approve_slka/dataakta/') ?>' + id,
                dataSrc: ''
            },
            "searching": false,
            "scrollX": true,
            "selected": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "destroy": true,
            // fixedColumns: {
            //     leftColumns: 1,
            //     rightColumns: 1
            // },
            "columns": [
                {title: "<center>No</center>"},
                {title: "<center><?= lang("No. Akta", "Akta ID") ?></center>"},
                {title: "<center><?= lang("Tanggal Akta", "Akta Date") ?></center>"},
                {title: "<center><?= lang("Tipe Akta", "Akta Type") ?></center>"},
                {title: "<center><?= lang("Notaris", "Notaris") ?></center>"},
                {title: "<center><?= lang("Alamat Notaris", "Notaris Address") ?></center>"},
                {title: "<center><?= lang("Pengesahan<br/>Kehakiman", "Judges Verification") ?></center>"},
                {title: "<center><?= lang("Berita Negara", "Judges Approval") ?></center>"},
                {title: "<center><?= lang("Dok. Akta", "Akta Dok.") ?></center>"},
                {title: "<center><?= lang("Dok. Pengesahan", "Verification Dok.") ?></center>"},
                {title: "<center><?= lang("Dok. Berita", "State Dok.") ?></center>"}
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
                {"className": "dt-center", "targets": [9]}
            ],
        });
        lang();

        var tabel4 = $('#datasertifikasi').DataTable({
            ajax: {
                url: '<?= base_url('vendor/approve_slka/show_datasertifikasi/') ?>' + id,
                dataSrc: ''
            },
            "searching": false,
            "scrollX": true,
            "selected": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "destroy": true,
            // fixedColumns: {
            //     leftColumns: 1,
            //     rightColumns: 1
            // },
            "columns": [
                {title: "<center>No</center>"},
                {title: "<center><?= lang("Dikeluarkan Oleh", "Issued By") ?></center>"},
                {title: "<center><?= lang("Nomer", "Number") ?></center>"},
                {title: "<center><?= lang("Dikeluarakan Tanggal", "Issued Date") ?></center>"},
                {title: "<center><?= lang("Tanggal Kadaluarsa", "Expired Date") ?></center>"},
                {title: "<center><?= lang("Kualifikasi", "Cualification") ?></center>"},
                {title: "<center><?= lang("File", "File") ?></center>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]}
            ],
        });
        lang();

        var tabel5 = $('#daftarjasa').DataTable({
            ajax: {
                url: '<?= base_url('vendor/approve_slka/daftarjasa/') ?>' + id,
                dataSrc: ''
            },
            "searching": false,
            "scrollX": true,
            "selected": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "destroy": true,
            "columns": [
                {title: "<center>No</center>"},
                {title: "<center><?= lang("Group Jasa", "Sub Group J") ?></center>"},
                {title: "<center><?= lang("Sub Group Jasa", "Service Group Sub") ?></center>"},
                {title: "<center><?= lang("Nama Jasa", "Service Name") ?></center>"},
                {title: "<center><?= lang("Deskripsi", "Description") ?></center>"},
                {title: "<center><?= lang("Nomor Izin", "License number") ?></center>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]}
            ],
        });
        lang();

        var tabel6 = $('#daftarbarang').DataTable({
            ajax: {
                url: '<?= base_url('vendor/approve_slka/daftarbarang/') ?>' + id,
                dataSrc: ''
            },
            "searching": false,
            "scrollX": true,
            "selected": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "destroy": true,
            // fixedColumns: {
            //     leftColumns: 1,
            //     rightColumns: 1
            // },
            "columns": [
                {title: "<center>No</center>"},
                {title: "<center><?= lang("Nama Barang", "Name of goods") ?></center>"},
                {title: "<center><?= lang("Merk", "Brand") ?></center>"},
                {title: "<center><?= lang("File", "File") ?></center>"},
                {title: "<center><?= lang("Deskripsi", "Description") ?></center>"},
                {title: "<center><?= lang("Nomor", "Number") ?></center>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]}
            ],
        });
        lang();

        var tabel7 = $('#dataDewanDireksi').DataTable({
            ajax: {
                url: '<?= base_url('vendor/approve_slka/show_company_management/') ?>' + id,
                dataSrc: ''
            },
            "searching": false,
            "data": null,
            "paging": false,
            "destroy": true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            columns: [
                {title: "<span>No.</span>"},
                {title: "<?= lang("Nama Lengkap (Sesuai KTP)", "Full Name (As per ID)") ?>"},
                {title: "<?= lang("Jabatan", "Position") ?>"},
                {title: "<?= lang("Nomor Telepon", "Phone number") ?>"},
                {title: "<?= lang("Email", "Email") ?>"},
                {title: "<?= lang("Nomor KTP", "ID card number") ?>"},
                {title: "<?= lang("Scan KTP", "Scan KTP") ?>"},
                {title: "<?= lang("Berlaku Sampai", "Valid until") ?>"},
                {title: "<?= lang("NPWP", "NPWP") ?>"},
                {title: "<?= lang("Scan NPWP", "Scan NPWP") ?>"},
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
            "scrollX": false,
            "scrollY": '300px',
            "scrollCollapse": true,
        });
        lang();

        var tabel8 = $('#databank').DataTable({
            ajax: {
                url: '<?= base_url('vendor/approve_slka/show_vendor_shareholders/') ?>' + id,
                dataSrc: ''
            },
            "searching": false,
            "data": null,
            "paging": false,
            "destroy": true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            columns: [
                {title:"<span>No.</span>"},
                {title:"<?= lang("Tipe Pemilik Saham", "Share Owner Type") ?>"},
                {title:"<?= lang("Nama Lengkap", "Full name") ?>"},
                {title:"<?= lang("Nomor Telepon", "Phone number") ?>"},
                {title:"<?= lang("Email", "Email") ?>"},
                {title:"<?= lang("Berlaku Sampai", "Valid until") ?>"},
                {title:"<?= lang("NPWP", "NPWP") ?>"},
                {title:"<?= lang("Scan NPWP", "Scan NPWP") ?>"},
            ],
            "columnDefs": [
                {"className": "dt-right", "targets": [0]},
                {"className": "dt-center", "targets": [4]}
            ],
            "scrollX": false,
            "scrollY": '300px',
            "scrollCollapse": true
        });
        lang();

        var tabel9 = $('#neraca_keuangan_tabel').DataTable({
            ajax: {
                url: '<?= base_url('vendor/approve_slka/show_financial_bank_data/') ?>' + id,
                dataSrc: ''
            },
            "searching": false,
            "data": null,
            "paging": false,
            "destroy": true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            "columns": [
                {title:"<span>No.</span>"},
                {title: "<?= lang("Tahun Laporan", "Report Year") ?>"},
                {title: "<?= lang("Jenis Laporan", "Report Type") ?>"},
                {title: "<?= lang("Valuta", "Valuta") ?>"},
                {title: "<?= lang("Nilai Asset", "Asset Value") ?>"},
                {title: "<?= lang("Hutang", "Debt") ?>"},
                {title: "<?= lang("Pendapatan Kotor", "Gross Income") ?>"},
                {title: "<?= lang("Labah Bersih", "Clean Laba") ?>"},
                {title: "<?= lang("File Neraca</br>Keuangan", "Financial</br>Balance File") ?>"},
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
            ],
            "scrollX": false,
            "scrollY": '300px',
            "scrollCollapse": true
        });
        lang();

        var tabel10 = $('#daftar_rekening_bank').DataTable({
            ajax: {
                url: '<?= base_url('vendor/approve_slka/show_vendor_bank_account/') ?>' + id,
                dataSrc: ''
            },
            "searching": false,
            "data": null,
            "paging": false,
            "destroy": true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            columns: [
                {title:"No"},
                {title:"<?= lang("Bank", "Share Owner Type") ?>"},
                {title:"<?= lang("Alamat", "Full name") ?>"},
                {title:"<?= lang("Cabang", "Phone number") ?>"},
                {title:"<?= lang("Nomor. Rekening", "Email") ?>"},
                {title:"<?= lang("Nama Akun", "Valid until") ?>"},
                {title:"<?= lang("Mata Uang", "NPWP") ?>"},
                {title:"<?= lang("File", "File") ?>"},
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
            ],
            "scrollX": false,
            "scrollY": '300px',
            "scrollCollapse": true
        });
        lang();

        var tabel11 = $('#tabelsertifikasi').DataTable({
            ajax: {
                url: '<?= base_url('vendor/approve_slka/show_certification/') ?>' + id,
                dataSrc: ''
            },
            "searching": false,
            "data": null,
            "paging": false,
            "destroy": true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            columns: [
                {title:"<span>No.</span>"},
                {title:"<?= lang("Jenis Sertifikasi", "Certification Type") ?>"},
                {title:"<?= lang("Nama Sertifikasi", "Certification Name") ?>"},
                {title:"<?= lang("No. Sertifikasi", "Number Certification") ?>"},
                {title:"<?= lang("Dikeluarkan Oleh", "Issued By") ?>"},
                {title:"<?= lang("Berlaku Mulai", "Apply Start") ?>"},
                {title:"<?= lang("Berlaku Sampai", "Apply End") ?>"},
                {title:"<?= lang("File", "File") ?>"},
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
            ],
            "scrollX": false,
            "scrollY": '300px',
            "scrollCollapse": true
        });
        lang();

        var tabel12 = $('#data_pengalaman').DataTable({
            ajax: {
                url: '<?= base_url('vendor/approve_slka/show_experience/') ?>' + id,
                dataSrc: ''
            },
            "searching": false,
            "data": null,
            "paging": false,
            "destroy": true,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            columns: [
                {title:"<span>No.</span>"},
                {title:"<?= lang("Nama Pelanggan", "Customers Name") ?>"},
                {title:"<?= lang("Nama Projek", "Project Name") ?>"},
                {title:"<?= lang("Projek Description", "Project Name") ?>"},
                {title:"<?= lang("Nilai Project", "Project Value") ?>"},
                {title:"<?= lang("No. Kontrak", "Contract Number") ?>"},
                {title:"<?= lang("Tanggal Mulai", "Start Date") ?>"},
                {title:"<?= lang("Tanggal Selesai", "Finish Date") ?>"},
                {title:"<?= lang("Contact Person", "Contact Person") ?>"},
                {title:"<?= lang("No. Tlpn", "No. Tlpn") ?>"},
            ],
            "columnDefs": [
                {"className": "dt-right", "targets": [0]},
                {"className": "dt-center", "targets": [4]}
            ],
            "scrollX": false,
            "scrollY": '300px',
            "scrollCollapse": true
        });
        lang();
    }

    function get()
    {
        var name = $('#search_name').val();
        var email = $('#search_email').val();
        var obj = {};
        //            if (name !== null) {
        //    name.map((data, index) = > {
        //    obj["name" + index] = data;
        //    });
        //    } //    else
        //     {
        //    obj["name"] = null;
        //    }
        //    if (email !== null){
        //    email.map((data, index) = > {
        //    obj["email" + index] = data;
        //    });
        //    }
        //    else{
        //    obj["email"] = null;
        //    }
        if ($('#status1').is(":checked"))
            obj.status1 = 5;
        else
            obj.status1 = "none";
        if ($('#status2').is(":checked"))
            obj.status2 = 0;
        else
            obj.status2 = "none";
        obj.limit = $('#limit2').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('vendor/show_vendor/filter_data'); ?>",
            data: obj,
            cache: false,
            success: function(res)
            {
                $('#tbl').DataTable().clear().draw();
                $('#tbl').DataTable().rows.add(res).draw();
                var tamp = 0;
                if (res.length > 0)
                    tamp = 1;
                $('#info').text("Showing " + tamp + " to " + res.length + " data from " +<?= (isset($total) != false ? $total : '0') ?>)
                $('#modal-filter').modal('hide');
            }
        })
    }

    function reject(id, id_vendor)
    {
        $('#modal_rej').modal('show');
        $('#modal_rej .email').val(id_vendor);
        $('#modal_rej .id_vendor').val(id);
        $('#modal_rej .modal-header').css("background", "#d9534f");
        $('#modal_rej .modal-header').css("color", "#fff");
    }

    function review_gambar(data)
    {
        //$('.modal-title').html("Priview File") ?>");
        $('#ref').attr('src', data);
        $('#modal_ref').modal('show');
    }

</script>
