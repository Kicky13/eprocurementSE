
<div class="app-content content">
<div class="content-wrapper">
    <div class="content-header row">        
    </div>
    <div class="content-detached">
        <div class="content-body" id="daftar">
            <section>
                <div class="card">
                    <div class="card-header">
                        <h3 class="content-header-title mb-1"><?= lang("Daftar Lelang", "Open Bid List") ?></h3>            
                        <!-- <h4 class="card-title"><?= lang("Pilih untuk Lelang", "Open to Bid"); ?></h4>                         -->                        
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">                                
                                <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <table id="datalelang" class="table table-striped table-bordered table-hover display" width="100%">                                                                                                
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="content-body" id="detail">
            <section>
                <div class="card">
                    <div class="card-header" style="background-color:#d3f7ef">                        
                        <div class="col-12 row">
                            <div class="col-12">                            
                                <h3 class="content-header-title mb-1">PT. Supreme Energy <span id="company"></span></h3>                                    
                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
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
                                <div class="project-info-count col-1">
                                    <button onclick="choose(1)" id="main-b-1" class="project-info-icon btn btn-primary">
                                        <i class="fa fa-paper-plane"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Invitation</h6>
                                    </div>
                                </div>
                                <div class="project-info-count col-1">
                                    <button onclick="choose(2)" id="main-b-2" class="project-info-icon btn btn-default">
                                        <i class="fa fa-info"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Instruction</h6>
                                    </div>
                                </div>
                                <div class="project-info-count col-1">
                                    <button onclick="choose(3)" id="main-b-3" class="project-info-icon btn btn-default">
                                        <i class="fa fa-file-text-o"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Form of Bid</h6>
                                    </div>
                                </div>
                                <div class="project-info-count col-1">
                                    <button onclick="choose(4)" id="main-b-4" class="project-info-icon btn btn-default">
                                        <i class="fa fa-file-text-o"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Form of PO</h6>
                                    </div>
                                </div>
                                <div class="project-info-count col-1">
                                    <button onclick="choose(5)" id="main-b-5" class="project-info-icon btn btn-default">
                                        <i class="fa fa-paperclip"></i>                       
                                    </button>
                                    <div class="project-info-text">
                                        <h6>Attachment</h6>
                                    </div>
                                </div>
                                <div class="project-info-count col-1">
                                    <button onclick="choose(6)" id="main-b-6" class="project-info-icon btn btn-default">
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
                                <h5 class="text-center"><b><u>Undangan Lelang</u><br/>Invitation To Bid</b></h5>
                                <div id="main-c-1">
                                </div>
                            </div>
                            <div class="col-12" id="main-p-2">
                                <h5 class="text-center"><b><u>Petunjuk Penawaran</u><br/>INSTRUCTION To Bid</b></h5>
                                <div id="main-c-2">
                                </div>
                            </div>
                            <div class="col-12" id="main-p-3">
                                <h5 class="text-center"><b><u>Format Penawaran</u><br/>Form Of Bid</b></h5>
                                <div id="main-c-3">
                                </div>
                            </div>
                            <div class="col-12" id="main-p-4">
                                <h5 class="text-center"><b><u>Format PO</u><br/>Form Of PO</b></h5>
                                <div id="main-c-4">
                                </div>
                            </div>
                            <div class="col-12" id="main-p-5">
                                <h5 class="text-center"><?=lang("<b><u>Lampiran Dokumen</u></b>","<b><u>Attachment Document</u></b>")?></h5>
                                <table id="attch" class="table table-striped table-bordered table-hover display" width="100%"></table>
                            </div>
                            <div class="col-12" id="main-p-6">
                                <div class="modal-body chat-application" style="padding:0px">
                                    <section class="chat-app-window" style="border:1px solid #edeef0">
                                        <div class="badge badge-default mb-1">Chat History</div>
                                            <input type="text" id="type_msg" style="display:none">
                                            <div class="chats">
                                                <div id="message" class="chats">                                
                                            </div>
                                        </div>
                                    </section>
                                    <section class="chat-app-form">
                                        <form id="chat" class="chat-app-input d-flex">
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
                                    <button class="btn btn-success" onclick="process(23)"><?=lang("Konfirmasi Bergabung","Join Confirmation")?></button>
                                    <button class="btn btn-danger" onclick="process(24)"><?=lang("Konfirmasi tidak bergabung","Withdraw Confirmation")?></button>
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
    <div class="modal-dialog modal-lg" style="width:800px">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="proc_msg" class="col-12">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?=lang("Batal","cancel")?></button>
                <button class="btn btn-success" id="snd_join" onclick="send(1)"><?=lang("Bergabung","Join")?></button>
                <button class="btn btn-danger" id="snd_wthdr" onclick="send(0)"><?=lang("Tidak bergabung","Withdraw")?></button>            
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    $('#detail').hide();
    window.index=1;
    lang();
    
    $('#min').click(function (){
        if(index==1)
            index=1;
        else
            index--;
        display(index);
    });
    $('#plus').click(function (){
        if(index==6)
            index=6;
        else
            index++;
        display(index);
    });
    $('#confirm').click(function (){        
        index=6;        
        display(index);
    });
    
    var tabel = $('#datalelang').DataTable({        
        ajax: {
            url: '<?= base_url('vn/info/bid_invite/show_list_invite') ?>',
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
            {title:"<span>No</span>"},
            {title:"<?= lang("Nomor ED", "ED Number") ?>"},
            {title:"<?= lang("Pekerjaan", "Subject Work") ?>"},
            {title:"<?= lang("Perusahaan", "Company") ?>"},
            {title:"<?= lang("Tanggal Undangan", "Invitation Date") ?>"},
            {title:"<?= lang("Tanggal Buka", "Pre Bid Date") ?>"},
            {title:"<?= lang("Tanggal Tutup", "Closing Date") ?>"},            
            {title:"<?= lang("&nbsp&nbsp&nbsp   Aksi   &nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp   Action   &nbsp&nbsp&nbsp") ?>"},
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
    $('#datalelang tbody').on('click', 'tr .detail', function () {
        var data2 = tabel.row($(this).parents('tr')).data();        
        $('#document').html(data2[2]);
        $('#ref_num').html(data2[1]);
        $('#daftar').hide();        
        init();
        $('#detail').show();        
        tbl(this.id);        
        lang();
        $('#chat :input').prop('disabled',false);
        
        $('#attch').DataTable().columns.adjust().draw();
    });
    
});

function send()
{
    var obj={};
    obj.msg=$('#send_msg').val();
    obj.type=$('#type_msg').val();    
    $.ajax({
        type: 'POST',
        url: '<?= base_url('vendor/bid_invite/send_comment/') ?>',
        data: obj,
        success: function (m) {                    
            if(m!=false)
                modal_komen(obj.type);
            else
                msg_danger('Gagal',"Terjadi kesalahan");
        }
    });
}

function modal_komen(type) {
    var obj={};
    obj.type=type;
    
    $.ajax({
        type: 'POST',
        url: '<?= base_url('vendor/bid_invite/comment/') ?>',
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
    if(index == 1)
    {
        addr="get_invitation";
        dt=25;
    }
    if(index <= 4)
        get_tampilan(addr,index,dt);
    else{
        $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .fixedColumns().relayout();
    }
}

function get_tampilan(addr,idx,dt)
{
    var elm = start($('body'));
    var obj={};
    obj.entity_id=dt;
    $.ajax({
        type: 'POST',
        url: '<?= base_url('vn/info/bid_invite/') ?>'+addr,        
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
    for(i=1;i<7;i++)
    {
        if(i==1)
            $('#main-p-'+index).show();
        else
            $('#main-p-'+i).hide();
    }
    addr="get_invitation";
    dt=25;        
    get_tampilan(addr,index,dt);
}

function choose(sel)
{
    index=sel;
    display(sel);
}

function process(id)
{
    var obj={};
    obj.entity_id=id;
    $.ajax({
        type: 'POST',
        url: '<?= base_url('vn/info/bid_invite/process/') ?>',
        data: obj,
        success: function (m) {                                            
            $('#proc_msg').html(m[0].OPEN_VALUE+m[0].CLOSE_VALUE);
            if(id==23)
            {            
                $('#snd_join').show();
                $('#snd_wthdr').hide();
                $("#modal_process .modal-header").css({"backgroundColor": "#10C888", "color": "white"});
                $('#modal_process .modal-title').html("<?=lang('Konfirmasi Bergabung','Join Confirmation')?>");            
            }
            else
            {
                $('#snd_wthdr').show();
                $('#snd_join').hide();
                $("#modal_process .modal-header").css({"backgroundColor": "#FF6275", "color": "white"});
                $('#modal_process .modal-title').html("<?=lang('Konfirmasi Tidak Bergabung','Withdraw Confirmation')?>");            
            }
            $('#modal_process').modal("show");            
            lang();            
        }
    });                
}

function send(sel)
{
    var addr="";
    if(sel === 0)
        addr="<?= base_url('vendor/bid_invite/join/') ?>";
    else if(sel === 1)
        addr="<?= base_url('vendor/bid_invite/wthdr/') ?>";
        var obj={};    
    $.ajax({
        type: 'POST',
        url: addr,    
        success: function (m) {                                            
            if(m.status != "Error")
            {
                msg_info("Berhasil",m.msg);
            }
            else
            {
                msg_danger("Gagal",m.msg);
            }
            lang();            
        }
    });                
}

function tbl(id)
{        
    var tabel2 = $('#attch').DataTable({        
        ajax: {
            url: '<?= base_url('vn/info/bid_invite/show_attch/') ?>'+id,
            'dataSrc': ''
        },
        "scrollX": true,
        "selected": true,
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false,        
        "columns": [            
            {title:"<?= lang("Tipe", "Type") ?>"},
            {title:"<?= lang("SEQ", "SEQ") ?>"},
            {title:"<?= lang("Nama File", "File Name") ?>"},
            {title:"<?= lang("Tanggal Upload", "Upload At") ?>"},
            {title:"<?= lang("Diupload oleh", "Uploader") ?>"},            
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
