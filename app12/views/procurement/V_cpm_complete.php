<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
<div class="content-wrapper">
    <div class="content-header row">
    </div>
	<h3 class="content-header-title"><?=lang("CPM Terselesaikan", "Completed CPM")?></h3>
    <div class="content-detached">
        <div class="content-body" id="main-content">
            <section>
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-8">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-12 form-row approval">
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
                        <div class="card-body body-step" >
                            <div class="col-12 form-row x-tab" id="project-info">
                                <input type="text" style="display:none" id="po_id"/>
                                <input type="text" style="display:none" id="vendor_id"/>
                                <input type="text" style="display:none" class="phase"/>
								<div class="steps clearfix">
                                    <ul role="tablist" class="tablist">
										<li >
											<button onclick="choose(1)" id="main-b-1" class="project-info-icon btn btn-default current">
												<i class="fa fa-info"></i>
												Scoring
											</button>
										</li>
										<li>
											<button onclick="choose(2)" id="main-b-2" class="project-info-icon btn btn-default">
												<i class="fa fa-paperclip"></i>
												Attachment
											</button>
										</li>
                                        <li id="btn-history">
                                            <button onclick="choose(3)" id="main-b-3" class="project-info-icon btn btn-default">
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
                                    <div class="col-md-6 mb-1">
                                        <select onchange="get_detail(this.value)" class="form-control">
                                            <option value="0">Please Select</option>
                                            <option value="1">Phase 1</option>
                                            <option value="2">Phase 2</option>
                                            <option value="3">Phase 3</option>
                                        </select>
                                    </div>
                                    <div class="mt-1 col-md-12" style="overflow:auto">
                                        <form action:"javascript:;" novalidate:"novalidate" id="scoring">
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
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" id="main-p-2">
                                <div id="main-c-2">
                                    <h3><?=lang("Lampiran","Attachment")?></h3>
                                    <table id="attch" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                    </table>
                                </div>
                            </div>
                            <div class="col-12" id="main-p-3">
                                <div id="main-c-3">
                                    <h3><?=lang("Riwayat", "History")?></h3>
                                    <table id="log_table" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th><?= lang("Fase", "Phase") ?></th>
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
                                <div class="col-4">
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
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
<script>
$(function(){
    lang();

    $('.input-group.date').datetimepicker({
        format: 'YYYY-MM-DD'
    });
    var tabel2 = $('#list2').DataTable({
    ajax: {
        url: '<?= base_url('procurement/cpm_complete/get_list/') ?>',
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
        {title:"<?= lang("No CPM", "CPM No") ?>"},
        {title:"<?= lang("Pekerjaan", "Subject") ?>"},
        {title:"<?= lang("Perusahaan", "Company") ?>"},
        {title:"<?= lang("Penyedia", "Supplier") ?>"},
        // {title:"<?= lang("Tanggal Akhir", "Due Date") ?>"},
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
    ]
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
        if(index == 3)
            index = 3;
        else
            index++;
        display(index);
    });
});

function get_detail(e) {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.vendor = $('#vendor_id').val();
    obj.phase = e;
    $.ajax({
        url: "<?=base_url('procurement/cpm_complete/get_cpm_detail')?>",
        data: obj,
        type: "POST",
        success: function(m) {
            if (m.length == 0) {
                $('#data_kpi').html("");
                $('#kpi > tbody:last-child').append("<tr><td colspan='11' style='text-align:center'>No Data</td></tr>");
                return;
            } else {
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
                            +"<td id='st_kpi_ds"+tamp+"'>"+st_kpi_ds+"</td>"
                            +"<td id='st_kpi_dws"+tamp+"'>"+st_kpi_dws.toFixed(2)+"</td>"
                            +"<td></td>"
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
                    +"<td id='st_kpi_ds"+tamp+"'>"+st_kpi_ds+"</td>"
                    +"<td id='st_kpi_dws"+tamp+"'>"+st_kpi_dws.toFixed(2)+"</td>"
                    +"<td></td>"
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
                    +"<td id='gt_kpi_ds'>"+gt_kpi_ds+"</td>"
                    +"<td id='gt_kpi_dws'>"+gt_kpi_dws.toFixed(2)+"</td>"
                    +"<td></td>"
                +"</tr>"
                );
            }
        },
        error: function(m) {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function get_history() {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.vendor = $('#vendor_id').val();
    $('#log_table').DataTable().destroy();
    var tbl_log = $('#log_table').DataTable({
        ajax: {
            url: '<?= base_url('procurement/cpm_complete/get_history')?>',
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
            {title:"<?= lang("Fase", "Phase") ?>", data: [1]},
            {title:"<?= lang("Aksi", "Action") ?>", data: [2]},
            {title:"<?= lang("Catatan", "Note") ?>", data: [3]},
            {title:"<?= lang("Transaksi Pada", "Transaction At") ?>", data: [4]},
        ],
        "columnDefs": [
            {"className": "dt-center"},
            {"className": "dt-center"},
            {"className": "dt-center"},
            {"className": "dt-center"},
            {"className": "dt-center"},
        ]
    });
}

function preview(path) {
    $('#ref').attr('src',"<?= base_url()?>"+path);
    var words = path.split('.');
    if (words[words.length - 1] == 'pdf')
        $('#modal_preview').modal('show');
}

function main()
{
    $('#approval').DataTable().destroy();
    $('#main-content').show();
    $('#slides').hide();
}

function process(po, phase, vendor) {
    window.index = 1;
    var obj = {};
    obj.po = po;
    obj.vendor = vendor;
    $.ajax({
        url: "<?=base_url('procurement/cpm_complete/get_header')?>",
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

    $('#opHead').html(po);
    $('#po_id').val(po);
    $('#po_id').val(po);
    $('#vendor_id').val(vendor);
    $('.phase').val(phase);
    $('#main-content').hide();
    $('#slides').show();

    tbl();
    get_history();
    choose(1);
    lang();
}

function calc(id)
{
    var obj={};
    obj.value=$('input[name='+id+'_0]').val();

    $.ajax({
        url:"<?= base_url('procurement/cpm_complete/calc/')?>"+id,
        type:"POST",
        data:obj,
        success:function (m)
        {
            if(!m.status)
                $('input[name='+id+'_1]').val(m);
        }
    });
}

function display(index) {
    var i = 1;
    for (i = 1; i <= 3; i++) {
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
    $('form :input').prop('disabled', false);
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
}

function choose(sel) {
    index = sel;
    display(sel);
}

function tbl()
{
    var po=$('#po_id').val();
    var tabel2 = $('#attch').DataTable({
    ajax: {
        url: '<?= base_url('procurement/cpm_complete/get_upload/') ?>'+po,
        'dataSrc': ''
    },
    "scrollX": true,
    "selected": true,
    "scrollY": "300px",
    "scrollCollapse": true,
    "paging": false,
    "columns": [
        {title:"No"},
        {title:"<?=lang("Tipe","Type")?>"},
        {title:"<?=lang("Nama File","File Name")?>"},
        {title:"<?=lang("Diupload Pada","Upload At")?>"},
        {title:"<?=lang("Pengunggah","Uploader")?>"},
        {title:"<?= lang("Aksi", "Action") ?>"},
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
</script>
