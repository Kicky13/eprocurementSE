<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
<div class="content-wrapper">
    <div class="content-header row">
    </div>
	<h3 class="content-header-title"><?=lang("Persetujuan CPM","CPM Approval")?></h3>
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
                    <div class="card-header " style="display:none">
                        <div class="col-12 row">
                            <input type="text" id="edit" value="0" style="display:none"/>
                            <input type="text" id="extra" value="0" style="display:none"/>
                            <input type="text" id="phase_id" value="0" style="display:none"/>

                        </div>
                    </div>
                    <div class="card-content card-scroll">
                        <div class="card-body body-step" >
                            <div class="col-12 form-row x-tab" id="project-info">
                                <input type="text" style="display:none" id="po_id"/>
                                <input type="text" style="display:none" id="vendor_id"/>
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
											<button onclick="choose(3)" id="main-b-3" class="project-info-icon btn btn-default" >
												<i class="fa fa-list"></i>
												Approval List
											</button>
										</li>
										<li>
											<button onclick="choose(4)" id="main-b-4" class="project-info-icon btn btn-default" >
												<i class="fa fa-paperclip"></i>
												Attachment
											</button>
										</li>
									</ul>
								</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12" id="main-p-1">
                                <div id="main-c-1">

                                    <div class="col-md-12" style="overflow:auto">
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
                                    </div>
                                    <div class="col-md-12" style="overflow:auto">
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
                                    <div class="mt-1 col-md-12" style="overflow:auto">
                                        <form action="javascript:;" id="adjust" novalidate="novalidate">
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
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" id="main-p-3">
                                <div id="main-c-3" style="overflow:auto">
                                    <h3><?=lang("Daftar Persetujuan CPM","CPM Approval List")?></h3>
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
                                </div>
                            </div>
                            <div class="col-12" id="main-p-4">
                                <div id="main-c-4">
                                    <h3><?=lang("Lampiran","Attachment")?></h3>
                                    <table id="attch" class="table table-striped table-bordered table-hover display text-center" width="100%">
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
                                <div class="col-8 text-right">
                                    <button class="btn btn-danger" id="rej"><?= lang("Tolak","Reject")?></button>
                                    <button class="btn btn-success" id="acpt"><?= lang("Setujui","Approve")?></button>
                                    <button class="btn btn-success" id="acpt2"><?= lang("Terbitkan","Issue")?></button>
                                    <button class="btn btn-success to-submit" id="send"><?= lang("Kirim","Send")?></button>
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
<div id="modal_app" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="approve_mdl" novalidate="novalidate" action="javascript:;">
            <div class="modal-header bg-success white">
                <?= lang("Persetujuan Data", "Approval Data") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input name="seq" class="seq" hidden>
                    <input name="idT" class="idT" hidden>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                            <textarea placeholder="Fill in your comment" class="form-control note" rows="5" name="note"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-success to-submit"><?= lang("Setujui dan kirim email", "Approve") ?></button>
            </div>
        </form>
    </div>
</div>
<div id="modal_rej" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="reject_mdl" novalidate="novalidate" action="javascript:;">
            <div class="modal-header bg-danger white">
                <?= lang("Tolak Data", "Reject Data") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input name="seq" class="seq" hidden>
                    <input name="idT" class="idT" hidden>
                    <div class="form-group">
                        <div class="controls col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                            <label id="label_kirim" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                            <textarea placeholder="Fill in your comment" class="form-control note" rows="5" name="note" required data-validation-required-message="This field is required"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-danger to-submit"><?= lang("Tolak ", "Reject") ?></button>
            </div>
        </form>
    </div>
