
<div class="app-content content">
<div class="content-wrapper">
    <div class="content-header row">        
    </div>
    <div class="content-detached">        
        <div class="content-body">
            <section>
                <div class="card">
                    <div class="card-header" style="background-color:#d3f7ef">                        
                        <div class="col-12 row">
                            <div class="col-12">                            
                                <h3 class="content-header-title mb-1">PT. Supreme Energy <span id="company"></span></h3>                                                                    
                            </div>
                            <div class="col-8">
                                <h5>Enquiry Document For Supply of <span id="document"></span></h5>
                            </div>
                            <div class="col-4">
                                <h5>Reference No: <span id="ref_num"></span></h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body" style="background-color:#e6f2f9">
                            <div class="col-12 form-row" id="project-info">                            
                                <div class="project-info-count col-sm-1">
                                    <button onclick="choose(1)" id="main-b-1" class="project-info-icon btn btn-primary">
                                        <i class="fa fa-paper-plane"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Administration Data</h6>
                                    </div>
                                </div>
                                <div class="project-info-count col-sm-1">
                                    <button onclick="choose(2)" id="main-b-2" class="project-info-icon btn btn-default">
                                        <i class="fa fa-info"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Technical Data</h6>
                                    </div>
                                </div>
                                <div class="project-info-count col-sm-1">
                                    <button onclick="choose(3)" id="main-b-3" class="project-info-icon btn btn-default">
                                        <i class="fa fa-file-text-o"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Commercial Data</h6>
                                    </div>
                                </div>
                                <div class="project-info-count col-sm-1">
                                    <button onclick="choose(4)" id="main-b-4" class="project-info-icon btn btn-default">
                                        <i class="fa fa-file-text-o"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Bid Attachment</h6>
                                    </div>
                                </div>                                
                                <div class="project-info-count col-sm-1">
                                    <button onclick="choose(5)" id="main-b-5" class="project-info-icon btn btn-default">
                                        <i class="fa fa-comments-o"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Clarification</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12" id="main-p-1">
                                
                                <div id="main-c-1">
                                </div>
                            </div>
                            <div class="col-12" id="main-p-2">
                                
                                <div id="main-c-2">
                                </div>
                            </div>
                            <div class="col-12" id="main-p-3">
                                
                                <div id="main-c-3">
                                </div>
                            </div>
                            <div class="col-12" id="main-p-4">                                
                                <div id="main-c-4">
                                    <div class="col-12 row mb-2">
                                        <div class="col-6">
                                            <h4><?=lang("<b>Penawaran Obligasi</b>","<b>Bid Bond</b>")?></h4>
                                        </div>
                                        <div class="col-6 text-right">
                                            <button onclick="add_bid()" class="btn btn-success"><?=lang("Tambah","Add")?></button>
                                        </div>
                                        <table id="bid_bond" class="table table-striped table-bordered table-hover display" width="100%"></table>
                                    </div>
                                    <div class="col-12 row mb-2">
                                        <div class="col-12">
                                            <h4><?=lang("<b>Jaminan Pelaksanaan</b>","<b>Performance Bond</b>")?></h4>
                                        </div>                                        
                                        <table id="perf_bond" class="table table-striped table-bordered table-hover display" width="100%"></table>
                                    </div>
                                    <div class="col-12 row mb-2">
                                        <div class="col-12">
                                            <h4><?=lang("<b>Jaminan</b>","<b>Insurance</b>")?></h4>
                                        </div>                                        
                                        <table id="asrnc" class="table table-striped table-bordered table-hover display" width="100%"></table>
                                    </div>
                                </div>
                            </div>                            
                            <div class="col-12" id="main-p-5">
                                <div class="modal-body chat-application" style="padding:0px">
                                    <section class="chat-app-window" style="border:1px solid #edeef0">
                                        <div class="badge badge-default mb-1">form History</div>
                                            <input type="text" id="type_msg" style="display:none">
                                            <div class="forms">
                                                <div id="message" class="forms">                                
                                            </div>
                                        </div>
                                    </section>
                                    <section class="chat-app-form">
                                        <form id="form" class="chat-app-input d-flex">
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
                                                <button type="button" onclick="send_cmnt()" class="btn btn-primary"><i class="fa fa-paper-plane-o d-lg-none"></i>
                                                    <span class="d-none d-lg-block"><?=lang("Kirim ","Send ")?><i class="fa fa-arrow-right"></i></span>
                                                </button>
                                            </fieldset>
                                        </form>
                                    </section>
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
                                    <button class="btn btn-primary" id="confirm"><i class="fa fa-comments-o"></i> <?=lang("Klarifikasi","Clarification")?></button>
                                    <button class="btn btn-success" onclick="process()"><?=lang("Proposal Lelang","Bid Proposal")?></button>
                                    <!-- <button class="btn btn-danger" onclick="process(24)"><?=lang("Konfirmasi tidak bergabung","Withdraw Confirmation")?></button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<div id="modal_process" class="modal fade bs-example-modal-lg" role="dialog"  >
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header bg-success white">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="proc_msg" class="col-12">
                    <p><?=lang("Anda akan mengajukan Proposal Penawaran","You will be submission the Bid Proposal")?></p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?=lang("Batal","cancel")?></button>
                <button class="btn btn-success" id="snd_join" onclick="send()"><?=lang("Ya, Lanjut","Yes Confirmation ")?></button>                
            </div>
        </div>
    </div>
