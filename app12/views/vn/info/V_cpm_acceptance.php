<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
<div class="app-content content">
<div class="content-wrapper">
    <div class="content-header row">        
    </div>
    <div class="content-detached">        
        <div class="content-body" id="main-content">
            <section>
                <div class="card">
                    <div class="card-header">                        
                        <div class="row">
                            <div class="col-sm-8">    
                                <h3><?=lang("Konfirmasi CPM","CPM Acceptance")?></h3>
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
            <section>
                <div class="card">
                    <div class="card-header" style="background-color:#d3f7ef">                        
                        <div class="col-12 row">
                            <div class="col-8">                            
                                <h3 class="content-header-title mb-1"><?=lang("Konfirmasi CPM","CPM Acceptance")?><span id="company"></span></h3>                                                                    
                            </div>
                            <div class="col-4">                            
                                <button class="btn btn-sm btn-primary" onclick="main()"><?= lang('Kembali','Back')?></button>
                            </div>
                            <div class="col-sm-8">
                                <h5><?= $this->session->NAME?></h5>
                                <h5>Contractor Performance Management</h5>
                            </div>                            
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body" style="background-color:#e6f2f9">
                            <div class="col-12 form-row" id="project-info">         
                                <input type="text" style="display:none" id="po_id"/>
                                <input type="text" style="display:none" id="vendor_id"/>                                                   
                                <input type="text" style="display:none" class="phase"/>
                                <div class="project-info-count col-sm-1">
                                    <button onclick="choose(1)" id="main-b-1" class="project-info-icon btn btn-default">
                                        <i class="fa fa-info"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Scoring</h6>
                                    </div>
                                </div>                                         
                                <div class="project-info-count col-sm-1">
                                    <button onclick="choose(2)" id="main-b-2" class="project-info-icon btn btn-default">
                                        <i class="fa fa-paperclip"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Attachment</h6>
                                    </div>
                                </div>                         
                            </div>
                        </div>
                        <div class="card-body">                            
                            <div class="col-12" id="main-p-1">                                
                                <div id="main-c-1">                                        
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
                                                        <th style="vertical-align: middle;" colspan="2">Contractor Self Scoring</th>
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
                        </div>
                        <div class="card-body">
                            <hr/>
                            <div class="col-12 row">
                                <div class="col-4">
                                    <button class="btn btn-default" id="min"><i class="fa fa-arrow-left"></i></button>
                                    <button class="btn btn-default" id="plus"><i class="fa fa-arrow-right"></i></button>
                                </div>
                                <div class="col-8 text-right">                                    
                                    <button class="btn btn-success" id="send"><?= lang("Konfirmasi","Accept")?></button>                                    
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
                <h4 class="modal-title">File Preview</h4>
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
<div id="modal_draft" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="draft_mdl" novalidate="novalidate" action="javascript:;">
            <div class="modal-header bg-primary white">
                <?= lang("Simpan sebagai draft", "Save as Draft") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">                                
                    <input name="seq" class="seq" hidden>
                    <input name="idT" class="idT" hidden>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Apakah anda yakin untuk menyimpan sebagai draft?", "Are You Sure to Save as draft?") ?></label>
                            <textarea placeholder="Additional Notes (optional)" class="form-control note" rows="5" name="note"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-success"><?= lang("Simpan", "Save") ?></button>
            </div>
        </form>
    </div>