</div>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
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
    var tabel2 = $('#list2').DataTable({
    ajax: {
        url: '<?= base_url('procurement/cpm_approval/get_list/') ?>',
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
        {title:"<?= lang("Pengumpulan Pada", "Submission At") ?>"},
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
    ]
    });

    $('#slides').hide();
    $('#min').click(function (){
        if(index==1)
            index=1;
        else
            index--;
        display(index);
    });

    $('#plus').click(function (){
        if(index==2)
            index=2;
        else
            index++;
        display(index);
    });
    $('#acpt').click(function(){
       $('#modal_app').modal('show');
    });
    $('#acpt2').click(function(){
       $('#modal_app').modal('show');
    });
    $('#rej').click(function(){
        $('#modal_rej').modal('show');
    });
    $("#approve_mdl").submit(function (){
        var obj={};
        $.each($('#approve_mdl').serializeArray(),function(i,field){
            obj[field.name] = field.value;
        });
        obj.po=$("#po_id").val();
        obj.idS=$('#vendor_id').val();
        obj.extra=$('#extra').val();
        obj.phase=$('#phase_id').val();
        $.ajax({
            url:"<?= base_url("procurement/cpm_approval/change_btn/1")?>",
            type:"POST",
            data:obj,
            success:function(m){
                if(m.status === "Success")
                {
                    msg_info(m.msg,m.status);
                    $('#modal_app').modal('hide');
                    $('#attch').DataTable().destroy();
                    $('#list2').DataTable().ajax.reload();
                    main();
                }
                else
                    msg_danger(m.msg,m.status);
            },
            error:function(m){
                msg_danger("Oops, something went wrong!", "Failed");
            }
        })
    });
    $("#send").click(function (){
        var obj={};
        $.each($('#adjust').serializeArray(),function(i,field){
            obj[field.name] = field.value;
        });
        obj.po=$("#po_id").val();
        obj.phase=$("#phase_id").val();
        obj.idS=$('#vendor_id').val();
        obj.extra=$('#extra').val();
        obj.idT=$('.idT').val();
        obj.seq=$('.seq').val();
        $.ajax({
            url:"<?= base_url("procurement/cpm_approval/send_kpi")?>",
            type:"POST",
            data:obj,
            success:function(m){
                if(m.status === "Success")
                {
                    msg_info(m.msg,m.status);
                    $('#modal_app').modal('hide');
                    $('#list2').DataTable().ajax.reload();
                    main();
                }
                else
                    msg_danger(m.msg,m.status);
            },
            error:function(m){
                msg_danger("Oops, something went wrong!", "Failed");
            }
        });
    });
    $("#reject_mdl").submit(function (){
        var obj={};
        $.each($('#reject_mdl').serializeArray(),function(i,field){
            obj[field.name] = field.value;
        });
        obj.po=$("#po_id").val();
        obj.idS=$('#vendor_id').val();
        obj.extra=$('#extra').val();
        obj.phase=$('#phase_id').val();
        $.ajax({
            url:"<?= base_url("procurement/cpm_approval/change_btn/2")?>",
            type:"POST",
            data:obj,
            success:function(m){
                if(m.status === "Success")
                {
                    $('#modal_rej').modal('hide');
                    msg_info(m.msg,m.status);
                    $('#attch').DataTable().destroy();
                    $('#list2').DataTable().ajax.reload();
                    main();
                }
                else
                    msg_danger(m.msg,m.status);
            },
            error:function(m){
                msg_danger("Oops, something went wrong!", "Failed");
            }
        })
    });
});

