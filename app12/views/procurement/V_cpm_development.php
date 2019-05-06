<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
<div class="content-wrapper">
    <div class="content-header row">        
    </div>
	<h3 id="cpm_title1" class="content-header-title"><?=lang("Persiapan CPM", "CPM Preparation")?></h3>
    <h3 id="cpm_title2" class="content-header-title" style="display: none;"><?=lang("Progres CPM", "CPM On Progress")?></h3>
    <div class="content-detached">        
        <div class="content-body" id="main-content">
            <section>
                <div class="card">
                    <div class="card-header">                        
                        <div class="row">
                            <div class="col-sm-8"></div>
                            <div class="col-sm-4 pull-right text-right">
                                <button id="cpm_btn1" class="btn btn-primary" onclick="show_prepared()" style="display: none;">
                                    <i class="fa fa-exchange"></i>
                                    <?=lang("Persiapan CPM", "CPM Preparation")?>
                                </button>
                                <button id="cpm_btn2" class="btn btn-primary" onclick="show_progress()">
                                    <i class="fa fa-exchange"></i>
                                    <?=lang("Progres CPM", "CPM On Progress")?>
                                </button>
                            </div>
                        </div>                 
                    </div>
                    <div class="card-body">
                        <div class="col-12 form-row prepared">
                            <table id="list1" class="table table-striped table-bordered table-hover display text-center" width="100%">
                            </table>
                        </div>
                        <div class="col-12 form-row onprogress">
                            <table id="list2" class="table table-striped table-bordered table-hover display text-center" width="100%">
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="content-body" id="slides">
            <div class="row info-header">
                <div class="col-md-6">
                    <table class="table table-condensed">
                        <tr>
                            <td width="30%">Company</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="comHead"></span> </strong></td>
                        </tr>
                        <tr>
                            <td width="30%">Vendor</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="venHead"></span> </strong></td>
                        </tr>
                        <tr>
                            <td width="30%">Agreement No.</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="opHead"></span> </strong></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-condensed">
                        <tr>
                            <td width="30%">Title</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="titleHead"></span> </strong></td>
                        </tr>
                        <tr>
                            <td width="30%">Requestor</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="reqHead"></span> </strong></td>
                        </tr>
                        <tr>
                            <td width="30%">Department</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="deptHead"></span> </strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            <section>
                <div class="card">
                    <div class="card-content card-scroll">
                        <div class="card-body body-step">
                            <div class="col-12 form-row x-tab" id="project-info">         
                                <input type="text" style="display:none" id="po_id"/>
                                <input type="text" style="display:none" id="vendor_id"/>
                                <input type="text" style="display:none" id="phase_id"/>
                                <input type="text" style="display:none" id="max_tab"/>
                                <div class="steps clearfix">
                                    <ul role="tablist" class="tablist">
										<li >
											<button onclick="choose(1)" id="main-b-1" class="project-info-icon btn btn-default current">
												<i class="fa fa-file"></i>
												Schedule
											</button>
										</li>
										<li>
											<button onclick="choose(2)" id="main-b-2" class="project-info-icon btn btn-default">
												<i class="fa fa-info"></i>   
												KPI	
											</button>
										</li>
										<li>
											<button onclick="choose(3)" id="main-b-3" class="project-info-icon btn btn-default">
												<i class="fa fa-list"></i>   
												Approval List	
											</button>
										</li>
										<li>
											<button onclick="choose(4)" id="main-b-4" class="project-info-icon btn btn-default">
												<i class="fa fa-paperclip"></i>   
												Attachment	
											</button>
										</li>
                                        <li id="btn-history">
                                            <button onclick="choose(5)" id="main-b-5" class="project-info-icon btn btn-default">
                                                <i class="fa fa-history"></i>
                                                History
                                            </button>
                                        </li>
									</ul>
								</div>                        
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12" id="main-p-1">                                
                                <div id="main-c-1">
                                    <div class="col-md-12">
                                        <h4><?=lang("Tanggal Perencanaan CPM","CPM Planning Date")?></h4>
                                        <table class="mt-1 table table-striped table-bordered table-hover display text-center" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th><?= lang("Fase", "Phase") ?></th>
                                                    <th><?= lang("Lokasi", "Location") ?></th>
                                                    <th><?= lang("Tanggal", "Date") ?></th>
                                                    <th><?= lang("Tanggal Akhir", "Due Date") ?></th>
                                                    <th><?= lang("Status", "Status") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="cpm_planning"> 
                                                <tr>
                                                    <td colspan="6"><?=lang("Tidak Ada Data","No Data")?></td>
                                                </tr>                                       
                                            </tbody>                                                
                                        </table>
                                        <div class="text-right">
                                            <button class="btn btn-success send1 btn-modif" onclick="add_phase()"><?=lang("Tambah / Ubah","Add / Edit")?></button>
                                        </div>                                                                                        
                                    </div>
                                    <div class="col-md-12">
                                        <h4><?=lang("Jadwal Notifikasi ","Schedule of remainder notification")?></h4>
                                        <table class="mt-1 table table-striped table-bordered table-hover display text-center" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th><?= lang("Fase", "Phase") ?></th>
                                                    <th><?= lang("Jadwal Pengingat", "Remainder Schedule") ?></th>
                                                    <th><?= lang("Tanggal Notifikasi", "Notification Date") ?></th>
                                                    <th><?= lang("Status", "Status") ?></th>
                                                    <th><?= lang("Aksi", "Action") ?></th>
                                                </tr>
                                            </thead>
                                            <tbody id="cpm_remainder">
                                                <tr>
                                                    <td colspan="6"><?=lang("Tidak Ada Data","No Data")?></td>
                                                </tr>                                       
                                            </tbody>                                                
                                        </table>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" id="main-p-2">                                
                                <div id="main-c-2">    
                                    <button class="btn btn btn-primary btn-modif" onclick="add_kpicategory()"><span>(%) </span><?=lang("Besar Kategori","Category Weight")?></button>
                                    <button id="add_kpi_btn" class="btn btn btn-primary btn-modif" onclick="add_kpi()"><i class="fa fa-plus">&nbsp;</i><?=lang("Tambah KPI","Add KPI")?></button>
                                    <div class="mt-1 col-md-12" style="overflow:auto">
                                        <table id="kpi" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle;" rowspan="2">No</th>
                                                    <th style="vertical-align: middle;" rowspan="2">Category</th>
                                                    <th style="vertical-align: middle;" rowspan="2">Category<br/>Weight</th>
                                                    <th style="vertical-align: middle;" rowspan="2">Specific<br/>KPI</th>
                                                    <th style="vertical-align: middle;" rowspan="2">KPI<br/>Weight</th>
                                                    <th style="vertical-align: middle;" rowspan="2">Scoring<br/>Methodology</th>
                                                    <th style="vertical-align: middle;" colspan="2">Target</th>
                                                    <th style="vertical-align: middle;" colspan="2">Contractor<br/>Self Scoring</th>
                                                    <th style="vertical-align: middle;" colspan="2">Final Score</th>
                                                    <th style="vertical-align: middle;" rowspan="2">Remark</th>
                                                    <th style="vertical-align: middle;" rowspan="2">Action</th>
                                                </tr>
                                                <tr>
                                                    <th>Score</th>
                                                    <th>Weight</th>
                                                    <th>Score</th>
                                                    <th>Weight</th>
                                                    <th>Score</th>
                                                    <th>Weight</th>
                                                </tr>
                                            </thead>
                                            <tbody id="data_kpi" >
                                                <tr>
                                                    <td colspan="11"><?=lang("Tidak Ada Data","No Data")?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" id="main-p-3">
                                <div id="main-c-3">
                                    <div class="row-fluid" style="padding-bottom: 1.5rem;">
                                        <h3 style="width: 75%; display: inline-block; margin-top: 0.5rem;"><?=lang("Daftar Persetujuan CPM","CPM Approval List")?></h3>
                                        <button onclick="reset_user()" title="<?=($_SESSION['lang'] == 'IND' ? "Ulang" : "Reset")?>" class="btn btn-danger btn-modif" style="float: right;"><i class="fa fa-refresh"></i></button>
                                    </div>
                                    <table id="approval_user" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>User Logon</th>
                                                <th>Employee Name</th>
                                                <th>Department</th>
                                                <th>Role Description</th>
                                            </tr>
                                        </thead>
                                        <tbody id="CPM_approval">
                                            <tr>
                                                <td colspan="6"><?=lang("Tidak Ada Data","No Data")?></td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                    <div class="text-right">
                                        <button onclick="add_user()" class="btn btn-success btn-modif"><?=lang("Tambah","Add")?></button>
                                    </div>                                    
                                </div>
                            </div>                         
                            <div class="col-12" id="main-p-4">
                                <div id="main-c-4">
                                    <h3><?=lang("Lampiran","Attachment")?></h3>
                                    <table id="attch" class="table table-striped table-bordered table-hover display text-center" width="100%">                                        
                                    </table>       
                                    <div class="pull-right">
                                        <button onclick="modal_upload()" class="btn btn-primary btn-modif">Upload File</button>
                                    </div>                                    
                                </div>
                            </div>                                                                           
                            <div class="col-12" id="main-p-5">
                                <div id="main-c-5">
                                    <h3><?=lang("Riwayat", "History")?></h3>
                                    <table id="log_table" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th><?= lang("Aksi", "Action") ?></th>
                                                <th><?= lang("Catatan", "Note") ?></th>
                                                <th><?= lang("Transaksi Pada", "Transaction At") ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="log_body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <hr/>
                            <div class="col-12 row">
                                <div class="col-md-4">
                                    <button class="btn btn-default" id="min"><i class="fa fa-arrow-left"></i></button>
                                    <button class="btn btn-default" id="plus"><i class="fa fa-arrow-right"></i></button>
                                </div>
                                <div class="col-md-8 text-right">
                                    <button class="btn btn-success btn-modif" onclick="sendit()"><?= lang("Kirim","Submit")?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</div>
