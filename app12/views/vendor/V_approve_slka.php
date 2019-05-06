<style>
    .tulisan{
        text-align:justify;
        vertical-align:top;
        /*        padding-left:10px;*/
    }
    .form-control:disabled, .form-control[readonly] {
        background-color: #FFF;
    }
</style>

<div class="app-content content">
    <div class="content-wrapper">

        <div id="main" class="wrapper wrapper-content animated fadeInRight">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-1">
                    <h3 class="content-header-title"><?= lang("Persetujuan Registrasi Supplier", "Supplier Registration Approval") ?></h3>
                </div>

                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home">Home</a>
                            </li>
                            <li class="breadcrumb-item"><?= lang("Management Supplier", "Management Supplier") ?>
                            </li>
                            <li class="breadcrumb-item"><?= lang("Review and Approve SLKA", "Vendor List") ?>
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
                                          <!-- <h4 class="card-title"><h5><?= lang("Daftar Pendaftaran", "List Registration") ?></h5></h4> -->
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="card-header">
                                            <div class="heading-elements">
                                                <h5 class="title pull-right">
                                                    <button data-toggle="modal" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></button>
                                                </h5>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>


                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="tbl" class="table table-striped table-bordered zero-configuration" width="100%">

                                                  <tfoot>
                                                      <tr>
                                                        <th>No</th>
                                                        <th>Nama Vendor</th>
                                                        <th>Email</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                      </tr>
                                                  </tfoot>
                                                </table>
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

        <div id="edit" class="wrapper wrapper-content animated fadeInRight white-bg">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <!--iwan edit-->
                                    <button type="button" class="btn btn-primary" href='javascript:void(0)' onclick='accept()' aria-hidden="true"><i class="fa fa-check"></i>&nbsp<?= lang("Setujui", "Apporve") ?></button>
                                    <button type="button" class="btn btn-danger" href='javascript:void(0)' onclick='reject()' aria-hidden="true"><i class="fa fa-ban"></i>&nbsp<?= lang("Tolak", "Reject") ?></button>
                                    <button type="button" class="btn btn-default" id="back" aria-hidden="true"><i class="fa fa-arrow-circle-o-left"></i>&nbsp<?= lang("Kembali", "Back") ?></button>
                                </div>
                            </div>
                            <h5 class="form-group pull-left"><?= lang("Tinjau Data", "Review Data") ?></h5>
                        </div>


                        <div class="card-content">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-top-border no-hover-bg" role="tablist">
                                    <li role="nav-item" class="active"><a href="#home" class="nav-link" aria-controls="dataumum" role="tab" data-toggle="tab"><?= lang("SLKA", "SLKA") ?></a></li>
                                    <li role="nav-item"><a href="#profile" id="data_umum" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Data Umum", "General Data") ?></a></li>
                                    <li role="nav-item"><a href="#profile1" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Legal", "Legal") ?></a></li>
                                    <li role="nav-item"><a href="#profile2" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Barang & Jasa", "Goods & Service") ?></a></li>
                                    <li role="nav-item"><a href="#profile3" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Pengurus", "Legal data") ?></a></li>
                                    <li role="nav-item"><a href="#profile4" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Bank & Keuangan", "finance & bank") ?></a></li>
                                    <li role="nav-item"><a href="#profile5" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Sertifikasi & Pengalaman", "Experience & Sertification") ?></a></li>
                                    <li role="nav-item" id="csms"><a href="#profile6" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("CSMS", "CSMS") ?></a></li>
                                </ul>
                                <div class="tab-content px-1 pt-1">
                                    <div class="col-md-12">
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="home">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="tulisan">
                                                            <table>
                                                                <tr>
                                                                    <td>To</td>
                                                                    <td id="name_slka"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>NPWP</td>
                                                                    <td id="npwp_slka"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Adress</td>
                                                                    <td id="address_slka"></td>
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
                                                                    <td id="fax_slka"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Phone No.</td>
                                                                    <td id="phone_slka"></td>
                                                                </tr>
                                                            </table><br>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="tulisan">
                                                    <table>
                                                        <tr>
                                                            <br/>
                                                            <td><p>Subject</td>
                                                            <td>: Company’s Letter of Administration Qualification / Surat Lulus Kualifikasi Administrasi Perusahaan (SLKA)</p></td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <div class="form-group">
                                                    <label for="name" class="label-control col-md-4"></label>
                                                    <div class="col-md-8">

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div id="open" class="tulisan">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div id="close" class="tulisan">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">

                                                </div>
                                            </div>


                                            <div role="tabpanel" class="tab-pane" id="profile">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">


                                                        <!-- Informasi perusahaan -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Informasi Perusahaan", "Company Information") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="row">
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
                                                            </div>


                                                        </div>


                                                        <!-- Kontak perusahaan -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Kontak Perusahaan", "Company Contact") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body card-dashboard">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <table id="datakontakperusahaan" class="table table-striped table-bordered zero-configuration" width="100%">

                                                                                    </table>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Alamat Perusahaan", "Company Address") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body card-dashboard">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <table id="alamatperusahaan" class="table table-striped table-bordered zero-configuration" width="100%">

                                                                                    </table>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- LEGAL  -->
                                            <div role="tabpanel" class="tab-pane" id="profile1">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">

                                                        <!-- akta -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Akta", "Akta") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body">
                                                                            <div class="card-content collapse show">
                                                                                <div class="card-body card-dashboard">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table id="dataakta" class="table table-striped table-bordered zero-configuration" width="100%">

                                                                                            </table>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>

                                                        <!-- SIUP -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("SUIP", "SIUP") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                            <label class="col-sm-6" ><?= lang("Dibuat Oleh", "Created By"); ?></label>
                                                                            <span class="col-sm-4 control-label" id="CREATED_BY_SIUP" ><?php echo(isset($SIUP[0]["CREATOR"]) != false ? $SIUP[0]["CREATOR"] : '') ?></span>

                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                            <label class="col-sm-6 control-label" >File</label>
                                                                            <button class="btn btn-sm btn-outline-primary" id="SIUP_FILE"><i class="fa fa-file-o"></i><?php
                                                                                if (isset($SIUP[0]["FILE_URL"])) {
                                                                                    echo '<a title="Lihat File" onclick=review_akta("SIUP_FILE")><i class="fa fa-file-o"></i></a>';
                                                                                }
                                                                                ?> </button>
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

                                                        </div>

                                                        <!-- TDP -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("TDP", "TDP") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6" ><?= lang("Dibuat Oleh", "Created By"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="CREATED_TDP_BY" ><?php echo(isset($SIUP[0]["CREATOR"]) != false ? $SIUP[0]["CREATOR"] : '') ?></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label" >File</label>
                                                                                <button class="btn btn-sm btn-outline-primary" id="TDP_FILE"><i class="fa fa-file-o"></i><?php echo(isset($SIUP[0]["SIUP_FILE"]) != false ? $SIUP[0]["SIUP_FILE"] : '') ?></button>
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
                                                            </div>

                                                        </div>


                                                        <!-- NPWP -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("NPWP", "NPWP") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="row">
                                                                            <div class="row">
                                                                                <div class="col-sm-6">
                                                                                    <label class="col-sm-6 control-label"><?= lang("Nomor", "Number"); ?></label>
                                                                                    <span class="col-sm-4 control-label" id="NO_NPWP"><?php echo(isset($all[0]->NO_NPWP) != false ? $all[0]->NO_NPWP : '') ?></span>
                                                                                </div>

                                                                                <div class="col-sm-6">
                                                                                    <label class="col-sm-6 control-label" >File</label>
                                                                                    <button class="btn btn-sm btn-outline-primary" id="FILE_NPWP"><i class="fa fa-file-o"></i></button>
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
                                                        </div>

                                                        <!--EBTKE-->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Direktorat Panas Bumi", "Geothermal Directorate") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6" ><?= lang("Dibuat Oleh", "Created By"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="CREATED_EBTKE_BY" ></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label" >File</label>
                                                                                <button class="btn btn-sm btn-outline-primary" id="EBTKE_FILE"><i class="fa fa-file-o"></i></button>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label"><?= lang("Nomor", "Number"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="NO_EBTKE" ></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label" ><?= lang("Berlaku Dari", "Valid From"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="VALID_FROM_EBTKE"></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label"><?= lang("Berlaku Hingga", "Valid To"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="VALID_TO_EBTKE"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!--MIGAS-->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("SKT MIGAS", "Oil and Gas Certificate") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6" ><?= lang("Dibuat Oleh", "Created By"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="CREATED_MIGAS_BY" ></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label" >File</label>
                                                                                <button class="btn btn-sm btn-outline-primary" id="MIGAS_FILE"><i class="fa fa-file-o"></i></button>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label"><?= lang("Nomor", "Number"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="NO_MIGAS" ></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label" ><?= lang("Berlaku Dari", "Valid From"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="VALID_FROM_MIGAS"></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label"><?= lang("Berlaku Hingga", "Valid To"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="VALID_TO_MIGAS"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!--SPPKP-->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("SPPKP", "SPPKP") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6" ><?= lang("Dibuat Oleh", "Created By"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="CREATED_EBTKE_BY" ></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label" >File</label>
                                                                                <button class="btn btn-sm btn-outline-primary" id="SPPKP_FILE"><i class="fa fa-file-o"></i></button>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label"><?= lang("Nomor", "Number"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="NO_SPPKP" ></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label" ><?= lang("Berlaku Dari", "Valid From"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="VALID_FROM_SPPKP"></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label"><?= lang("Berlaku Hingga", "Valid To"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="VALID_TO_SPPKP"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!--SKT PAJAK-->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("SKT PAJAK", "SKT Certificate") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6" ><?= lang("Dibuat Oleh", "Created By"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="CREATED_PAJAK_BY" ></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label" >File</label>
                                                                                <button class="btn btn-sm btn-outline-primary" id="PAJAK_FILE"><i class="fa fa-file-o"></i></button>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label"><?= lang("Nomor", "Number"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="NO_PAJAK" ></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label" ><?= lang("Berlaku Dari", "Valid From"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="VALID_FROM_PAJAK"></span>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <label class="col-sm-6 control-label"><?= lang("Berlaku Hingga", "Valid To"); ?></label>
                                                                                <span class="col-sm-4 control-label" id="VALID_TO_PAJAK"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="profile2">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">

                                                        <!-- sertifikasi keagenan prinsipal -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Sertifikasi Keagenan dan Prinsipal", "Sertifikasi Keagenan dan Prinsipal") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body">
                                                                            <div class="card-content collapse show">
                                                                                <div class="card-body card-dashboard">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table id="datasertifikasi" class="table table-striped table-bordered zero-configuration" width="100%">

                                                                                            </table>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <!-- Daftar Jasa -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Daftar Jasa", "Daftar Jasa") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body">
                                                                            <div class="card-content collapse show">
                                                                                <div class="card-body card-dashboard">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table id="daftarjasa" class="table table-striped table-bordered zero-configuration" width="100%">

                                                                                            </table>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- Daftar Barang -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Daftar Barang", "Daftar Barang") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body">
                                                                            <div class="card-content collapse show">
                                                                                <div class="card-body card-dashboard">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table id="daftarbarang" class="table table-striped table-bordered zero-configuration" width="100%">

                                                                                            </table>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="profile3">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">

                                                        <!-- Daftar Dewan direksi -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Daftar Dewan direksi", "Daftar Dewan direksi") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body">
                                                                            <div class="card-content collapse show">
                                                                                <div class="card-body card-dashboard">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table id="dataDewanDireksi" class="table table-striped table-bordered zero-configuration" width="auto">
                                                                                            </table>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <!-- Daftar Pemilik Saham -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Daftar Pemilik Saham", "Daftar Pemilik Saham") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body">
                                                                            <div class="card-content collapse show">
                                                                                <div class="card-body card-dashboard">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table id="databank" class="table table-striped table-bordered zero-configuration" width="auto">

                                                                                            </table>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="profile4">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <!-- Neraca Keuangan -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Neraca Keuangan", "Neraca Keuangan") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body">
                                                                            <div class="card-content collapse show">
                                                                                <div class="card-body card-dashboard">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table id="neraca_keuangan_tabel" class="table table-striped table-bordered zero-configuration" width="auto">

                                                                                            </table>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- Daftar Rekening Bank -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Daftar Rekening Bank", "Daftar Rekening Bank") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body">
                                                                            <div class="card-content collapse show">
                                                                                <div class="card-body card-dashboard">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table id="daftar_rekening_bank" class="table table-striped table-bordered zero-configuration" width="100%">

                                                                                            </table>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div role="tabpanel" class="tab-pane" id="profile5">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <!-- Sertifikasi Umum -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Sertifikasi Umum", "Sertifikasi Umum") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body">
                                                                            <div class="card-content collapse show">
                                                                                <div class="card-body card-dashboard">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table id="tabelsertifikasi" class="table table-striped table-bordered zero-configuration" width="100%">

                                                                                            </table>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- Pengalaman Perusahaan -->
                                                        <div class="card box-shadow-0 border-primary">
                                                            <div class="card-header card-head-inverse bg-primary">
                                                                <h4 class="card-title"><h5><?= lang("Pengalaman Perusahaan", "Pengalaman Perusahaan") ?></h5></h4>
                                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                                <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                        <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="card-content collapse show">
                                                                <div class="card-body">
                                                                    <div class="card-content collapse show">
                                                                        <div class="card-body">
                                                                            <div class="card-content collapse show">
                                                                                <div class="card-body card-dashboard">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <table id="data_pengalaman" class="table table-striped table-bordered zero-configuration" width="100%">

                                                                                            </table>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="profile6">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12">
                                                        <form id="form" action="#" class="steps-validation wizard-circle">
                                                            <h6><?= lang("Bagian 1", "Section 1"); ?></h6>
                                                            <h6><?= lang("Bagian 2", "Section 2"); ?></h6>
                                                            <h6><?= lang("Bagian 3", "Section 3"); ?></h6>
                                                            <h6><?= lang("Bagian 4", "Section 4"); ?></h6>
                                                            <h6><?= lang("Bagian 5", "Section 5"); ?></h6>
                                                            <h6><?= lang("Bagian 6", "Section 6"); ?></h6>
                                                            <h6><?= lang("Bagian 7", "Section 7"); ?></h6>
                                                            <h6><?= lang("Bagian 8", "Section 8"); ?></h6>
                                                            <h6><?= lang("Bagian 9", "Section 9"); ?></h6>

                                                            <fieldset id="bagian1" class="col-12" class="white-bg">
                                                                <h2 class="m-b-md"><?= lang("Kepemimpinan dan Komitmen Manajemen", "Leadership and Top Management Commitment"); ?></h2>
                                                                <div class="row">
                                                                    <?= areacsms("1a", "", "<strong>a) Bagaimana manajer senior di manajemen puncak terlibat secara pribadi dalam manajemen SHE?</strong>", "<strong>a) How are senior managers in top management personally involve in SHE management ?</strong>")
                                                                    ?>
                                                                    <label class="form-label"><?= lang("<strong>b) Berikan bukti komitmen di semua tingkat organisasi dengan:</strong>", "<strong>b) Provide evidence of commitment at all levels of the organization by:</strong>")
                                                                    ?></label>
                                                                    <?= areacsms("1b1", "", "(i) Nyatakan target perusahaan tahun ini untuk kinerja SHE", "(i) Stating this year's company targets for SHE performance") ?>
                                                                    <?=
                                                                    areacsms("1b2", "", "(ii) Jelaskan bagaimana Anda memastikan bahwa organisasi Anda mengerti dan berkomitmen untuk memenuhi target SHE perusahaan Anda", "(ii) Describe how you ensure that your organization understands and is committed to deliver on your company SHE targets")
                                                                    ?>
                                                                    <?= areacsms("1c", "", "<strong>c) Bagaimana Anda mempromosikan budaya positif terhadap masalah SHE?</strong>", "<strong>c) How do you promote a positive culture towards SHE matters ?</strong>")
                                                                    ?>
                                                                    <?= areacsms("1d", "", "<strong>d) Berikan bagan organisasi Anda saat ini</strong>", "<strong>d) Provide your current organization chart</strong>")
                                                                    ?>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset id="bagian2" class="col-12">
                                                                <h2 class="m-b"><?= lang("Tujuan Kebijakan dan Strategi ", "Policy and Strategic Objectives"); ?></h2>
                                                                <div class="row">
                                                                    <!--2.1-->
                                                                    <label class="form-label"><?= lang("<strong> 2.1. Kebijakan dan Dokumen SHE</strong>", "<strong>2.1.SHE Policy and Document</strong>")
                                                                    ?></label>
                                                                    <?=
                                                                    areacsms("2_1a", "", "a) Apakah perusahaan Anda memiliki dokumen kebijakan SHE yang diterapkan di wilayah ini? (Ya / Tidak) jika iya, mohon lampirkan"
                                                                            , "a) Does your company have an SHE policy document that is applied in this region ? (Yes/No) if yes, please attach")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("2_1b", "", "b) siapa yang memiliki tanggung jawab keseluruhan dan terakhir untuk SHE di organisasi Anda?"
                                                                            , "b) who has overall and final responsibility for SHE in your organization ?")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("2_1c", "", "c) Bagaimana Anda memastikan kepatuhan dan komunikasi kebijakan SHE di lokasi?"
                                                                            , "c) How do you ensure SHE policy compliance and communication at site ?")
                                                                    ?>
                                                                    <!--2.2-->
                                                                    <label class="form-label"><?= lang("<strong>2.2. Ketersediaan Kebijakan Pernyataan kepada karyawan</strong>", "<strong>2.2. Availability of Policy Statements to employees</strong>")
                                                                    ?></label>
                                                                    <?=
                                                                    areacsms("2_2", "", "Bagaimana Anda mengkomunikasikan kebijakan perusahaan Anda kepada karyawan Anda termasuk perubahan apa pun"
                                                                            , "How do you communicate your company's policy to your employees including any changes")
                                                                    ?>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset id="bagian3" class="col-12">
                                                                <h2 class="m-b"><?= lang("Organisasi, Sumber Daya, Standar dan Dokumentasi", "Organization,Resources,Standards and Documentation"); ?></h2>
                                                                <div class="row">
                                                                    <!--3.1-->
                                                                    <label class="form-label"><?= lang("<strong>3.1. Organisasi - Komitmen dan Komunikasi</strong>", "<strong>3.1. Organization - Commitment and Communication</strong>")
                                                                    ?></label>
                                                                    <?=
                                                                    areacsms("3_1a", "", "a) Bagaimana manajemen terlibat dalam kegiatan K3, penetapan dan pemantauan yang obyektif?"
                                                                            , "a) How is management involved in SHE activities, objective setting and monitoring ?")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("3_1b", "", "b) Apa ketentuan yang dibuat perusahaan Anda untuk komunikasi dan pertemuan SHE?"
                                                                            , "b) What provision does your company make for SHE communication and meetings ?")
                                                                    ?>
                                                                    <!--3.2-->
                                                                    <label class="form-label"><?= lang("<strong>3.2. Kompetensi dan Pelatihan Manajer / Staf Pengawas / Staf Senior / Penasihat SHE</strong>", "<strong>3.2. Competence and Training of Manager/Supervisors/Senior Site Staff/SHE Advisor</strong>")
                                                                    ?></label>
                                                                    <?=
                                                                    areacsms("3_2", "", "Apakah manajer dan supervisor di semua tingkat yang akan merencanakan, memantau, mengawasi dan melaksanakan pekerjaan tersebut menerima pelatihan SHE formal dalam tanggung jawab mereka sehubungan dengan melakukan pekerjaan sesuai persyaratan SHE? (Ya/Tidak)"
                                                                            , "Have the managers and supervisors at all levels that will plan, monitor, oversee and carry out the work received formal SHE training in their responsibilities with respect to conducting work to SHE requirements ? (Yes/No)")
                                                                    ?>
                                                                    <!--3.3-->
                                                                    <label class="form-label"><?= lang("<strong>3.3. Kompetensi dan Pelatihan SHE secara umum</strong>", "<strong>3.3. Competence and general SHE Training</strong>")
                                                                    ?></label>
                                                                    <?=
                                                                    areacsms("3_3a", "", "a) Pengaturan apa yang telah dilakukan perusahaan Anda untuk memastikan karyawan memiliki pengetahuan tentang SHE industri dasar, dan agar pengetahuan terkini tetap terjaga?"
                                                                            , "a) What arrangements has your company made to ensure employees have knowledge of basic industrial SHE, and to keep this knowledge up to date ?")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("3_3b", "", "b) Pengaturan apa yang telah dilakukan perusahaan Anda untuk memastikan SEMUA karyawan, termasuk sub kontraktor, juga memiliki pengetahuan tentang kebijakan dan praktik SHE?"
                                                                            , "b) What arrangements has your company made to ensure ALL employees, including sub contractors, also have knowledge of yur SHE policies and practices ?")
                                                                    ?>
                                                                    <!--3.4-->
                                                                    <label class="form-label"><?= lang("<strong>3.4. Komite Manajemen SHE</strong>", "<strong>3.4. SHE Management Committee</strong>")
                                                                    ?></label>
                                                                    <?=
                                                                    areacsms("3_4a", "", "Jelaskan secara singkat pengorganisasian Komite Manajemen SHE yang melibatkan Manajemen dan Karyawan Teratas di perusahaan Anda."
                                                                            , "Explain briefly the organization of SHE Management Committee which involves Top Management and employees in your company.")
                                                                    ?>
                                                                    <!--3.5-->
                                                                    <label class="form-label"><?= lang("<strong>3.5. Pelatihan Khusus</strong>", "<strong>3.5. Specialized Training</strong>") ?></label>
                                                                    <?=
                                                                    areacsms("3_5a", "", "Sudahkah Anda mengidentifikasi area operasi perusahaan Anda dimana pelatihan khusus diperlukan untuk mengatasi potensi bahaya? (Ya/Tidak)"
                                                                            , "Have you identified areas of your company's operations where specialized training is required to deal with potential hazards ? (Yes/No)")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("3_5b", "", "Jika Ya, berikan daftar (misalnya radioaktif, asbes, peledak, menyelam, dll.)"
                                                                            , "If Yes, please provide the list (e.g. radioactive, asbestos, explosive, diving, etc.)")
                                                                    ?>
                                                                    <!--3.6-->
                                                                    <label class="form-label"><?= lang("<strong>3.6. Staf Berkualitas SHE - Pelatihan Tambahan</strong>", "<strong>3.6. SHE Qualified Staff - Additional Training</strong>") ?></label>
                                                                    <?=
                                                                    areacsms("3_6a", "", "Apakah perusahaan Anda memiliki spesialis SHE (terkait dengan layanan perusahaan Anda) yang dapat memberikan pelatihan untuk karyawan lain? (Ya/Tidak)"
                                                                            , "Does your company have SHE specialists (related to your company's services) who can provide training for other employees ? (Yes/No)")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("3_6b", "", "Jika iya, mohon lampirkan cv."
                                                                            , "If Yes, please attach the curriculum vitae.")
                                                                    ?>
                                                                    <!--3.7-->
                                                                    <label class="form-label"><?= lang("<strong>3.7. Penilaian Kesesuaian Subkontraktor</strong>", "<strong>3.7. Assessment of Suitability of Subcontractors</strong>")
                                                                    ?></label>
                                                                    <?=
                                                                    areacsms("3_7a", "", "a) Bagaimana Anda menilai subkontraktor Anda untuk memastikan kepatuhan terhadap Kebijakan dan standar SHE perusahaan Anda, jika ada?"
                                                                            , "a) How do you assess your sub-contractor(s) to ensure they comply with your company's SHE Policy and standards, if any ?")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("3_7b", "", "b) Apakah Anda mempekerjakan subkontraktor untuk layanan yang dimaksud? (Ya/Tidak)"
                                                                            , "b) Do you employ sub-contractor(s) for the intended service ? (Yes/No)")
                                                                    ?>
                                                                    <!--3.8-->
                                                                    <label class="form-label"><?= lang("<strong>3.8. Standar</strong>", "<strong>3.8. Standards</strong>") ?></label>
                                                                    <?=
                                                                    areacsms("3_8a", "", "a) Standar peraturan atau industri SHE apa yang perusahaan Anda lihat untuk layanan yang dimaksud?"
                                                                            , "a) What kind of SHE regulatory or industrial standards that your company refer to for the intended service ?")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("3_8b", "", "b) Bagaimana Anda memastikan ini dipenuhi dan diverifikasi?"
                                                                            , "b) How do you ensure these are met and verified ?")
                                                                    ?>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset id="bagian4" class="col-12">
                                                                <h2 class="m-b"><?= lang("Resiko dan Manajemen Akibat", "Hazards and Effect Management"); ?></h2>
                                                                <div class="row">
                                                                    <!--4.1-->
                                                                    <label class="form-label"><?= lang("<strong>4.1. Resiko dan Manajemen Akibat</strong>", "<strong>4.1. Hazards and effect management</strong>") ?></label>
                                                                    <?=
                                                                    areacsms("4_1", "", "Apakah perusahaan Anda memiliki prosedur untuk identifikasi, penilaian, pengendalian dan mitigasi bahaya dan dampak? (Ya Tidak)"
                                                                            , "Does your company have procedure for identification, assessment, control and mitigation of hazards and effects ? (Yes/No)")
                                                                    ?>
                                                                    <!--4.2-->
                                                                    <label class="form-label"><?= lang("<strong>4.2. Paparan Tenaga Kerja</strong>", "<strong>4.2. Exposure of the Workforce</strong>") ?></label>
                                                                    <?=
                                                                    areacsms("4_2", "", "Sistem apa yang ada untuk memantau paparan bahaya terhadap tenaga kerja Anda misalnya agen kimia atau fisik?"
                                                                            , "What systems are in place to monitor the hazard's exposure of your workforce e.g. chemical or physical agents ?")
                                                                    ?>
                                                                    <!--4.3-->
                                                                    <label class="form-label"><?= lang("<strong>4.3. Penanganan Material Yang Berpotensi Bahaya</strong>", "<strong>4.3. Handling of Potential Hazards</strong>") ?></label>
                                                                    <?=
                                                                    areacsms("4_3", "", "Bagaimana tenaga kerja Anda memberi saran tentang potensi bahaya, berikan contoh."
                                                                            , "How is your workforce advised on potential hazards eg. chemical, noise, radiation, etc. encountered in the course of their work ?")
                                                                    ?>
                                                                    <!--4.4-->
                                                                    <label class="form-label"><?= lang("<strong>4.4. Alat pelindung diri</strong>", "<strong>4.4. Personnel Protective Equipment</strong>")
                                                                    ?></label>
                                                                    <?=
                                                                    areacsms("4_4a", "", "a) pengaturan apa yang dimiliki perusahaan Anda untuk penyediaan dan pembungkaman peralatan dan pakaian pelindung, baik standar dan yang diperlukan untuk kegiatan khusus?"
                                                                            , "a) what arrangements does your company have for provision and unkeep of protective equipment and clothing, both standards issue, and that "
                                                                            . "required for specialized activities ?")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("4_4b1", "", "b) Apakah Anda menyediakan perlengkapan pelindung diri yang layak (PPE) untuk karyawan Anda? (Ya/Tidak)"
                                                                            , "b) Do you provide appropriate personnel protective equipment (PPE) for your employees ? (Yes/No)")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("4_4b2", "", "mohon cantumkan daftar PPE untuk lingkup pekerjaan ini"
                                                                            , "  please provide a listing of the PPE for the scope of this work")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("4_c1", "", "c) Apakah Anda memberikan pelatihan bagaimana menggunakan PPE? (Ya Tidak)"
                                                                            , "c) Do you provide training on how to use PPE ? (Yes/No)")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("4_c2", "", "Jelaskan isi pelatihan dan tindak lanjutnya"
                                                                            , "  Explain the content of the training and any follow-up")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("4_d1", "", "d) Apakah Anda memiliki sebuah program untuk memastikan bahwa PPE terkena dampak dan dipelihara?"
                                                                            , "d) Do you have a program to ensure that PPE is impacted and maintained ?")
                                                                    ?>
                                                                    <label class="form-label"><?= lang("<strong>4.5. Penanganan limbah</strong>", "<strong>4.5. Waste management</strong>")
                                                                    ?></label>
                                                                    <?= areacsms("4_5a", "", "a) Sistem apa yang ada untuk identifikasi, klasifikasi, minimisasi dan pengelolaan wates?", "a) What systems are in place for identification, classification, minimization and management of wates ?")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("4_5b", "", "b) Mohon berikan jumlah kecelakaan yang mengakibatkan kerusakan lingkungan sebesar lebih dari "
                                                                            . "USD 50.000 selama 24 bulan terakhir. Lampirkan salinan dari setiap laporan pemerintah yang disampaikan.", "b) Please provide the number of accidents resulting in environmental damage in the amount greater than USD 50,000 for the last 24 months. Attach copies of any"
                                                                            . " governmental reports submitted.")
                                                                    ?>
                                                                    <?= areacsms("4_5c", "", "Apakah anda memiliki prosedur untuk pembuangan limbah (Ya/Tidak)", "c) Do you have procedures for waste disposal (Yes/No)")
                                                                    ?>
                                                                    <?= areacsms("4_5d", "", "e) Apakah Anda memiliki prosedur untuk pelaporan tumpahan? (Ya Tidak)", "d) Do you have procedures for spill reporting ? (Yes/No)")
                                                                    ?>
                                                                    <?= areacsms("4_5e", "", "e) Apakah Anda memiliki prosedur untuk pembersihan tumpahan? (Ya Tidak)", "e) Do you have procedures for spill clean up ? (Yes/No)")
                                                                    ?>
                                                                    <?= areacsms("4_5f", "", "f) Tolong berikan rincian peralatan Anda yang berkaitan dengan masalah lingkungan", "f) Please provide details at any of your equipment related to environmental matters")
                                                                    ?>
                                                                    <label class="form-label"><?= lang("<strong>4.7. Kebersihan Industri</strong>", "<strong>4.6. Industrial Hygiene</strong>") ?></label>
                                                                    <?=
                                                                    areacsms("4_6a", "", "a) Apakah Anda memiliki program kebersihan industri? (Ya Tidak)"
                                                                            , "a) Do you have an industrial hygiene program ? (Yes/No)")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("4_6b", "", "Mohon jelaskan proses ini. Jika ya, berikan daftar"
                                                                            , "  Please describe this process. If yes, please provide the list.")
                                                                    ?>
                                                                    <label class="form-label"><?= lang("<strong>4.8. Alkohol dan Narkoba</strong>", "<strong>4.7. Drugs and Alcohol</strong>") ?></label>
                                                                    <?=
                                                                    areacsms("4_7", "", "Apakah Anda memiliki kebijakan narkoba dan alkohol di organisasi Anda? (Ya / Tidak) Jika iya, mohon lampirkan"
                                                                            , "Do you have a drugs and alcohol policy in your organization ? (Yes/No) If yes, please attach")
                                                                    ?>
                                                                </div>
                                                            </fieldset>
                                                            <!-- 5.1 -->
                                                            <fieldset id="bagian5" class="col-12">
                                                                <h2 class="m-b"><?= lang("Prosedur dan Perencanaan", "Planning and Procedures"); ?></h2>
                                                                <div class="row">
                                                                    <label class="form-label"><?= lang("<strong>5.1. SHE atau Operasi Manual</strong>", "<strong>5.1. SHE or Operations Manuals</strong>")
                                                                    ?></label>
                                                                    <?= areacsms("5_1a", "", "a) Apakah Anda memiliki manual prosedur SHE? (Ya / Tidak) jika Ya, mohon lampirkan daftar isi", "a) Do you have SHE procedures manuals ? (Yes/No) if Yes, please attach the list of content")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("5_1b", "", "b) Bagaimana Anda memastikan bahwa prosedur kerja yang digunakan oleh karyawan Anda di tempat secara konsisten sesuai dengan tujuan dan pengaturan "
                                                                            . "kebijakan SHE Anda?", "b) How do you ensure that the working procedures used by your employees on-site are consistently in accordance with your SHE policy objectives and arrangements ?")
                                                                    ?>
                                                                    <label class="form-label"><?= lang("<strong>5.2. Kontrol dan Pemeliharaan Peralatan</strong>", "<strong>5.2. Equipment Control and Maintenance</strong>") ?></label>
                                                                    <?=
                                                                    areacsms("5_2", "", "Bagaimana Anda memastikan bahwa pabrik dan peralatan yang digunakan di tempat Anda, di tempat, atau di lokasi lain oleh karyawan Anda "
                                                                            . "terdaftar dengan benar, disertifikasi dengan persyaratan peraturan, diperiksa, dikendalikan dan dipelihara dalam kondisi kerja yang aman?", "How do you ensure that plant and "
                                                                            . "equipment used within your premises, on-site, or at other locations by your employees are correctly"
                                                                            . " registered, certified with regulatory requirement, inspected, controlled and maintained in a safe working condition ?")
                                                                    ?>
                                                                    <label class="form-label"><?= lang("<strong>5.3 Manajemen dan Pemeliharaan Keselamatan Transportasi</strong>", "<strong>5.3 Transport Safety management and Maintenance</strong>") ?></label>
                                                                    <?= areacsms("5_3", "", "Pengaturan apa yang dimiliki perusahaan Anda untuk pencegahan insiden kendaraan?", "What arrangement does your company have for vehicle incidents prevention ?")
                                                                    ?>
                                                                </div>
                                                            </fieldset>
                                                            <!-- 5.2 -->
                                                            <fieldset id="bagian6" class="col-12">
                                                                <h2 class="m-b"><?= lang("Pengawasan Performa dan Pengerjaan", "Implementation and Performance Monitoring"); ?></h2>
                                                                <div class="row">
                                                                    <label class="form-label">
                                                                        <?= lang("<strong>6.1. Manajemen K3 dan Pemantauan Kinerja Kegiatan Kerja</strong>", "<strong>6.1. SHE Management and Performance Monitoring of Work Acivities</strong>")
                                                                        ?></label>?>
                                                                    <?= areacsms("6_1a", "", "a) Pengaturan apa yang dimiliki perusahaan Anda untuk pengawasan dan pemantauan kinerja SHE?", "a) What arrangement(s) does your company have for supervision and monitoring of SHE performance ?")
                                                                    ?>
                                                                    <?= areacsms("6_1b", "", "b) Pengaturan apa yang dimiliki perusahaan Anda untuk diteruskan?", "b) What arrangements does your company have for passing on ")
                                                                    ?>
                                                                    <?= areacsms("6_1b1", "", "(i) Manajemen Dasar", "(i) Base Management") ?>
                                                                    <?= areacsms("6_1b2", "", "(ii) Karyawan lapangan", "(ii) Site employees") ?>
                                                                    <?= areacsms("6_1c", "", "c) Apakah perusahaan Anda menerima penghargaan atas prestasi kinerja SHE? (Ya Tidak)", "c) Has your company received any award for SHE performance acheivement ? (Yes/No)")
                                                                    ?>
                                                                    <!--6.2-->
                                                                    <label class="form-label"><?= lang("<strong>6.2 Insiden Wajib Pajak / Kejadian Berbahaya, Persyaratan Perbaikan dan Pemberitahuan Larangan</strong>", "<strong>6.2 Statutory Notifiable Incidents/Dangerous occurences, Improvement Requirement and Prohibition Notices</strong>")
                                                                    ?></label>
                                                                    <?=
                                                                    areacsms("6_2a", "", "Apakah perusahaan Anda mengalami persyaratan perbaikan atau pemberitahuan larangan atas insiden yang dapat dikenai undang-undang / "
                                                                            . "kejadian berbahaya oleh badan nasional yang relevan, badan pengatur untuk SHE atau otoritas penegakan lainnya atau telah diadili berdasarkan undang-undang SHE dalam lima tahun terakhir?", "Has your company suffered any improvement requirement or prohibition notices on statutory notifiable incidents/dangerous occurences by the "
                                                                            . "relevant national body, regulatory body for SHE or other enforcing authority or been prosecuted under any SHE legislation in the last five years ?")
                                                                    ?>
                                                                    <?= areacsms("6_2b", "", "Jika iya, tolong beri jumlah kejadian dan deskripsi singkatnya", "If yes, please give the number of occurences and its short description")
                                                                    ?>
                                                                    <!--6.3-->
                                                                    <label class="form-label"><?= lang("<strong>6.3. Catatan Kinerja SHE</strong>", "<strong>6.3. SHE Performance Records</strong>")
                                                                    ?></label>
                                                                    <label class="form-label"><?=
                                                                        lang("<strong>a) Tolong berikan rincian statistik kinerja SHE Anda selama 3 tahun terakhir (jika tidak dicatat / berlaku, tandai N / R atau N / A)</strong>"
                                                                                , "<strong>a) Please provide statistical details of your SHE performance over the past 3 years (if not recorded/applicable please mark N/R or N/A)</strong>")
                                                                        ?></label>
                                                                    <table class="table display">
                                                                        <thead>
                                                                            <tr>
                                                                                <th></th>
                                                                                <th><?= lang("Total<br/>(Termasuk semua kontrak dan sub kontrak pegawai)", "Total Number</br>(incl. All conracts & sub contract personnel)") ?></th>
                                                                                <th><?= lang("Frekuensi", "Frequency") ?><br/><?= lang("Berdasarkan OSHA", "(based on OSHA)") ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><?= lang("Fatalities", "Fatalities") ?></td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input type="text" class="form-control" id="6_3a1" name="6_3a1">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input type="text" class="form-control" id="6_3a2" name="6_3a2">
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><?= lang("Day away from work cases (DAFWC) or LTIs", "Fatalities") ?></td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input type="text" class="form-control" id="6_3a3" name="6_3a3">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input type="text" class="form-control" id="6_3a4" name="6_3a4">
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><?= lang("Total recordable cases", "Fatalities") ?></td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input type="text" class="form-control" id="6_3a5" name="6_3a5">
                                                                                    </div>
                                                                                </td>
                                                                                <td>
                                                                                    <div class="form-group">
                                                                                        <input type="text" class="form-control" id="6_3a6" name="6_3a6">
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <?=
                                                                    areacsms("6_3b", "", "c) Bagaimana kinerja  kesehatan yang telah tercatat?"
                                                                            , "b) How is health performance recorded ?")
                                                                    ?>
                                                                    <?=
                                                                    areacsms("6_3c", "", "c) Bagaimana kinerja lingkungan yang telah tercatat?"
                                                                            , "c) How is environmental performance recorded ?")
                                                                    ?>
                                                                    <!--6.4-->
                                                                    <label class="form-label"><?= lang("<strong>6.4. Investigasi dan Pelaporan Insiden</strong>", "<strong>6.4. Incident Investigation and Reporting</strong>")
                                                                    ?></label>
                                                                    <?= areacsms("6_4a", "", "a) Apakah Anda memiliki prosedur untuk penyelidikan, pelaporan dan tindak lanjut dari kecelakaan, kejadian berbahaya atau penyakit akibat kerja? (Ya / Tidak) jika iya, mohon lampirkan", "a) Do you have a procedure for investigation, reporting and follow-up of accidents, dangerous occurences or occupational illness ? (Yes/No) if yes, please attach")
                                                                    ?>
                                                                    <?= areacsms("6_4b", "", "b) Bagaimana temuan setelah penyelidikan, atau insiden terkait yang terjadi di tempat lain, dikomunikasikan kepada karyawan Anda?", "b) How are the findings following an investigation, or relevant incident occurring elsewhere, communicated to your employees ?")
                                                                    ?>
                                                                    <?= areacsms("6_4c", "", "Harap lampirkan contoh laporan investigasi selama 12 bulan terakhir.", "Please attach an example of investigation reports during the last 12 months.") ?>
                                                                </div>
                                                            </fieldset>

                                                            <fieldset id="bagian7" class="col-12">
                                                                <h2 class="m-b"><?= lang("Audit dan Tinjauan", "Audit and Review"); ?></h2>
                                                                <div class="row">
                                                                    <label class="form-label"><?= lang("<strong>a) Apakah Anda memiliki kebijakan tertulis tentang audit SHE? (Ya/Tidak)</strong>", "<strong>a) Do you have a written policy on SHE auditing ? (Yes/No)</strong>") ?></label>
                                                                    <?= areacsms("7_a", "", "", "") ?>
                                                                    <label class="form-label"><?= lang("<strong>b) Bagaimana kebijakan ini menetapkan standar audit, termasuk jadwal, cakupan dan kualifikasi auditor?</strong>", "<strong>b) How does this policy specify the standards for auditing, including schedule, coverage and the qualification for auditors ?</strong>")
                                                                    ?></label>
                                                                    <?= areacsms("7_b", "", "", "") ?>
                                                                    <label class="form-label"><?= lang("<strong>c) Bagaimana efektivitas audit diverifikasi dan bagaimana caranya?</strong>", "<strong>c) How is the effectiveness of auditing verified and how does </strong>")
                                                                    ?></label>
                                                                    <?= areacsms("7_c", "", "", "") ?>
                                                                </div>
                                                            </fieldset>
                                                            <fieldset id="bagian8" class="col-12">
                                                                <h2 class="m-b"><?= lang("Prosedur Respon Keadaan Darurat  ", "Emergency Response Procedure"); ?></h2>
                                                                <div class="row">
                                                                    <label class="form-label"><?= lang("<strong>Apakah Anda memiliki rencana tanggap darurat? (Ya / Tidak), jika ya, silahkan melampirkan</strong>", "<strong>Do you have an emergency response plan ? (Yes/No), if yes, please attach</strong>") ?></label>
                                                                    <?= areacsms("8_a", "", "", "") ?>
                                                                </div>
                                                            </fieldset>

                                                            <fieldset id="bagian9" class="col-12">
                                                                <h2 class="m-b"><?= lang("Bagian 9 - Manajemen SHE", "Section - 9 SHE Management - Additional Features"); ?></h2>
                                                                <div class="row">
                                                                    <label class="form-label"><?= lang("<strong>a) Apakah perusahaan anda memegang keanggotaan asosiasi? (Ya Tidak)</strong>", "<strong>a) Do you company hold association(s) membership ? (Yes/No)</strong>") ?></label>
                                                                    <?= areacsms("9_a", "", "", "") ?>
                                                                    <label class="form-label"><?= lang("<strong>Jika ya, tuliskan daftarnya</strong>", "<strong>If yes, please provide the list</strong>")
                                                                    ?></label>
                                                                    <?= areacsms("9_a1", "", "", "") ?>
                                                                    <label class="form-label"><?=
                                                                        lang("<strong>b) Apakah ada aspek kinerja SHE Anda yang Anda percaya membedakan Anda dari pesaing Anda yang tidak dijelaskan di
                                                                             tempat lain dalam tanggapan Anda terhadap kuesioner? Jika ya, tolong jelaskan</strong>", "<strong>b) Are there any aspect of your SHE performance that you believe differentiates you from your competitors that not described elsewhere in your "
                                                                                . "response to the questionnaire ? If yes, please explain</strong>")
                                                                        ?></label>
                                                                    <?= areacsms("9b", "", "", "") ?>
                                                                </div>
                                                            </fieldset>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="modal2" class="modal fade" role="dialog"  >
    <div class="modal-dialog" style="width:800px">
        <div class="modal-content modal-lg" >
            <div class="modal-header">
                <h4 class="modal-title"><?lang("Lihat File","Preview File")?></h4>
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

                    <input name="id_vendor" class="id_vendor" hidden><!--id vendor ANGKA-->
                    <input name="email" class="email" hidden><!--id vendor MAIL-->
                    <input name="entity_tax_id" class="entity_tax_id"  hidden>
                    <input name="entity_name" class="entity_name" hidden >

                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                            <textarea placeholder="Isi komentar anda" class="form-control note" rows="5" name="note"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-primary"><?= lang("Setujui dan kirim email", "Approve") ?></button>
            </div>
        </form>
    </div>
</div>

<!--reject-->
<div id="modal_rej" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="reject_mdl" novalidate="novalidate" action="javascript:;">
            <div class="modal-header">
                <?= lang("Tolak Data", "Reject Data") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input name="id_vendor" class="id_vendor" hidden>
                    <input name="email" class="email" hidden>
                    <div class="form-group">
                        <div class="controls col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                            <label id="label_kirim" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                            <textarea placeholder="Isi komentar anda" class="form-control note" rows="5" name="note" required data-validation-required-message="This field is required"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-danger"><?= lang("Tolak SLKA", "Reject SLKA") ?></button>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/js/scripts/forms/validation/form-validation.js"type="text/javascript"></script>
<script>
    function accept(id, id_vendor) {
        var nama = $('#NAMA').html();
        var npwp = $('#NO_NPWP').html();
        $('.entity_name').val(nama);
        $('.entity_tax_id').val(npwp);

        $('.note').val(null);
        $('#modal_app .modal-header').css("background", "#347ab5");
        $('#modal_app .modal-header').css("color", "#fff");
        $('#modal_app').modal('show');
        lang();
    }

    function reject(id, id_vendor) {
//        document.getElementById("reject_mdl").reset();
        $('.note').val(null);
        $('#modal_rej .modal-header').css("background", "#d9534f");
        $('#modal_rej .modal-header').css("color", "#fff");
        $('#modal_rej').modal('show');
        lang();
    }
    $(function () {
        lang();
        $('#csms').click(function (e) {
            var elm = start($('.px-1').find('.tab-content'));
            var obj = {};
            obj.id = $('.id_vendor').val();
            obj.API = 'SELECT';
            $.ajax({
                url: "<?= base_url('vendor/show_vendor/get_csms') ?>",
                data: obj,
                type: "POST",
                cache: "false",
                success: function (res)
                {
                    stop(elm);
                    if (res != null) {
                        var len = Object.keys(res).length;
                        for (var i = 0; i < 9; i++)
                        {
                            var elmn1 = $("#form-p-" + i + " :input");
                            for (var j = 0; j < elmn1.length; j++)
                            {
                                if (res[elmn1[j].id] != '')
                                {
                                    index = i;
                                }
                                $("#form-p-" + i + " #" + elmn1[j].id).html(res[elmn1[j].id]);
                                if(i==5)
                                    $("#form-p-" + i + " #" + elmn1[j].id).val(res[elmn1[j].id]);
                            }
                        }
                    }
                    $("#form :input").prop('disabled',true);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown)
                {
                    stop(elm);
                    msg_danger("Gagal", "Oops,Terjadi kesalahan pengambilan data");
                }
            });
        });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
        });
        $(".steps-validation").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '<span class="step">#index#</span> #title#',
            labels: {
                finish: 'Finish'
            },
        });
        $('#approve_mdl').on('submit', function (e) {
            e.preventDefault();
            var elm = start($('#modal_app').find('.modal-dialog'));
            $.ajax({
                type: 'POST',
                url: '<?= base_url('vendor/approve_slka/change_btn/7') ?>',
                data: $('#approve_mdl').serialize(),
                success: function (m) {
                    stop(elm);
                    if (m == 'sukses') {
                        $('#modal_app').modal('hide');
                        msg_info('Approve Berhasil');
                        $('#tbl').DataTable().ajax.reload();
                        slides();
                    } else {
                        msg_danger(m);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    stop(elm);
                    msg_danger("Error", "Oops,Terjadi Kesalahan");
                }
            });
        });
        $('#reject_mdl').on('submit', function (e) {
            e.preventDefault();
            var elm = start($('#modal_rej').find('.modal-dialog'));
            $.ajax({
                type: 'POST',
                url: '<?= base_url('vendor/approve_slka/change_btn/13') ?>',
                data: $('#reject_mdl').serialize(),
                success: function (m) {
                    stop(elm);
                    m = JSON.parse(m);
                    if (m.status === 'sukses') {
                        $('#modal_rej').modal('hide');
                        msg_info(m.msg, 'Berhasil');
                        $('#tbl').DataTable().ajax.reload();
                        slides();
                    } else {
                        msg_danger(m);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    stop(elm);
                    msg_danger("Error", "Oops,Terjadi Kesalahan");
                }
            });
        });
        $(".area label").hide();
        $("#back").click(function () {
            slides();
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
        $('#edit').on('show', function () {
            console.log("tes");
            $('#datakontak').DataTable().columns.adjust().draw();
            $('#dataalamat').DataTable().columns.adjust().draw();
            $('#dataakta').DataTable().columns.adjust().draw();
        });
        $('#modal2').on('hidden.bs.modal', function (e) {
            if ($('#modal').hasClass('in')) {
                $('body').addClass('modal-open');
            }
        });
        $('#modal').modal('hide');
        $('#edit').hide();
        var selected = [];

        $('#tbl tfoot th').each( function (i) {
          if(i<4){
				var title = $('#tbl thead th').eq( $(this).index() ).text();
				$(this).html( '<input type="text" placeholder="Search '+title+'" data-index="'+i+'" />' );
			}else{
				var title = $('#tbl thead th').eq( $(this).index() ).text();
				$(this).html( '' );
			}
        });

        var table = $('#tbl').DataTable({
            "ajax": {
                "url": "<?= base_url('vendor/approve_slka/show') ?>",
                "dataSrc": ""
            },
            "data": null,
            "searching": true,
            "paging": true,
            "columns": [
                {title: "<center>No</center>"},
                {title: "<center><?= lang('Nama Vendor', 'Vendor Name') ?></center>"},
                {title: "<center>Email</center>"},
                {title: "<center>Status</center>"},
                {title: "<center><?= lang("Aksi", "Action") ?></center>"},
//                {title: "<center><?= lang("Rincian", "Detail") ?></center>"}
            ],
            "columnDefs": [
                {"className": "dt-right", "targets": [0]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
//                {"className": "dt-center", "targets": [5]},
            ],
            "scrollX": true,
            "scrollY": '300px',
            "scrollCollapse": true,
        });

        table.columns().every( function () {
          var that = this;

          $( 'input', this.footer() ).on( 'keyup change', function () {
              if ( that.search() !== this.value ) {
                  that
                      .search( this.value )
                      .draw();
              }
          });
        });


        lang();
        $('#tbl tbody').on('click', 'tr', function () {
            var data = table.rows({selected: true}).data();
            var data2 = table.rows(this).data();
        });
        $('#home a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        $('#profile a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        $('#modal').on('shown.bs.modal', function () {
            $('#datakontak').DataTable().columns.adjust().draw();
            $('#dataalamat').DataTable().columns.adjust().draw();
            $('#dataakta').DataTable().columns.adjust().draw();
        });
    });
    function filter() {
        $('.modal-filter').html("<?= lang("Filter Data", "Filter Data") ?>");
        $('#total').text("dari " + "<?= (isset($total) != false ? $total : '0') ?>" + " Data");
        $('#modal-filter .modal-header').css('background-color', "#23c6c8");
        $('#modal-filter .modal-header').css('color', "#fff");
        $('#modal-filter').modal('show');
        lang();
    }

    function detail(id, idvendor) {
        var obj = {};
        obj.ID_VENDOR = id;
        $('.email').val(idvendor);
        $('.id_vendor').val(id);
        $('#supps').val(idvendor);
        $.ajax({
            type: "POST",
            url: "<?= site_url('vendor/approve_slka/get_data/'); ?>" + id,
            data: "",
            cache: false,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res != false) {
                    tbl(id);
                    $('#NAMA').text(res[0]["GEN"][0]);
                    $('#PREFIX').text(res[0]["GEN"][1]);
                    $('#SUFFIX').text(res[0]["GEN"][2]);
                    $('#KATEGORI').text(res[0]["GEN"][3]);
                    $("#open").html(res[1]['SLKA'][0]);
                    $("#close").html(res[1]['SLKA'][1]);
                    $("#name_slka").html(': ' + res[0]["GEN"][0]);
                    $("#npwp_slka").html(': ' + res[0]["NPWP"][0]);
                    $("#address_slka").html(': ' + res[1]['SLKA'][2]);
                    $("#phone_slka").html(': ' + res[1]['SLKA'][3]);
                    $("#fax_slka").html(': ' + res[1]['SLKA'][4]);
                    // SIUP
                    if (res["SIUP"]) {
                        $('#CREATED_BY_SIUP').text(res["SIUP"][3]);
                        $('#NO_SIUP').text(res["SIUP"][4]);
                        $('#VALID_FROM_SIUP').text(res["SIUP"][1]);
                        $('#VALID_TO_SIUP').text(res["SIUP"][2]);
                        $('#SIUP_TYPE').text(res["SIUP"][0]);
                        $('#SIUP_FILE').attr('onClick', 'review("' + res["SIUP"][5] + '","SIUP/")');
                    }
                    // TDP
                    if (res["TDP"]) {
                        $('#CREATED_TDP_BY').text(res["TDP"][3]);
                        $('#NO_TDP').text(res["TDP"][4]);
                        $('#VALID_FROM_TDP').text(res["TDP"][1]);
                        $('#VALID_TO_TDP').text(res["TDP"][2]);
                        $('#TDP_FILE').attr('onClick', 'review("' + res["TDP"][5] + '","TDP/")');
                    }
                    if (res["SKT_EBTKE"]) {
                        $('#CREATED_EBTKE_BY').text(res["SKT_EBTKE"][3]);
                        $('#NO_EBTKE').text(res["SKT_EBTKE"][4]);
                        $('#VALID_FROM_EBTKE').text(res["SKT_EBTKE"][1]);
                        $('#VALID_TO_EBTKE').text(res["SKT_EBTKE"][2]);
                        $('#EBTKE_FILE').attr('onClick', 'review("' + res["SKT_EBTKE"][5] + '","EBTKE/")');
                    }
                    //MIGAS
                    if (res["SKT_MIGAS"]) {
                        $('#CREATED_MIGAS_BY').text(res["SKT_MIGAS"][3]);
                        $('#NO_MIGAS').text(res["SKT_MIGAS"][4]);
                        $('#VALID_FROM_MIGAS').text(res["SKT_MIGAS"][1]);
                        $('#VALID_TO_MIGAS').text(res["SKT_MIGAS"][2]);
                        $('#MIGAS_FILE').attr('onClick', 'review("' + res["SKT_MIGAS"][5] + '","MIGAS/")');
                    }
                    if (res[0]["NPWP"]) {
                        $('#NO_NPWP').text(res[0]["NPWP"][0]);
                        $('#NPWP_NOTARIS').text(res[0]['NPWP'][1]);
                        $('#NPWP_PROVINCE').text(res[0]["NPWP"][2]);
                        $('#NPWP_CITY').text(res[0]["NPWP"][3]);
                        $('#FILE_NPWP').attr('onClick', 'review("' + res[0]["NPWP"][5] + '","NPWP/")');
                        $('#POSTAL_CODE').text(res[0]["NPWP"][4]);
                    }
                    if (res["SPPKP"]) {
                        $('#CREATED_SPPKP_BY').text(res["SPPKP"][3]);
                        $('#NO_SPPKP').text(res["SPPKP"][4]);
                        $('#VALID_FROM_SPPKP').text(res["SPPKP"][1]);
                        $('#VALID_TO_SPPKP').text(res["SPPKP"][2]);
                        $('#SPPKP_FILE').attr('onClick', 'review("' + res["SPPKP"][5] + '","SPPKP/")');
                    }
                    if (res["SKT_PAJAK"]) {
                        $('#CREATED_PAJAK_BY').text(res["SKT_PAJAK"][3]);
                        $('#NO_PAJAK').text(res["SKT_PAJAK"][4]);
                        $('#VALID_FROM_PAJAK').text(res["SKT_PAJAK"][1]);
                        $('#VALID_TO_PAJAK').text(res["SKT_PAJAK"][2]);
                        $('#SPPKP_FILE').attr('onClick', 'review("' + res["SKT_PAJAK"][5] + '","PAJAK/")');
                    }
                    $('#main').hide();
                    $('#edit').show();
                    $('#datakontak').DataTable().columns.adjust().draw();
                    $('#dataalamat').DataTable().columns.adjust().draw();
                    $('#dataakta').DataTable().columns.adjust().draw();
                    lang();
                } else {
                    tbl(id);
                    lang();
                    msg_danger("Peringatan", "Data tidak ditemukan");
                    $('#main').hide();
                    $('#edit').show();
                    lang();
                }
            }
        });
    }
    function pilih(elem) {
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
    function slides()
    {
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
            // "scrollX": true,
            "selected": true,
            // "scrollY": "300px",
            // "scrollCollapse": true,
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
            "scrollX": "300px",
            "selected": true,
            // "scrollY": "300px",
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
            // "scrollX": true,
            "selected": true,
            // "scrollY": "300px",
            // "scrollCollapse": true,
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
            // "scrollX": true,
            "selected": true,
            // "scrollY": "300px",
            // "scrollCollapse": true,
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
            // fixedColumns: {
            //     leftColumns: 1,
            //     rightColumns: 1
            // },
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
            "scrollX": '300px',
            // "scrollY": '300px',
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
            // fixedColumns: {
            //     leftColumns: 1,
            //     rightColumns: 1
            // },
            columns: [
                {title: "<span>No.</span>"},
                {title: "<?= lang("Tipe Pemilik Saham", "Share Owner Type") ?>"},
                {title: "<?= lang("Nama Lengkap", "Full name") ?>"},
                {title: "<?= lang("Nomor Telepon", "Phone number") ?>"},
                {title: "<?= lang("Email", "Email") ?>"},
                {title: "<?= lang("Berlaku Sampai", "Valid until") ?>"},
                {title: "<?= lang("NPWP", "NPWP") ?>"},
                {title: "<?= lang("Scan NPWP", "Scan NPWP") ?>"},
            ],
            "columnDefs": [
                {"className": "dt-right", "targets": [0]},
                {"className": "dt-center", "targets": [4]}
            ],
            "scrollX": '300px',
            // "scrollY": '300px',
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
            // fixedColumns: {
            //     leftColumns: 1,
            //     rightColumns: 1
            // },
            "columns": [
                {title: "<span>No.</span>"},
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
            "scrollX": '300px',
            // "scrollY": '300px',
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
            // fixedColumns: {
            //     leftColumns: 1,
            //     rightColumns: 1
            // },
            columns: [
                {title: "No"},
                {title: "<?= lang("Bank", "Share Owner Type") ?>"},
                {title: "<?= lang("Alamat", "Full name") ?>"},
                {title: "<?= lang("Cabang", "Phone number") ?>"},
                {title: "<?= lang("Nomor. Rekening", "Email") ?>"},
                {title: "<?= lang("Nama Akun", "Valid until") ?>"},
                {title: "<?= lang("Mata Uang", "NPWP") ?>"},
                {title: "<?= lang("File", "File") ?>"},
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
            // "scrollX": true,
            // "scrollY": '300px',
            // "scrollCollapse": true
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
            // fixedColumns: {
            //     leftColumns: 1,
            //     rightColumns: 1
            // },
            columns: [
                {title: "<span>No.</span>"},
                {title: "<?= lang("Jenis Sertifikasi", "Certification Type") ?>"},
                {title: "<?= lang("Nama Sertifikasi", "Certification Name") ?>"},
                {title: "<?= lang("No. Sertifikasi", "Number Certification") ?>"},
                {title: "<?= lang("Dikeluarkan Oleh", "Issued By") ?>"},
                {title: "<?= lang("Berlaku Mulai", "Apply Start") ?>"},
                {title: "<?= lang("Berlaku Sampai", "Apply End") ?>"},
                {title: "<?= lang("File", "File") ?>"},
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
            "scrollX": '300px',
            // "scrollY": '300px',
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
            // fixedColumns: {
            //     leftColumns: 1,
            //     rightColumns: 1
            // },
            columns: [
                {title: "<span>No.</span>"},
                {title: "<?= lang("Nama Pelanggan", "Customers Name") ?>"},
                {title: "<?= lang("Nama Projek", "Project Name") ?>"},
                {title: "<?= lang("Projek Description", "Project Name") ?>"},
                {title: "<?= lang("Nilai Project", "Project Value") ?>"},
                {title: "<?= lang("No. Kontrak", "Contract Number") ?>"},
                {title: "<?= lang("Tanggal Mulai", "Start Date") ?>"},
                {title: "<?= lang("Tanggal Selesai", "Finish Date") ?>"},
                {title: "<?= lang("Contact Person", "Contact Person") ?>"},
                {title: "<?= lang("No. Tlpn", "No. Tlpn") ?>"},
            ],
            "columnDefs": [
                {"className": "dt-right", "targets": [0]},
                {"className": "dt-center", "targets": [4]}
            ],
            "scrollX": '300px',
            // "scrollY": '300px',
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
            url: "<?php echo site_url('vendor/approve_update/filter_data'); ?>",
            data: obj,
            cache: false,
            success: function (res)
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

    function review_gambar(data)
    {
        //$('.modal-title').html("Priview File") ?>");
        $('#ref').attr('src', data);
        $('#modal_ref').modal('show');
    }

</script>