function table_weight() {
    get_status();
    var obj = {};
    obj.po = $('#po_id').val();
    obj.vendor = $('#vendor_id').val();
    obj.phase = $('#phase_id').val();

    $.ajax({
        url: "<?=base_url('procurement/cpm_approval/get_cpm_detail')?>",
        data: obj,
        type: "POST",
        success: function(m) {
            if (m.length == 0)
                return;
            else {
                $('#data_kpi').html("");
                var edit = $('#edit').val();
                var extra = $('#extra').val();
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
                    iw_base = (item.adjust_weight == null ? '0.00' : (item.adjust_weight*1).toFixed(2));

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

                        if (edit == 1) {
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
                                +"<td><input type='number' onchange='calculate("+item.id+", "+item.category_id+")' class='form-control' min=0 max="+item.target_score+" id='"+('1_'+item.id)+"' name='"+('1_'+item.id)+"' value='"+item.adjust_score+"' style='width:70px' /></td>"
                                +"<td><p id='iw_mask_"+item.id+"'>"+iw_base+"</p><input type='hidden' class='form-control' name='"+('2_'+item.id)+"' value='"+iw_base+"' /></td>"
                                +"<td><input type='text' class='form-control' id='"+('3_'+item.id)+"' name='"+('3_'+item.id)+"' value='"+item.remarks+"' style='width:140px' /></td>"
                                +"<td></td>"
                            +"</tr>"
                            );
                        } else {
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
                                +"<td></td>"
                            +"</tr>"
                            );
                        }
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
                            +"<td id='stds_"+tamp+"'>"+st_kpi_ds+"</td>"
                            +"<td id='stdws_"+tamp+"'>"+st_kpi_dws.toFixed(2)+"</td>"
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

                        if (edit == 1) {
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
                                +"<td><input type='number' onchange='calculate("+item.id+", "+item.category_id+")' class='form-control' min=0 max="+item.target_score+" id='"+('1_'+item.id)+"' name='"+('1_'+item.id)+"' value='"+item.adjust_score+"' style='width:70px' /></td>"
                                +"<td><p id='iw_mask_"+item.id+"'>"+iw_base+"</p><input type='hidden' class='form-control' name='"+('2_'+item.id)+"' value='"+iw_base+"' /></td>"
                                +"<td><input type='text' class='form-control' id='"+('3_'+item.id)+"' name='"+('3_'+item.id)+"' value='"+item.remarks+"' style='width:140px' /></td>"
                                +"<td></td>"
                            +"</tr>"
                            );
                        } else {
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
                                +"<td></td>"
                            +"</tr>"
                            );
                        }
                    } else {
                        st_kpi_w += (item.kpi_weight * 1);
                        st_kpi_ts += (item.target_score * 1);
                        st_kpi_tws += (item.target_weight * 1);
                        st_kpi_as += (item.actual_score * 1);
                        st_kpi_aws += (item.actual_weight * 1);
                        st_kpi_ds += (item.adjust_score * 1);
                        st_kpi_dws += (item.adjust_weight * 1);

                        if (edit == 1) {
                            $('#kpi > tbody:last-child').append
                            ("<tr>"
                                +"<td>"+item.specific_kpi+"</td>"
                                +"<td>"+item.kpi_weight+" %</td>"
                                +"<td>"+item.scoring_method+"</td>"
                                +"<td>"+item.target_score+"</td>"
                                +"<td>"+item.target_weight+"</td>"
                                +"<td>"+item.actual_score+"</td>"
                                +"<td>"+item.actual_weight+"</td>"
                                +"<td><input type='number' onchange='calculate("+item.id+", "+item.category_id+")' class='form-control' min=0 max="+item.target_score+" id='"+('1_'+item.id)+"' name='"+('1_'+item.id)+"' value='"+item.adjust_score+"' style='width:70px' /></td>"
                                +"<td><p id='iw_mask_"+item.id+"'>"+iw_base+"</p><input type='hidden' class='form-control' name='"+('2_'+item.id)+"' value='"+iw_base+"' /></td>"
                                +"<td><input type='text' class='form-control' id='"+('3_'+item.id)+"' name='"+('3_'+item.id)+"' value='"+item.remarks+"' style='width:140px' /></td>"
                                +"<td></td>"
                            +"</tr>"
                            );
                        } else {
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
                                +"<td></td>"
                            +"</tr>"
                            );
                        }
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
                    +"<td id='stds_"+tamp+"'>"+st_kpi_ds+"</td>"
                    +"<td id='stdws_"+tamp+"'>"+st_kpi_dws.toFixed(2)+"</td>"
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
                    +"<td id='gtds'>"+gt_kpi_ds+"</td>"
                    +"<td id='gtdws'>"+gt_kpi_dws.toFixed(2)+"</td>"
                    +"<td colspan=2></td>"
                +"</tr>"
                );
            }
        },
        error: function(m) {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });

}
function send_notif(phase)
{
    var obj={};
        swal({
        title: "Apakah anda yakin?",
        text: "Untuk Mengirim email",
        type: "warning",
        showCancelButton: true,
        CancelButtonColor: "#DD6B55",
        confirmButtonColor: "#d9534f",
        confirmButtonText: "Ya",
        closeOnConfirm: false
    }, function () {
        var elm = start($('.sweet-alert'));
        var obj = {};
        obj.po=$('#po_id').val();
        obj.vendor=$('#vendor_id').val();
        obj.phase=phase;
        $.ajax({
            type: 'POST',
            data: obj,
            url: '<?= base_url('procurement/cpm_approval/send_email') ?>',
            success: function (msg) {
                stop(elm);
                swal(msg.msg, "", msg.status);
                lang();
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                stop(elm);
                msg_danger("Oops, something went wrong!", "Failed");
            }
        });
    });
}