<div id="cat_weight_modal" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="kpi_category_form" novalidate="novalidate" action="javascript:;">
            <div class="modal-header bg-primary white">
                <h4 class="edit-title"><?= lang("Menentukan Pembobotan Category", "Determine Category Weighting") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="form-label"><?=lang("Kategori","Category")?></label>
                            <select class="form-control" name="category">
                                <?php
                                    if(isset($option))
                                    {                                    
                                        foreach($option as $k => $v)
                                        {
                                            echo '<option value='.$v->id.'>'.$v->category.'</option>';
                                        }                                    
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Besar Kategori", "% Cat Weight") ?></label>
                            <input type="number" min="0" max="100" name="weight" class="form-control" id="weight" required data-validation-required-message="This Field is required"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-primary"><?= lang("Proses", "Process") ?></button>
            </div>
        </form>
    </div>
</div>
<div id="cpm_approve" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="approval_form" novalidate="novalidate" action="javascript:;">
            <div class="modal-header bg-primary white">
                <h4 class="edit-title"><?= lang("Menentukan Persetujuan CPM", "CPM Approval Determination") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">                    
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="form-label"><?=lang("Departemen","Department")?></label>
                            <select onchange="choose_user(this.value,1)" class="form-control" id="dept" name="dept">
                                <?php
                                    if(isset($dept))
                                    {                                    
                                        foreach($dept as $k => $v)
                                        {
                                            echo '<option value=' . $v->ID_DEPARTMENT . '>' . '[' . $v->ID_DEPARTMENT . '] ' . $v->DEPARTMENT_DESC . '</option>';
                                        }                                    
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="form-label"><?=lang("Penerima Tugas","Assignee")?></label>
                            <select class="form-control" id="user" name="user">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="form-label"><?=lang("Jabatan","Role")?></label>
                            <select class="form-control" id="roles" name="roles">
                                <option value='1'>User</option>
                                <option value='2'>Subject Matter Expert</option>
                                <option value='3'>Subject Matter Support</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-primary"><?= lang("Tambah", "Add") ?></button>
            </div>
        </form>
    </div>
</div>
<div id="kpi_weight_modal" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="kpi_data_form" novalidate="novalidate" action="javascript:;">
            <div class="modal-header bg-primary white">               
                <h4 id="kpi_title_add" class="edit-title">
                    <?= lang("Menambahkan Detail KPI", "Adding Specific KPI") ?>
                </h4>
                <h4 id="kpi_title_edit" class="edit-title" style="display: none">
                    <?= lang("Mengubah Detail KPI", "Editing Specific KPI") ?>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input type="hidden" name="kpi_id" id="kpi_id" required />
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="form-label"><?=lang("Kategori","Category")?></label>
                            <select id="kpi_cat_list" class="form-control" name="category">
                                <option value="0"><?php echo ($_SESSION['lang'] == 'IND' ? 'Tidak Ada Data' : 'No Data');?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="controls col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Detail KPI", "Specific KPI") ?></label>
                            <textarea row="5" class="form-control" name="kpi_spec" id="kpi_spec" required data-validation-required-message="This Field is required"></textarea>
                        </div>
                    </div>                                    
                    <div class="form-group">
                        <div class="controls col-md-12">
                            <label class="control-label" for="field-1"><?= lang("% Besar KPI", "% KPI Weight") ?></label>
                            <input type="number" min=0 max=100 class="form-control" name="kpi_weight" id="kpi_weight" required data-validation-required-message="This Field is required"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="controls col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Metodologi Penilaian", "Scoring Methodology") ?></label>
                            <textarea row="5" class="form-control" name="kpi_method" id="kpi_method" required data-validation-required-message="This Field is required"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="controls col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Target Nilai", "Target Score") ?></label>
                            <input class="form-control" name="target_score" id="target_score" required data-validation-required-message="This Field is required"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" id="modal_kpi_btn" class="btn btn-primary"></button>
            </div>
        </form>
    </div>
