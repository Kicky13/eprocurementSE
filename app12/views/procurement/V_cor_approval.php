<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
<div class="content-wrapper">
    <div class="content-header row">
    </div>
	<h3 class="content-header-title"><?=lang("Persetujuan COR","COR Approval")?></h3>
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
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" id="main-p-2">
                                <div id="main-c-2">
                                    <div id="from_cpm" style="display: none;"></div>
                                    <input style="display:none" class="idvendor" name="idvendor" id="idvendor"/>
                                    <input style="display:none" class="tid" name="tid" id="tid"/>
                                    <input style="display:none" class="po_id" name="po_id" id="po_id"/>
                                    <input style="display:none" class="seq" name="seq" id="seq"/>
                                    <input style="display:none" class="type" name="type" id="type"/>
                                    <form id="point_data" class="form-horizontal" novalidate="novalidate" action="javascript:;">
                                        <div id="header_tkdn_text" style="padding-bottom: 1em; display: none;">
                                            <div>Achievment for Local content:</div>
                                            <div>As per Contract Document <span id="text_contract_cpm"></span> %</div>
                                            <div>Actual Achievement <span id="text_actual_cpm"></span> %</div>
                                        </div>
                                        <div id="header_tkdn_input" style="padding-bottom: 1em; display: none;">
                                            <div>Achievment for Local content:</div>
                                            <div>As per Contract Document <input name="input_contract" id="input_contract_cpm" onchange="reformat(this, 100, 0)" disabled/>%</div>
                                            <div>Actual Achievement <input name="input_actual" id="input_actual_cpm" onchange="reformat(this, 100, 0)" disabled/>%</div>
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
                                    <div class="pull-right">
                                        <button onclick="modal_upload()" class="btn btn-primary btn-modif">Upload File</button>
                                    </div>
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
                                    <button id="rej" class="btn btn-danger" onclick="change_btn(2)"><?=lang("Tolak","Reject")?></button>
                                    <button id="appr" class="btn btn-success" onclick="change_btn(1)"><?=lang("Setujui","Approve")?></button>
                                    <button id="send1" class="btn btn-success" onclick="change_btn(3)"><?=lang("Setujui","Approve")?></button>
                                    <button id="send2" class="btn btn-success to-submit" onclick="send_point_dt()"><?=lang("Kirim","Send")?></button>
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
                        <input style="display:none" class="po_id" name="po"/>
                        <input style="display:none" class="idvendor" name="id"/>
                        <input style="display:none" class="type" name="type"/>
                        <div class="form-group controls col-md-12">
                            <label class="control-label" for="file_unggah_tipe"><?= lang("Tipe Dokumen", "Document Type") ?></label>
                            <select name="file_unggah_tipe" id="file_unggah_tipe" class="form-control" required>
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
<div id="modal_app_amount" class="modal fade" data-backdrop="static" role="dialog">
<div class="modal-dialog">
    <form class=" modal-content" id="approve_mdl_amount">
        <div class="modal-header bg-success white">
            <?= lang("Persetujuan Data", "Approval Data") ?>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="edit-title"></h4>
        </div>
        <div class="modal-body">
            <div class="form-horizontal">
                <input name="idS" class="idS" hidden><!--id transaction ANGKA-->
                <input name="seq" class="seq" hidden><!--id transaction ANGKA-->
                <input name="type" class="type" hidden>
                <input name="input_tkdn" class="input_tkdn" hidden>
                <input name="input_tkdn_act" class="input_tkdn_act" hidden>
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
<div id="modal_app" class="modal fade" data-backdrop="static" role="dialog">
<div class="modal-dialog">
    <form class=" modal-content" id="approve_mdl">
        <div class="modal-header bg-success white">
            <?= lang("Persetujuan Data", "Approval Data") ?>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="edit-title"></h4>
        </div>
        <div class="modal-body">
            <div class="form-horizontal">

                <input name="idS" class="idS" hidden><!--id transaction ANGKA-->
                <input name="seq" class="seq" hidden><!--id transaction ANGKA-->
                <input name="type" class="type" hidden>
                <input name="input_tkdn" class="input_tkdn" hidden>
                <input name="input_tkdn_act" class="input_tkdn_act" hidden>

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
    <form class=" modal-content" id="reject_mdl" action="javascript:;">
        <div class="modal-header bg-danger white">
            <?= lang("Tolak Data", "Reject Data") ?>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="edit-title"></h4>
        </div>
        <div class="modal-body">
            <div class="form-horizontal">

                <input name="idS" class="idS" hidden><!--id transaction ANGKA-->
                <input name="seq" class="seq" hidden><!--id transaction ANGKA-->
                <input name="type" class="type" hidden>

                <div class="form-group">
                    <div class="controls col-md-12">
                        <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                        <label id="label_kirim" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                        <textarea placeholder="Fill in your comment" class="form-control note" rows="5" name="note" required></textarea>
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