</div>
<div id="add_bid_bond" class="modal fade bs-example-modal-lg" role="dialog"  >
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-header bg-success white">
                <h4 class="modal-title"><?=lang("Dokumen Penawaran Obligasi","Bid Bond Document")?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <form id="form_bid" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                <div class=col-12>
                    <div class="row form-group">
                        <label class="label-control col-4"><?=lang("Nomor Penawaran Obligasi","Bid Bond No")?></label>
                        <input type="text" class="form-control col-8" name="bid_no">
                    </div>
                    <div class="row form-group">
                        <label class="label-control col-4"><?=lang("Penerbit","Issuer")?></label>
                        <input type="text" class="form-control col-8" name="issuer">
                    </div>
                    <div class="row form-group">
                        <label class="label-control col-4"><?=lang("Tanggal Terbit","Issued Date")?></label>
                        <input type="text" class="form-control col-8" name="issued_date">
                    </div>
                    <div class="row form-group">
                        <label class="label-control col-4"><?=lang("Jumlah","Value")?></label>
                        <input type="text" class="form-control col-8" name="value">
                    </div>
                    <div class="row form-group">
                        <label class="label-control col-4"><?=lang("Mata Uang","Currency")?></label>
                        <input type="text" class="form-control col-8" name="currency">
                    </div>
                    <div class="row form-group">
                        <label class="label-control col-4"><?=lang("Tanggal Efektif","Effective Date")?></label>
                        <input type="text" class="form-control col-8" name="efct_date">
                    </div>
                    <div class="row form-group">
                        <label class="label-control col-4"><?=lang("Tanggal Kadaluarsa","Expired Date")?></label>
                        <input type="text" class="form-control col-8" name="exp_date">
                    </div>
                    <div class="row form-group">
                        <label class="label-control col-4"><?=lang("Status","Status")?></label>
                        <input type="text" class="form-control col-8" name="status">
                    </div>
                    <div class="row form-group">
                        <label class="label-control col-4"><?=lang("Deskripsi","Description")?></label>
                        <input type="text" class="form-control col-8" name="description">
                    </div>
                </div>
                </form>
            </div>            
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?=lang("Batal","cancel")?></button>
                <button class="btn btn-success" id="snd_join" onclick="send()"><?=lang("Tambahkan Tawaran Obligasi","Add Bid Bond")?></button>                
            </div>
        </div>
    </div>
</div>
<script>
$(function(){   
    window.index=1;        
    init(); 
    lang();
    
    $('#min').click(function (){
        if(index==1)
            index=1;
        else
            index--;
        display(index);
    });
    $('#plus').click(function (){
        if(index==5)
            index=5;
        else
            index++;
        display(index);
    });
    $('#confirm').click(function (){        
        index=5;        
        display(index);
    });                
});

function send()
{
    window.location="<?=base_url("vn/info/bid_proposal")?>"
}

function process()
{    
    $('#modal_process .modal-title').html("<?=lang('Pengajuan Penawaran','Bid Submission')?>");            
    $('#modal_process').modal("show"); 
    lang();
}

function modal_komen(type) {
    var obj={};
    obj.type=type;
    
    $.ajax({
        type: 'POST',
        url: '<?= base_url('vendor/bid_proposal/comment/') ?>',
        data: obj,
        success: function (m) {                    
            $('#message').html(m);
            $('#type_msg').val(type)
            lang();            
        }
    });                
}