</div>
<div id="add_planning" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="planning_form" novalidate="novalidate" action="javascript:;">
            <div class="modal-header bg-primary white">               
                <h4 class="edit-title"> <?= lang("Pengaturan Perencanaan Tanggal CPM", "CPM Planning Date Configuration") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                
            </div>
            <div class="modal-body">
                <div class="form-horizontal">  
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="form-label"><?=lang("Kategori","Category")?></label>
                            <select class="form-control" name="category">
                                <option value="1">Phase 1</option>
                                <option value="2">Phase 2</option>
                                <option value="3">Phase 3</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="controls col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Lokasi", "Location") ?></label>                            
                            <textarea row="5" class="form-control" name="location" id="location" required data-validation-required-message="This Field is required"></textarea>
                        </div>
                    </div>                                    
                    <div class="form-group">
                        <div class="controls col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Tanggal Perencanaan", "Planning Date") ?></label>                            
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="plan_date" class="form-control" name="plan_date" value="<?php echo date("Y-m-d"); ?>" >
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-primary"><?= lang("Proses", "Process") ?></button>
            </div>
        </form>
    </div>
</div>
<div id="upload_file" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form id="file_upload" class="modal-content" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
            <div class="modal-header bg-primary white">               
                <h4 class="edit-title"> <?= lang("Unggah File", "Upload File") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                
            </div>
            <div class="modal-body">                            
                <div class="form-horizontal">                                      
                    <div class="form-group">
                        <input type="text" style="display:none" name="po_id" class="po_id"/>
                        <div class="controls col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Pilih File", "Choose File") ?></label>                            
                            <input type="file" name="file_unggah" id="file_unggah" class="form-control" required data-validation-required-message="This Field is required">
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-primary"><?= lang("Tambah ", "Add") ?></button>
            </div>
        </form>
    </div>
</div>
<div id="check_list" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success white">               
                <h4 class="edit-title"> <?= lang("Daftar Isian", "Check List") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                
            </div>
            <div class="modal-body">                            
                <div class="form-horizontal">                                      
                    <div class="form-group">
                        <input type="text" style="display: none" id="selector"/>
                        <table id="list" class="table table-striped table-bordered table-hover display text-center" width="100%">
                            <thead>
                                <tr>  
                                    <td>No</td>
                                    <td>Form</td>
                                    <td><?= lang("Jumlah Isian", "Entry Counter") ?></td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody id="list_body">
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button id="send_list_new" onclick="send_all(1)" class="btn btn-success"><?= lang("Kirim ", "Submit") ?></button>
                <button id="send_list_old" onclick="send_all(2)" class="btn btn-success" style="display: none;"><?= lang("Kirim ", "Submit") ?></button>
            </div>       
        </div> 
    </div>
</div>

