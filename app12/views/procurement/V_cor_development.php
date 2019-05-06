<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">        
        </div>
        <?php if ($init_from_cpm == 2) { ?>
        <h3 id="cor_title1" class="content-header-title"><?=lang("Persiapan COR CPM", "COR CPM Preparation")?> </h3>
        <h3 id="cor_title2" class="content-header-title" style="display: none;"><?=lang("Progres COR CPM", "COR CPM On Progress")?></h3>
        <?php } else { ?>
        <h3 id="cor_title1" class="content-header-title"><?=lang("Persiapan COR", "COR Preparation")?> </h3>
        <h3 id="cor_title2" class="content-header-title" style="display: none;"><?=lang("Progres COR", "COR On Progress")?></h3>
        <?php } ?>
        <div class="content-detached">        
            <div class="content-body" id="main-content">
                <section>
                    <div class="card">
                        <div class="card-header">                        
                            <div class="row ">
                                <div class="col-sm-8"> 
                                </div>
                                <div class="col-sm-4 pull-right text-right">
                                    <button id="cor_btn1" class="btn btn-primary" onclick="show_approval()" style="display: none;">
                                        <i class="fa fa-exchange"></i>
                                        <?php if ($init_from_cpm == 2) { ?>
                                        <?=lang("Persiapan COR CPM", "COR CPM Preparation")?>
                                        <?php } else { ?>
                                        <?=lang("Persiapan COR", "COR Preparation")?>
                                        <?php } ?>
                                    </button>
                                    <button id="cor_btn2" class="btn btn-primary" onclick="show_list()">
                                        <i class="fa fa-exchange"></i>
                                        <?php if ($init_from_cpm == 2) { ?>
                                        <?=lang("Progres COR CPM", "COR CPM On Progress")?>
                                        <?php } else { ?>
                                        <?=lang("Progres COR", "COR On Progress")?>
                                        <?php } ?>
                                    </button>
                                </div>
                            </div>                 
                        </div>
                        <div class="card-body">
                            <div class="col-12 form-row approval">
                                <table id="list" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                </table>
                            </div>
                            <div class="col-12 form-row addlist">
                                <table id="list2" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="content-body" id="slides" style="display: none;">
    			<div class="row info-header">
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <table class="table table-condensed">
                            <tr>
                                <td width="30%">Point</td>
                                <td class="no-padding-lr">:</td>
                                <td><strong><span id="poin">0</span><span id="pembagi">/72</span></strong></td>
                            </tr>
                            <tr>
                                <td width="30%">Score</td>
                                <td class="no-padding-lr">:</td>
                                <td><strong><span id="scoring">0</span></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <section>
                    <div class="card">
                         
                        <div class="card-content card-scroll"> 
							
							<div class="card-body body-step" >
                                <div class="col-12 form-row x-tab" id="project-info">  
                                <input type="text" style="display:none" id="max_tab"/>
								<div class="steps clearfix">
                                    <ul role="tablist" class="tablist">
										<li >
											<button onclick="choose(1)" id="main-b-1" class="project-info-icon btn btn-default current">
												<i class="fa fa-file-text"></i>
												COR Form
											</button>
										</li>
										<li>
											<button onclick="choose(2)" id="main-b-2" class="project-info-icon btn btn-default">
												<i class="fa fa-info"></i>   
												Point	
											</button>
										</li>
                                        <li>
                                            <button onclick="choose(3)" id="main-b-3" class="project-info-icon btn btn-default">
                                                <i class="fa fa-paperclip"></i>
                                                Attachment
                                            </button>
                                        </li>
                                        <li id="btn-history">
                                            <button onclick="choose(4)" id="main-b-4" class="project-info-icon btn btn-default">
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
                                        <div class="col-md-12 text-center">
                                            <h5><strong>CLOSE OUT REPORT FORM</strong></h5>
                                        </div>                           
                                        <div class="row mt-2">
                                            <div class="col-sm-2">
                                                <label>In this day, date</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label id='createDate'>: <?= date('d F Y')?></label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Original Amount</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label id='origAmount'>: 0</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Partial</label>
                                            </div>
                                            <div class="col-sm-2" id="stat_partial">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label>MSR No.</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label id="msrNo">: </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Final Amount</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label id="finAmount">: 0 </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>LD/Penalty Enforcement</label>
                                            </div>
                                            <div class="col-sm-2" id="stat_penalty">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label>Agreement No.</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label id="agreement">: </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label id="compAmountTitle">Agreement Completion Amount</label>
                                            </div>
                                            <div class="col-sm-2" id="compAmount">
                                            </div>
                                            <div class="col-sm-2">
                                                <label>LD/Penalty Amount</label>
                                            </div>
                                            <div class="col-sm-2" id="penAmount">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label>Agreement Type</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label id="agreementType">: Purchase Order</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Scheduled Delivery Date</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label id="dateDeliv">: </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label></label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label></label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label></label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Actual Delivery Date</label>
                                            </div>
                                            <div class="col-sm-2" id="stat_date">
                                            </div>
                                            <div class="col-sm-2">
                                                <label></label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="approval_table">
                                                <table id="approval" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                                </table>
                                            </div>
                                            <div class="assignee">
                                                <form id="form_asigned" novalidate="novalidate">
                                                    <input type="text" style="display:none" name="vendor_id" id="vendor_id"/>
                                                    <input type="text" style="display:none" name="po_id" id="po_id"/>
                                                    <input type="text" style="display:none" name="cor_id" id="cor_id"/>
                                                    <table class="mt-1 table table-striped table-bordered table-hover display text-center" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th><?= lang("Kondisi", "Condition") ?></th>
                                                                <th><?= lang("Dikonfirmasi Oleh", "Confirmed By") ?></th>
                                                                <th><?= lang("Jabatan", "Role") ?></th>
                                                                <th><?= lang("Status Konfirmasi", "Confirmation Status") ?></th>
                                                                <th><?= lang("Tanggal", "Date") ?></th>            
                                                                <th><?= lang("Catatan", "Remark") ?></th>                        
                                                            </tr>
                                                        </thead>
                                                        <tbody id="data_approval">                                        
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="main-p-2">                                
                                    <div id="main-c-2">
                                        <div id="from_cpm" style="display: none;"></div>
                                        <form id="point_data" class="form-horizontal" novalidate="novalidate">
                                            <div id="header_tkdn_text" style="padding-bottom: 1em; display: none;">
                                                <div>Achievment for Local content:</div>
                                                <div>As per Contract Document <span id="text_contract_cpm"></span> %</div>
                                                <div>Actual Achievement <span id="text_actual_cpm"></span> %</div>
                                            </div>
                                            <table id="performance" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                                <thead id="perf_header">
                                                </thead>
                                                <tbody id="data" class="text-justify">
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>                            
                                <div class="col-12" id="main-p-3">
                                    <div id="main-c-3">
                                        <h3><?=lang("Lampiran", "Attachment")?></h3>
                                        <table id="attch" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                        </table>
                                        <div class="pull-right">
                                            <button onclick="modal_upload()" class="btn btn-primary btn-modif">Upload File</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="main-p-4">
                                    <div id="main-c-4">
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
                                    <div class="col-2">
                                        <button class="btn btn-default" id="min"><i class="fa fa-arrow-left"></i></button>
                                        <button class="btn btn-default" id="plus"><i class="fa fa-arrow-right"></i></button>
                                    </div>
                                    <div class="col-10 text-right">
                                        <button class="btn btn-success send-new" onclick="send_data(1)"><?=lang("Kirim","Submit")?></button>
                                        <button class="btn btn-success send-old" onclick="resub_note()"><?=lang("Kirim","Submit")?></button>
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
<div id="upload_file" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form id="file_upload" class="modal-content" action="javascript:;" enctype="multipart/form-data">
            <div class="modal-header bg-primary white">
                <h4 class="edit-title"> <?= lang("Unggah File", "Upload File") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div style="display:none" id="ul_type"></div>
                        <input type="text" style="display:none" name="po_id" class="po_id"/>
                        <div class="form-group controls col-md-12">
                            <label class="control-label" for="file_unggah_tipe"><?= lang("Tipe Dokumen", "Document Type") ?></label>
                            <select name="file_unggah_tipe" id="file_unggah_tipe" class="form-control" required>
                                <option value>Please Select</option>
                                <option value="other">Other</option>
                                <option value="memo">Memo</option>
                            </select>
                        </div>
                        <div class="form-group controls col-md-12">
                            <label class="control-label" for="file_unggah"><?= lang("Pilih File", "Choose File") ?></label>
                            <input type="file" name="file_unggah" id="file_unggah" class="form-control" required>
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
<div id="modal_preview" class="modal fade bs-example-modal-lg" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg" role="document">
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
<div id="modal_resubmit" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class="modal-content" id="resubmit_form_modal">
            <div class="modal-header bg-success white">
                <?= lang("Balasan", "Response") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="field-1-note"><?= lang("Catatan", "Note") ?></label>
                            <label id="label_kirim" class="control-label" for="field-1-note" style="color:rgb(217, 83, 79)">*</label>
                            <textarea placeholder="Fill in your response" id="field-1-note" class="form-control note" rows="5" name="note" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-success send-old-note"><?= lang("Kirim", "Submit") ?></button>
            </div>
        </form>
    </div>