<script src="<?= base_url('ast11/assets/js/accounting.js/accounting.js') ?>"></script>
<script>
$(function() {
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
        url: '<?= base_url('procurement/cor_approval/show_list2/') ?>',
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

    $('#file_upload').submit(function (){
        var formData = new FormData($('#file_upload')[0]);
        var elm = start($('#upload_file').find('.modal-content'))
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('procurement/cor_approval/upload_file'); ?>",
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

    $('#approve_mdl_amount').on('submit', function (e) {
        e.preventDefault();
        $('.to-submit').prop('disabled', true);
        amount_orig = accounting.parse($('#origAmount').html().substring(2));
        amount_comp = accounting.parse($('#comp_amount').val());

        if (amount_orig > 0 && amount_comp <= 0) {
            $('.to-submit').prop('disabled', false);
            msg_danger("Completion Amount must be greater than 0.00!", "Failed");
        } else {
            var elm = start($('#modal_app_amount').find('.modal-dialog'));
            var obj = {};
            $.each($("#approve_mdl_amount").serializeArray(), function (i, field) {
                    obj[field.name] = field.value;
            });
            obj["amount_orig"] = amount_orig;
            obj["amount_comp"] = amount_comp;
            obj["tid"] = $("#tid").val();
            obj["po"] = $('#po_id').val();
            obj["from_cpm"] = $('#from_cpm').html();
            if ($('#total_nilai').val()) {
                obj['total'] = $('#total_nilai').val();
                obj['jumlah'] = $('input[name="total"]').val();
                obj['scoring'] = $('#scoring').html();
            }
            if ($('#from_cpm').html()=="2") {
                obj['input_tkdn']=$('#input_contract_cpm').val();
                obj['input_tkdn_act'] = $('#input_actual_cpm').val();
            }else{
                obj['input_tkdn']=$('#input_tkdn').val();
                obj['input_tkdn_act'] = $('#input_tkdn_act').val();
            }
            $.ajax({
                type: 'POST',
                url: "<?=base_url('procurement/cor_approval/approve_comp')?>",
                data: obj,
                success: function (m) {
                    $('.to-submit').prop('disabled', false);
                    stop(elm);
                    if (m.status == 'Success') {
                        $('#modal_app_amount').modal('hide');
                        msg_info(m.msg, m.status);
                        $('#list2').DataTable().ajax.reload();
                        main();
                    } else {
                        msg_danger(m.msg, m.status);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $('.to-submit').prop('disabled', false);
                    stop(elm);
                    msg_danger("Oops, something went wrong!", "Failed");
                }
            });
        }
    });
    $('#approve_mdl').on('submit', function (e) {
        e.preventDefault();
        $('.to-submit').prop('disabled', true);

        var elm = start($('#modal_app').find('.modal-dialog'));
        var obj = {};
        $.each($("#approve_mdl").serializeArray(), function (i, field) {
                obj[field.name] = field.value;
        });
        obj["tid"] = $("#tid").val();
        obj["po"] = $('#po_id').val();
        obj["from_cpm"] = $('#from_cpm').html();
        if ($('#total_nilai').val()) {
            obj['total'] = $('#total_nilai').val();
            obj['jumlah'] = $('input[name="total"]').val();
            obj['scoring'] = $('#scoring').html();
        }
        $.ajax({
            type: 'POST',
            url: '<?= base_url('procurement/cor_approval/change_btn/1') ?>',
            data: obj,
            success: function (m) {
                $('.to-submit').prop('disabled', false);
                stop(elm);
                if (m.status == 'Success') {
                    $('#modal_app').modal('hide');
                    msg_info(m.msg, m.status);
                    $('#list2').DataTable().ajax.reload();
                    main();
                } else {
                    msg_danger(m.msg, m.status);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('.to-submit').prop('disabled', false);
                stop(elm);
                msg_danger("Oops, something went wrong!", "Failed");
            }
        });
    });
    $('#reject_mdl').on('submit', function (e) {
        e.preventDefault();
        $('.to-submit').prop('disabled', true);

        var elm = start($('#modal_rej').find('.modal-dialog'));
        var obj = {};
        $.each($("#reject_mdl").serializeArray(), function (i, field) {
                obj[field.name] = field.value;
        });
        obj["tid"] = $("#tid").val();
        obj["po"] = $('#po_id').val();
        obj["from_cpm"] = $('#from_cpm').html();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('procurement/cor_approval/change_btn/2') ?>',
            data: obj,
            success: function (m) {
                stop(elm);
                if (m.status == 'Success') {
                    $('#modal_rej').modal('hide');
                    msg_info(m.msg, m.status);
                    $('#list2').DataTable().ajax.reload();
                    main();
                } else {
                    msg_danger(m.msg, m.status);
                }
                $('.to-submit').prop('disabled', false);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                stop(elm);
                msg_danger("Oops, something went wrong!", "Failed");
                $('.to-submit').prop('disabled', false);
            }
        });
    });
});

function reformat(obj, max, min) {
    val = $(obj).val();
    if (val > max) val = max;
    else if (val < min) val = min;
    $(obj).val(accounting.format(val));
}

function send_point_dt() {
    if ($('#actual_date').val() == null) {
        msg_danger("Please input actual delivery date!", "Failed");
    } else {
        var elm = start($('#main-p-2').find('#main-c-2'));
        $('.to-submit').prop('disabled', true);
        var obj = {};
        obj.point_data = $('#point_data').serializeArray();
        obj.from_cpm = $('#from_cpm').html();
        obj.idvendor = $('#idvendor').val();
        obj.tid = $('#tid').val();
        obj.po_id = $('#po_id').val();
        obj.seq = $('#seq').val();
        obj.type = $('#type').val();
        obj.actual_deliv_date = $('#actual_date').val();
        obj.check_partial = ($('#check_partial').prop('checked') ? 1 : 0);
        if ($('#check_penalty').prop('checked')) {
            obj.check_penalty = 1;
            obj.amount_penalty = accounting.parse($('#pen_amount').val());
        } else {
            obj.check_penalty = 0;
        }

        $.ajax({
            type: "POST",
            url: "<?=base_url('procurement/cor_approval/send_point_dt')?>",
            data: obj,
            success: function(m) {
                $('.to-submit').prop('disabled', false);
                stop(elm);
                if (m.status === "Success") {
                    msg_info(m.msg, m.status);
                    $('#list2').DataTable().ajax.reload();
                    main();
                } else {
                    msg_danger(m.msg, m.status);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $('.to-submit').prop('disabled', false);
                stop(elm);
                msg_danger("Oops, something went wrong!", "Failed");
            }
        });
    }
};

function check_data(po, id, type) {
    var obj = {};
    obj.po = po;
    obj.id = id;
    obj.type = type;
    $.ajax({
        type: 'POST',
        url: '<?=base_url('procurement/cor_approval/check_data')?>',
        data: obj,
        success: function (m) {
            if (m.status === "Success") {
                if (m.data_fn === "1") {
                    $('.btn-modif').hide();
                    // $('#appr').html("<?=lang('Terbitkan', 'Issue')?>");
                    $('#appr').show();
                    $('#send1').hide();
                    $('#send2').hide();
                } else if (m.data_sm === "3") {
                    $('.btn-modif').show();
                    $('#appr').hide();
                    $('#send1').show();
                    $('#send2').hide();
                } else if (m.data_sm === "2") {
                    $('.btn-modif').show();
                    $('#appr').hide();
                    $('#send1').hide();
                    $('#send2').show();
                } else {
                    $('.btn-modif').hide();
                    // $('#appr').html("<?=lang('Setujui', 'Approve')?>");
                    $('#appr').show();
                    $('#send1').hide();
                    $('#send2').hide();
                }
                if (m.data_sr === "1") {
                    $('#rej').show();
                } else {
                    $('#rej').hide();
                }
                lang();
            }
        }
    });
}

function get_data_assigned(id, po, tid, type) {
    var obj = {};
    obj.id = id;
    obj.po = po;
    obj.tid = tid;
    obj.type = type;
    var elm = start($('main-p-1').find('#main-c-1'));
    $.ajax({
        type: 'POST',
        data: obj,
        url: '<?= base_url('procurement/cor_approval/get_data_assigned/') ?>',
        success: function (m)  {
            stop(elm);
            if(m.status != false)
                $("#data_approval").html(m);
        },
        error: function (m) {
            msg_danger('Oops, something went wrong!', 'Failed');
            stop(elm);
        }
    });
}

function modal_upload() {
    $('#upload_file').modal('show');
}

function get_upload() {
    var obj = {};
    obj.po = $('#po_id').val();
    obj.id = $('#idvendor').val();
    obj.type = $('#type').val();
    var table = $('#attch').DataTable({
    ajax: {
        type: 'POST',
        url: '<?= base_url('procurement/cor_approval/get_upload') ?>',
        data: obj,
        'dataSrc': function (json) {
            lang();
            return json;
        }
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

function delete_ul(id) {
    var obj = {};
    obj.fid = id;
    obj.po = $('#po_id').val();
    obj.id = $('#idvendor').val();
    obj.type = $('#type').val();
    $.ajax({
        url: "<?= base_url('procurement/cor_approval/delete_uploads')?>",
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

function preview(path) {
    $('#ref').attr('src',"<?= base_url()?>"+path);
    var words = path.split('.');
    if (words[words.length - 1] == 'pdf')
        $('#modal_preview').modal('show');
}

function change_btn(sel) {
    if ($('#from_cpm').html()=="2") {
        $('.input_tkdn_act').val($('#input_contract_cpm').val());
        $('.input_tkdn').val($('#input_actual_cpm').val());
    }else{
        $('.input_tkdn_act').val($('#input_actual').val());
        $('.input_tkdn').val($('#input_contract').val());
    }
    if (sel === 1)
        $('#modal_app').modal('show');
    else if (sel == 2)
        $('#modal_rej').modal('show');
    else if (sel == 3)
        $('#modal_app_amount').modal('show');
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
    for(i = 1; i <= 3; i++) {
        if (i === index) {
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

function proc(seq, id, po, tid, type, cpm) {
    $('#appr').hide();
    $('#rej').hide();
    $('#send1').hide();
    $('#send2').hide();

    var obj = {};
    obj.po = po;
    obj.vendor = id;
    $.ajax({
        url: "<?=base_url('procurement/cor_approval/get_header')?>",
        type: "POST",
        data: obj,
        success: function(m) {
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
    $('#agreement').html(": "+po);
    $('#from_cpm').html(cpm);
    $('#opHead').html(po);
    $('.po_id').val(po);
    $('.idvendor').val(id);
    $('.tid').val(tid);
    $('.idS').val(id);
    $('.seq').val(seq);
    $('.type').val(type);
    check_data(po, id, type);
    get_upload();
    get_data_assigned(id, po, tid, type);
    process(2);
}


function calculate(id, cat) {
    var val = accounting.format($('input[name=cpms_'+id+']').val(), 0);
    var max = ($('input[name=cpms_'+id+']').prop('max') * 1);
    var min = ($('input[name=cpms_'+id+']').prop('min') * 1);
    var obj = {};
    obj.po = $('#po_id').val();
    if (val > max) {
        obj.val = max;
        $('input[name=cpms_'+id+']').val(max);
    } else if (val < min){
        obj.val = min;
        $('input[name=cpms_'+id+']').val(min);
    } else {
        obj.val = val;
        $('input[name=cpms_'+id+']').val(val);
    }

    $.ajax({
        url: "<?=base_url('procurement/cor_approval/calculate/')?>"+id,
        data: obj,
        type: "POST",
        success: function(m) {
            if (!m.status) {
                $.each(m, function(i, item) {
                    if (item.id == id) {
                        $('[name=cpmw_'+id+']').html(accounting.format(item.weight));
                    }
                });
            }
        },
        error: function() {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
}

function init(sel) {
    var obj = {};
    if (sel == 2) {
        obj.id = $('#idvendor').val();
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
    $('#header_tkdn_input').hide();
    $('#header_tkdn_text').hide();

    $po = $('#po_id').val();
    $type = $('#type').val();

    $.ajax({
        type: 'POST',
        url: '<?= base_url('procurement/cor_approval/get_performance_q/') ?>'+$po+'/'+$type,
        data: obj,
        success: function (m) {
            $('#data').html(m);
            if (obj.from_cpm == 2) {
                if ($('#tcpm').html() == 2) {
                    $('#header_tkdn_input').show();
                    $('#input_actual_cpm').prop('disabled', false);
                    $('#input_contract_cpm').prop('disabled', false);
                    $('#input_actual_cpm').val(accounting.format($('#cina').html()));
                    $('#input_contract_cpm').val(accounting.format($('#cinc').html()));
                } else {
                    $('#header_tkdn_text').show();
                    $('#input_actual_cpm').prop('disabled', true);
                    $('#input_contract_cpm').prop('disabled', true);
                    $('#text_actual_cpm').html(accounting.format($('#cina').html()));
                    $('#text_contract_cpm').html(accounting.format($('#cinc').html()));
                }
                pt_dec = 2;
            } else {
                $('#input_actual_cpm').prop('disabled', true);
                $('#input_contract_cpm').prop('disabled', true);
                pt_dec = 0;
            }
            var actscore = 0;
            $('[name^="cpmw"]').each(function() {
                $(this).html(accounting.format($(this).html()));
                actscore = actscore + Number.parseFloat($(this).html());
            });
            $('#total_nilai').val(actscore);
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
            stat = $("#stat").html();
            if (stat == 3) {
                $("#file_unggah_tipe").html('<option value>Please Select</option>'+
                                '<option value="other">Other</option>'+
                                '<option value="memo">Memo</option>');
                $('#compAmount').html('<input id="comp_amount" maxlength="21" value="' + accounting.format($("#coma").html()) + '"/>');
                $('#penAmount').html('<label>: ' + accounting.formatMoney($("#pena").html()) + '</label>');
                $('#stat_date').html('<label>: ' + $("#actd").html() + '</label>');
                // $('#stat_partial').html('<label>: ' + ($("#cpar").html() == "1" ? "Yes" : "No") + '</label>');
                // $('#stat_penalty').html('<label>: ' + ($("#cpen").html() == "1" ? "Yes" : "No") + '</label>');
                $('#stat_partial').html('<input type="checkbox" id="check_partial" ' + ($("#cpar").html() == "1" ? "checked" : "") + ' disabled/>');
                $('#stat_penalty').html('<input type="checkbox" id="check_penalty" ' + ($("#cpen").html() == "1" ? "checked" : "") + ' disabled/>');
                $('#comp_amount').change(function(e) {
                    temp = $('#comp_amount').val();
                    $('#comp_amount').val(accounting.format(temp));
                });
            } else if (stat == 2) {
                $("#file_unggah_tipe").html('<option value>Please Select</option>'+
                                '<option value="other">Other</option>'+
                                '<option value="memo">Memo</option>'+
                                '<option value="scoring">Scoring Result</option>');
                $('#compAmount').html('<label>: ' + accounting.formatMoney($("#coma").html()) + '</label>');
                $('#penAmount').html('<input id="pen_amount" maxlength="21" value="' + accounting.format($("#pena").html()) + '"/>');
                $('#stat_date').html('<input id="actual_date" class="form-control"/>');
                $('#actual_date').datepicker({ dateFormat: 'yy-mm-dd' });
                $('#actual_date').datepicker('setDate', $("#actd").html());
                $('#stat_partial').html('<input type="checkbox" id="check_partial" ' + ($("#cpar").html() == "1" ? "checked" : "") + '/>');
                $('#stat_penalty').html('<input type="checkbox" id="check_penalty" ' + ($("#cpen").html() == "1" ? "checked" : "") + '/>');
                $('#pen_amount').change(function(e) {
                    temp = $('#pen_amount').val();
                    $('#pen_amount').val(accounting.format(temp));
                });
                $('#check_penalty').change(function(e) {
                    if ($('#check_penalty').prop('checked'))
                        $('#pen_amount').prop('disabled', false);
                    else
                        $('#pen_amount').prop('disabled', true);
                });
                if ($("#cpen").html() != "1")
                    $('#pen_amount').prop('disabled', true);
            } else {
                $("#file_unggah_tipe").html('<option value>Please Select</option>');
                $('#compAmount').html('<label>: ' + accounting.formatMoney($("#coma").html()) + '</label>');
                $('#penAmount').html('<label>: ' + accounting.formatMoney($("#pena").html()) + '</label>');
                $('#stat_date').html('<label>: ' + $("#actd").html() + '</label>');
                // $('#stat_partial').html('<label>: ' + ($("#cpar").html() == "1" ? "Yes" : "No") + '</label>');
                // $('#stat_penalty').html('<label>: ' + ($("#cpen").html() == "1" ? "Yes" : "No") + '</label>');
                $('#stat_partial').html('<input type="checkbox" id="check_partial" ' + ($("#cpar").html() == "1" ? "checked" : "") + ' disabled/>');
                $('#stat_penalty').html('<input type="checkbox" id="check_penalty" ' + ($("#cpen").html() == "1" ? "checked" : "") + ' disabled/>');
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            msg_danger("Oops, something went wrong!", "Failed");
        }
    });
    choose(1);
}

function choose(sel) {
    index = sel;
    display(sel);
}

function count_score() {
    var total_point = 0;
    var pembagi = toFloat($('input[name="total"]').val()) * 4;
    if ($('[data-cor-param]:checked').length) {
        $.each($('[data-cor-param]:checked'), function(key, elem) {
            total_point+=toFloat($(elem).val());
        });
    }
    $('#poin').html(total_point.toFixed(0));
    var score = total_point / pembagi * 100;
    $('#scoring').html(score.toFixed(2));
}
</script>
