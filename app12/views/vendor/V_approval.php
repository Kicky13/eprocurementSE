<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
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
<div class="app-content content v_approval">
   <div class="content-wrapper">
      <div id="main" class="wrapper wrapper-content animated fadeInRight invitation_approval">
         <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
               <h3 class="content-header-title header_item_title"><?= lang("Verifikasi dan Persetujuan", "New Supplier Invitation Approval") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
               <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="<?= base_url() ?>/home">Home</a>
                     </li>
                     <li class="breadcrumb-item"><?= lang("Management Supplier", "Management Supplier") ?>
                     </li>
                     <li class="breadcrumb-item item_title"><?= lang("Review and Approve SLKA", "New Supplier Invitation Approval") ?>
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
                        </div>
                        <div class="card-content collapse show">
                           <div class="card-body card-dashboard">
                              <div class="row">
                                 <div class="col-md-12">
                                   <input type="hidden" id="urisegment" value="<?= $this->uri->segment(2); ?>">
                                    <table id="tbl" class="table nowrap table-striped table-bordered" width="100%">
                                       <tfoot>
                                          <tr>
                                             <th>No</th>
                                             <th>Nama Vendor</th>
                                             <th>Email</th>
                                             <th>Status</th>
                                             <th>Waktu</th>
                                             <th>attch</th>
                                             <th>note</th>
                                             <th>Action</th>
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
                           <div class='nonregis'>
                              <button type="button" class="btn btn-success" href='javascript:void(0)' onclick='accept()' aria-hidden="true"><?= lang("Setujui", "Approve") ?></button>
                              <button type="button" class="btn btn-danger" href='javascript:void(0)' onclick='reject()' aria-hidden="true"><?= lang("Tolak", "Reject") ?></button>
                              <button type="button" class="btn btn-secondary back" id="back" aria-hidden="true"><?= lang("Kembali", "Back") ?></button>
                           </div>
                           <div class='registrasi'>
                              <button type="button" class="btn btn-success checklist" onclick="check_list()" aria-hidden="true">Check List</button>
                              <button type="button" class="btn btn-secondary back" id="back" aria-hidden="true"><?= lang("Kembali", "Back") ?></button>
                           </div>
                        </div>
                     </div>
                     <h5 class="form-group pull-left"><?= lang("Tinjau Data", "Review Data") ?></h5>
                  </div>
                  <div class="card-content">
                     <div class="card-body steps">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg" role="tablist">
                           <li role="nav-item" class="active"><a href="#home" class="nav-link" aria-controls="dataumum" role="tab" data-toggle="tab"><?= lang("SLKA", "SLKA") ?></a></li>
                           <li role="nav-item"><a href="#profile" id="data_umum" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Informasi Umum", "General Information") ?></a></li>
                           <li role="nav-item"><a href="#profile1" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Data Legal", "Legal Data") ?></a></li>
                           <li role="nav-item"><a href="#profile2" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Barang & Jasa", "Goods & Service") ?></a></li>
                           <li role="nav-item"><a href="#profile3" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Tax Data", "Tax Data") ?></a></li>
                           <li role="nav-item"><a href="#profile4" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Bank & Keuangan", "Finance & Experience") ?></a></li>
                           <li role="nav-item"><a href="#profile5" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("Pengalaman", "Certification") ?></a></li>
                           <li role="nav-item" id="csms"><a href="#profile6" class="nav-link" aria-controls="datalegal" role="tab" data-toggle="tab"><?= lang("CSMS", "CSMS") ?></a></li>
                        </ul>
                        <div class="tab-content px-1 pt-1 card-scroll">
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
                                                   <td>Address</td>
                                                   <td id="address_slka"></td>
                                                </tr>
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
                                             </table>
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="tulisan">
                                             <table>
                                             </table>
                                             <br>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="tulisan">
                                       <table>
                                          <tr>
                                             <br/>
                                             <td>
                                                <p>Subject
                                             </td>
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
                                          <div class="card inner-card box-shadow-0 border-primary div_comp_info">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Informasi Perusahaan", "Company Information") ?></h5>
                                                </h4>
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
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class="" for="PREFIX"><?= lang("Awalan", "Company Type"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="PREFIX" for="PREFIX"><?php echo(isset($SIUP[0]["PREFIX"]) != false ? $SIUP[0]["PREFIX"] : '') ?></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" for="SUFFIX"><?= lang("Klasifikasi Perusahaan", "Prefix"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="SUFFIX" for="SUFFIX"><?php echo(isset($vendor[0]->SUFFIX) != false ? $vendor[0]->SUFFIX : '') ?></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" for="CLASSIFICATION"><?= lang("Klasifikasi Perusahaan", "Clasification"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="CLASSIFICATION" for="CLASSIFICATION">&nbsp;<?php echo(isset($vendor[0]->CLASSIFICATION) != false ? $vendor[0]->CLASSIFICATION : '') ?></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class="" for="NAMA"><?= lang("Nama Perusahaan", "Company Name"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="NAMA" for="NAMA"><?php echo(isset($vendor[0]->NAMA) != false ? $vendor[0]->NAMA : '') ?></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" for="KATEGORI"><?= lang("Kualifikasi Perusahaan", "Supplier Category"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="KATEGORI" for="KATEGORI">l<?php echo(isset($vendor[0]->KATEGORI) != false ? $vendor[0]->KATEGORI : '') ?></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='GENERAL1_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('GENERAL1')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('GENERAL1')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('GENERAL1')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- Kontak perusahaan -->
                                          <div class="card inner-card box-shadow-0 border-primary div_comp_contact">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Kontak Perusahaan", "Company Contact") ?></h5>
                                                </h4>
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
                                                      <div class="col-md-12">
                                                         <table id="datakontakperusahaan" class="table table-striped table-bordered zero-configuration" width="100%">
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='GENERAL3_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('GENERAL3')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('GENERAL3')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('GENERAL3')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- Company Address -->
                                          <div class="card inner-card box-shadow-0 border-primary div_comp_addrs">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Alamat Perusahaan", "Company Address") ?></h5>
                                                </h4>
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
                                                      <div class="col-md-12">
                                                         <table id="alamatperusahaan" class="table table-striped table-bordered zero-configuration" width="100%">
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='GENERAL2_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('GENERAL2')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('GENERAL2')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('GENERAL2')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- KTP -->
                                          <div class="card inner-card box-shadow-0 border-primary div_ktp">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Kartu Tanda Penduduk", "KTP") ?></h5>
                                                </h4>
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
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class="" for="PREFIX"><?= lang("Dibuat Oleh", "Name"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="CREATED_BY_KTP" ></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Nomor", "NIK"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="NO_KTP"></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Kota", "City"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="KTP_CITY" ></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class="" >File</label></th>
                                                                  <td>
                                                                     <button class="btn btn-sm btn-outline-primary" id="KTP_FILE"><i class="fa fa-file-o"></i> </button>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Berlaku Hingga", "Expiry Date"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="VALID_TO_KTP"></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='LEGAL_KTP_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('KTP')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('KTP')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('KTP')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="row">
                                             <div class="col-md-12 col-sm-12">
                                                <!-- Daftar Dewan direksi -->
                                                <div class="card inner-card box-shadow-0 border-primary div_bod">
                                                   <div class="card-header card-head-inverse bg-primary">
                                                      <h4 class="card-title">
                                                         <h5><?= lang("Daftar Dewan direksi", "List of Board of Directors") ?></h5>
                                                      </h4>
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
                                                            <div class="col-md-12">
                                                               <table id="dataDewanDireksi" class="table table-striped table-bordered zero-configuration" width="auto">
                                                               </table>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                      <div class="row m-b">
                                                         <div class="col-md-12 text-center" id='MANAGEMENT1_BTN'>
                                                            <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('MANAGEMENT1')"><?= lang('Setujui', 'Approve') ?></button>
                                                            <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('MANAGEMENT1')"><?= lang('Tolak', 'Reject') ?></button>
                                                            <button class="btn btn-primary"  onclick="modal_komen('MANAGEMENT1')"><i class="fa fa-envelope"></i></button>
                                                         </div>
                                                      </div>
                                                      <div class="row ">
                                                         <div class="col-md-12 area">
                                                            <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <!-- Daftar Pemilik Saham -->
                                                <div class="card inner-card box-shadow-0 border-primary div_sharehd">
                                                   <div class="card-header card-head-inverse bg-primary">
                                                      <h4 class="card-title">
                                                         <h5><?= lang("Daftar Pemilik Saham", "List of Shareholders") ?></h5>
                                                      </h4>
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
                                                            <div class="col-md-12">
                                                               <table id="databank" class="table table-striped table-bordered zero-configuration" width="auto">
                                                               </table>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                      <div class="row m-b">
                                                         <div class="col-md-12 text-center" id='MANAGEMENT2_BTN'>
                                                            <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('MANAGEMENT2')"><?= lang('Setujui', 'Approve') ?></button>
                                                            <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('MANAGEMENT2')"><?= lang('Tolak', 'Reject') ?></button>
                                                            <button class="btn btn-primary"  onclick="modal_komen('MANAGEMENT2')"><i class="fa fa-envelope"></i></button>
                                                         </div>
                                                      </div>
                                                      <div class="row ">
                                                         <div class="col-md-12 area">
                                                            <label class="control-label"><?= lang("Catatan", "Note") ?></label>
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
                                          <div class="card inner-card box-shadow-0 border-primary div_deed">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Akta", "Deed") ?></h5>
                                                </h4>
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
                                                      <div class="col-md-12">
                                                         <table id="dataakta" class="table table-striped table-bordered zero-configuration" width="100%">
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='LEGAL1_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('LEGAL1')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('LEGAL1')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('LEGAL1')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- SIUP -->
                                          <div class="card inner-card box-shadow-0 border-primary div_business_license">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Surat Izin Usaha", "Business License") ?></h5>
                                                </h4>
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
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class=""><?= lang("Dibuat Oleh", "Created By"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="CREATED_BY_SIUP" ><?php echo(isset($SIUP[0]["CREATOR"]) != false ? $SIUP[0]["CREATOR"] : '') ?></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class=""><?= lang("Berlaku Sejak", "Issued Date"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="VALID_FROM_SIUP" ><?php echo(isset($SIUP[0]["VALID_SINCE"]) != false ? date("d-m-Y", strtotime($SIUP[0]["VALID_SINCE"])) : date("Y-m-d")) ?></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Nomor", "Number"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="NO_SIUP"><?php echo(isset($SIUP[0]["NO_DOC"]) != false ? $SIUP[0]["NO_DOC"] : '') ?></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class="" >File</label></th>
                                                                  <td>
                                                                     <button class="btn btn-sm btn-outline-primary" id="SIUP_FILE"><i class="fa fa-file-o"></i><?php
                                                                        if (isset($SIUP[0]["FILE_URL"])) {
                                                                        	echo '<a title="Lihat File" onclick=review_akta("SIUP_FILE")><i class="fa fa-file-o"></i></a>';
                                                                        }
                                                                        ?>
                                                                     </button>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Berlaku Hingga", "Expiry Date"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="VALID_TO_SIUP"><?php echo(isset($SIUP[0]["VALID_UNTIL"]) != false ? date("d-m-Y", strtotime($SIUP[0]["VALID_UNTIL"])) : date("Y-m-d")) ?></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Kategori SIUP", "SIUP Type"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="SIUP_TYPE" ><?php echo(isset($SIUP[0]["CATEGORY"]) != false ? $SIUP[0]["CATEGORY"] : '') ?></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='LEGAL2_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('LEGAL2')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('LEGAL2')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('LEGAL2')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- TDP -->
                                          <div class="card inner-card box-shadow-0 border-primary div_tdp">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("TDP", "TDP") ?></h5>
                                                </h4>
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
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class=""><?= lang("Dibuat Oleh", "Issued By"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="CREATED_TDP_BY" ><?php echo(isset($SIUP[0]["CREATOR"]) != false ? $SIUP[0]["CREATOR"] : '') ?></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class=""><?= lang("Berlaku Dari", "Issued Date"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="VALID_FROM_TDP"><?php echo(isset($SIUP[0]["VALID_SINCE"]) != false ? $SIUP[0]["VALID_SINCE"] : date("Y-m-d")) ?></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Nomor", "Number"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="NO_TDP" ><?php echo(isset($SIUP[0]["NO_DOC"]) != false ? $SIUP[0]["NO_DOC"] : '') ?></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class="" >File</label></th>
                                                                  <td>
                                                                     <button class="btn btn-sm btn-outline-primary" id="TDP_FILE"><i class="fa fa-file-o"></i><?php echo(isset($SIUP[0]["SIUP_FILE"]) != false ? $SIUP[0]["SIUP_FILE"] : '') ?></button>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Berlaku Hingga", "Expiry Date"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="VALID_TO_TDP"><?php echo(isset($SIUP[0]["VALID_UNTIL"]) != false ? $SIUP[0]["VALID_UNTIL"] : date("Y-m-d")) ?></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='LEGAL3_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('LEGAL3')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('LEGAL3')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('LEGAL3')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!--EBTKE-->
                                          <div class="card inner-card box-shadow-0 border-primary div_skt_panas">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("SKT Panas Bumi", "SKT Panas Bumi") ?></h5>
                                                </h4>
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
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class=""><?= lang("Dibuat Oleh", "Issued By"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="CREATED_EBTKE_BY" ></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class=""><?= lang("Berlaku Dari", "Issued Date"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="VALID_FROM_EBTKE"></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Nomor", "Number"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="NO_EBTKE" ></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class="" >File</label></th>
                                                                  <td>
                                                                     <button class="btn btn-sm btn-outline-primary" id="EBTKE_FILE"><i class="fa fa-file-o"></i></button>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Berlaku Hingga", "Expiry Date"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="VALID_TO_EBTKE"></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='LEGAL5_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('LEGAL5')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('LEGAL5')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('LEGAL5')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!--MIGAS-->
                                          <div class="card inner-card box-shadow-0 border-primary div_skt_migas">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("SKT MIGAS", "SKT MIGAS") ?></h5>
                                                </h4>
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
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class=""><?= lang("Dibuat Oleh", "Issued By"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="CREATED_MIGAS_BY" ></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class=""><?= lang("Berlaku Dari", "Issued Date"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="VALID_FROM_MIGAS"></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Nomor", "Number"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="NO_MIGAS" ></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class="" >File</label></th>
                                                                  <td>
                                                                     <button class="btn btn-sm btn-outline-primary" id="MIGAS_FILE"><i class="fa fa-file-o"></i></button>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Berlaku Hingga", "Expiry Date"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="VALID_TO_MIGAS"></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='LEGAL6_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('LEGAL6')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('LEGAL6')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('LEGAL6')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- NPWP -->
                                          <!-- SDKP -->
                                          <div class="card inner-card box-shadow-0 border-primary div_skdp">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("SKDP", "SKDP") ?></h5>
                                                </h4>
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
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class=""><?= lang("Dibuat Oleh", "Issued By"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="CREATED_BY_SDKP" ></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class=""><?= lang("Nomor", "Document Number"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="NO_SDKP"></span>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Berlaku Hingga", "Expiry Date"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="VALID_TO_SDKP"></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <table class="table vertical-table">
                                                            <tbody>
                                                               <tr>
                                                                  <th><label class="" >File</label></th>
                                                                  <td>
                                                                     <button class="btn btn-sm btn-outline-primary" id="SDKP_FILE"><i class="fa fa-file-o"></i></button>
                                                                  </td>
                                                               </tr>
                                                               <tr>
                                                                  <th><label class="" ><?= lang("Issued Date", "Issued Date"); ?></label></th>
                                                                  <td>
                                                                     <span class="control-label" id="VALID_FROM_SDKP" ></span>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='LEGAL_SDKP_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('SDKP')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('SDKP')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('SDKP')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
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
                                          <div class="card  inner-card box-shadow-0 border-primary div_agency">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Sertifikasi Keagenan dan Prinsipal", "Agency and Principal Certification") ?></h5>
                                                </h4>
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
                                                      <div class="col-md-12">
                                                         <table id="datasertifikasi" class="table table-striped table-bordered zero-configuration" width="100%">
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='GNS1_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('GNS1')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('GNS1')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('GNS1')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- Daftar Jasa -->
                                          <div class="card inner-card box-shadow-0 border-primary jasa">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Daftar Jasa", "Service Lists") ?></h5>
                                                </h4>
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
                                                      <div class="col-md-12">
                                                         <table id="daftarjasa" class="table table-striped table-bordered zero-configuration" width="100%">
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='GNS3_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('GNS3')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('GNS3')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('GNS3')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- Daftar Barang -->
                                          <div class="card inner-card box-shadow-0 border-primary barang">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Daftar Barang", "Goods") ?></h5>
                                                </h4>
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
                                                      <div class="col-md-12">
                                                         <table id="daftarbarang" class="table table-striped table-bordered zero-configuration" width="100%">
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='GNS2_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('GNS2')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('GNS2')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('GNS2')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- data konsultasi -->
                                          <div class="card inner-card box-shadow-0 border-primary konsul">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Daftar Kosultan", "List Of Consultation Service") ?></h5>
                                                </h4>
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
                                                      <div class="col-md-12">
                                                         <table id="datakonsultasi" class="table table-striped table-bordered zero-configuration" width="100%">
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='GNS4_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('GNS4')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('GNS4')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('GNS4')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div role="tabpanel" class="tab-pane" id="profile3">
                                    <!-- TAX DATA -->
                                    <div class="card inner-card box-shadow-0 border-primary">
                                       <div class="card-header card-head-inverse bg-primary">
                                          <h4 class="card-title">
                                             <h5><?= lang("TAX Form", "TAX Form") ?></h5>
                                          </h4>
                                          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                          <div class="heading-elements">
                                             <ul class="list-inline mb-0">
                                                <li><a data-action="collapse"><i class="fa fa-chevron-up"></i></a></li>
                                             </ul>
                                          </div>
                                       </div>
                                       <div class="card-content collapse show">
                                          <div class="row">
                                             <div class="col-sm-12">
                                                <table class="table vertical-table">
                                                   <tbody>
                                                      <tr style="border-bottom: 1px solid #eee;">
                                                         <th style="vertical-align: middle;min-width: 160px;">NPWP</th>
                                                         <td>
                                                            <table class="table vertical-table inner-vertical-table">
                                                               <tbody>
                                                                  <tr>
                                                                     <th style="width: 130px;"><label class="col-sm-6 control-label"><?= lang("Nomor", "Number"); ?></label></th>
                                                                     <td style="width: 250px;">
                                                                        <span class="control-label" id="NO_NPWP"><?php echo(isset($all[0]->NO_NPWP) != false ? $all[0]->NO_NPWP : '') ?></span>
                                                                     </td>
                                                                     <th style="width: 100px;"><label class="col-sm-6 control-label">File</label></th>
                                                                     <td>
                                                                        <button class="btn btn-sm btn-outline-primary" id="FILE_NPWP"><i class="fa fa-file-o"></i></button>
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <th ><label class="col-sm-6 control-label"><?= lang("Alamat", "Address"); ?></label></th>
                                                                     <td >
                                                                        <span class="control-label" id="NPWP_NOTARIS"></span></span>
                                                                     </td>
                                                                     <th><label class="col-sm-6 control-label"><?= lang("Kota", "City"); ?></label></th>
                                                                     <td>
                                                                        <span class="control-label" id="NPWP_CITY"></span>
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <th><label class="col-sm-6 control-label"><?= lang("Kode Pos", "Postal Code"); ?></label></th>
                                                                     <td>
                                                                        <span class="control-label" id="POSTAL_CODE"></span>
                                                                     </td>
                                                                     <th><label class="col-sm-6 control-label"><?= lang("Provinsi NPWP", "Province") ?></label></th>
                                                                     <td>
                                                                        <span class="control-label" id="NPWP_PROVINCE"></span>
                                                                     </td>
                                                                  </tr>
                                                               </tbody>
                                                            </table>
                                                         </td>
                                                         <td style="min-width: 130px;vertical-align: middle;">
                                                            <div class="text-center" id='LEGAL4_BTN'>
                                                               <button type="submit" class="btn btn-sm btn-primary" id="save" onclick="setujui_data('LEGAL4')"><i class="fa fa-check"></i></button>
                                                               <button type="submit" class="btn btn-sm btn-danger" id="save" onclick="batal_data('LEGAL4')"><i class="fa fa-ban"></i></button>
                                                               <button class="btn btn-sm btn-primary"  onclick="modal_komen('LEGAL4')"><i class="fa fa-envelope"></i></button>
                                                            </div>
                                                         </td>
                                                      </tr>
                                                      <tr style="border-bottom: 1px solid #eee;">
                                                         <th style="vertical-align: middle;min-width: 160px;">SPPKP</th>
                                                         <td>
                                                            <table class="table vertical-table inner-vertical-table">
                                                               <tbody>
                                                                  <tr>
                                                                     <th style="width: 130px;"><label class="col-sm-6 control-label"><?= lang("Dibuat Oleh", "Issued By"); ?></label></th>
                                                                     <td style="width: 250px;">
                                                                        <span class="control-label" id="CREATED_SPPKP_BY" ></span>
                                                                     </td>
                                                                     <th style="width: 100px;"><label class="col-sm-6 control-label">File</label></th>
                                                                     <td>
                                                                        <button class="btn btn-sm btn-outline-primary" id="SPPKP_FILE"><i class="fa fa-file-o"></i></button>
                                                                     </td>
                                                                  </tr>
                                                                  <tr>
                                                                     <th><label class="col-sm-6 control-label"><?= lang("Nomor", "Number"); ?></label></th>
                                                                     <td>
                                                                        <span class="control-label" id="NO_SPPKP" ></span>
                                                                     </td>
                                                                     <th>
                                                                        <label class="col-sm-6 control-label label">
                                                                     </th>
                                                                     <td>
                                                                     <span class="control-label" ></span>
                                                                     </td>
                                                                  </tr>
                                                                  <!--
                                                                     <tr>
                                                                       <th><label class="col-sm-6 control-label"><?= lang("Berlaku Dari", "Issued Date"); ?></label></th>
                                                                       <td>
                                                                     	<span class="control-label" id="VALID_FROM_SPPKP"></span>
                                                                       </td>
                                                                       <th><label class="col-sm-6 control-label"><?= lang("Berlaku Hingga", "Expiry Date"); ?></label></th>
                                                                       <td>
                                                                     	<span class="control-label" id="VALID_TO_SPPKP"></span>
                                                                       </td>
                                                                     </tr>
                                                                     -->
                                                               </tbody>
                                                            </table>
                                                         </td>
                                                         <td style="min-width: 130px;vertical-align: middle;">
                                                         <div class="text-center" id='LEGAL7_BTN'>
                                                         <button type="submit" class="btn btn-sm btn-primary" id="save" onclick="setujui_data('LEGAL7')"><i class="fa fa-check"></i></button>
                                                         <button type="submit" class="btn btn-sm btn-danger" id="save" onclick="batal_data('LEGAL7')"><i class="fa fa-ban"></i></button>
                                                         <button class="btn btn-sm btn-primary"  onclick="modal_komen('LEGAL7')"><i class="fa fa-envelope"></i></button>
                                                         </div>
                                                         </td>
                                                      </tr>
                                                      <tr style="border-bottom: 1px solid #eee;">
                                                      <th style="vertical-align: middle;min-width: 160px;">Tax Certificate</th>
                                                      <td>
                                                      <table class="table vertical-table inner-vertical-table">
                                                      <tbody>
                                                      <tr>
                                                      <th style="width: 130px;"><label class="col-sm-6 control-label"><?= lang("Berlaku Dari", "Issued Date"); ?></label></th>
                                                      <td style="width: 250px;">
                                                      <span class="control-label" id="VALID_FROM_PAJAK"></span>
                                                      </td>
                                                      <th style="width: 100px;"><label class="col-sm-6 control-label">File</label></th>
                                                      <td>
                                                      <button class="btn btn-sm btn-outline-primary" id="PAJAK_FILE"><i class="fa fa-file-o"></i></button>
                                                      </td>
                                                      </tr>
                                                      <tr>
                                                      <th><label class="col-sm-6 control-label"><?= lang("Nomor", "Number"); ?></label></th>
                                                      <td>
                                                      <span class="control-label" id="NO_PAJAK" ></span>
                                                      </td>
                                                      </tbody>
                                                      </table>
                                                      </td>
                                                      <td style="min-width: 130px;vertical-align: middle;">
                                                      <div class="text-center" id='LEGAL8_BTN'>
                                                      <button type="submit" class="btn btn-sm btn-primary" id="save" onclick="setujui_data('LEGAL8')"><i class="fa fa-check"></i></button>
                                                      <button type="submit" class="btn btn-sm btn-danger" id="save" onclick="batal_data('LEGAL8')"><i class="fa fa-ban"></i></button>
                                                      <button class="btn btn-sm btn-primary"  onclick="modal_komen('LEGAL8')"><i class="fa fa-envelope"></i></button>
                                                      </div>
                                                      </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div role="tabpanel" class="tab-pane" id="profile4">
                                    <div class="row">
                                       <div class="col-md-12 col-sm-12">
                                          <!-- Neraca Keuangan -->
                                          <div class="card inner-card box-shadow-0 border-primary div_balancesheet">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Neraca Keuangan", "Balance Sheet") ?></h5>
                                                </h4>
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
                                                      <div class="col-md-12">
                                                         <table id="neraca_keuangan_tabel" class="table table-striped table-bordered zero-configuration" width="auto">
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='BNF1_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('BNF1')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('BNF1')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('BNF1')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- Daftar Rekening Bank -->
                                          <div class="card inner-card box-shadow-0 border-primary div_bank_acc">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Daftar Rekening Bank", "Bank Account List") ?></h5>
                                                </h4>
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
                                                      <div class="col-md-12">
                                                         <table id="daftar_rekening_bank" class="table table-striped table-bordered zero-configuration" width="100%">
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='BNF2_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('BNF2')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('BNF2')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('BNF2')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- Pengalaman Perusahaan -->
                                          <div class="card inner-card box-shadow-0 border-primary div_comp_exp">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Pengalaman Perusahaan", "Company Experience") ?></h5>
                                                </h4>
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
                                                      <div class="col-md-12">
                                                         <table id="data_pengalaman" class="table table-striped table-bordered zero-configuration" width="100%">
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='CNE2_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('CNE2')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('CNE2')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('CNE2')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
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
                                          <div class="card inner-card box-shadow-0 border-primary div_general_certification">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("Sertifikasi Umum", "General Certification") ?></h5>
                                                </h4>
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
                                                      <div class="col-md-12">
                                                         <table id="tabelsertifikasi" class="table table-striped table-bordered zero-configuration" width="100%">
                                                         </table>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='CNE1_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('CNE1')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('CNE1')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('CNE1')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- BPJS -->
                                          <div class="card inner-card box-shadow-0 border-primary div_bpjs">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("BPJS", "BPJS Kesehatan") ?></h5>
                                                </h4>
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
                                                         <label class="col-sm-6 control-label"><?= lang("Nomor", "Document Number"); ?></label>
                                                         <span class="col-sm-4 control-label" id="NO_BPJS"></span>
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <label class="col-sm-6 control-label" >File</label>&nbsp;&nbsp;&nbsp;
                                                         <button class="btn btn-sm btn-outline-primary" id="BPJS_FILE"><i class="fa fa-file-o"></i></button>
                                                      </div>
                                                      <div class="col-sm-6 BPJS">
                                                         <label class="col-sm-6 control-label"><?= lang("Issued Date", "Issued Date"); ?></label>
                                                         <span class="col-sm-4 control-label" id="VALID_FROM_BPJS" ></span>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='LEGAL_BPJS_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('BPJS')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('BPJS')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('BPJS')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <!-- BPJSTK -->
                                          <div class="card inner-card box-shadow-0 border-primary div_bpjstk">
                                             <div class="card-header card-head-inverse bg-primary">
                                                <h4 class="card-title">
                                                   <h5><?= lang("BPJS Ketenagakerjaan", "BPJS Ketenagakerjaan") ?></h5>
                                                </h4>
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
                                                         <label class="col-sm-6 control-label"><?= lang("Nomor", "Document Number"); ?></label>
                                                         <span class="col-sm-4 control-label" id="NO_BPJSTK"></span>
                                                      </div>
                                                      <div class="col-sm-6">
                                                         <label class="col-sm-6 control-label" >File</label>&nbsp;&nbsp;&nbsp;
                                                         <button class="btn btn-sm btn-outline-primary" id="BPJSTK_FILE"><i class="fa fa-file-o"></i></button>
                                                      </div>
                                                      <div class="col-sm-6 BPJSTK">
                                                         <label class="col-sm-6 control-label"><?= lang("Issued Date", "Issued Date"); ?></label>
                                                         <span class="col-sm-4 control-label" id="VALID_FROM_BPJSTK" ></span>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="card-footer border-2 text-muted mt-2 registrasi">
                                                <div class="row m-b">
                                                   <div class="col-md-12 text-center" id='LEGAL_BPJSTK_BTN'>
                                                      <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('BPJSTK')"><?= lang('Setujui', 'Approve') ?></button>
                                                      <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('BPJSTK')"><?= lang('Tolak', 'Reject') ?></button>
                                                      <button class="btn btn-primary"  onclick="modal_komen('BPJSTK')"><i class="fa fa-envelope"></i></button>
                                                   </div>
                                                </div>
                                                <div class="row ">
                                                   <div class="col-md-12 area">
                                                      <label class="control-label"><?= lang("Catatan", "Note") ?></label>
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
                                       <div class="table-responsive">
                                          <table class="table table-striped">
                                             <thead>
                                                <tr>
                                                   <th>
                                                      <center>No</center>
                                                   </th>
                                                   <th>
                                                      <center><?= lang('Jenis File', 'File Type') ?></center>
                                                   </th>
                                                   <th>
                                                      <center><?= lang('Keterangan', 'Description') ?></center>
                                                   </th>
                                                   <th>
                                                      <center>File</center>
                                                   </th>
                                                   <th>
                                                      <center>
                                                         <center><?= lang("Aksi", "Action") ?></center>
                                                      </center>
                                                   </th>
                                                </tr>
                                             </thead>
                                             <tbody class="filetable">
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                    <div class="card-footer border-2 text-muted mt-2 registrasi">
                                       <div class="row m-b">
                                          <div class="col-md-5"></div>
                                          <div class="col-md-3 text-center" id='CSMS_BTN'>
                                             <button type="submit" class="btn btn-primary" id="save" onclick="setujui_data('CSMS')"><?= lang('Setujui', 'Approve') ?></button>
                                             <button type="submit" class="btn btn-danger" id="save" onclick="batal_data('CSMS')"><?= lang('Tolak', 'Reject') ?></button>
                                             <button class="btn btn-primary"  onclick="modal_komen('CSMS')"><i class="fa fa-envelope"></i></button>
                                          </div>
                                          <div class="col-md-12 area">
                                             <label class="control-label"><?= lang("Catatan", "Note") ?></label>
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
</div>
<div id="data_comment" class="modal fade " data-backdrop="static" role="dialog">
   <div class="modal-dialog">
      <div class=" modal-content">
         <div class="content-body">
            <div class="modal-header bg-primary white">
               <h4 class="modal-title" id="myModalLabel1"><?=lang("Pesan","Message")?></h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body chat-application" style="padding:0px">
               <section class="chat-app-window" style="max-height:330px">
                  <div class="badge badge-default mb-1">Chat History</div>
                  <input type="text" id="type_msg" style="display:none">
                  <div class="chats">
                     <div id="message" class="chats">
                     </div>
                  </div>
               </section>
               <section class="chat-app-form">
                  <form class="chat-app-input d-flex">
                     <fieldset class="form-group position-relative has-icon-left col-10 m-0">
                        <div class="form-control-position">
                           <i class="fa fa-paper-plane-o"></i>
                        </div>
                        <input type="text" class="form-control" id="send_msg" placeholder="Type your message">
                        <div class="form-control-position control-position-right">
                           <i class="ft-image"></i>
                        </div>
                     </fieldset>
                     <fieldset class="form-group position-relative has-icon-left col-2 m-0">
                        <button type="button" onclick="send()" class="btn btn-primary"><i class="fa fa-paper-plane-o d-lg-none"></i>
                        <span class="d-none d-lg-block"><?=lang("Kirim","Send")?></span>
                        </button>
                     </fieldset>
                  </form>
               </section>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="modal2" class="modal fade" role="dialog"  >
   <div class="modal-dialog modal-xl" style="width: 100%; height: 100%;">
      <div class="modal-content">
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
               <input name="idT" class="idT" hidden><!--id transaction ANGKA-->
               <input name="seq" class="seq" hidden><!--id transaction ANGKA-->
               <input name="email" class="email" hidden><!--id vendor MAIL-->
               <input name="entity_tax_id" class="entity_tax_id"  hidden>
               <input name="entity_name" class="entity_name" hidden >
               <div class="form-group">
                  <div class="col-md-12">
                     <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                     <textarea placeholder="Please fill your comment here . . ." class="form-control note" rows="5" name="note"></textarea>
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
               <input name="idT" class="idT" hidden><!--id transaction ANGKA-->
               <input name="seq" class="seq" hidden><!--id transaction ANGKA-->
               <input name="email" class="email" hidden>
               <div class="form-group">
                  <div class="controls col-md-12">
                     <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                     <label id="label_kirim" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                     <textarea placeholder="Please fill your comment here . . ." class="form-control note" rows="5" name="note" required data-validation-required-message="This field is required"></textarea>
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
<div class="modal fade" id="check_list_data" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <form class="modal-content" id="checklist_app">
         <div class="modal-header">
            <h4 class="modal-title"> <?= lang('Check list verifikasi Data', 'Show Detail Data') ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>
         <div class="modal-body" style="overflow: auto">
            <div class="ibox-content">
               <input name="id_vendor" style="display:none" class="act_id" id="ck_id_vendor">
               <div class="row">
                  <div class="col-sm-12">
                     <div id="tbl_checklist"></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
            <button type="submit" id="kirim_email_data_reject" class="btn btn-danger btn-rejected" data-dismiss="modal"><?= lang('Tolak', 'Reject') ?></button>
            <button type="submit" id="kirim_email_data" class="btn btn-primary btn-approved" data-dismiss="modal"><?= lang('Setujui', 'Approve') ?></button>
         </div>
      </form>
   </div>
</div>
<!-- ================================ Approve reject one time ============================ -->
<div id="modal_app_rej" class="modal fade" data-backdrop="static" role="dialog">
   <div class="modal-dialog">
      <form id="send" class="form-horizontal" novalidate="novalidate" action="javascript:;">
         <div class=" modal-content">
            <div class="modal-header">
               <h4 class="reject-title">Approval</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <input name="id" id="id" hidden>
               <div class="form-group">
                  <label class="control-label label_html" for="field-1"><?= lang("Catatan", "Comment") ?></label>
                  <label id="label_rej" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                  <input name="id_vendor" class="id_vendor" hidden>
                  <input name="idT" class="idT" hidden><!--id transaction ANGKA-->
                  <input name="seq" class="seq" hidden><!--id transaction ANGKA-->
                  <input name="email" class="email" hidden>
                  <textarea class="form-control" rows="5" id="note" name="note" required data-validation-required-message="This field is required"></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button class="btn btn-secondary" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
               <button type="submit" class="btn btn-danger" onclick="reject_data()" id="reject_inv"><?= lang("Tolak", "Reject") ?></button>
               <button type="submit" class="btn btn-success" onclick="send_data()" id="finish"><?= lang("Setujui dan Kirim Undangan", "Approve") ?></button>
            </div>
         </div>
      </form>
   </div>
</div>
<!-- ================================End of Approve reject one time ============================ -->
<!-- ================================Approve reject per data============================ -->
<div id="modal-approve" class="modal fade" data-backdrop="static" role="dialog">
   <div class="modal-dialog">
      <form class=" modal-content" id="approve_mdl2" action="javascript:;" novalidate="novalidate">
         <div class="modal-header">
            <h4 class="edit-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-horizontal">
               <input name="id" style="display:none" class="act_id" value="" hidden>
               <input name="type" class="act_type" value="" hidden>
               <div class="form-group textnote">
                  <label for="timesheetinput7"><?= lang("Catatan", "Note") ?></label>
                  <div class="form-group position-relative has-icon-left">
                     <textarea id="aprv" placeholder="Please fill your comment here . . ." class="form-control note_approve" rows="5" name="note" class="note"></textarea>
                     <div class="form-control-position">
                        <i class="fa fa-file"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
            <button type="submit" class="btn btn-primary" id="finish"><?= lang("Setujui", "Approve") ?></button>
         </div>
      </form>
   </div>
</div>
<div id="modal-reject" class="modal fade" data-backdrop="static" role="dialog">
   <div class="modal-dialog">
      <form class=" modal-content" id="reject_mdl2" novalidate="novalidate">
         <div class="modal-header">
            <h4 class="edit-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="form-horizontal">
               <input name="id" style="display:none" class="act_id" value="" type="hidden">
               <input name="type" class="act_type" value="" type="hidden">
               <div class="form-group">
                  <label for="timesheetinput7"><?= lang("Catatan", "Note") ?></label>
                  <label id="label_kirim" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                  <div class="controls position-relative has-icon-left" >
                     <!--<div class="position-relative has-icon-left form-group">-->
                     <textarea placeholder="Please fill your comment here . . ." class="form-control note_reject" rows="5" name="note" class="note" data-validation-required-message="This Field is required"></textarea>
                     <div class="form-control-position">
                        <i class="fa fa-file"></i>
                     </div>
                     <!--</div>-->
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
            <button type="submit" class="btn btn-danger" id="reject_inv"><?= lang("Tolak", "Reject") ?></button>
         </div>
      </form>
   </div>
</div>
<!-- ================================ End of Approve reject per data============================ -->
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/js/scripts/forms/validation/form-validation.js"type="text/javascript"></script>
<script>
   var var_result = false;
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

     function accept_inv(id,idvendor,idT,seq) {
         $('#modal_app_rej .email').val(idvendor);
         $('#modal_app_rej .id_vendor').val(id);
         $('#modal_app_rej .idT').val(idT);
         $('#modal_app_rej .seq').val(seq);
         $('#modal_app_rej #supps').val(idvendor);
         $('#modal_app_rej #reject_inv').hide();
         $('#modal_app_rej #finish').show();
         $('#modal_app_rej #label_kirim').hide();
         $("#note").val("");
         // $('#modal_app_rej #note').hide();
         // $('#modal_app_rej .label_html').html("<h2><b> Are you sure to approve data ? </b></h2>");
         $('#modal_app_rej').modal('show');
     }

     function reject_inv(id,idvendor,idT,seq) {
         $("#note").val("")
         $('#modal_app_rej .email').val(idvendor);
         $('#modal_app_rej .id_vendor').val(id);
         $('#modal_app_rej .idT').val(idT);
         $('#modal_app_rej .seq').val(seq);
         $('#modal_app_rej #supps').val(idvendor);
         $('#modal_app_rej #finish').hide();
         $('#modal_app_rej #reject_inv').show();
         $('#modal_app_rej #label_rej').show();
         // $('#modal_app_rej #note').show();
         // $('#modal_app_rej .label_html').html("Note ");
         $('#modal_app_rej').modal('show');
     }

     function reject(id, id_vendor) {
         $('.note').val(null);
         $('#modal_rej .modal-header').css("background", "#d9534f");
         $('#modal_rej .modal-header').css("color", "#fff");
         $('#modal_rej').modal('show');
         lang();
     }
     //===================================== Fungsi Checklist==============================
     function check_list() {
         var id_vendor = $('#ck_id_vendor').val();
         $.ajax({
             type: 'POST',
             url: '<?= base_url('vendor/approval/getlist/') ?>' + id_vendor,
             success: function (msg) {
                 $('#tbl_checklist').html(msg);
                 $('#check_list_data .modal-header').css("background-color", "#1c84c6");
                 $('#check_list_data .modal-header').css("color", "#fff");
                 $('#check_list_data').modal('show');
                 lang();
                 console.log($('.fa.fa-times.text-danger').length);
                 // console.log($("#total_check_mandatory").val());
                 if ($('.fa.fa-times.text-danger').length >= 1) {
                   $(".btn-approved").prop('disabled', true);
                   $(".btn-rejected").prop('disabled', false);
                 } else {
                   $(".btn-approved").prop('disabled', false);
                   $(".btn-rejected").prop('disabled', true);
                 }
             }});
         lang();
     }
     $("#check_list_data #kirim_email_data").click(function () {
             swal({
                 title: "Are You Sure?",
                 text: "Send this data",
                 type: "warning",
                 showCancelButton: true,
                 CancelButtonColor: "#DD6B55",
                 confirmButtonColor: "#337ab7",
                 confirmButtonText: "Yes",
                 closeOnConfirm: false
             }, function () {
                 var elm = start($('.sweet-alert'));
                 var obj={};
                 //obj=$('#checklist_app').serialize();
                 obj.tot_none=$('#checklist_app #tot_none').val();
                 obj.tot_un_apv=$('#checklist_app #tot_un_apv').val();
                 obj.id_vendor=$('.id_vendor').val();
                 obj.idT=$('.idT').val();
                 obj.seq=$('.seq').val();
                 obj.email=$(".act_id").val();
                 $.ajax({
                     url: "<?= base_url('vendor/approval/change_btn/8') ?>/",
                     type: "POST",
                     data: obj,
                     dataType: "JSON",
                     success: function (data) {
                         stop(elm);
                         if (data.status != "Error") //if success close modal and reload ajax table
                         {
                             $('#check_list_data').modal('hide');
                             msg_info('Successfully');
                             swal("Data Saved", "", "success");
                             $("#edit").hide();
                             $("#main").show();
                             $('#tbl').DataTable().ajax.reload();
                         } else {
                             $('#check_list_data').modal('hide');
                             msg_danger(data.msg);
                             swal("Warning!", data.msg, "failed");
                         }
                     },
                     error: function (XMLHttpRequest, textStatus, errorThrown) {
                         stop(elm);
                         msg_danger("Failed!", "Oops,Something wrong");
                         swal("Failed send data", "", "failed");
                     }
                 });
             });
         });
     $("#check_list_data #kirim_email_data_reject").click(function () {
             swal({
                 title: "Are You Sure?",
                 text: "Send this data",
                 type: "warning",
                 showCancelButton: true,
                 CancelButtonColor: "#DD6B55",
                 confirmButtonColor: "#337ab7",
                 confirmButtonText: "Yes",
                 closeOnConfirm: false
             }, function () {
                 var elm = start($('.sweet-alert'));
                 var obj={};
                 //obj=$('#checklist_app').serialize();
                 obj.tot_none=$('#checklist_app #tot_none').val();
                 obj.tot_un_apv=$('#checklist_app #tot_un_apv').val();
                 obj.id_vendor=$('.id_vendor').val();
                 obj.idT=$('.idT').val();
                 obj.seq=$('.seq').val();
                 obj.email=$(".act_id").val();
                 $.ajax({
                     url: "<?= base_url('vendor/approval/change_btn/13') ?>/",
                     type: "POST",
                     data: obj,
                     dataType: "JSON",
                     success: function (data) {
                         stop(elm);
                         if (data.status != "Error") //if success close modal and reload ajax table
                         {
                             $('#check_list_data').modal('hide');
                             msg_info('Successfully');
                             swal("Data Saved", "", "success");
                             $("#edit").hide();
                             $("#main").show();
                             $('#tbl').DataTable().ajax.reload();
                         } else {
                             $('#check_list_data').modal('hide');
                             msg_danger(data.msg);
                             swal("Warning!", data.msg, "failed");
                         }
                     },
                     error: function (XMLHttpRequest, textStatus, errorThrown) {
                         stop(elm);
                         msg_danger("Failed!", "Oops,Something wrong");
                         swal("Failed send data", "", "failed");
                     }
                 });
             });
         });

         function check_risk()
         {
             var obj={};
             obj.id = $('.id_vendor').val();
             $.ajax({
                 url:"<?= base_url("vendor/approval/check_risk")?>",
                 data:obj,
                 type:"POST",
                 success:function(m){
                     if(m == true)
                         $('#csms').hide();
                     else
                         $('#csms').show();
                 }
             });
         }

     $(function () {
         lang();
         $(".textnote").html('<h3>Are you sure to proccess?</h3>');
         //======================== Approve reject per data ========================
         $('#approve_mdl2').on('submit', function (e) {
             e.preventDefault();
             $.ajax({
                 type: 'POST',
                 url: '<?= base_url('vendor/show_vendor/change_btn/1') ?>',
                 data: $('#approve_mdl2').serialize(),
                 success: function (m) {
                     if (m == 'sukses') {
                         $('#modal-approve').modal('hide');
                         msg_info('Approve Berhasil');
                     } else {
                         msg_danger(m);
                     }
                 }
             });
         });
         $('#reject_mdl2').on('submit', function (e) {
             e.preventDefault();
             $.ajax({
                 type: 'POST',
                 url: '<?= base_url('vendor/show_vendor/change_btn/0') ?>',
                 data: $('#reject_mdl2').serialize(),
                 success: function (m) {
                     if (m == 'sukses') {
                         $('#modal-reject').modal('hide');
                         msg_info('Reject Successfully');
                     } else {
                         msg_danger(m);
                     }
                 }
             });
         });
         // ==================================================================================
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
                     msg_danger("Warning", "Oops,Something Wrong ");
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
         //============================ approve reject one time ============================
         $('#approve_mdl').on('submit', function (e) {
             e.preventDefault();
             var elm = start($('#modal_app').find('.modal-dialog'));
             $.ajax({
                 type: 'POST',
                 url: '<?= base_url('vendor/approval/change_btn/7') ?>',
                 data: $('#approve_mdl').serialize(),
                 success: function (m) {
                     stop(elm);
                     if (m.status == 'Success') {
                         $('#modal_app').modal('hide');
                         msg_info(m.status,m.msg);
                         $('#tbl').DataTable().ajax.reload();
                         slides();
                     } else {
                         msg_danger(m.status,m.msg);
                     }
                 },
                 error: function (XMLHttpRequest, textStatus, errorThrown) {
                     stop(elm);
                     msg_danger("Error", "Oops,Something Wrong");
                 }
             });
         });
         $('#reject_mdl').on('submit', function (e) {
             e.preventDefault();
             var elm = start($('#modal_rej').find('.modal-dialog'));
             $.ajax({
                 type: 'POST',
                 url: '<?= base_url('vendor/approval/change_btn/13') ?>',
                 data: $('#reject_mdl').serialize(),
                 success: function (m) {
                     stop(elm);
                     // m = JSON.parse(m);
                     if (m.status == 'Success') {
                         $('#modal_rej').modal('hide');
                         msg_info(m.status,m.msg);
                         $('#tbl').DataTable().ajax.reload();
                         slides();
                     } else {
                         msg_danger(m.status,m.msg);
                     }
                 },
                 error: function (XMLHttpRequest, textStatus, errorThrown) {
                     stop(elm);
                     msg_danger("Error", "Oops,Something Wrong");
                 }
             });
         });
         // ================================================================================
         $(".area label").hide();
         $(".back").click(function () {
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
           var title = $('#tbl thead th').eq( $(this).index() ).text();
           if ($(this).text() == 'No') {
             $(this).html('');
           } else if ($(this).text() == 'Action') {
             $(this).html('');
           } else {
             $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
           }
         });

         var urisegment = $("#urisegment").val();
         if (urisegment == 'approval_verification') {
           var show_url = 'vendor/approval_verification/show';
           $(".header_item_title").html("New Supplier Verification Approval");
           $(".item_title").html("New Supplier Verification Approval");

           var table = $('#tbl').DataTable({
               "ajax": {
                   "url": "<?= base_url() ?>"+show_url,
                   "dataSrc": ""
               },
               "data": null,
               "searching": true,
               "paging": true,
               "fixedColumns": {
                   leftColumns: 0,
                   rightColumns: 1
               },
               "columns": [
                   {title: "No"},
                   {title: "Email"},
                   {title: "<?= lang('Nama Vendor', 'Vendor Name') ?>"},
                   {title: "Company Type"},
                   {title: "Classification"},
                   {title: "Status"},
                   {title: "Note"},
                   {title: "<?= lang("Aksi", "Action") ?>"},
     //                {title: "<center><?= lang("Rincian", "Detail") ?>"}
               ],
               "columnDefs": [
                   {"class": "text-center", "targets": [7]},
     //                {"className": "dt-center", "targets": [5]},
               ],
               "scrollX": true,
           });
         } else {
           var show_url = 'vendor/approval/show';
           var table = $('#tbl').DataTable({
               "ajax": {
                   "url": "<?= base_url() ?>"+show_url,
                   "dataSrc": ""
               },
               "data": null,
               "searching": true,
               "paging": true,
               "fixedColumns": {
                   leftColumns: 0,
                   rightColumns: 1
               },
               "columns": [
                   {title: "No"},
                   {title: "<?= lang('Nama Vendor', 'Vendor Name') ?>"},
                   {title: "Email"},
                   {title: "Status"},
                   {title: "Sent Date"},
                   {title: "Attachment"},
                   {title: "Note"},
                   {title: "<?= lang("Aksi", "Action") ?>"},
     //                {title: "<center><?= lang("Rincian", "Detail") ?></center>"}
               ],
               "columnDefs": [
                   {"class": "text-center", "targets": [7, 5]},
     //                {"className": "dt-center", "targets": [5]},
               ],
               "scrollX": true
           });
         }

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
     function send_data()
     {
      swalConfirm('New Supplier Invitation', '<?= __('confirm_submit') ?>', function() {
         $.ajax({
           type: 'POST',
           url: '<?= base_url('vendor/approval/change_btn/9') ?>',
           data: $('#send').serialize(),
           success: function (m) {
               if (m.status == 'Success') {
                  $('#tbl').DataTable().ajax.reload();
                  $('#modal_app_rej').modal('hide');
                  setTimeout(function() {
                     swal('<?= __('success') ?>', '<?= __('success_approve') ?>', 'success');
                  }, swalDelay);
                  //msg_info(m.status,m.msg);
                  slides();
               } else {
                  setTimeout(function() {
                     swal('<?= __('warning') ?>', m.msg, 'warning');
                  }, swalDelay);
               }
           },
           error: function (XMLHttpRequest, textStatus, errorThrown) {
               setTimeout(function() {
                  swal('<?= __('warning') ?>', 'Something Went Wrong', 'warning');
               }, swalDelay);
           }
        });
      });
     }
     function reject_data()
     {
      if($('textarea#note').val().trim() != ""){
         swalConfirm('New Supplier Invitation', '<?= __('confirm_submit') ?>', function() {
            $.ajax({
               type: 'POST',
               url: '<?= base_url('vendor/approval/change_btn/13') ?>',
               data: $('#send').serialize(),
               success: function (m) {
                   if (m.status == 'Success') {
                       $('#modal_app_rej').modal('hide');
                       $('#tbl').DataTable().ajax.reload();
                       //msg_info(m.status,m.msg);
                       setTimeout(function() {
                           swal('<?= __('success') ?>', '<?= __('success_approve') ?>', 'success');
                       }, swalDelay);
                       slides();
                   } else {
                     setTimeout(function() {
                        swal('<?= __('warning') ?>', m.msg, 'warning');
                     }, swalDelay);
                   }
               },
               error: function (XMLHttpRequest, textStatus, errorThrown) {
                  setTimeout(function() {
                     swal('<?= __('warning') ?>', 'Something Went Wrong', 'warning');
                  }, swalDelay);
               }
            })
         });
      } else {
         swal('<?= __('warning') ?>', 'The Comment field is required', 'warning');
      }
     }
     function detail(id,idvendor,idT,pil,seq) {
         var obj = {};
         $(".act_id").val(idvendor);
         $('#ck_id_vendor').val(idvendor);
         obj.ID_VENDOR = id;
         console.log(pil);
         if(pil === 0 )
         {
             console.log("test");
             $('.nonregis').show();
             $('.registrasi').hide();
             $('.registrasi2').hide();
         }
         else
         {
             console.log("test2");
             $('.nonregis').hide();
             $('.registrasi').show();
             $('.registrasi2').show();
         }
         $('.email').val(idvendor);
         $('.id_vendor').val(id);
         $('.idT').val(idT);
         $('.seq').val(seq);
         $('#supps').val(idvendor);
         check_risk();
         // console.log("sesuai"+id);

         $(".div_comp_info").show();
         $(".div_comp_contact").show();
         $(".div_comp_addrs").show();
         $(".div_ktp").show();
         $(".div_bod").show();
         $(".div_sharehd").show();
         $(".div_deed").show();
         $(".div_business_license").show();
         $(".div_tdp").show();
         $(".div_skt_panas").show();
         $(".div_skt_migas").show();
         $(".div_skdp").show();
         $(".div_agency").show();
         $(".div_npwp").show();
         $(".div_sppkp").show();
         $(".div_taxcertif").show();
         $(".div_balancesheet").show();
         $(".div_bank_acc").show();
         $(".div_comp_exp").show();
         $(".div_general_certification").show();
         $(".div_bpjs").show();
         $(".div_bpjstk").show();

         $.ajax({
             type: "POST",
             url: "<?= base_url('vn/info/All_vendor/get_status_vendor') ?>",
             dataType: 'JSON',
             data: {param1: id},
             success: function (res) {
                 // $(".filetable").html(res);
                 if (parseInt(res[0].general_information) > 0){ $(".div_comp_info").show(); } else { $(".div_comp_info").hide(); }
                 if (parseInt(res[1].address) > 0){ $(".div_comp_addrs").show(); } else { $(".div_comp_addrs").hide(); }
                 if (parseInt(res[2].contact) > 0){ $(".div_comp_contact").show(); } else { $(".div_comp_contact").hide(); }
                 if (parseInt(res[3].deed) > 0){ $(".div_deed").show(); } else { $(".div_deed").hide(); }
                 if (parseInt(res[4].business_license) > 0){ $(".div_business_license").show(); } else { $(".div_business_license").hide(); }
                 if (parseInt(res[5].tdp) > 0){ $(".div_tdp").show(); } else { $(".div_tdp").hide(); }
                 if (parseInt(res[6].npwp) > 0){ $(".div_npwp").show(); } else { $(".div_npwp").hide(); }
                 if (parseInt(res[7].skt_panas_bumi) > 0){ $(".div_skt_panas").show(); } else { $(".div_skt_panas").hide(); }
                 if (parseInt(res[8].skt_migas) > 0){ $(".div_skt_migas").show(); } else { $(".div_skt_migas").hide(); }
                 if (parseInt(res[9].sppkp) > 0){ $(".div_sppkp").show(); } else { $(".div_sppkp").hide(); }
                 if (parseInt(res[10].tax_certificate) > 0){ $(".div_taxcertif").show(); } else { $(".div_taxcertif").hide(); }
                 if (parseInt(res[11].agency_certificate) > 0){ $(".div_agency").show(); } else { $(".div_agency").hide(); }
                 if (parseInt(res[15].bank_account) > 0){ $(".div_bank_acc").show(); } else { $(".div_bank_acc").hide(); }
                 if (parseInt(res[16].balance_sheet) > 0){ $(".div_balancesheet").show(); } else { $(".div_balancesheet").hide(); }
                 if (parseInt(res[17].list_board_of_director) > 0){ $(".div_bod").show(); } else { $(".div_bod").hide(); }
                 if (parseInt(res[18].list_shareholder) > 0){ $(".div_sharehd").show(); } else { $(".div_sharehd").hide(); }
                 if (parseInt(res[19].experience) > 0){ $(".div_comp_exp").show(); } else { $(".div_comp_exp").hide(); }
                 if (parseInt(res[21].general_certificate) > 0){ $(".div_general_certification").show(); } else { $(".div_general_certification").hide(); }
                 if (parseInt(res[22].bpjs_certificate) > 0){ $(".div_bpjs").show(); } else { $(".div_bpjs").hide(); }
                 if (parseInt(res[23].bpjs_tk_certificate) > 0){ $(".div_bpjstk").show(); } else { $(".div_bpjstk").hide(); }
                 if (parseInt(res[24].skdp) > 0){ $(".div_skdp").show(); } else { $(".div_skdp").hide(); }
                 if (parseInt(res[25].ktp) > 0){ $(".div_ktp").show(); } else { $(".div_ktp").hide(); }
             }
         });

         $.ajax({
             type: "GET",
             url: "<?= base_url('vendor/approval/ambil_attch_vendor') ?>/" + id,
             cache: false,
             processData: false,
             contentType: false,
             success: function (res) {
                 $(".filetable").html(res);
             }
         });


         $.ajax({
             type: "POST",
             url: "<?= site_url('vendor/approval/get_data/'); ?>" + id,
             data: "",
             cache: false,
             processData: false,
             contentType: false,
             success: function (res) {
                 if (res != false) {
                     tbl(id);
                     $('#NAMA').text(res[0]["GEN"][0]);
                     $('#PREFIX').text(res[0]["GEN"][1]);
                     $('#SUFFIX').text(res[0]["GEN"][4]);
                     $('#KATEGORI').text(res[0]["GEN"][3]);
                     $('#CLASSIFICATION').text(res[0]["GEN"][2]);
                     console.log(" Hello "+res[0]["GEN"][2]);
                     // console.log(res[0]["GEN"]);
                     // ktp
                     $("#CREATED_BY_KTP").text(res[2]['KTP'][0]);
                     $("#NO_KTP").text(res[2]['KTP'][1]);
                     $("#KTP_CITY").text(res[2]['KTP'][2]);
                     $("#VALID_TO_KTP").text(GetFormattedDate(res[2]['KTP'][3]));
                     $('#KTP_FILE').attr('onClick', 'review("' + res[2]['KTP'][4] + '","KTP/")');

                     if(typeof res['SDKP'] === 'undefined') {
                       // sdkp
                       $("#CREATED_BY_SDKP").text("");
                       $("#NO_SDKP").text("");
                       $("#VALID_FROM_SDKP").text("");
                       $("#VALID_TO_SDKP").text("");
                       $('#SDKP_FILE').attr('disabled', true);
                     } else {
                       // sdkp
                       $("#CREATED_BY_SDKP").text(res['SDKP'][3]);
                       $("#NO_SDKP").text(res['SDKP'][4]);
                       $("#VALID_FROM_SDKP").text(GetFormattedDate(res['SDKP'][1]));
                       $("#VALID_TO_SDKP").text(GetFormattedDate(res['SDKP'][2]));
                       $('#SDKP_FILE').attr('disabled', false);
                       $('#SDKP_FILE').attr('onClick', 'review("' + res['SDKP'][5] + '","SDKP/")');
                     }

                     if(typeof res['BPJS'] == 'undefined') {
                       // bpjs
                       $("#NO_BPJS").text("");
                       $("#VALID_FROM_BPJS").text("");
                       $('#BPJS_FILE').attr('disabled', true);
                     } else {
                       // bpjs
                       $("#NO_BPJS").text(res['BPJS'][4]);
                       $("#VALID_FROM_BPJS").text(GetFormattedDate(res['BPJS'][1]));
                       $('#BPJS_FILE').attr('onClick', 'review("' + res['BPJS'][5] + '","BPJS/")');
                     }

                     if (typeof res['BPJSTK'] == 'undefined') {
                       $("#NO_BPJSTK").text("");
                       $("#VALID_FROM_BPJSTK").text("");
                       $('#BPJSTK_FILE').attr('disabled', true);
                     } else {
                       $("#NO_BPJSTK").text(res['BPJSTK'][4]);
                       $("#VALID_FROM_BPJSTK").text(GetFormattedDate(res['BPJSTK'][1]));
                       $('#BPJSTK_FILE').attr('onClick', 'review("' + res['BPJSTK'][5] + '","BPJSTK/")');

                       $('#BPJS_FILE').attr('disabled', false);
                       $('#BPJSTK_FILE').attr('disabled', false);
                     }

                     if (res[0]["GEN"][2] === null) {
                       var_result = false;
                       var strx = '';
                     } else {
                       var_result = true;
                       var strx = res[0]["GEN"][2].toLowerCase().replace(',', ' ');
                       var stry = res[0]["GEN"][2].toLowerCase()+',';
                       var split_stry = stry.split(",");

                       if (split_stry.length > 1) {
                         if (split_stry.includes('jasa pemborongan') == true) {
                           $(".jasa").show();
                         } else {
                           $(".jasa").hide();
                           $(".tr-services").hide();
                         }

                         if (split_stry.includes('konsultan') == true) {
                           $(".konsul").show();
                         } else {
                           $(".konsul").hide();
                           $(".tr-consultant_service").hide();
                         }

                         if (split_stry.includes('penyedia jasa') == true) {
                           $(".jasa").show();
                           $(".konsul").show();
                           $(".tr-consultant_service").show();
                         }

                         if (split_stry.includes('penyedia barang') == true) {
                           $(".barang").show();
                         } else {
                           $(".barang").hide();
                           $(".tr-goods").show();
                         }

                       } else {
                         if (strx.indexOf("konsul") == -1) {
                           $(".konsul").hide();
                         } else {
                           $(".konsul").show();
                         }

                         if (strx.indexOf("barang") == -1) {
                           $(".barang").hide();
                         } else {
                           $(".barang").show();
                         }

                         if (strx.indexOf("jasa") == -1) {
                           $(".jasa").hide();
                         } else {
                           $(".konsul").show();
                           $(".jasa").show();
                         }
                       }

                     }
                     // Jasa Pemborongan,Penyedia Barang,Penyedia Jasa,Konsultan


                     $("#open").html(res[1]['SLKA'][0]);
                     $("#close").html(res[1]['SLKA'][1]);
                     $("#name_slka").html(': ' + res[0]["GEN"][0]);
                     $("#npwp_slka").html(': ' + res[0]["NPWP"][0]);
                     $("#address_slka").html(': ' + res[1]['SLKA'][2]);
                     $("#phone_slka").html(': ' + res[1]['SLKA'][3]);
                     $("#fax_slka").html(': ' + res[1]['SLKA'][4]);
                     // SIUP
                     if (res["SIUP"]) {
                             $(".siup").show();
                             $('#CREATED_BY_SIUP').text(res["SIUP"][3]);
                             $('#NO_SIUP').text(res["SIUP"][4]);
                             $('#VALID_FROM_SIUP').text(GetFormattedDate(res["SIUP"][1]));
                             $('#VALID_TO_SIUP').text(GetFormattedDate(res["SIUP"][2]));
                             $('#SIUP_TYPE').text(res["SIUP"][0]);
                             $('#SIUP_FILE').attr('onClick', 'review("' + res["SIUP"][5] + '","SIUP/")');
                     }
                     else if(res['BKPM'])
                     {
                             $(".siup").hide();
                             $('#CREATED_BY_SIUP').text(res["BKPM"][3]);
                             $('#NO_SIUP').text(res["BKPM"][4]);
                             $('#VALID_FROM_SIUP').text(GetFormattedDate(res["BKPM"][1]));
                             $('#VALID_TO_SIUP').text(GetFormattedDate(res["BKPM"][2]));
                             $('#SIUP_TYPE').text(res["BKPM"][0]);
                             $('#SIUP_FILE').attr('onClick', 'review("' + res["BKPM"][5] + '","BKPM/")');
                     }
                     // TDP
                     if (res["TDP"]) {
                         $('#CREATED_TDP_BY').text(res["TDP"][3]);
                         $('#NO_TDP').text(res["TDP"][4]);
                         $('#VALID_FROM_TDP').text(GetFormattedDate(res["TDP"][1]));
                         $('#VALID_TO_TDP').text(GetFormattedDate(res["TDP"][2]));
                         $('#TDP_FILE').attr('onClick', 'review("' + res["TDP"][5] + '","TDP/")');
                     }
                     if (res["SKT_EBTKE"]) {
                         $('#CREATED_EBTKE_BY').text(res["SKT_EBTKE"][3]);
                         $('#NO_EBTKE').text(res["SKT_EBTKE"][4]);
                         $('#VALID_FROM_EBTKE').text(GetFormattedDate(res["SKT_EBTKE"][1]));
                         $('#VALID_TO_EBTKE').text(GetFormattedDate(res["SKT_EBTKE"][2]));
                         $('#EBTKE_FILE').attr('onClick', 'review("' + res["SKT_EBTKE"][5] + '","EBTKE/")');
                     }
                     //MIGAS
                     if (res["SKT_MIGAS"]) {
                         $('#CREATED_MIGAS_BY').text(res["SKT_MIGAS"][3]);
                         $('#NO_MIGAS').text(res["SKT_MIGAS"][4]);
                         $('#VALID_FROM_MIGAS').text(GetFormattedDate(res["SKT_MIGAS"][1]));
                         $('#VALID_TO_MIGAS').text(GetFormattedDate(res["SKT_MIGAS"][2]));
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
                         $('#VALID_FROM_SPPKP').text(GetFormattedDate(res["SPPKP"][1]));
                         $('#VALID_TO_SPPKP').text(GetFormattedDate(res["SPPKP"][2]));
                         $('.VALID_TO_SPPKP').hide();
                         $('#SPPKP_FILE').attr('onClick', 'review("' + res["SPPKP"][5] + '","SPPKP/")');
                     }
                     if (res["SKT_PAJAK"]) {
                         $('#CREATED_PAJAK_BY').text(res["SKT_PAJAK"][3]);
                         $('#NO_PAJAK').text(res["SKT_PAJAK"][4]);
                         $('#VALID_FROM_PAJAK').text(GetFormattedDate(res["SKT_PAJAK"][1]));
                         $('#VALID_TO_PAJAK').text(GetFormattedDate(res["SKT_PAJAK"][2]));
                         $('.VALID_TO_PAJAK').hide();
                         $('#PAJAK_FILE').attr('onClick', 'review("' + res["SKT_PAJAK"][5] + '","PAJAK/")');
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
     function setujui_data(type) {
       console.log(type);
         $('.act_type').val(type);
         $('.note_approve').val('');
         $('#modal-approve .edit-title').text("Approval");
         $('#modal-approve .modal-header').css("background", "#347ab5");
         $('#modal-approve .modal-header').css("color", "#fff");
         $('#modal-approve').modal('show');
     }

     function batal_data(type) {
         $('.act_type').val(type);
         $('.note_reject').val('');
         $('#modal-reject .edit-title').text("Reject");
         $('#modal-reject .modal-header').css("background", "#d9534f");
         $('#modal-reject .modal-header').css("color", "#fff");
         $('#modal-reject').modal('show');
     }
     function modal_komen(type) {
         $('#send_msg').val("");
         var obj={};
         obj.type=type;
         obj.id=$('#ck_id_vendor').val();
         $.ajax({
                 type: 'POST',
                 url: '<?= base_url('vendor/show_vendor/comment/') ?>',
                 data: obj,
                 success: function (m) {
                         $('#message').html(m);
                         $('#type_msg').val(type)
                         lang();
                         $('#data_comment').modal('show');
                 }
             });
     }
     function send()
     {
         var obj={};
         obj.msg=$('#send_msg').val();
         obj.type=$('#type_msg').val();
         obj.id=$('#ck_id_vendor').val();
         $.ajax({
             type: 'POST',
             url: '<?= base_url('vendor/show_vendor/send_comment/') ?>',
             data: obj,
             success: function (m) {
                 if(m!=false)
                     modal_komen(obj.type);
                 else
                     msg_danger('Failed',"Something Wrong");
             }
         });
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
         $('#datakonsultasi').DataTable().destroy();
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
                 url: '<?= base_url('vendor/approval/datakontakperusahaan/') ?>' + id,
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
                 url: '<?= base_url('vendor/approval/alamatperusahaan/') ?>' + id,
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
                 {title: "<center><?= lang("Alamat", "Address 1") ?></center>"},
                 {title: "<center><?= lang("Alamat", "Address 2") ?></center>"},
                 {title: "<center><?= lang("Alamat", "Address 3") ?></center>"},
                 {title: "<center><?= lang("Alamat", "Address 4") ?></center>"},
                 {title: "<center><?= lang("Negara", "Country") ?></center>"},
                 {title: "<center><?= lang("Provinsi", "Province") ?></center>"},
                 {title: "<center><?= lang("Kota", "City") ?></center>"},
                 {title: "<center><?= lang("Kode Pos", "Postal Code") ?></center>"},
                 {title: "<center><?= lang("Telp", "Telp") ?></center>"},
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
                 {"className": "dt-center", "targets": [10]},
                 {"className": "dt-center", "targets": [11]},
                 {"className": "dt-center", "targets": [12]},
             ],
         });
         var tabel3 = $('#dataakta').DataTable({
             ajax: {
                 url: '<?= base_url('vendor/approval/dataakta/') ?>' + id,
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
                 {title: "<center>Deed ID</center>"},
                 {title: "<center>Deed Date</center>"},
                 {title: "<center>Deed Type</center>"},
                 {title: "<center>Notary</center>"},
                 {title: "<center>Notary Address</center>"},
                 {title: "<center>Judges Verification</center>"},
                 {title: "<center>Judges Approval</center>"},
                 {title: "<center>Deed Doc.</center>"},
                 {title: "<center>Verification Doc.</center>"},
                 {title: "<center>State Doc.</center>"}
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
                 url: '<?= base_url('vendor/approval/show_datasertifikasi/') ?>' + id,
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
                 {title: "<center><?= lang("Kualifikasi", "Qualification") ?></center>"},
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
                 url: '<?= base_url('vendor/approval/daftarjasa/') ?>' + id,
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
                 {title: "<center><?= lang("Nomor Izin", "License Number") ?></center>"}
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

         var tabelkonsul = $('#datakonsultasi').DataTable({
             'ajax': {
                 'url': '<?= base_url('vn/info/goods_service/get_consul/') ?>'+ id,
                 'dataSrc': ''
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
                 {title: "No"},
                 {title: "<?= lang("Group Jasa", "Group Service") ?>"},
                 {title: "<?= lang("Sub Group Jasa", "Service Sub Group") ?>"},
                 {title: "<?= lang("Nama Jasa", "Service Name") ?>"},
                 {title: "<?= lang("Deskripsi", "Description") ?>"},
                 {title: "<?= lang("Nomor Izin", "Number") ?>"},
                 // {title: "<?= lang("&nbsp&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp&nbsp&nbsp")
      ?>"},
             ],
             "columnDefs": [
                 {"className": "dt-center", "targets": [0]},
                 {"className": "dt-center", "targets": [1]},
                 {"className": "dt-center", "targets": [2]},
                 {"className": "dt-center", "targets": [3]},
                 {"className": "dt-center", "targets": [4]},
                 {"className": "dt-center", "targets": [5]},
                 // {"className": "dt-center", "targets": [6]},
             ],
             "scrollX": true,
             "scrollY": '300px',
             "scrollCollapse": true,
         });

         var tabel6 = $('#daftarbarang').DataTable({
             ajax: {
                 url: '<?= base_url('vendor/approval/daftarbarang/') ?>' + id,
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
                 url: '<?= base_url('vendor/approval/show_company_management/') ?>' + id,
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
                 {title: "<?= lang("Nomor Telepon", "Phone Number") ?>"},
                 {title: "<?= lang("Email", "Email") ?>"},
                 {title: "<?= lang("Nomor KTP", "NIK (KITAS/KIMS)") ?>"},
                 {title: "<?= lang("Scan KTP", "Scan KTP") ?>"},
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
             ],
             "scrollX": '300px',
             // "scrollY": '300px',
             "scrollCollapse": true,
         });
         lang();
         var tabel8 = $('#databank').DataTable({
             ajax: {
                 url: '<?= base_url('vendor/approval/show_vendor_shareholders/') ?>' + id,
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
                 {title: "<?= lang("Nama Lengkap", "Full Name") ?>"},
                 {title: "<?= lang("Nomor Telepon", "Phone Number") ?>"},
                 {title: "<?= lang("Email", "Email") ?>"},
                 {title: "<?= lang("NPWP", "NPWP") ?>"},
                 {title: "<?= lang("Scan NPWP", "Scan NPWP") ?>"},
             ],
             "columnDefs": [
                 {"className": "dt-right", "targets": [0]},
                 {"className": "dt-right", "targets": [1]},
                 {"className": "dt-right", "targets": [2]},
                 {"className": "dt-right", "targets": [3]},
                 {"className": "dt-right", "targets": [4]},
                 {"className": "dt-right", "targets": [5]},
             ],
             "scrollX": '300px',
             // "scrollY": '300px',
             "scrollCollapse": true
         });
         lang();
         var tabel9 = $('#neraca_keuangan_tabel').DataTable({
             ajax: {
                 url: '<?= base_url('vendor/approval/show_financial_bank_data/') ?>' + id,
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
                 {title: "<?= lang("Labah Bersih", "Net Income") ?>"},
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
                 url: '<?= base_url('vendor/approval/show_vendor_bank_account/') ?>' + id,
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
                 {title: "<?= lang("Bank", "Bank") ?>"},
                 {title: "<?= lang("Alamat", "Address") ?>"},
                 {title: "<?= lang("Cabang", "Branch") ?>"},
                 {title: "<?= lang("Nomor. Rekening", "Account Number") ?>"},
                 {title: "<?= lang("Nama Akun", "Name") ?>"},
                 {title: "<?= lang("Mata Uang", "Currency") ?>"},
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
                 url: '<?= base_url('vendor/approval/show_certification/') ?>' + id,
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
                 url: '<?= base_url('vendor/approval/show_experience/') ?>' + id,
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
                 {title: "<?= lang("Projek Description", "Project Description") ?>"},
                 {title: "<?= lang("Nilai Project", "Project Value") ?>"},
                 {title: "<?= lang("Matauang", "Currency") ?>"},
                 {title: "<?= lang("No. Kontrak", "Contract Number") ?>"},
                 {title: "<?= lang("Tanggal Mulai", "Start Date") ?>"},
                 {title: "<?= lang("Tanggal Selesai", "Finish Date") ?>"},
                 {title: "<?= lang("Contact Person", "Contact Person") ?>"},
                 {title: "<?= lang("Phone Number", "Phone Number") ?>"},
             ],
             "columnDefs": [
                 {"className": "dt-right", "targets": [0]},
                 {"className": "dt-right", "targets": [1]},
                 {"className": "dt-right", "targets": [2]},
                 {"className": "dt-right", "targets": [3]},
                 {"className": "dt-right", "targets": [4]},
                 {"className": "dt-right", "targets": [5]},
                 {"className": "dt-right", "targets": [6]},
                 {"className": "dt-center", "targets": [7]},
                 {"className": "dt-center", "targets": [8]},
                 {"className": "dt-center", "targets": [9]},
                 {"className": "dt-center", "targets": [10]},
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


   function GetFormattedDate(id) {
    var todayTime = new Date(id);
    var month = todayTime .getMonth() + 1;
    var day = todayTime .getDate();
    var year = todayTime .getFullYear();
    return day + "-" + month + "-" + year;
   }

</script>