</div>

<script src="<?= base_url('ast11/assets/js/accounting.js/accounting.js') ?>"></script>
<script>
    var tabel2;
$(function(){                 
    lang();
    var obj_setup = {};
    obj_setup.init_from_cpm = <?= $init_from_cpm;?>;
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
    var tabel = $('#list').DataTable({        
        ajax: {
            type: "POST",
            data: obj_setup,
            url: '<?= base_url('procurement/cor_development/get_list_prepared/') ?>',
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
            {title:"<?= lang("Tipe", "Type") ?>"},
            {title:"<?= lang("Pekerjaan", "Subject") ?>"},
            {title:"<?= lang("Perusahaan", "Company") ?>"},
            {title:"<?= lang("Supplier", "Vendor") ?>"},            
            {title:"<?= lang("Mata Uang", "Currency") ?>"},
            {title:"<?= lang("Nilai", "Value") ?>", render : function(data) {
                    return accounting.formatMoney(data);
                }},
            {title:"<?= lang("Tanggal Mulai", "Validity Start") ?>"},
            {title:"<?= lang("Tanggal Selesai", "Validity End") ?>"},
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
        ] 
    });
    $('#list tbody').on('click', 'tr .process', function () {
        var data2 = tabel.row($(this).parents('tr')).data();
        $('.send-old').hide();
        $('.send-new').show();
        $('#agreement').html(": "+data2[1]);
        $('#opHead').html(data2[1]);
        $('#from_cpm').html('1');
        $('#po_id').val(data2[1]);
        $('.po_id').val(data2[1]);
        $('#cor_id').val('');
        $('#vendor_id').val(this.id);
        var obj = {};
        obj.po = data2[1];
        obj.vendor = this.id;
        $.ajax({
            url: "<?=base_url('procurement/cor_development/get_header_prepare')?>",
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
                $('#msrNo').html(": "+m[0].msr_no);
                $('#agreementType').html(": "+m[0].po_type);
                $('#createDate').html(': '+m[0].createdate);
                $('#origAmount').html(': '+accounting.formatMoney(m[0].total_amount_base));
                $('#finAmount').html(': '+accounting.formatMoney(m[0].total_amount_base));
                $('#compAmountTitle').html(m[0].po_type == 'Service Order' ? 'Agreement Completion Amount' : 'PO Completion Amount');
                $('#dateDeliv').html(': '+m[0].delivery_date);
            }
        });
        $('#btn-history').hide();
        $('#max_tab').val(3);
        $('#ul_type').html(1);
        get_upload();
        process(1);
        // $(".approval_table").hide();
        $(".assignee").show();
        get_data_assigned(this.id, data2[1]);
    });
    $('#list tbody').on('click', 'tr .process-cpm', function () {
        var data2 = tabel.row($(this).parents('tr')).data();
        $('.send-old').hide();
        $('.send-new').show();
        $('#agreement').html(": "+data2[1]);
        $('#opHead').html(data2[1]);
        $('#from_cpm').html('2');
        $('#po_id').val(data2[1]);
        $('.po_id').val(data2[1]);
        $('#cor_id').val('');
        $('#vendor_id').val(this.id);
        var obj = {};
        obj.po = data2[1];
        obj.vendor = this.id;
        $.ajax({
            url: "<?=base_url('procurement/cor_development/get_header_prepare')?>",
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
                $('#msrNo').html(": "+m[0].msr_no);
                $('#agreementType').html(": "+m[0].po_type);
                $('#createDate').html(': '+m[0].createdate);
                $('#origAmount').html(': '+accounting.formatMoney(m[0].total_amount_base));
                $('#finAmount').html(': '+accounting.formatMoney(m[0].total_amount_base));
                $('#compAmountTitle').html(m[0].po_type == 'Service Order' ? 'Agreement Completion Amount' : 'PO Completion Amount');
                $('#dateDeliv').html(': '+m[0].delivery_date);
            }
        });
        $('#btn-history').hide();
        $('#max_tab').val(3);
        $('#ul_type').html(1);
        get_upload();
        process(1);
        // $(".approval_table").hide();
        $(".assignee").show();
        get_data_assigned(this.id, data2[1]);
    });
    
    tabel2 = $('#list2').DataTable({        
        ajax: {
            type: "POST",
            data: obj_setup,
            url: '<?= base_url('procurement/cor_development/get_list_progress/') ?>',
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
            {title:"<?= lang("Tipe", "Type") ?>"},
            {title:"<?= lang("Dari CPM", "From CPM") ?>", render : function(data) {
                    if (data == 2)
                        return 'Yes';
                    else
                        return 'No';
                }},
            {title:"<?= lang("No COR", "COR Number") ?>"},
            {title:"<?= lang("Pekerjaan", "Subject") ?>"},
            {title:"<?= lang("Jabatan", "Role") ?>"},
            {title:"<?= lang("Status", "Status") ?>"},
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
        ] 
    });
    $('#list2 tbody').on('click', 'tr .process', function () {
        var data2 = tabel2.row($(this).parents('tr')).data();
        var sel = 2;
        $('.send-new').hide();
        $('.send-old').hide();
        $('#agreement').html(": "+data2[1]);
        $('#opHead').html(data2[1]);
        $('#from_cpm').html(data2[3]);
        $('#vendor_id').val(this.id);
        $('#po_id').val(data2[1]);
        $('.po_id').val(data2[1]);
        $('#cor_id').val(data2[4]);
        $('.idS').val(this.id);           
        $('.seq').val(this.name);   
        // $(".approval_table").show();
        $(".assignee").show();
        var obj = {};
        obj.po = data2[1];
        obj.vendor = this.id;
        $.ajax({
            url: "<?=base_url('procurement/cor_development/get_header_progress')?>",
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
                $('#msrNo').html(": "+m[0].msr_no);
                $('#agreementType').html(": "+m[0].po_type);
                $('#createDate').html(': '+m[0].createdate);
                $('#origAmount').html(': '+accounting.formatMoney(m[0].total_amount_base));
                $('#finAmount').html(': '+accounting.formatMoney(m[0].total_amount_base));
                $('#compAmountTitle').html(m[0].po_type == 'Purchase Order' ? 'PO Completion Amount' : 'Agreement Completion Amount');
                $('#dateDeliv').html(': '+m[0].delivery_date);
            }
        });
        get_history();
        $('#btn-history').show();
        $('#max_tab').val(4);
        if (data2[7] == "<span class='badge badge badge-pill badge-danger'>Rejected</span>") {
            $('#ul_type').html(2);
            get_upload();
            check_maker(this.id);
        } else {
            $('#ul_type').html(3);
            get_upload();
            process(2);
            tbl(this.id, data2[4], 2);
        }
    });
    $('#file_upload').submit(function (){
        var formData = new FormData($('#file_upload')[0]);
        var elm = start($('#upload_file').find('.modal-content'))
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('procurement/cor_development/upload_file'); ?>",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (m) {
                if (m.status === "Success") {
                    $('#upload_file').modal('hide');
                    $('#attch').DataTable().ajax.reload();
                    msg_info(m.msg, m.status);
                } else {
                    msg_danger(m.msg, m.status);
                }
                stop(elm);
            },
            error: function(m) {
                stop(elm);
                msg_danger("Oops, something went wrong!", "Failed");
            }
        });
    });
    $('#modal_resubmit').submit(function(e) {
        e.preventDefault();
        send_data(2);
    });
    
    show_approval();
    $('#slides').hide();
    $('#min').click(function (){
        if(index==1)
            index=1;
        else
            index--;
        display(index);
    });
    $('#plus').click(function (){
        if (index == $('#max_tab').val())
            index = $('#max_tab').val();
        else
            index++;
        display(index);
    });        
});