function display(index)
{    
    var i=1;
    for(i=1;i<7;i++)
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
    }
    var addr="";
    var dt=""
    $('form :input').prop('disabled',false);
    // if(index < 4)
    //     get_tampilan(addr,index,dt);
    // else{
        $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
    // }
}

function get_tampilan(addr,idx,dt)
{
    var elm = start($('body'));
    var obj={};
    obj.entity_id=dt;
    $.ajax({
        type: 'POST',
        url: '<?= base_url('vn/info/bid_proposal/') ?>'+addr,        
        data:obj,
        success: function (m) 
        {
            stop(elm);            
            $('#main-c-'+idx).html(m[0].OPEN_VALUE+m[0].CLOSE_VALUE);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            stop(elm);
            msg_danger("Gagal", "Oops,Terjadi kesalahan");
        }

    });
}

function init()
{
    console.log(index);
    for(i=1;i<6;i++)
    {
        if(i==1)
            $('#main-p-'+index).show();
        else
            $('#main-p-'+i).hide();
    }
    $('form :input').prop('disabled',false);
    tbl(1);
    // addr="get_invitation";
    // dt=25;        
    // get_tampilan(addr,index,dt);
}

function add_bid()
{
    $("#add_bid_bond").modal("show");
}

function choose(sel)
{
    index=sel;
    display(sel);
}

function tbl(id)
{        
    var tabel1 = $('#bid_bond').DataTable({        
        ajax: {
            url: '<?= base_url('vn/info/bid_proposal/show_bid/') ?>'+id,
            'dataSrc': ''
        },
        "scrollX": true,
        "selected": true,
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false,        
        "columns": [            
            {title:"No"},
            {title:"<?= lang("No Penawaran", "Bid Bond No") ?>"},
            {title:"<?= lang("Penerbit", "Issuer") ?>"},
            {title:"<?= lang("Tanggal Terbit", "Issued Date") ?>"},
            {title:"<?= lang("Jumlah", "Value") ?>"},
            {title:"<?= lang("Mata Uang", "Currency") ?>"},            
            {title:"<?= lang("Tanggal Aktif", "Effective Date") ?>"},            
            {title:"<?= lang("Tanggal Kadaluarsa", "Expired Date") ?>"},            
            {title:"<?= lang("Status", "Status") ?>"},            
            {title:"<?= lang("Deskripsi", "Description") ?>"},            
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},            
        ] 
    });        
    var tabel2 = $('#perf_bond').DataTable({        
        ajax: {
            url: '<?= base_url('vn/info/bid_proposal/show_perf/') ?>'+id,
            'dataSrc': ''
        },
        "scrollX": true,
        "selected": true,
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false,        
        "columns": [            
            {title:"No"},
            {title:"<?= lang("No Jaminan Pelaksanaan", "Performance Bond No") ?>"},
            {title:"<?= lang("Penerbit", "Issuer") ?>"},
            {title:"<?= lang("Tanggal Terbit", "Issued Date") ?>"},
            {title:"<?= lang("Jumlah", "Value") ?>"},
            {title:"<?= lang("Mata Uang", "Currency") ?>"},            
            {title:"<?= lang("Tanggal Aktif", "Effective Date") ?>"},            
            {title:"<?= lang("Tanggal Kadaluarsa", "Expired Date") ?>"},            
            {title:"<?= lang("Status", "Status") ?>"},            
            {title:"<?= lang("Deskripsi", "Description") ?>"},            
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},            
        ] 
    });        
    var tabel3 = $('#asrnc').DataTable({        
        ajax: {
            url: '<?= base_url('vn/info/bid_proposal/show_asrnc/') ?>'+id,
            'dataSrc': ''
        },
        "scrollX": true,
        "selected": true,
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false,        
        "columns": [            
            {title:"No"},
            {title:"<?= lang("No Jaminan Pelaksanaan", "Performance Bond No") ?>"},
            {title:"<?= lang("Penerbit", "Issuer") ?>"},
            {title:"<?= lang("Tanggal Terbit", "Issued Date") ?>"},
            {title:"<?= lang("Jumlah", "Value") ?>"},
            {title:"<?= lang("Mata Uang", "Currency") ?>"},            
            {title:"<?= lang("Tanggal Aktif", "Effective Date") ?>"},            
            {title:"<?= lang("Tanggal Kadaluarsa", "Expired Date") ?>"},            
            {title:"<?= lang("Status", "Status") ?>"},            
            {title:"<?= lang("Deskripsi", "Description") ?>"},            
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},            
        ] 
    });        
}
</script>