<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/js/scripts/forms/validation/form-validation.js"type="text/javascript"></script>
<script src="<?= base_url('ast11/assets/js/accounting.js/accounting.js') ?>"></script>
<script>
$(function(){                 
    lang();
    accounting.settings = {
        currency: {
            decimal : ".",  // decimal point separator
            thousand: ",",  // thousands separator
            precision : 2,   // decimal places
            format: "%v"
        },
        number: {
            precision : 2,  // default precision on numbers is 0
            thousand: ",",
            decimal : "."
        }
    }
    $('.input-group.date').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    var table1 = $('#list1').DataTable({
    ajax: {
        url: '<?= base_url('procurement/cpm_development/get_list_prepared/') ?>',
        'dataSrc': ''
    },
    "scrollX": true,
    "selected": true,
    "scrollY": "300px",
    "scrollCollapse": true,
    "paging": true,
    "columns": [
        {title:"No"},
        {title:"<?= lang("No Persetujuan", "Agreement No") ?>"},
        // {title:"<?= lang("Tipe", "Type") ?>"},
        {title:"<?= lang("Pekerjaan", "Subject") ?>"},
        {title:"<?= lang("Perusahaan", "Company") ?>"},            
        {title:"<?= lang("Penyedia", "Supplier") ?>"},
        {title:"<?= lang("Mata Uang", "Currency") ?>"},
        {title:"<?= lang("Jumlah", "Value") ?>", render : function(data) {
                return accounting.formatMoney(data);
            }},
        {title:"<?= lang("Valid Sejak", "Validity Start") ?>"},
        {title:"<?= lang("Valid Hingga", "Validity End") ?>"},
        {title:"<?= lang("Aksi", "Action") ?>"},
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
        // {"className": "dt-center", "targets": [10]},
    ]
    });
    var table2 = $('#list2').DataTable({
    ajax: {
        url: '<?= base_url('procurement/cpm_development/get_list_progress/') ?>',
        'dataSrc': ''
    },
    "scrollX": true,
    "selected": true,
    "scrollY": "300px",
    "scrollCollapse": true,
    "paging": true,
    "columns": [
        {title:"No"},
        {title:"<?= lang("No Persetujuan", "Agreement No") ?>"},
        // {title:"<?= lang("Tipe", "Type") ?>"},
        {title:"<?= lang("Pekerjaan", "Subject") ?>"},
        {title:"<?= lang("Perusahaan", "Company") ?>"},
        {title:"<?= lang("Penyedia", "Supplier") ?>"},
        {title:"<?= lang("Mata Uang", "Currency") ?>"},
        {title:"<?= lang("Jumlah", "Value") ?>", render : function(data) {
                return accounting.formatMoney(data);
            }},
        {title:"<?= lang("Fase", "Phase") ?>"},
        {title:"<?= lang("Jabatan", "Role") ?>"},
        {title:"Status"},
        {title:"<?= lang("Aksi", "Action") ?>"},
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
        // {"className": "dt-center", "targets": [11]},
    ] 
    });
    show_prepared();
    $('#file_upload').submit(function (){
        var formData = new FormData($('#file_upload')[0]);
        var elm=start($('#upload_file').find('.modal-content'))
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('procurement/cpm_development/upload_file'); ?>",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (m)
            {
                if(m.status === "Success")
                {
                    $('#upload_file').modal('hide');
                    $('#attch').DataTable().ajax.reload();
                    msg_info(m.msg,m.status);
                }
                else
                    msg_danger(m.msg,m.status);
                stop(elm);
            },
            error: function(m)
            {
                stop(elm);
                msg_danger("Oops, something went wrong!", "Failed");
            }
        });
    });
    $('#approval_form').submit(function() {
        var obj = {};
        $.each($("#approval_form").serializeArray(), function(i, field) {
            obj[field.name] = field.value;
        });
        if (obj['user'] == 0) {
            msg_danger("<?php echo ($_SESSION['lang'] == 'IND' ? 'Belum ada penerima tugas terpilih' : 'No assignees has been chosen') ?>", "Failed");
        } else {
            obj.vendor = $('#vendor_id').val();
            obj.po = $('#po_id').val();
            obj.idS = $('#vendor_id').val();

            $.ajax({
                url: '<?=base_url("procurement/cpm_development/set_approval")?>',
                data: obj,
                type: 'POST',
                success: function(m) {
                    if(m.status === "Success") {
                        msg_info(m.msg,m.status);
                        get_approval();
                    } else
                        msg_danger(m.msg,m.status);
                },
                error: function(m)  {
                    msg_danger(m.msg,m.status);
                }
            });
        }
    });

    $("#kpi_data_form").submit(function() {
        $('#kpi_cat_list').attr('disabled', false);
        var obj = {};
        $.each($('#kpi_data_form').serializeArray(), function(i,field){
            obj[field.name] = field.value;
        });
        obj.po = $('#po_id').val();
        obj.vendor = $('#vendor_id').val();

        if ($('#kpi_id').val() != 0)
            $('#kpi_cat_list').attr('disabled', true);

        $.ajax({
            url: "<?= base_url('procurement/cpm_development/add_kpi_detail')?>",
            type: "POST",
            data: obj,
            success: function (m){
                if (m.status === "Success") {
                    msg_info(m.msg, m.status);
                    $('#kpi_weight_modal').modal('hide');
                    table_weight();
                } else {
                    msg_danger(m.msg, m.status);
                }
            },
            error: function (m){
                msg_danger(m.msg, m.status);
            },
        });
    });

    $('#kpi_category_form').submit(function ()
    {
        var obj={};
        $.each($('#kpi_category_form').serializeArray(),function(i,field){
            obj[field.name] = field.value;
        });
        obj.po=$('#po_id').val();
        obj.vendor=$('#vendor_id').val();
        $.ajax({
            url:"<?= base_url('procurement/cpm_development/add_weight')?>",
            type:"POST",
            data:obj,
            success:function(m)
            {
                if(m.status === "Success"){
                    msg_info(m.msg,m.status);
                    $('#cat_weight_modal').modal('hide');
                    table_weight();
                }
                else
                {
                    msg_danger(m.msg,m.status);
                }
            },
            error:function(m)
            {
                msg_danger(m.msg,m.status);
            }
        });
    });

    $('#planning_form').submit(function()
    {
        var elm=start($('.card').find('.card-content'));
        var obj={};
        $.each($("#planning_form").serializeArray(), function (i, field) {
            obj[field.name] = field.value;
        });
        obj["po_no"]=$('#po_id').val();

        $.ajax({
            url:"<?=base_url('procurement/cpm_development/add_phase')?>",
            type:"POST",
            data:obj,
            success:function(m)
            {                
                if(m.status==="Success")
                {
                    $('#add_planning').modal('hide');
                    msg_info(m.msg,m.status);
                    get_plan(elm);
                }
                else{
                    stop(elm);
                    msg_danger(m.msg,m.status);
                }
            },
            error:function(e)
            {
                stop(elm);
                msg_danger(m.msg,m.status);
            }
        });
    });
   
    $('#slides').hide();

    $('#min').click(function() {
        if(index == 1)
            index = 1;
        else
            index--;
        display(index);
    });

    $('#plus').click(function() {
        if (index == $('#max_tab').val())
            index = $('#max_tab').val();
        else
            index++;
        display(index);
    });
});

function show_prepared() {
    $('#cpm_btn1').hide();
    $('#cpm_title1').show();
    $('#cpm_title1_sub').show();
    $('#cpm_btn2').show();
    $('#cpm_title2').hide();
    $('#cpm_title2_sub').hide();
    $('.prepared').show();
    $('.onprogress').hide();
    $('#list1').DataTable().columns.adjust();
}

function show_progress() {
    $('#cpm_btn1').show();
    $('#cpm_title1').hide();
    $('#cpm_title1_sub').hide();
    $('#cpm_btn2').hide();
    $('#cpm_title2').show();
    $('#cpm_title2_sub').show();
    $('.prepared').hide();
    $('.onprogress').show();
    $('#list2').DataTable().columns.adjust();
}