function check_maker(id) {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.cor = $('#cor_id').val();
    $.ajax({
        url: "<?=base_url('procurement/cor_development/check_maker')?>",
        type: "POST",
        data: obj,
        success: function(m) {
            process(2);
            if (m) {
                $('.send-old').show();
                tbl(id, $('#cor_id').val(), 1); 
            } else {
                tbl(id, $('#cor_id').val(), 2); 
            }
        }
    });
}

function show_approval() {
    $('#cor_btn1').hide();
    $('#cor_btn2').show();
    $('#cor_title1').show();
    $('#cor_title2').hide();
    $('#cor_title1_sub').show();
    $('#cor_title2_sub').hide();
    $('.approval').show();
    $('.addlist').hide();
}

function show_list() {
    $('#cor_btn1').show();
    $('#cor_btn2').hide();
    $('#cor_title1').hide();
    $('#cor_title2').show();
    $('#cor_title1_sub').hide();
    $('#cor_title2_sub').show();
    $('.approval').hide();
    $('.addlist').show();
    tabel2.columns.adjust();
}

function modal_upload() {
    $('#upload_file').modal('show');
}

function main() {
    $('#attch').DataTable().destroy();
    $('#main-content').show();
    $('#slides').hide();
}

function process(sel) {
    window.index = 1;
    init(sel);
    $('#main-content').hide();
    $('#slides').show();
    lang();
}