</div>
<div id="modal_submit" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="submit_mdl" novalidate="novalidate" action="javascript:;">
            <div class="modal-header bg-success white">
                <?= lang("Kirim Data", "Send Data") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">                                                            
                    <div class="form-group">
                        <div class="controls col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Apakah anda yakin untuk mengirim data?", "Are You Sure to Send Data?") ?></label>                            
                            <textarea placeholder="Aditional Notes (optional)" class="form-control note" rows="5" name="note" required data-validation-required-message="This field is required"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-success"><?= lang("Kirim ", "Send") ?></button>
            </div>
        </form>
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
        url: '<?= base_url('vn/info/cpm_acceptance/get_list/') ?>',
        'dataSrc': ''
    },
    "scrollX": true,
    "selected": true,
    "scrollY": "300px",
    "scrollCollapse": true,
    "paging": false,        
    "columns": [            
        {title:"No"},
        {title:"<?= lang("No Persetujuan", "Agreement No") ?>"},        
        {title:"<?= lang("Jabatan", "Subject Work") ?>"},            
        {title:"<?= lang("Perusahaan", "Company") ?>"},                         
        {title:"<?= lang("Fase", "Phase") ?>"},
        {title:"<?= lang("Batas Tanggal", "Due Date") ?>"},
        {title:"<?= lang("Status CPM", "CPM Status") ?>"},        
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
    $('#draft').click(function(){
       $('#modal_draft').modal('show');
    });    
    
    $('#send').click(function(){
        $('#modal_submit').modal('show');
    });

    $("#draft_mdl").submit(function (){
        var obj={};
        $.each($('#scoring').serializeArray(),function(i,field){
            obj[field.name] = field.value;
        });
        obj.po=$("#po_id").val();        
        $.ajax({
            url:"<?= base_url("vn/info/cpm_acceptance/draft/")?>",
            type:"POST",
            data:obj,
            success:function(m){
                if(m.status === "Success")
                {
                    msg_info(m.msg,m.status);
                    $('#modal_draft').modal('hide');
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
        });
    });

    $("#submit_mdl").submit(function (){
        var obj={};
        $.each($('#submit_mdl').serializeArray(),function(i,field){
            obj[field.name] = field.value;
        });        
        obj.po=$("#po_id").val();        
        obj.phase=$('.phase').val();
        $.ajax({
            url:"<?= base_url("vn/info/cpm_acceptance/send/")?>",
            type:"POST",
            data:obj,
            success:function(m){
                if(m.status === "Success")
                {
                    $('#modal_submit').modal('hide');
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
    var obj = {};
    obj.po = $('#po_id').val();
    obj.phase = $('.phase').val();
    $.ajax({
        url: "<?=base_url('vn/info/cpm_acceptance/get_cpm_detail')?>",
        data: obj,
        type: "POST",
        success: function(m) {
            if(m.length == 0)
                return;
            else {
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
                            +"<td>"+st_kpi_ds+"</td>"
                            +"<td>"+st_kpi_dws.toFixed(2)+"</td>"
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
                    +"<td>"+st_kpi_ds+"</td>"
                    +"<td>"+st_kpi_dws.toFixed(2)+"</td>"
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
                    +"<td>"+gt_kpi_ds+"</td>"
                    +"<td>"+gt_kpi_dws.toFixed(2)+"</td>"
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

function preview(path) {
    $('#ref').attr('src',"<?= base_url()?>"+path);
    var words = path.split('.');
    if (words[words.length - 1] == 'pdf')
        $('#modal_preview').modal('show');
}

function main()
{
    $('#attch').DataTable().destroy();
    $('#main-content').show();
    $('#slides').hide();
}

function process(po,phase)
{    
    window.index=1;      
    init(1);        
    
    $('#po_id').val(po);
    $('.po_id').val(po);
    $('.phase').val(phase);
    
    $('#main-content').hide();
    $('#slides').show();    
        
    table_weight();    
    tbl();
    lang();    
}

function display(index)
{    
    var i=1;
    for(i=1;i<=4;i++)
    {
        if(i===index)
        {
            $('#main-p-'+index).show();
            $('#main-b-'+index).removeClass("btn-default");
            $('#main-b-'+index).addClass("btn-primary");
        }
        else
        {
            $('#main-p-'+i).hide();            
            $('#main-b-'+i).removeClass("btn-primary");
            $('#main-b-'+i).addClass("btn-default");
        }
        if(i==4)
        {
            $('#poin').html($('#total_nilai').val());
        }
}
var addr="";
var dt=""
$('form :input').prop('disabled',false);    
$($.fn.dataTable.tables(true)).DataTable()
    .columns.adjust()
    .fixedColumns().relayout();    
}


function init(sel)
{         
    var obj={};   
    if(sel == 2)
    {
        obj.id=$('#idvendor').val();        
    }    
    $po=$('.po_id').val();
    $type=$('.type').val();
       
    choose(1);
}

function choose(sel)
{
    index=sel;
    display(sel);
}

function tbl() {
    var po=$('#po_id').val();
    var tabel2 = $('#attch').DataTable({
    ajax: {
        url: '<?= base_url('vn/info/cpm_acceptance/get_upload/') ?>'+po,
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