function table_weight() {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.vendor = $('#vendor_id').val();
    obj.pid = $('#phase_id').val();
    $.ajax({
        url: "<?=base_url('procurement/cpm_development/get_cpm_detail')?>",
        data: obj,
        type: "POST",
        success: function(m) {
            if (m.length == 0) {
                $('#add_kpi_btn').attr("disabled", "disabled");
                $('#data_kpi').html("<tr><td colspan='14'><?php echo ($_SESSION['lang'] == 'IND' ? 'Tidak Ada Data' : 'No Data');?></td></tr>");
                return;
            } else {
                $('#add_kpi_btn').removeAttr("disabled");
                $('#data_kpi').html("");
                var tamp = 0;
                var cnt = 0;

                var st_kpi_w = 0;
                var st_kpi_ts = 0;
                var st_kpi_tws = 0;
                var st_kpi_as = 0;
                var st_kpi_aws = 0;
                var st_kpi_ds = 0;
                var st_kpi_dws = 0;

                var gt_cat_w = 0;
                var gt_kpi_ts = 0;
                var gt_kpi_tws = 0;
                var gt_kpi_as = 0;
                var gt_kpi_aws = 0;
                var gt_kpi_ds = 0;
                var gt_kpi_dws = 0;

                $.each(m, function(i,item) {
                    if (tamp == 0) {
                        cnt++;
                        gt_cat_w += (item.weight * 1);

                        st_kpi_w += (item.kpi_weight * 1);
                        st_kpi_ts += (item.target_score * 1);
                        st_kpi_tws += (item.target_weight * 1);
                        st_kpi_as += (item.actual_score * 1);
                        st_kpi_aws += (item.actual_weight * 1);
                        st_kpi_ds += (item.adjust_score * 1);
                        st_kpi_dws += (item.adjust_weight * 1);

                        $('#kpi > tbody:last-child').append
                        ("<tr>"
                            +"<td rowspan="+(item.total * 1 + 1)+">"+cnt+"</td>"
                            +"<td rowspan="+(item.total * 1 + 1)+">"+item.category+"</td>"
                            +"<td rowspan="+(item.total * 1 + 1)+">"+item.weight+" %</td>"
                            +"<td>"+item.specific_kpi+"</td>"
                            +"<td>"+item.kpi_weight+" %</td>"
                            +"<td>"+item.scoring_method+"</td>"
                            +"<td>"+item.target_score+"</td>"
                            +"<td>"+item.target_weight+"</td>"
                            +"<td>"+item.actual_score+"</td>"
                            +"<td>"+item.actual_weight+"</td>"
                            +"<td>"+item.adjust_score+"</td>"
                            +"<td>"+item.adjust_weight+"</td>"
                            +"<td>"+item.remarks+"</td>"
                            +"<td><button style='width:30px;height:30px' class='btn btn-sm btn-primary btn-modif-kpi' onclick='edit_dt("+item.id+")'><i class='fa fa-pencil'></i></button>&nbsp;<button style='width:30px;height:30px' class='btn btn-sm btn-danger btn-modif-kpi' onclick='delete_dt("+item.id+")'><i class='fa fa-trash'></i></button></td>"
                        +"</tr>"
                        );
                    } else if (tamp != item.category_id) {
                        $('#kpi > tbody:last-child').append
                        ("<tr>"
                            +"<td style='font-weight: bold; white-space: nowrap;'>Sub Total</td>"
                            +"<td>"+st_kpi_w+" %</td>"
                            +"<td></td>"
                            +"<td>"+st_kpi_ts+"</td>"
                            +"<td>"+st_kpi_tws.toFixed(2)+"</td>"
                            +"<td>"+st_kpi_as+"</td>"
                            +"<td>"+st_kpi_aws.toFixed(2)+"</td>"
                            +"<td>"+st_kpi_ds+"</td>"
                            +"<td>"+st_kpi_dws.toFixed(2)+"</td>"
                            +"<td colspan=2></td>"
                        +"</tr>"
                        );

                        cnt++;
                        gt_cat_w += (item.weight * 1);
                        gt_kpi_ts += (st_kpi_ts * 1);
                        gt_kpi_tws += (st_kpi_tws * 1);
                        gt_kpi_as += (st_kpi_as * 1);
                        gt_kpi_aws += (st_kpi_aws * 1);
                        gt_kpi_ds += (st_kpi_ds * 1);
                        gt_kpi_dws += (st_kpi_dws * 1);

                        st_kpi_w = 0;
                        st_kpi_ts = 0;
                        st_kpi_tws = 0;
                        st_kpi_as = 0;
                        st_kpi_aws = 0;
                        st_kpi_ds = 0;
                        st_kpi_dws = 0;

                        st_kpi_w += (item.kpi_weight * 1);
                        st_kpi_ts += (item.target_score * 1);
                        st_kpi_tws += (item.target_weight * 1);
                        st_kpi_as += (item.actual_score * 1);
                        st_kpi_aws += (item.actual_weight * 1);
                        st_kpi_ds += (item.adjust_score * 1);
                        st_kpi_dws += (item.adjust_weight * 1);

                        $('#kpi > tbody:last-child').append
                        ("<tr>"
                            +"<td rowspan="+(item.total * 1 + 1)+">"+cnt+"</td>"
                            +"<td rowspan="+(item.total * 1 + 1)+">"+item.category+"</td>"
                            +"<td rowspan="+(item.total * 1 + 1)+">"+item.weight+" %</td>"
                            +"<td>"+item.specific_kpi+"</td>"
                            +"<td>"+item.kpi_weight+" %</td>"
                            +"<td>"+item.scoring_method+"</td>"
                            +"<td>"+item.target_score+"</td>"
                            +"<td>"+item.target_weight+"</td>"
                            +"<td>"+item.actual_score+"</td>"
                            +"<td>"+item.actual_weight+"</td>"
                            +"<td>"+item.adjust_score+"</td>"
                            +"<td>"+item.adjust_weight+"</td>"
                            +"<td>"+item.remarks+"</td>"
                            +"<td><button style='width:30px;height:30px' class='btn btn-sm btn-primary btn-modif-kpi' onclick='edit_dt("+item.id+")'><i class='fa fa-pencil'></i></button>&nbsp;<button style='width:30px;height:30px' class='btn btn-sm btn-danger btn-modif-kpi' onclick='delete_dt("+item.id+")'><i class='fa fa-trash'></i></button></td>"
                        +"</tr>"
                        );
                    } else {
                        st_kpi_w += (item.kpi_weight * 1);
                        st_kpi_ts += (item.target_score * 1);
                        st_kpi_tws += (item.target_weight * 1);
                        st_kpi_as += (item.actual_score * 1);
                        st_kpi_aws += (item.actual_weight * 1);
                        st_kpi_ds += (item.adjust_score * 1);
                        st_kpi_dws += (item.adjust_weight * 1);

                        $('#kpi > tbody:last-child').append
                        ("<tr>"                            
                            +"<td>"+item.specific_kpi+"</td>"
                            +"<td>"+item.kpi_weight+" %</td>"
                            +"<td>"+item.scoring_method+"</td>"
                            +"<td>"+item.target_score+"</td>"
                            +"<td>"+item.target_weight+"</td>"
                            +"<td>"+item.actual_score+"</td>"
                            +"<td>"+item.actual_weight+"</td>"
                            +"<td>"+item.adjust_score+"</td>"
                            +"<td>"+item.adjust_weight+"</td>"
                            +"<td>"+item.remarks+"</td>"
                            +"<td><button style='width:30px;height:30px' class='btn btn-sm btn-primary btn-modif-kpi' onclick='edit_dt("+item.id+")'><i class='fa fa-pencil'></i></button>&nbsp;<button style='width:30px;height:30px' class='btn btn-sm btn-danger btn-modif-kpi' onclick='delete_dt("+item.id+")'><i class='fa fa-trash'></i></button></td>"
                        +"</tr>"
                        );
                    }
                    tamp = item.category_id;
                });

                $('#kpi > tbody:last-child').append
                ("<tr>"
                    +"<td style='font-weight: bold; white-space: nowrap;'>Sub Total</td>"
                    +"<td>"+st_kpi_w+" %</td>"
                    +"<td></td>"
                    +"<td>"+st_kpi_ts+"</td>"
                    +"<td>"+st_kpi_tws.toFixed(2)+"</td>"
                    +"<td>"+st_kpi_as+"</td>"
                    +"<td>"+st_kpi_aws.toFixed(2)+"</td>"
                    +"<td>"+st_kpi_ds+"</td>"
                    +"<td>"+st_kpi_dws.toFixed(2)+"</td>"
                    +"<td colspan=2></td>"
                +"</tr>"
                );

                gt_kpi_ts += (st_kpi_ts * 1);
                gt_kpi_tws += (st_kpi_tws * 1);
                gt_kpi_as += (st_kpi_as * 1);
                gt_kpi_aws += (st_kpi_aws * 1);
                gt_kpi_ds += (st_kpi_ds * 1);
                gt_kpi_dws += (st_kpi_dws * 1);

                $('#kpi > tbody:last-child').append
                ("<tr>"
                    +"<td style='font-weight: bold;' colspan=2>Total</td>"
                    +"<td>"+gt_cat_w+" %</td>"
                    +"<td colspan=3></td>"
                    +"<td>"+gt_kpi_ts+"</td>"
                    +"<td>"+gt_kpi_tws.toFixed(2)+"</td>"
                    +"<td>"+gt_kpi_as+"</td>"
                    +"<td>"+gt_kpi_aws.toFixed(2)+"</td>"
                    +"<td>"+gt_kpi_ds+"</td>"
                    +"<td>"+gt_kpi_dws.toFixed(2)+"</td>"
                    +"<td colspan=2></td>"
                +"</tr>"
                );

                if ($('#selector').val() == 3) {
                    $('.btn-modif-kpi').hide();
                } else {
                    $('.btn-modif-kpi').show();
                }
            }
        },
        error: function(m) {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function get_kpi_cat() {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.vendor = $('#vendor_id').val();
    $.ajax({
        url: "<?=base_url('procurement/cpm_development/get_kpi_cat')?>",
        data: obj,
        type: "POST",
        success: function(m) {
            if (m.length == 0) {
                $('#kpi_cat_list').html("<option value='0'><?php echo ($_SESSION['lang'] == 'IND' ? 'Maaf' : 'Sorry');?></option>");
            } else {
                $('#kpi_cat_list').html("");
                $.each(m, function(i,item) {
                    $('#kpi_cat_list').append("<option value='" + item.id + "'>" + item.category + "</option>");
                });
                $('#kpi_cat_list').attr("disabled", false);
            }
        },
        error: function(m) {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function edit_dt(id) {
    $('#modal_kpi_btn').html("<?= lang('Ubah', 'Edit') ?>");
    lang();
    var obj = {};
    obj.kpi = id;
    obj.po = $('#po_id').val();
    obj.vendor = $('#vendor_id').val();
    $.ajax({
        url: "<?= base_url('procurement/cpm_development/get_kpi_spec')?>",
        type: "POST",
        data: obj,
        success: function(m) {
            if(m.status) {
                msg_danger(m.msg, m.status);
            } else {
                $('#kpi_cat_list').html("");
                $.each(m.cat_list, function(i, item) {
                    if (item.id == m.category_id)
                        $('#kpi_cat_list').append("<option value='" + item.id + "' selected>" + item.category + "</option>");
                    else
                        $('#kpi_cat_list').append("<option value='" + item.id + "'>" + item.category + "</option>");
                });
                $('#kpi_cat_list').attr("disabled", true);
                $('#kpi_id').val(id);
                $('#kpi_spec').val(m.specific_kpi);
                $('#kpi_weight').val(m.kpi_weight);
                $('#kpi_method').val(m.scoring_method);
                $('#target_score').val(m.target_score);
                $('#kpi_title_add').hide();
                $('#kpi_title_edit').show();
                $('#kpi_weight_modal').modal('show');
            }
        },
        error: function() {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function delete_dt(id) {
    var obj = {};
    obj.id = id;
    $.ajax({
        url: "<?= base_url('procurement/cpm_development/delete_dt')?>",
        type: "POST",
        data: obj,
        success: function(m) {
            if(m.status == "Success") {
                msg_info("Data has been deleted", "Success");
                table_weight();
            } else
                msg_danger("Oops, something went wrong!", "Failed");
        },
        error: function() {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function delete_ul(id) {
    var obj = {};
    obj.id = id;
    obj.po = $('#po_id').val();
    $.ajax({
        url: "<?= base_url('procurement/cpm_development/delete_uploads')?>",
        type: "POST",
        data: obj,
        success: function(m) {
            if(m.status == "Success") {
                msg_info("Data has been deleted", "Success");
                get_upload();
            } else
                msg_danger("Oops, something went wrong!", "Failed");
        },
        error: function() {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function get_history() {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.vendor = $('#vendor_id').val();
    obj.phase = $('#phase_id').val();
    $('#log_table').DataTable().destroy();
    var tbl_log = $('#log_table').DataTable({
        ajax: {
            url: '<?= base_url('procurement/cpm_development/get_history')?>',
            type: "POST",
            data: obj,
            'dataSrc': function (json) {
                lang();
                return json;
            }
        },
        "selected": true,
        "paging": true,
        "columns": [
            {title:"No", data: [0]},
            {title:"<?= lang("Aksi", "Action") ?>", data: [1]},
            {title:"<?= lang("Catatan", "Note") ?>", data: [2]},
            {title:"<?= lang("Transaksi Pada", "Transaction At") ?>", data: [3]},
        ],
        "columnDefs": [
            {"className": "dt-center"},
            {"className": "dt-center"},
            {"className": "dt-center"},
            {"className": "dt-center"},
        ]
    });
}

function send_all(sel) {
    $('#check_list').modal('hide');
    swal({
        title: "<?php echo ($_SESSION['lang'] == 'IND' ? 'Apakah Anda Yakin?' : 'Are You Sure?')?>",
        text: "<?php echo ($_SESSION['lang'] == 'IND' ? 'Untuk mengirim data ini' : 'To submit this data')?>",
        type: "warning",
        showCancelButton: true,
        CancelButtonColor: "#DD6B55",
        confirmButtonColor: "#d9534f",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    }, function () {
        var elm = start($('.sweet-alert'));
        var obj = {};
        obj.po = $('#po_id').val();
        obj.vendor = $('#vendor_id').val();
        obj.selector = $('#selector').val();
        if (sel == 1) {
            $.ajax({
                type: 'POST',
                data: obj,
                url: '<?= base_url('procurement/cpm_development/send_all') ?>',
                success: function (msg) {
                    stop(elm);
                    swal(msg.msg, "", msg.status);
                    if (msg.status == "success")
                    {
                        $('#list1').DataTable().ajax.reload();
                        $('#list2').DataTable().ajax.reload();
                        main();
                    }
                    lang();
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    stop(elm);
                    msg_danger("Oops, something went wrong!", "Failed");
                }
            });
        } else if (sel == 2) {
            $.ajax({
                type: 'POST',
                data: obj,
                url: '<?= base_url('procurement/cpm_development/send_all_old') ?>',
                success: function (msg) {
                    stop(elm);
                    swal(msg.msg, "", msg.status);
                    if (msg.status == "success")
                    {
                        $('#list2').DataTable().ajax.reload();
                        main();
                    }
                    lang();
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    stop(elm);
                    msg_danger("Oops, something went wrong!", "Failed");
                }
            });
        } else {
            stop(elm);
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function send_notif(phase) {
    var obj = {};
        swal({
        title: "<?php echo ($_SESSION['lang'] == 'IND' ? 'Apakah Anda Yakin?' : 'Are You Sure?')?>",
        text: "<?php echo ($_SESSION['lang'] == 'IND' ? 'Untuk Mengirim Pemberitahuan' : 'To Send Notification')?>",
        type: "warning",
        showCancelButton: true,
        cancelButtonColor: "#DD6B55",
        cancelButtonText: "<?php echo ($_SESSION['lang'] == 'IND' ? 'Batal' : 'Cancel')?>",
        confirmButtonColor: "#d9534f",
        confirmButtonText: "<?php echo ($_SESSION['lang'] == 'IND' ? 'Kirim' : 'Send')?>",
        closeOnConfirm: false
    }, function () {
        var elm = start($('.sweet-alert'));
        var obj = {};
        obj.po = $('#po_id').val();
        obj.vendor = $('#vendor_id').val();
        obj.phase = phase;
        $.ajax({
            type: 'POST',
            data: obj,
            url: '<?= base_url('procurement/cpm_development/send_phase_notif') ?>',
            success: function (msg) {
                stop(elm);
                swal({
                    title: msg.status,
                    text: msg.msg
                });           
                get_schedule();
                lang();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                stop(elm);
                msg_danger("Oops, something went wrong!", "Failed");
            }
        });
    });
}

function sendit(sel) {
    var obj = {};
    obj.po = $('#po_id').val();
    mode = $("#selector").val();
    // $("#selector").val(sel);
    $.ajax({
        url: "<?=base_url("procurement/cpm_development/check_list")?>",
        data: obj,
        type: "POST",
        success: function(m) {
            var flag = 0;
            $('#check_list').modal('show');
            if (m.status)
                msg_danger("Oops, something went wrong!", "Failed");
            else {
                $('#list_body').html("");
                $.each(m, function(i, item) {
                    if (item.head.toLowerCase() == 'KPI'.toLowerCase() || item.head.toLowerCase() == 'Schedule'.toLowerCase()) {
                        if (item.filled == item.total && item.total > 0) {
                            $('#list > tbody:last-child').append(
                                "<tr>"
                                + "<td>" + (i + 1) + "</td>"
                                + "<td>" + item.head + "</td>"
                                + "<td>" + item.filled + ' / ' + item.total + "</td>"
                                + "<td class='text-center'><i class='fa fa-check success'></i></td></tr>"
                            );
                        } else {
                            flag = 1;
                            $('#list > tbody:last-child').append(
                                "<tr>"
                                + "<td>" + (i + 1) + "</td>"
                                + "<td>" + item.head + "</td>"
                                + "<td>" + item.filled + ' / ' + item.total + "</td>"
                                + "<td class='text-center'><i class='fa fa-close danger'></i></td></tr>"
                            );
                        }
                    } else if (item.total > 0) {
                        $('#list > tbody:last-child').append(
                            "<tr>"
                            + "<td>" + (i + 1) + "</td>"
                            + "<td>" + item.head + "</td>"
                            + "<td>" + item.total + "</td>"
                            + "<td class='text-center'><i class='fa fa-check success'></i></td></tr>"
                        );
                    } else {
                        flag = 1;
                        $('#list > tbody:last-child').append(
                            "<tr>"
                            + "<td>"+ (i + 1) + "</td>"
                            + "<td>"+ item.head + "</td>"
                            + "<td>"+ item.total + "</td>"
                            + "<td class='text-center'><i class='fa fa-close danger'></i></td></tr>"
                        );
                    }
                });
                if (flag === 0) {
                    $('#check_list').find('.modal-header').addClass('bg-success');
                    $('#check_list').find('.modal-header').removeClass('bg-danger');
                    if (mode == 1) {
                        $('#send_list_new').show();
                        $('#send_list_old').hide();
                    } else if (mode == 2) {
                        $('#send_list_new').hide();
                        $('#send_list_old').show();
                    } else {
                        $('#send_list_new').hide();
                        $('#send_list_old').hide();
                    }
                } else {
                    $('#check_list').find('.modal-header').removeClass('bg-success');
                    $('#check_list').find('.modal-header').addClass('bg-danger');
                    $('#send_list_new').hide();
                    $('#send_list_old').hide();
                }
            }
        },
        error: function(m) {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function get_approval() {
    var obj = {};
    obj.po = $('#po_id').val();    
    obj.vendor = $('#vendor_id').val();    
    $.ajax({
        url:'<?=base_url("procurement/cpm_development/get_user/1")?>',
        data: obj,
        type: 'POST',
        success: function (m) {
            if(m.status == 'Failed') {
                $('#CPM_approval').html("");
                $('#approval_user > tbody:last-child').append("<tr><td colspan='6'><?=($_SESSION['lang'] == 'IND' ? 'Tidak Ada Data' : 'No Data')?></td></tr>");
                $('#cpm_approve').modal('hide');
            } else {
                $('#CPM_approval').html("");
                cnt = 1;
                $.each(m, function(i, item) {
                    $('#approval_user > tbody:last-child').append("<tr><td>"+cnt+"</td><td>"+item.logon+"</td><td>"+item.name+"</td><td>"+item.dept+"</td><td>"+item.roles+"</td></tr>");
                    cnt++;
                });
                $('#cpm_approve').modal('hide');
            }
        },
        error:function(m) {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function choose_user(val,sel) {
    $('#user').html("");
    var obj = {};

    if (sel == 1) {
        obj.dept = val;
        obj.roles = $("#roles").val();
    } else {
        obj.roles = val;
        obj.dept = $('#dept').val();
    }

    $.ajax({
        url: '<?=base_url("procurement/cpm_development/get_user")?>',
        data: obj,
        type: 'POST',
        success: function(m) {
            if (m.status) {
                msg_danger(m.msg, m.status);
            } else {
                $('#user').html("");
                $.each(m, function(i, item) {
                     $('#user').append($('<option>', {
                        text: item.name,
                        value: item.id 
                    }));
                });
            }
        },
        error: function(m) {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    })
}

function add_phase()
{
    $('#add_planning').modal('show');
}

function main()
{
    $('#approval').DataTable().destroy();
    $('#main-content').show();
    $('#slides').hide();
}

function process(id, po, pid, sel) {
    window.index = 1;
    var obj = {};
    obj.po = po;
    obj.vendor = id;
    $.ajax({
        url: "<?=base_url('procurement/cpm_development/get_header_prepare')?>",
        type: "POST",
        data: obj,
        success: function(m){
            $('#comHead').html(m[0].comp);
            $('#titleHead').html(m[0].title);
            $('#venHead').html(m[0].vendor);
            $('#reqHead').html(m[0].req);
            $('#deptHead').html(m[0].dept);
            $('#cor_creator').html(m[0].cor_creator);
            $('#cor_role').html(m[0].cor_role);
        }
    });

    $("#selector").val(sel);
    $('#vendor_id').val(id);
    $('#phase_id').val(pid);
    $('#opHead').html(po);
    $('#po_id').val(po);
    $('.po_id').val(po);
    $('#main-content').hide();
    $('#slides').show();

    get_plan(start($('.card').find('.card-content')));
    table_weight();
    get_approval();
    get_upload();
    if (sel == 1) {
        $('#btn-history').hide();
        $('.btn-modif').show();
        $('#max_tab').val(4);
    } else if (sel == 2) {
        get_history();
        $('#btn-history').show();
        $('.btn-modif').show();
        $('#max_tab').val(5);
    } else {
        get_history();
        $('#btn-history').show();
        $('.btn-modif').hide();
        $('#max_tab').val(5);
    }
    choose(1);
    lang();
}

function get_plan(elm) {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.pid = $('#phase_id').val();
    $.ajax({
        url: "<?=base_url('procurement/cpm_development/get_plan')?>",
        type: "POST",
        data: obj,
        success: function(m) {
            if(!m.status) {
                $('#cpm_planning').html(m);
                get_schedule(elm);
            } else {
                stop(elm);
            }
        },
        error: function(m) {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function get_schedule(elm, pid) {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.pid = $('#phase_id').val();
    $.ajax({
        url: "<?=base_url('procurement/cpm_development/get_schedule')?>",
        type: "POST",
        data: obj,
        success: function(m) {
            if (!m.status) {
                $('#cpm_remainder').html(m);
                lang();
            }
            stop(elm);
        },
        error: function(m) {
            stop(elm);
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function get_upload() {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.sel = $("#selector").val();
    var table = $('#attch').DataTable({
    ajax: {
        type: "POST",
        data: obj,
        url: '<?= base_url('procurement/cpm_development/get_upload') ?>',
        'dataSrc': function (json) {
            lang();
            return json;
        }
    },
    "destroy": true,
    "scrollX": true,
    "selected": true,
    "scrollY": "300px",
    "scrollCollapse": true,
    "paging": false,
    "columns": [
        {title: "<?=lang("No", "No")?>"},
        // {title: "<?=lang("Tipe", "Type")?>"},
        {title: "<?=lang("Nama File", "File Name")?>"},
        {title: "<?=lang("Diupload Pada", "Upload At")?>"},
        {title: "<?=lang("Pengunggah", "Uploader")?>"},
        {title: "<?= lang("Aksi", "Action") ?>"},
    ],
    "columnDefs": [
        {"className": "dt-center", "targets": [0]},
        {"className": "dt-center", "targets": [1]},
        {"className": "dt-center", "targets": [2]},
        {"className": "dt-center", "targets": [3]},
        {"className": "dt-center", "targets": [4]},
        // {"className": "dt-center", "targets": [5]},
    ]
    });
}

function display(index) {
    var i = 1;
    for (i = 1; i <= 5; i++) {
        if (i == index) {
            $('#main-p-'+index).show();
            $('#main-b-'+index).addClass("current");
        } else {
            $('#main-p-'+i).hide();
            $('#main-b-'+i).removeClass("current");
        }
    }
    var addr = "";
    var dt = "";
    $('form :input').prop('disabled',false);
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
}

function choose(sel) {
    index = sel;
    display(sel);
}

function add_kpicategory() {
    $('#cat_weight_modal').modal('show');
}

function add_kpi() {
    get_kpi_cat();
    $('#kpi_id').val(0);
    $('#kpi_spec').val('');
    $('#kpi_weight').val('');
    $('#kpi_method').val('');
    $('#target_score').val('');
    $('#kpi_title_add').show();
    $('#kpi_title_edit').hide();
    $('#modal_kpi_btn').html("<?= lang('Tambah', 'Add') ?>");
    lang();
    $('#kpi_weight_modal').modal('show');
}

function add_user() {
    choose_user('<?=$dept[0]->ID_DEPARTMENT?>', 1);
    $('#cpm_approve').modal('show');
}

function reset_user() {
    var obj = {};
        swal({
        title: "<?php echo ($_SESSION['lang'] == 'IND' ? 'Apakah Anda Yakin?' : 'Are You Sure?')?>",
        text: "<?php echo ($_SESSION['lang'] == 'IND' ? 'Untuk Mengulang Daftar' : 'To Reset List')?>",
        type: "warning",
        showCancelButton: true,
        cancelButtonColor: "#DD6B55",
        cancelButtonText: "<?php echo ($_SESSION['lang'] == 'IND' ? 'Batal' : 'Cancel')?>",
        confirmButtonColor: "#d9534f",
        confirmButtonText: "<?php echo ($_SESSION['lang'] == 'IND' ? 'Proses' : 'Process')?>",
        closeOnConfirm: true
    }, function () {
        var elm = start($('.sweet-alert'));
        var obj = {};
        obj.vendor = $('#vendor_id').val();
        obj.po = $('#po_id').val();
        $.ajax({
            url: "<?= base_url('procurement/cpm_development/reset_approval')?>",
            type: "POST",
            data: obj,
            success: function(m) {
                stop(elm);
                if(m.status == "Success"){
                    msg_info(m.msg, m.status);
                    get_approval();
                } else {
                    msg_danger(m.msg, m.status);
                }
            },
            error: function() {
                stop(elm);
                msg_danger("Oops, something went wrong!", "Failed");
            }
        });
    });
}

function modal_upload() {
    $('#upload_file').modal('show');
}
</script>