function display(index) {
    var i = 1;
    for(i = 1; i <= 4; i++) {
        if(i == index) {
            $('#main-p-'+index).show();
            $('#main-b-'+index).addClass("current");
        } else {
            $('#main-p-'+i).hide();
            $('#main-b-'+i).removeClass("current");
        }
    }
    var addr = "";
    var dt = "";
    // $('form :input').prop('disabled',false);
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
}

function choose_user(usr,seq,po,entid,sel)
{
    var elm=start($("#form_asigned"));
    var obj={};
    obj.usr=usr;
    obj.seq=seq;
    obj.po=po;
    obj.entid=entid;
    obj.sel=sel;
    $.ajax({
        type:'POST',
        url: '<?=base_url('procurement/cor_development/update_user')?>',
        data:obj,        
        success:function (m)
        {
            if(m.status == "Success")
                msg_info("Data has been saved!", "Success");
            else
                msg_danger("Oops, something went wrong!", "Failed");
            stop(elm);
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            msg_danger("Oops, something went wrong!", "Failed");
            stop(elm);
        }
    });
}

function get_upload() {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.sel = $('#ul_type').html();
    if (obj.sel == '1' || obj.sel == '2') {
        $('.btn-modif').show();
    } else {
        $('.btn-modif').hide();
    }
    var table = $('#attch').DataTable({
    ajax: {
        type: "POST",
        data: obj,
        url: '<?= base_url('procurement/cor_development/get_upload') ?>',
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
        {title: "<?=lang("Tipe", "Type")?>"},
        {title: "<?=lang("Nama File", "File Name")?>"},
        {title: "<?=lang("Diupload Pada", "Upload At")?>"},
        {title: "<?=lang("Pengunggah", "Uploader")?>"},
        {title: "<?=lang("Aksi", "Action") ?>"},
    ],
    "columnDefs": [
        {"className": "dt-center", "targets": [0]},
        {"className": "dt-center", "targets": [1]},
        {"className": "dt-center", "targets": [2]},
        {"className": "dt-center", "targets": [3]},
        {"className": "dt-center", "targets": [4]},
        {"className": "dt-center", "targets": [5]},
    ]
    });
}

