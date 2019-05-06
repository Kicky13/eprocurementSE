<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0"><?= lang("Barang dan Jasa", "Goods and Service") ?></h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?=base_url($menu[0][1]['URL']);?>"><?= lang("Dashboard", "Dashboard"); ?></a>
                            </li>
                            <li class="breadcrumb-item active"><?= lang("Barang dan Jasa", "Goods and Service") ?>
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
                        <div class="card-header" id="GNS1">
                            <h4 class="card-title"><?= lang("Sertifikasi Keagenan dan Prinsipal", "Agency and Principal Certification") ?></h4>
                            <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                            <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Sertifikasi ditolak", "Certification data is rejected") ?></div>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><button aria-expanded="false" id="modal1" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table id="datasertifikasi" class="table table-striped table-bordered table-hover display" width="100%">
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="jasa">
                  <section id="description">
                      <div class="card">
                          <div class="card-header" id="GNS3">
                              <h4 class="card-title"><?= lang("Daftar Jasa ", "List of Services Supplied"); ?></h4>
                              <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                              <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Jasa ditolak", "Service data is rejected") ?></div>
                              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                              <div class="heading-elements">
                                  <ul class="list-inline mb-0">
                                      <li><button aria-expanded="false" id="modal2" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                      <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                  </ul>
                              </div>
                          </div>
                          <div class="card-content">
                              <div class="card-body">
                                  <table id="datajasa" class="table table-striped table-bordered table-hover display" width="100%">
                                  </table>
                              </div>
                          </div>
                      </div>
                  </section>
                </div>

                <div class="barang">
                  <section id="description">
                      <div class="card">
                          <div class="card-header" id="GNS2">
                              <h4 class="card-title"><?= lang("Daftar Barang ", "List of Material Supplied") ?></h4>
                              <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                              <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Barang ditolak", "Goods data is rejected") ?></div>
                              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                              <div class="heading-elements">
                                  <ul class="list-inline mb-0">
                                      <li><button aria-expanded="false" id="modal4" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                      <!-- <li><button aria-expanded="false" id="modal3" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Pilih data", "Choose data") ?></button></li> -->
                                      <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                  </ul>
                              </div>
                          </div>
                          <div class="card-content">
                              <div class="card-body">
                                  <table id="databarang" class="table table-striped table-bordered table-hover display" width="100%">
                                  </table>
                              </div>
                          </div>
                      </div>
                  </section>
                </div>

                <div class="konsul">
                  <section id="description">
                      <div class="card">
                          <div class="card-header" id="GNS4">
                              <h4 class="card-title"><?= lang("Daftar Jasa Konsultasi ", "List of Consultation Service") ?></h4>
                              <div class="verif"><i class="fa fa-check success"></i><?= lang(" Data Terverifikasi", "Data is verified") ?></div>
                              <div class="verif_rej"><i class=" fa fa-times danger"></i><?= lang(" Data Konsultasi ditolak", "Consultation data is rejected") ?></div>
                              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                              <div class="heading-elements">
                                  <ul class="list-inline mb-0">
                                      <li><button aria-expanded="false" id="modal5" class="btn btn-outline-primary"><i class="ft-plus-circle"></i><?= lang(" Tambah data", "Add data") ?></button></li>
                                      <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                  </ul>
                              </div>
                          </div>
                          <div class="card-content">
                              <div class="card-body">
                                  <table id="datakonsultasi" class="table table-striped table-bordered table-hover display" width="100%">
                                  </table>
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
</div>
<div class="modal fade text-left" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang("Tambah Data Sertifikasi Keagenan", "Tambah Finance and Bank Data ") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body col-12">
                <form id="cert_form" class="form GNS1" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 control-label " for="tahun"><?= lang("Dikeluarkan Oleh", "Issued By"); ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="issued_by" name="issued_by" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="no_doc"><?= lang("Nomor Surat", "Doc. Number") ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="no_doc" name="no_doc" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="valid_since"><?= lang("Berlaku Mulai", "Issued date"); ?></label>
                                    <div class="col-8">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="valid_since" name="valid_since" value="<?= date('d-m-Y') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="kualifikasi"><span><?= lang("kualifikasi", "Qualification") ?></span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="kualifikasi" name="kualifikasi" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="file_sert"><?= lang("File Sertifikasi", "Document") ?></label>
                                    <div class="col-8">
                                        <input type="file" name="file_sert" id="file_sert" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="valid_until"><?= lang("Berlaku sampai", "Expired Date"); ?></label>
                                    <div class="col-8">
                                        <div class="input-group date validto">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="valid_until" name="valid_until" value="<?= date('Y-m-d') ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class=" col-sm-12 text-right">
                        <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                        <button type="submit" id="key_update" name="keys1" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Perbarui data", "Update Data") ?></button>
                        <button type="submit" id="keys1" name="keys" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Tambah data", "Add Data") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <div id="modal_file" class="modal fade bs-example-modal-xl" role="dialog"  >
    <div class="modal-dialog modal-xl" style="width:800px">
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
</div> -->
<div id="modal_file" class="modal fade bs-example-modal-lg" role="dialog" style="z-index: 9999;">
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
<div class="modal fade bs-example-modal-xl" data-backdrop="static" id="modal_jasa" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang("Tambah Data Jasa", "Add Service Data") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body GNS2">
                <form id="service_data" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-2 control-label " for="grup_jasa"><?= lang("Group Jasa", "Service Group "); ?></label>
                            <div class="col-4">
                                <select style="width:100%" class="select2 form-control" id="grup" name="grup_jasa[]" onchange="jasa(this.value)">
                                    <?php
                                    foreach ($SERVICE as $k => $v) {
                                        echo '<option value=' . $v['ID'] . '>' . $v['MATERIAL_GROUP'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <label class="col-2 control-label" for="subgrup_jasa"><?= lang("Sub Group Jasa", "Service Sub Group ") ?></label>
                            <div class="col-4">
                                <select style="width:100%" class="select2 form-control" id="subgrup_jasa" name="subgrup_jasa[]" onchange="lihat_produk()" >
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="nama_jasa"><?= lang("Nama Jasa", "Service Name"); ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="nama_jasa" name="nama_jasa" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="deskripsi"><?= lang("Deskripsi", "Description"); ?></label>
                                    <div class="col-8">
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 control-label" for="nomor_cert"><span><?= lang("Nomor Sertifikat", "Certificate Number") ?></span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="nomor_cert" name="nomor_cert" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class=" col-12 text-right">
                        <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                        <button type="submit" id="update_service" name="keys_update" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Perbarui data", "Update Data") ?></button>
                        <button type="submit" id="keys1" name="keys" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Simpan data", "Save Data") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-xl" data-backdrop="static" id="modal_consultation" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang("Tambah Data Consultation", "Add Consultation Service Data") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body GNS2">
                <form id="consul_data" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-2 control-label " for="grup_consul"><?= lang("Group Konsultasi", "Consultation Group "); ?></label>
                            <div class="col-4">
                                <select style="width:100%" class="select2 form-control" id="grup_consul" name="grup_consul[]" onchange="consul(this.value,'CONSULTATION','#modal_consultation #subgrup_consul')">
                                    <?php
                                    foreach ($CONSULTATION as $k => $v) {
                                        echo '<option value=' . $v['ID'] . '>' . $v['MATERIAL_GROUP'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <label class="col-2 control-label" for="subgrup_consul"><?= lang("Sub Group Konsultasi", "Consultation Sub Group") ?></label>
                            <div class="col-4">
                                <select style="width:100%" class="select2 form-control" id="subgrup_consul" name="subgrup_consul[]" onchange="lihat_produk()" >
                                </select>
                            </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-4 control-label" for="nama_consul"><?= lang("Nama Konsultasi", "Consultation Name"); ?></label>
                              <div class="col-6">
                                  <input type="text" class="form-control" id="nama_consul" name="nama_consul" >
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-4 control-label" for="nomor_consul"><span><?= lang("Nomor Sertifikat", "Certificate Number") ?></span></label>
                              <div class="col-6">
                                  <input type="text" class="form-control" id="nomor_consul" name="nomor_consul" >
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-2 control-label" for="deskripsi"><?= lang("Deskripsi", "Description"); ?></label>
                            <div class="col-4">
                                <textarea class="form-control" id="deskripsi_consul" name="deskripsi_consul" ></textarea>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class=" col-12 text-right">
                        <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                        <button type="submit" id="update_consul" name="keys_update" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Perbarui data", "Update Data") ?></button>
                        <button type="submit" id="keys1" name="keys" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Simpan data", "Save Data") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-xl" data-backdrop="static" id="modal_barang" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang("Pilih Data Barang", "Choose Goods Data ") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-12 GNS3">
                    <form id="form_goods" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row">
                                    <label class="col-2 control-label " for="tahun"><?= lang("Group Barang", "Goods Group"); ?></label>
                                    <div class="col-8">
                                        <div class="col-8" style="padding-left:0px">
                                            <select style="width:100%" class="select2 form-control" id="group_goods" onchange="lihat_sub()" name="group_goods" >
                                                <?php
                                                foreach ($GOODS as $k => $v) {
                                                    echo '<option value=' . $v['ID'] . '>' . $v['MATERIAL_GROUP'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 control-label" for="hp"><?= lang("Sub Group Barang", "Goods Sub Group") ?></label>
                                    <div class="col-sm-8">
                                        <select style="width:100%" class="select2 form-control" id="sub_group_goods" onchange="lihat_produk()" name="sub_group_goods[]" >
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="produk" class="form-group row col-12">
                            </div>
                        </div>
                        <hr/>
                        <div class=" col-sm-12 text-right">
                            <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                            <!--<button type="submit" id="update" name="keys" value="0" style="width:115px" class="btn btn-primary"><?= lang("Perbarui data", "Update data") ?></button>-->
                            <button type="submit" id="update" name="keys" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Perbarui data", "Update Data") ?></button>
                            <!--<button type="submit" id="keys1" name="keys" value="0" style="width:115px" class="btn btn-primary"><?= lang("Simpan", "Save") ?></button>-->
                            <button type="submit" id="keys1" name="keys" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Simpan data", "Save Data") ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bs-example-modal-xl" data-backdrop="static" id="modal_buat" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang("Tambah Data Barang", "Choose Goods Data ") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body GNS3">
                <form id="goods_data" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 label-control " for="tahun"><?= lang("Group Barang", "Goods Group"); ?></label>
                                    <div class="col-sm-8">
                                        <select style="width:100%" class="select2 form-control" id="goods_group" name="goods_group" onchange="barang(this.value)">
                                            <?php
                                            $c = 0;
                                            foreach ($GOODS as $k => $v) {
                                                echo '<option value=' . $v['ID'] . '>' . $v['MATERIAL_GROUP'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="hp"><?= lang("Sub Group Barang", "Goods Sub Group") ?></label>
                                    <div class="col-8">
                                        <select style="width:100%" class="select2 form-control" id="goods_sub_group" onchange="lihat_produk()" name="goods_sub_group" >

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="valuta"><?= lang("Nama Barang", "Goods Name"); ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="goods_name" name="goods_name" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="nilai_aset"><?= lang("Merk", "Merk"); ?></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="goods_merk" name="goods_merk" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="hutang"><span><?= lang("Status Keagenan", "Agency Status") ?></span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="goods_status" name="goods_status" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 label-control" for="hutang"><span><?= lang("Nomor Sertifikat", "Certificate Number") ?></span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="number_cert" name="number_cert" >
                                    </div>
                                </div>
                                <div class="form-group row" id="file_goods">
                                    <label class="col-4 label-control" for="hutang"><span><?= lang("Upload Gambar", "Pricture Upload") ?></span></label>
                                    <div class="col-8">
                                        <input type="file" name="goods_file" id="goods_file" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class=" col-12 text-right">
                                <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>
                                <button type="submit" id="keys1" name="keys1" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Simpan data", "Save Data") ?></button>
                                <button type="submit" id="update_keys1" name="update_keys1" value="0" style="width:115px" class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in"><?= lang("Perbarui data", "Update Data") ?></button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>
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
      date_moment(".validto", true);
      date_moment(".input-group.date", false);
      // $('.input-group.date').datetimepicker({
      //     format: 'DD-MM-YYYY'
      // });

        lang();
        $("#grup").select2({
            placeholder: "Please Select"
        });
        $("#subgrup_jasa").select2({
            placeholder: "Please Select"
        });
        $("#subgrup_consul").select2({
            placeholder: "Please Select"
        });
        $("#grup_consul").select2({
            placeholder: "Please Select"
        });
        $("#goods_group").select2({
            placeholder: "Please Select"
        });
        $("#group_goods").select2({
            placeholder: "Please Select"
        });
        $("#goods_sub_group").select2({
            placeholder: "Please Select"
        });
        $("#sub_group_goods").select2({
            placeholder: "Please Select"
        });
        $('#goods_sub_group').prop('disabled', true);
        $('#service_data #subgrup_jasa').prop('disabled', true);
        $('#modal2').modal('hide');
        $('#modal').modal('hide');
        $('#produk').hide();
        $('#modal1').click(function (e) {
            $('#modal #keys1').show();
            $('#modal #key_update').hide();
            $('#modal .modal-title').html("<?= lang("Tambah Data Sertifikasi Keagenan", "Add Agency Sertification Data") ?>");
            lang();
            $('#modal').modal('show');
        });
        $('#modal2').click(function (e) {
            jasa('<?=$SERVICE[0]['ID']; ?>');
            $('#modal_jasa #keys1').show();
            $('#modal_jasa #update_service').hide();
            $('#modal_jasa .modal-title').html("<?= lang("Tambah Data Jasa", "Add Service Data") ?>");
            lang();
            $('#modal_jasa').modal('show');
        });
        $('#modal3').click(function (e) {
            $('#modal_barang #keys1').show();
            $('#modal_barang #update').hide();
            $('#sub_group_goods').prop('disabled', true);
            $('#produk').hide();
            $('#modal_barang .modal-title').html("<?= lang("Pilih Data Barang", "Choose Goods Data") ?>");
            lang();
            $('#modal_barang').modal('show');
        });
        $('#modal4').click(function (e) {
            $('#modal_buat #file_goods').show();
            $('#modal_buat #keys1').show();
            $('#modal_buat #update_keys1').hide();
            $('#modal_buat .modal-title').html("<?= lang("Tambah Data Barang", "Add Goods Data") ?>");
            lang();
            $('#modal_buat').modal('show');
        });
        $('#modal5').click(function (e) {
            consul('<?=$CONSULTATION[0]['ID']; ?>','CONSULTATION','#modal_consultation #subgrup_consul');
            $('#modal_consultation #keys1').show();
            $('#modal_consultation #update_consul').hide();
            $('#modal_consultation .modal-title').html("<?= lang("Tambah Data Jasa Konsultasi", "Add Consultation Service Data") ?>");
            $('#consul_data').trigger("reset");
            $("#deskripsi_consul").html('');
            lang();
            $('#modal_consultation').modal('show');
        });
        $('input[type="file"]').change(function () {
            var filename = $("#" + this.id)[0].files[0];
            var ext = String(filename.name).split(".");
            if (this.id != "goods_file" && ext[ext.length-1] != "pdf")
                msg_danger("Warning", "File type allowed only PDF Max 2MB");
            else if(this.id == "goods_file" && ext[ext.length-1].toLowerCase() != "jpg" && ext[ext.length-1].toLowerCase() != "png" && ext[ext.length-1].toLowerCase() != "jpeg" && ext[ext.length-1].toLowerCase() != "pdf")
                msg_danger("Warning", "File type allowed only JPG,PNG,JPEG Max 1MB");
        });

        $.ajax({
          url: '<?= base_url('vn/info/goods_service/material_vendor'); ?>',
          type: 'get',
          dataType: 'json',
          success: function(res){
            // var str1 = $( ".jasa h4:first" ).text().toLowerCase();
            // var str2 = $( ".barang h4:first" ).text().toLowerCase();
            // var strx = res.data.CLASSIFICATION.toLowerCase().replace(',', ' ');
            // console.log(res);
            // if (strx.indexOf("jasa") == -1) {
            //   $(".jasa").hide();
            // } else {
            //   $(".jasa").show();
            // }
            //
            // if (strx.indexOf("penyedia barang") == -1) {
            //   $(".barang").hide();
            // } else {
            //   $(".barang").show();
            // }
            //
            // if (strx.indexOf("konsultan") == -1) {
            //   $(".konsul").hide();
            // } else {
            //   $(".konsul").show();
            // }

            var arr = [];
            var splitx = res.data.CLASSIFICATION.toLowerCase().split(",");
            arr.push(splitx);
            console.log(splitx);

            if (splitx.indexOf("penyedia barang") == -1) {
              $(".barang").hide();
            } else {
              $(".barang").show();
            }

            if (splitx.indexOf("konsultan") == -1) {
              $(".konsul").hide();
            } else {
              $(".konsul").show();
            }

            if (splitx.indexOf("jasa pemborongan") == -1) {
              $(".jasa").hide();
            } else {
              $(".jasa").show();
            }

            if (splitx.indexOf("penyedia jasa") == -1) {
              // $(".jasa").hide();
            } else {
              $(".jasa").show();
              $(".konsul").show();
            }

          }
        });

        var tabel = $('#datasertifikasi').DataTable({
            ajax: {
                url: '<?= base_url('vn/info/goods_service/get_cert') ?>',
                'dataSrc': ''
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
                {title: "No"},
                {title: "<?= lang("Dikeluarkan Oleh", "Issued By") ?>"},
                {title: "<?= lang("Nomer", "Number") ?>"},
                {title: "<?= lang("Dikeluarakan Tanggal", "Issued Date") ?>"},
                {title: "<?= lang("Tanggal Kadaluarsa", "Expired Date") ?>"},
                {title: "<?= lang("Kualifikasi", "Qualification") ?>"},
                {title: "<?= lang("File", "File") ?>"},
                {title: "<?= lang("&nbsp&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp&nbsp&nbsp") ?>"},
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
        $('#datasertifikasi tbody').on('click', 'tr .update', function () {
            var data2 = tabel.row($(this).parents('tr')).data();
            $(' #key_update').show();
            $(' #key_update').val(this.id);
            $('#keys1').hide();
            $('#produk').hide();
            $('#issued_by').val(data2[1]);
            $('#no_doc').val(data2[2]);
            $('#valid_since').val(data2[3]);
            $('#valid_until').val(data2[4]);
            $('#kualifikasi').val(data2[5]);
            $('#modal .modal-title').html("<?= lang("Perbarui Data Sertifikasi Keagenan", "Update Agency Sertification Data") ?>");
            lang();
            $('#modal').modal('show');
        });
        var tabel2 = $('#databarang').DataTable({
            ajax: {
                url: '<?= base_url('vn/info/goods_service/get_goods') ?>',
                'dataSrc': ''
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
                {title: "No</span>"},
                {title: "<?= lang("Group Barang", "Goods Group") ?>"},
                {title: "<?= lang("Sub Group Barang", "Goods Sub Group") ?>"},
                {title: "<?= lang("Nama Barang", "Goods Name") ?>"},
                {title: "<?= lang("Merk", "Merk") ?>"},
                {title: "<?= lang("Status Keagenan", "Agen Status") ?>"},
                {title: "<?= lang("Nomor", "Number") ?>"},
                {title: "<?= lang("File", "File") ?>"},
                {title: "<?= lang("&nbsp&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp&nbsp&nbsp")
                                            ?>"},
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
            ]
        });
        $('#databarang tbody').on('click', 'tr .update-goods', function () {
            var data2 = tabel2.row($(this).parents('tr')).data();
//            console.log(data2);
            if (this.value === "TAMBAH")
            {
                var res=conv_data('GROUP','GOODS',data2[1]);
                $('#goods_data #goods_group').val(res[0].ID).select2();

                consul(res[0].ID,"GOODS","#goods_data #goods_sub_group");
                res=conv_data('SUB','GOODS',data2[2]);
                $('#goods_data #goods_sub_group').val(res[0].ID).select2();

                $('#goods_data #goods_name').val(data2[3]);
                $('#goods_data #goods_merk').val(data2[4]);
                $('#goods_data #goods_status').val(data2[5]);
                $('#goods_data #number_cert').val(data2[6]);
                $('#goods_data #update_keys1').val(this.id);
                $('#modal_buat #update_keys1').show();
                $('#modal_buat #keys1').hide();
                $('#modal_buat #file_goods').show();
                $('#modal_buat .modal-title').html("<?= lang("Perbarui Data Barang", "Update Goods Data") ?>");
                lang();
                $('#modal_buat').modal('show');
            }
            else if (this.value === "PILIH")
            {
                var res=conv_data('GROUP','GOODS',data2[1]);
                $('#goods_data #goods_group').val(res[0].ID).select2();

                consul(res[0].ID,"GOODS","#goods_data #goods_sub_group");
                res=conv_data('SUB','GOODS',data2[2]);
                $('#goods_data #goods_sub_group').val(res[0].ID).select2();

                $('#goods_data #goods_name').val(data2[3]);
                $('#goods_data #update_keys1').val(this.id);
                $('#modal_buat #update_keys1').show();
                $('#modal_buat #keys1').hide();
                $('#modal_buat #file_goods').hide();
                $('#modal_buat .modal-title').html("<?= lang("Perbarui Data Barang", "Update Goods Data") ?>");
                lang();
                $('#modal_buat').modal('show');
            }
        });
        var tabel3 = $('#datajasa').DataTable({
            'ajax': {
                'url': '<?= base_url('vn/info/goods_service/get_service') ?>',
                'dataSrc': ''
            },
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            "data": null,
            paging: false,
            "columns": [
                {title: "No"},
                {title: "<?= lang("Group Jasa", "Group Service") ?>"},
                {title: "<?= lang("Sub Group Jasa", "Service Sub Group") ?>"},
                {title: "<?= lang("Nama Jasa", "Service Name") ?>"},
                {title: "<?= lang("Deskripsi", "Description") ?>"},
                {title: "<?= lang("Nomor Izin", "Number") ?>"},
                {title: "<?= lang("&nbsp&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp&nbsp&nbsp")
                                            ?>"},
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]},
            ],
            "scrollX": true,
            "scrollY": '300px',
            "scrollCollapse": true,
        });
        $('#datajasa tbody').on('click', 'tr .update', function () {
            var data2 = tabel3.row($(this).parents('tr')).data();
            var res=conv_data('GROUP','SERVICE',data2[1]);
            $('#service_data #grup').val(res[0].ID).select2();

            consul(res[0].ID,"SERVICE","#service_data #subgrup_jasa");
            res=conv_data('SUB','SERVICE',data2[2]);
            $('#service_data #subgrup_jasa').val(res[0].ID).select2();

            $('#service_data #nama_jasa').val(data2[3]);
            $('#service_data #deskripsi').text(data2[4]);
            $('#service_data #nomor_cert').val(data2[5]);
            $('#modal_jasa #keys1').hide();
            $('#modal_jasa #update_service').show();
            $('#modal_jasa #update_service').val(this.id);
            $('#modal_jasa .modal-title').html("<?= lang("Perbarui Data Jasa", "Update Service Data") ?>");
            lang();
            $('#modal_jasa').modal('show');
        });

        var tabel4 = $('#datakonsultasi').DataTable({
            'ajax': {
                'url': '<?= base_url('vn/info/goods_service/get_consul') ?>',
                'dataSrc': ''
            },
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            },
            "data": null,
            paging: false,
            "columns": [
                {title: "No"},
                {title: "<?= lang("Group Jasa", "Group Service") ?>"},
                {title: "<?= lang("Sub Group Jasa", "Service Sub Group") ?>"},
                {title: "<?= lang("Nama Jasa", "Service Name") ?>"},
                {title: "<?= lang("Deskripsi", "Description") ?>"},
                {title: "<?= lang("Nomor Izin", "Number") ?>"},
                {title: "<?= lang("&nbsp&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp&nbsp&nbsp")
                                            ?>"},
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]},
            ],
            "scrollX": true,
            "scrollY": '300px',
            "scrollCollapse": true,
        });
        $('#datakonsultasi tbody').on('click', 'tr .update', function () {
            var data2 = tabel4.row($(this).parents('tr')).data();
            var res=conv_data('GROUP','CONSULTATION',data2[1]);

            $('#modal_consultation #grup_consul').val(res[0].ID).select2();
            consul(res[0].ID,"CONSULTATION","#modal_consultation #subgrup_consul");
            res=conv_data('SUB','CONSULTATION',data2[2]);
            $('#modal_consultation #subgrup_consul').val(res[0].ID).select2();
            $('#modal_consultation #nama_consul').val(data2[3]);
            $('#modal_consultation #deskripsi_consul').text(data2[4]);
            $('#modal_consultation #nomor_consul').val(data2[5]);
            $('#modal_consultation #keys1').hide();
            $('#modal_consultation #update_consul').show();
            $('#modal_consultation #update_consul').val(this.id);
            $('#modal_consultation .modal-title').html("<?= lang("Perbarui Data Jasa Konsultasi", "Update Consultation Service Data") ?>");
            lang();
            $('#modal_consultation').modal('show');
        });

        $('#saveall').click(function (e)
        {
            $('#company_info').submit();
        });
        lang();
        $('#modal_detail').on('hidden.bs.modal', function (e) {
            if ($('#modal_barang').hasClass('in')) {
                $('body').addClass('modal-open');
            }
        });
        $('#service_data').validate({
            focusInvalid: false,
            rules: {
                nama_jasa: {required: true},
                nomor_cert: {required: false},
                deskripsi: {required: true},
                grup_jasa: {required: true},
                subgrup_jasa: {required: true},
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
                var elm = start($('#modal_jasa').find('.modal-content'));
                var obj = {};
                $.each($("#service_data").serializeArray(), function (i, field) {
                    obj[field.name] = field.value;
                });
                obj['KEY'] = $("#update_service").val();
//                console.log(obj);
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/goods_service/add_service'); ?>",
                    data: obj,
                    cache: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res === true) {
                            $('#modal_jasa').modal('hide');
                            if ($('#service_data #update').val !== "0")
                            {
                                $('#service_data #update').val("0");
                                document.getElementById("service_data").reset();
                            }
                            $('#datajasa').DataTable().ajax.reload();
                            $('#datajasa').DataTable().columns.adjust().draw();
                            msg_info("Success", "Data successfully saved");
                        }else
                        {
                            msg_danger("Error", "Failed saving Data ");
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Failed", "Oops,something wrong");
                    }
                });
            }
        });
        $('#consul_data').validate({
            focusInvalid: false,
            rules: {
                nama_consul: {required: true},
                nomor_consul: {required: false},
                deskripsi_consul: {required: true},
                grup_consul: {required: true},
                subgrup_consul: {required: true},
            },
            errorPlacement: function (label, element) { // render error placement for each input type
                var elmnt = element[0].id;
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
                var elm = start($('#modal_consultation').find('.modal-content'));
                var obj = {};
                $.each($("#consul_data").serializeArray(), function (i, field) {
                    obj[field.name] = field.value;
                });
                obj['KEY'] = $("#update_consul").val();
//                console.log(obj);
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/goods_service/add_consul'); ?>",
                    data: obj,
                    cache: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res === true) {
                            $('#modal_consultation').modal('hide');
                            if ($('#update_consul').val !== "0")
                            {
                                $('#update_consul').val("0");
                                document.getElementById("consul_data").reset();
                            }
                            $('#datakonsultasi').DataTable().ajax.reload();
                            $('#datakonsultasi').DataTable().columns.adjust().draw();
                            msg_info("Success", "Data successfully saved");
                        }else
                        {
                            msg_danger("Error", "Failed saving Data");
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Failed", "Oops,something wrong");
                    }
                });
            }
        });
        $('#cert_form').validate({
            focusInvalid: false,
            rules: {
                issued_by: {required: true},
                no_doc: {required: true},
                valid_since: {required: true},
                valid_until: {required: true},
                kualifikasi: {required: true},
//                file_sert: {required: true},
            },
            errorPlacement: function (label, element) { // render error placement for each input type
                var elmnt = element[0].id;
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
                var obj = {};
                var formData = new FormData($('#cert_form')[0]);
                var key = $('#key_update').val();
//                console.log(key);
                formData.append('KEY', key);
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/goods_service/add_cert'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res === true) {
                            $('#modal').modal('hide');
                            if ($('#key_update').val !== "0")
                            {
                                $('#key_update').val("0");
                                document.getElementById("cert_form").reset();
                            }
                            $('#datasertifikasi').DataTable().ajax.reload();
                            $('#datasertifikasi').DataTable().columns.adjust().draw();
                            msg_info("Success", "Data successfully saved");
                        } else
                        {
                            msg_danger(res.status,res.msg);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Failed", "Oops,something wrong");
                    }
                });
            }
        });
        $('#goods_data').validate({
            focusInvalid: false,
            rules: {
                goods_group: {required: true},
                goods_sub_group: {required: true},
                goods_name: {required: true},
                goods_merk: {required: true},
                goods_status: {required: false},
                number_cert: {required: false},
//                goods_file: {required: true},
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
                var elm = start($('#modal_buat').find('.modal-content'));
                var obj = {};
                var formData = new FormData($('#goods_data')[0]);
                formData.append('update_keys1', $('#goods_data #update_keys1').val());
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/goods_service/add_goods'); ?>",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res.status == "success") {
                            $('#modal_buat').modal('hide');
                            if ($('#goods_data #update_keys1').val !== "0")
                            {
                                $('#goods_data #update_keys1').val("0");
                                document.getElementById("goods_data").reset();
                            }
                            $('#databarang').DataTable().ajax.reload();
                            $('#databarang').DataTable().columns.adjust().draw();
                            msg_info(res.status, res.msg);
                        }
                        else
                            msg_danger(res.status, res.msg);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Failed", "Oops,Something Wrong");
                    }
                });
            }
        });
        $('#form_goods').validate({
            focusInvalid: false,
            rules: {
                group_goods: {required: true},
                sub_group_goods: {required: true},
                pilih: {required: true},
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
                var elm = start($('#modal_barang').find('.modal-content'));
                var obj = {};
                $.each($("#form_goods").serializeArray(), function (i, field) {
                    obj[field.name] = field.value;
                });
                obj.keys = $('#form_goods #update').val();
                delete obj['pilih'];
                var checkboxes = document.getElementsByName('pilih');
                for (var i = 0, n = checkboxes.length; i < n; i++)
                {
                    if (checkboxes[i].checked)
                    {
                        if (typeof obj['pilih'] !== 'undefined')
                            obj['pilih'] += "," + checkboxes[i].value;
                        else
                        {
                            obj['pilih'] = checkboxes[i].value;
                        }
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/goods_service/add_goods_pilih'); ?>",
                    data: obj,
                    cache: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res.status != "failed") {
                            $('#modal_barang').modal('hide');
                            if ($('#form_goods #update').val !== "0")
                            {
                                $('#form_goods #update').val("0");
                                document.getElementById("form_goods").reset();
                            }
                            $('#databarang').DataTable().ajax.reload();
                            $('#databarang').DataTable().columns.adjust().draw();
                            msg_info("Success", res.msg);
                        }
                        else
                            msg_danger("Failed", res.msg);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Failed", "Oops,Something went wrong");
                    }
                });
            }
        });
    });
    function jasa(type)
    {
//        console.log(type);
        var obj = {};
        obj.ID = type;
        obj.TYPE = "SERVICE";
        obj.API = "GET";
        $.ajax({
            type: "POST",
            url: "<?= base_url('vn/info/goods_service/get_sub'); ?>",
            data: obj,
            cache: false,
            success: function (res)
            {
                if (!res.status) {
                    $("#service_data #subgrup_jasa").html(res);
                    $("#service_data #subgrup_jasa").prop('disabled', false);
                }
                else
                    msg_danger(res.status, res.msg);
            }
        });

    }

    function conv_data(group,type,data)
    {
        var obj = {};
        obj.GROUP = group;
        obj.TYPE = type;
        obj.DATA = data;
        var dt=$.ajax({
            type: "POST",
            url: "<?= base_url('vn/info/goods_service/conv_data'); ?>",
            data: obj,
            async: false,
            cache: false,
        }).responseJSON;
        return dt;
    }

    function consul(id,type,sel)
    {
//        console.log(type);
        var obj = {};
        obj.ID = id;
        obj.TYPE = type;
        obj.API = "GET";
        $.ajax({
            type: "POST",
            url: "<?= base_url('vn/info/goods_service/get_sub'); ?>",
            data: obj,
            async:false,
            cache: false,
            success: function (res)
            {
                if (!res.status) {
                    $(sel).html(res);
                    $(sel).prop('disabled', false);
                }
                else
                    msg_danger(res.status, res.msg);
            }
        });

    }
    function barang(type)
    {
//        console.log(type);
        var obj = {};
        obj['ID'] = type;
        obj['TYPE'] = "GOODS";
        obj['API'] = "GET";
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('vn/info/goods_service/get_sub'); ?>",
            cache: false,
            data: obj,
            success: function (res)
            {
                if (!res.status) {
                    $("#goods_data #goods_sub_group").html(res);
                    $("#goods_data #goods_sub_group").prop('disabled', false);
                }
                else
                    msg_danger(res.status, res.msg);
            }
        });
    }
    function lihat_sub()
    {
        var obj = {};
        obj.group = $('#modal_barang #group_goods').val();
        if (obj.group === "") {

            $('#modal_barang #sub_group_goods').prop('disabled', true);
            $('#produk').hide();
        }
        else
        {
            var obj = {};
            obj['ID'] = $('#modal_barang #group_goods').val();
            obj['TYPE'] = "GOODS";
            obj['API'] = "GET";
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/goods_service/get_sub'); ?>",
                cache: false,
                data: obj,
                success: function (res)
                {
                    $('#modal_barang #sub_group_goods').html(res);
                    $('#modal_barang #sub_group_goods').prop('disabled', false);
                }
            });
        }
    }
    function lihat_produk()
    {
        var obj = {};
        obj.sub = $('#modal_barang #sub_group_goods').val();

        if ($('#modal_barang #sub_group_goods').val() === "") {
            $('#produk').hide();
            return;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('vn/info/goods_service/get_produk'); ?>",
            data: obj,
            cache: false,
            success: function (res)
            {
                $('#produk').html(res);
                $('#produk').show();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                msg_danger("Failed", "Oops,Something wrong");
            }
        });
    }

    function delete_data(obj, dt, tbl)
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
            msg_default('Proccesing', "Deleting Data...");
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('vn/info/goods_service/') ?>" + dt,
                data: obj,
                cache: false,
                success: function (res)
                {
                    if (res == true)
                    {
                        $(tbl).DataTable().ajax.reload();
                        $(tbl).DataTable().columns.adjust().draw();
                        msg_info("Success", "Data successfully deleted");
                        swal("Data successfully deleted", "", "success");
                    } else {
                        swal("Failed deleting data", "", "failed");
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    msg_danger("Failed", "Oops,something wrong");
                }
            });
        });
    }
    function delete_service(key, id)
    {
        var data = {};
        data.ID_VENDOR = id;
        data.KEY = key;
        data.API = "delete";
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('vn/info/all_vendor/check_vendor'); ?>",
            cache: false,
            success: function (res)
            {
                if (res == true)
                {
                    msg_danger("Error", "Not allowed change this Data");
                    return;
                }
                else
                    delete_data(data, "delete_service", "#datajasa");
            }, error: function (XMLHttpRequest, textStatus, errorThrown) {
                msg_danger("Failed", "Oops,Something wrong");
                swal("Failed deleting Data", "", "failed");
            }
        });
    }
    function review_file(data)
    {
        $('#ref').attr('src', data);
        $('#modal_file').modal('show');
    }
    function delete_cert(id)
    {
        var data = {};
        data.ID = id;
        data.API = "delete";
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('vn/info/all_vendor/check_vendor'); ?>",
            cache: false,
            success: function (res)
            {
                if (res == true)
                {
                    msg_danger("Error", "Not allowed change this data");
                    return;
                }
                else
                    delete_data(data, "delete_cert", "#datasertifikasi");
            }, error: function (XMLHttpRequest, textStatus, errorThrown) {
                msg_danger("Failed", "Oops,something wrong");
                swal("Failed deleting data", "", "failed");
            }
        });
    }
    function delete_goods(id)
    {
        var data = {};
        data.KEY = id;
        data.API = "delete";
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('vn/info/all_vendor/check_vendor'); ?>",
            cache: false,
            success: function (res)
            {
                if (res == true)
                {
                    msg_danger("Error", "Not allowed change this data");
                    return;
                }
                else
                    delete_data(data, "delete_goods", "#databarang");
            }, error: function (XMLHttpRequest, textStatus, errorThrown) {
              msg_danger("Failed", "Oops,something wrong");
              swal("Failed deleting data", "", "failed");
            }
        });
    }

</script>
