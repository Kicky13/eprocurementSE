<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">        
        </div>
		<h3 class="content-header-title"><?=lang("COR Terverifikasi","Verified COR")?></h3>
        <div class="content-detached">        
            <div class="content-body" id="main-content">
                <section>
                    <div class="card">
                        <div class="card-header">                        
                            <div class="row">
                                <div class="col-sm-8">     
                                </div>
                                <div class="col-sm-4 pull-right text-right">                                    
                                </div>           
                            </div>                 
                        </div>
                        <div class="card-body">                            
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
                                            <button onclick="choose(3)" id="main-b-3" class="project-info-icon btn btn-default" >
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
                                            <table id="approval" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="main-p-2">                                
                                    <div id="main-c-2">
                                        <div id="from_cpm" style="display: none;"></div>
                                        <form id="point_data" class="form-horizontal" novalidate="novalidate">
                                            <input type="text" style="display:none" name="idvendor" id="idvendor"/>
                                            <input type="text" style="display:none" name="msr_id" id="msr_id"/>
                                            <input type="text" style="display:none" name="cor_id" id="cor_id"/>
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
                                        <h3><?=lang("Lampiran","Attachment")?></h3>
                                        <table id="attch" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                        </table>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
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
    var tabel2 = $('#list2').DataTable({        
        ajax: {
            url: '<?= base_url('procurement/cor_finished/get_list2/') ?>',
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
            {title:"<?= lang("Penilaian Penyedia", "Supplier Rating") ?>", render: function(data) {
                if (isNaN(data))
                    return data;
                else
                    return accounting.format(data);
            }},
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
        $('.app').show();
        $('.rej').show();
        $('#agreement').html(": "+data2[1]);
        $('#from_cpm').html(data2[3]);
        $('#opHead').html(data2[1]);
        $('#idvendor').val(this.id);
        $('#msr_id').val(data2[1]);
        $('#cor_id').val(data2[4]);
        $('.idS').val(this.id);
        $('.seq').val(this.name);
        var obj = {};
        obj.po = data2[1];
        obj.vendor = this.id;
        $.ajax({
            url: "<?=base_url('procurement/cor_finished/get_header')?>",
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
        process(2);
    });

    $('#slides').hide();
    $('#min').click(function (){
        if(index == 1)
            index = 1;
        else
            index--;
        display(index);
    });
    $('#plus').click(function (){
        if(index == 4)
            index = 4;
        else
            index++;
        display(index);
    });
});

function main() {
    $('#approval').DataTable().destroy();
    $('#attch').DataTable().destroy();
    $('#main-content').show();
    $('#slides').hide();
}

function process(sel) {
    window.index = 1;

    if (sel == 2) {
        get_app($('#idvendor').val());
    } else {
        get_app(0);
    }
    get_perf(sel);
    get_history();
    get_upload();

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
    var dt = ""
    $('form :input').prop('disabled',false);
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
}

function get_upload() {
    var obj = {};
    obj.po = $('#msr_id').val();
    var table = $('#attch').DataTable({
    ajax: {
        type: 'POST',
        url: '<?= base_url('procurement/cor_finished/get_upload') ?>',
        data: obj,
        'dataSrc': ''
    },
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

function get_history() {
    var obj = {};
    obj.cor = $('#cor_id').val();
    obj.vendor = $('#idvendor').val();
    $('#log_table').DataTable().destroy();
    var tbl_log = $('#log_table').DataTable({
        ajax: {
            url: '<?= base_url('procurement/cor_finished/get_history')?>',
            type: "POST",
            data: obj,
            'dataSrc': function (json) {
                $('#cor_history').modal('show');
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

function get_perf(sel) {
    var obj = {};
    obj.id = $('#idvendor').val();
    obj.sel = sel;
    obj.po = $('#msr_id').val();
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
        url: "<?= base_url('procurement/cor_finished/get_performance_q') ?>",
        data: obj,
        success: function (m) {
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
            $('[name^="cpmw"]').each(function() {
                $(this).html(accounting.format($(this).html()));
            });
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
            // $('#stat_partial').html('<label>: ' + ($("#cpar").html() == "1" ? "Yes" : "No") + '</label>');
            // $('#stat_penalty').html('<label>: ' + ($("#cpen").html() == "1" ? "Yes" : "No") + '</label>');
            $('#stat_partial').html('<input type="checkbox" id="check_partial" ' + ($("#cpar").html() == "1" ? "checked" : "") + ' disabled/>');
            $('#stat_penalty').html('<input type="checkbox" id="check_penalty" ' + ($("#cpen").html() == "1" ? "checked" : "") + ' disabled/>');
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
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

function get_app(id) {
    var obj = {};
    obj.id = id;
    obj.po = $('#msr_id').val();

    var table = $('#approval').DataTable({
        ajax: {
            type: 'POST',
            url: '<?= base_url('procurement/cor_finished/show_app') ?>',
            data: obj,
            'dataSrc': ''
        },
        "selected": true,
        "paging": false,
        "columns": [
            {title:"No"},
            {title:"<?= lang("Kondisi", "Condition") ?>"},
            {title:"<?= lang("Dikonfirmasi Oleh", "Confirmed By") ?>"},
            {title:"<?= lang("Jabatan", "Role") ?>"},
            {title:"<?= lang("Status Konfirmasi", "Confirmation Status") ?>"},
            {title:"<?= lang("Tanggal", "Date") ?>"},
            {title:"<?= lang("Catatan", "Remark") ?>"},
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},
            {"className": "dt-center", "targets": [5]},
            {"className": "dt-center", "targets": [6]},
        ]
    });
}
</script>