function preview(path) {
    $('#ref').attr('src',"<?= base_url()?>"+path);
    var words = path.split('.');
    if (words[words.length - 1] == 'pdf')
        $('#modal_preview').modal('show');
}

function delete_ul(id) {
    var obj = {};
    obj.id = id;
    obj.po = $('#po_id').val();
    $.ajax({
        url: "<?= base_url('procurement/cor_development/delete_uploads')?>",
        type: "POST",
        data: obj,
        success: function(m) {
            if(m.status == "Success") {
                msg_info("Data has been deleted", "Success");
                $('#attch').DataTable().destroy();
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
    obj.cor = $('#cor_id').val();
    obj.vendor = $('#vendor_id').val();
    $('#log_table').DataTable().destroy();
    var tbl_log = $('#log_table').DataTable({
        ajax: {
            url: '<?= base_url('procurement/cor_development/get_history')?>',
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

function resub_note() {
    $('#modal_resubmit').modal('show');
}

function send_data(sel) {
    var obj = $("#form_asigned").serializeArray();
    obj.push({name: 'from_cpm', value: $('#from_cpm').html()});
    if (sel == 2) {
        obj.push({name: 'note', value: $('#field-1-note').val()});
    }

    $('.send-old-note').prop('disabled', true);
    $('.send-new').prop('disabled', true);

    var comp = 1;
    $('[id^=user]').each(function() {
        if ($(this).val().indexOf("0_") >= 0) {
            comp = 0;
            return false;
        }
    });

    if (comp == 0) {
        msg_danger("Sorry, there are unchosen assignees!", "Failed");
        $('.send-old-note').prop('disabled', false);
        $('.send-new').prop('disabled', false);
    } else {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('procurement/cor_development/send_data/') ?>' + sel,
            data: obj,
            success: function(m) {
                if (m.status == "Success") {
                    msg_info(m.msg, m.status);
                    $('#list2').DataTable().ajax.reload();
                    $('#list').DataTable().ajax.reload();
                    if (sel == 2) {
                        $('#modal_resubmit').modal('hide');
                    }
                    $('.send-old-note').prop('disabled', false);
                    $('.send-new').prop('disabled', false);
                    // $('#approval').DataTable().destroy();
                    main();
                } else {
                    msg_danger(m.msg, m.status);
                    $('.send-old-note').prop('disabled', false);
                    $('.send-new').prop('disabled', false);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                msg_danger("Oops, something went wrong!", "Failed");
                $('.send-old-note').prop('disabled', false);
                $('.send-new').prop('disabled', false);
            }
        });
    }
}

function init(sel) {
    var obj = {};
    if (sel == 2) {
        obj.id = $('#vendor_id').val();
        // tbl($('#vendor_id').val());
    }
    obj.from_cpm = $('#from_cpm').html();
    if (obj.from_cpm == 2) {
        $('#perf_header')
        .html('<tr>'
                    +'<th rowspan="2">No</th>'
                    +'<th rowspan="2">Specific KPI</th>'
                    +'<th rowspan="2">KPI Weight</th>'
                    +'<th rowspan="2">Scoring Methodology</th>'
                    +'<th colspan="2">Target</th>'
                    +'<th colspan="2">Performance Rating</th>'
                +'</tr>'
                +'<tr>'
                    +'<th>Score</th>'
                    +'<th>Weight</th>'
                    +'<th>Score</th>'
                    +'<th>Weight</th>'
                +'</tr>');
    } else {
        $('#perf_header')
        .html('<tr>'
                    +'<th rowspan="2">No</th>'
                    +'<th rowspan="2">Performance Category</th>'
                    +'<th colspan="4">Performance Rating</th>'
                    +'<th rowspan="2">Total Score</th>'
                +'</tr>'
                +'<tr>'
                    +'<th>1<br/>Poor</th>'
                    +'<th>2<br/>Fair</th>'
                    +'<th>3<br/>Good</th>'
                    +'<th>4<br/>Excellent</th>'
                +'</tr>');
    }

    $.ajax({
        type: 'POST',
        url: '<?= base_url('procurement/cor_development/get_performance_q/') ?>' + sel + '/' + $('#po_id').val(),
        data: obj,
        success: function(m) {
            $('#data').html(m);
            if (obj.from_cpm == 2) {
                $('#header_tkdn_text').show();
                $('#text_actual_cpm').html(accounting.format($('#cina').html()));
                $('#text_contract_cpm').html(accounting.format($('#cinc').html()));
                pt_dec = 2;
            } else {
                $('#header_tkdn_text').hide();
                pt_dec = 0;
            }
            $('[name="inp_weight"]').each(function() {
                $(this).html(accounting.format($(this).html()));
            });
            if (sel != 2) {
                $('#poin').html(accounting.format('0', pt_dec));
                if (obj.from_cpm == 2) {
                    var tot = $('#cpmttl').html();
                    $('#pembagi').html('/' + accounting.format(tot, pt_dec));
                    $('#scoring').html(accounting.format('Not Yet'));
                } else {
                    var tot = $('input[name="total"]').val();
                    tot *= 4;
                    $('#pembagi').html('/' + accounting.format(tot, pt_dec));
                    $('#scoring').html(accounting.format('0'));
                }
                $('#compAmount').html('<label>: '+accounting.formatMoney('0')+'</label>');
                $('#penAmount').html('<label>: '+accounting.formatMoney('0')+'</label>');
                $('#stat_date').html('<label>: </label>');
                $('#stat_partial').html('<input type="checkbox" id="check_partial" disabled/>');
                $('#stat_penalty').html('<input type="checkbox" id="check_penalty" disabled/>');
                // $('#stat_partial').html('<label>: Yes/No</label>');
                // $('#stat_penalty').html('<label>: Yes/No</label>');
            } else {
                var nilai = $('#total_nilai').val();
                $('#poin').html(accounting.format(nilai, pt_dec));
                if (obj.from_cpm == 2) {
                    var tot = $('#cpmttl').html();
                    $('#pembagi').html('/' + accounting.format(tot, pt_dec));
                    var res = nilai / tot * 100;
                    var rank = JSON.parse('<?= json_encode($cpm_rank); ?>');
                    for (var i = 0; i < rank.length; i++) {
                        if (nilai > rank[i]['value']) {
                            $('#scoring').html(rank[i]['description']);
                            break;
                        }
                    }
                } else {
                    var tot = $('input[name="total"]').val();
                    tot *= 4;
                    $('#pembagi').html('/' + accounting.format(tot, pt_dec));
                    var res = nilai / tot * 100;
                    $('#scoring').html(accounting.format(res));
                }
                $('#compAmount').html('<label>: ' + accounting.formatMoney($("#coma").html()) + '</label>');
                $('#penAmount').html('<label>: ' + accounting.formatMoney($("#pena").html()) + '</label>');
                $('#stat_date').html('<label>: ' + $("#actd").html() + '</label>');
                $('#stat_partial').html('<input type="checkbox" id="check_partial" ' + ($("#cpar").html() == "1" ? "checked" : "") + ' disabled/>');
                $('#stat_penalty').html('<input type="checkbox" id="check_penalty" ' + ($("#cpen").html() == "1" ? "checked" : "") + ' disabled/>');
                // $('#stat_partial').html('<label>: ' + ($("#cpar").html() == "1" ? "Yes" : "No") + '</label>');
                // $('#stat_penalty').html('<label>: ' + ($("#cpen").html() == "1" ? "Yes" : "No") + '</label>');
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
    choose(1);
}

function choose(sel)
{
    index=sel;
    display(sel);
}

function get_data_assigned(id,po) {
    var obj = {};
    $.ajax({
        type: 'POST',
        url: '<?= base_url('procurement/cor_development/get_data_assigned/') ?>'+id+'/'+po,
        success: function (m) {
            if(m.status != false)
                $("#data_approval").html(m);
        }
    });
}

function tbl(id, cor, sel) {
    var obj = {};
    obj.id = id;
    obj.cor = cor;
    obj.po = $('#po_id').val();
    obj.sel = sel;
    $.ajax({
        type: 'POST',
        url: '<?= base_url('procurement/cor_development/show_app') ?>',
        data: obj,
        success: function (m) {
            if(m.status != false)
                $("#data_approval").html(m);
        }
    });
}
</script>