function calculate(id, cat) {
    var val = $('input[name=1_'+id+']').val();
    var max = ($('input[name=1_'+id+']').prop('max') * 1);
    var min = ($('input[name=1_'+id+']').prop('min') * 1);
    var obj = {};
    obj.po = $('#po_id').val();
    if (val > max) {
        obj.val = max;
        $('input[name=1_'+id+']').val(max);
    } else if (val < min){
        obj.val = min;
        $('input[name=1_'+id+']').val(min);
    } else {
        obj.val = val;
    }

    $.ajax({
        url: "<?=base_url('procurement/cpm_approval/calculate/')?>"+id,
        data: obj,
        type: "POST",
        success: function(m) {
            if (!m.status) {
                var tcat = 0;
                var ts = 0;
                var tw = 0;
                var gs = 0;
                var gw = 0;
                $.each(m, function(i, item) {
                    if (item.id == id) {
                        $('input[name=2_'+id+']').val(item.weight);
                        $('#iw_mask_'+id).html(item.weight);
                    }
                    if (tcat != 0 && tcat != item.category_id) {
                        $('#stds_'+tcat).html(ts);
                        $('#stdws_'+tcat).html(tw.toFixed(2));
                        gs += ts;
                        gw += tw;
                        ts = 0;
                        tw = 0;
                    }
                    ts += ($('input[name=1_'+item.id+']').val() * 1);
                    tw += ($('input[name=2_'+item.id+']').val() * 1);
                    tcat = item.category_id;
                });
                $('#stds_'+tcat).html(ts);
                $('#stdws_'+tcat).html(tw.toFixed(2));
                gs += ts;
                gw += tw;
                $('#gtds').html(gs);
                $('#gtdws').html(gw.toFixed(2));
            }
        },
        error: function() {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function get_status() {
    var obj = {};
    obj.idvendor = $('#vendor_id').val();
    obj.po = $('#po_id').val();
    obj.seq = $('.seq').val();
    $.ajax({
        url: "<?= base_url('procurement/cpm_approval/get_status')?>",
        type: "POST",
        async: false,
        data: obj,
        success: function(m) {
            $('#edit').val(m.edit);
            $('#extra').val(m.extra);
            if(m.max == 1 && m.extra == 0) {
                $("#acpt").hide();
                $("#rej").hide();
                $("#acpt2").show();
                $("#send").hide();
            } else if(m.edit == 1 && m.extra == 1) {
                $("#acpt").hide();
                $("#rej").hide();
                $("#acpt2").hide();
                $("#send").show();
            } else {
                $("#acpt").show();
                $("#rej").show();
                $("#acpt2").hide();
                $("#send").hide();
            }
        }
    });
}

function preview(path) {
    $('#ref').attr('src',"<?= base_url()?>"+path);
    var words = path.split('.');
    if (words[words.length - 1] == 'pdf')
        $('#modal_preview').modal('show');
}

function get_approval()
{
    var obj={};
    obj.po=$('#po_id').val();
    obj.vendor=$('#vendor_id').val();
    $.ajax({
        url:'<?=base_url("procurement/cpm_approval/get_user")?>',
        data:obj,
        type:'POST',
        success:function (m)
        {
            if(m.status)
                msg_danger(m.msg,m.status);
            else
            {
                $('#CPM_approval').html("");
                cnt = 1
                $.each(m, function (i, item) {
                    $('#approval_user > tbody:last-child').append("<tr><td>"+cnt+"</td><td>"+item.logon+"</td><td>"+item.name+"</td><td>"+item.dept+"</td><td>"+item.roles+"</td></tr>");
                    cnt++;
                });
                $('cpm_approve').modal('hide');
            }
        },
        error:function (m)
        {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function main()
{
    $('#approval').DataTable().destroy();
    $('#attch').DataTable().destroy();
    $('#main-content').show();
    $('#slides').hide();
}

function process(id, po, idT, seq, phase) {
    window.index = 1;
    var obj = {};
    obj.po = po;
    obj.vendor = id;
    $.ajax({
        url: "<?=base_url('procurement/cpm_approval/get_header')?>",
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

    $('#vendor_id').val(id);
    $('#opHead').html(po);
    $('#po_id').val(po);
    $('.po_id').val(po);
    $('.idT').val(idT);
    $('.seq').val(seq);
    $('#phase_id').val(phase);
    $('#main-content').hide();
    $('#slides').show();

    get_plan(start($('.card').find('.card-content')));
    get_schedule();
    get_approval();
    table_weight();
    get_upload();
    lang();
    choose(1);
    get_status();
}

function get_plan(elm) {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.phase = $("#phase_id").val();
    $.ajax({
        url: "<?=base_url('procurement/cpm_approval/get_plan')?>",
        type: "POST",
        data: obj,
        success: function(m) {
            if (!m.status) {
                $('#cpm_planning').html(m);
                get_schedule(elm);
            } else {
                msg_danger(m.msg, m.status);
            }
        },
        error: function(m) {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function get_schedule(elm) {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.phase = $("#phase_id").val();
    $.ajax({
        url: "<?=base_url('procurement/cpm_approval/get_schedule')?>",
        type: "POST",
        data: obj,
        success: function(m) {
            if (!m.status) {
                $('#cpm_remainder').html(m);
                lang();
            } else{
                msg_danger(m.msg, m.status);
            }
            stop(elm);
        },
        error: function(m) {
            stop(elm);
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
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
    $('form :input').prop('disabled',false);
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
}

function choose(sel) {
    index = sel;
    display(sel);
}

function get_upload() {
    var po = $('#po_id').val();
    var table = $('#attch').DataTable({
    ajax: {
        url: '<?= base_url('procurement/cpm_approval/get_upload/') ?>' + po,
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
        {title: "<?= lang("Aksi", "Action") ?>"},
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
