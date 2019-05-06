<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div id="main" class="wrapper wrapper-content animated fadeInRight">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-1">
                  <h3 class="content-header-title"><?= lang("Performa Supplier", "Supplier Performance Rating") ?></h3>
                </div>

                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home">Home</a>
                            </li>
                            <li class="breadcrumb-item"><?= lang("Management Supplier", "Management Supplier") ?>
                            </li>
                            <li class="breadcrumb-item"><?= lang("Review and Approve SLKA", "Supplier Performance Rating") ?>
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
                                                <table id="tbl" class="table nowrap table-striped table-bordered zero-configuration" width="100%">

                                                  <tfoot>
                                                      <tr>
                                                        <th>No</th>
                                                        <th>NO SLKA</th>
                                                        <th>Nama Vendor</th>
                                                        <th>Supply Category</th>
                                                        <th>Agreement (n)</th>
                                                        <th>Average Rating (n)</th>
                                                        <th>History</th>
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
                                        <button type="button" class="btn btn-default back" id="back" aria-hidden="true"><i class="fa fa-arrow-circle-o-left"></i>&nbsp<?= lang("Kembali", "Back") ?></button>
                                    </div>
                                </div>
                            </div>
                            <h4 class="form-group pull-left"><strong><?= lang("Rekap Supplier ", "Supplier History ") ?><span id="nama"></span></strong></h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table id="tbl2" class="table table-striped table-bordered zero-configuration" width="100%">
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function()
{
    $('#tbl tfoot th').each( function (i) {
      var title = $('#tbl thead th').eq( $(this).index() ).text();
      if ($(this).text() == 'No') {
        $(this).html('');
      } else if ($(this).text() == 'History') {
        $(this).html('');
      } else {
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
      }
    });

    var table = $('#tbl').DataTable({
        "ajax": {
            "url": "<?= base_url('vendor/supplier_performance/show') ?>",
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
            {title:"<center>No</center>"},
            {title:"<center>SLKA</center>"},
            {title:"<center>Vendor Name</center>"},
            {title:"<center>Supply Category</center>"},
            {title:"<center>Agreement (n)</center>"},
            {title:"<center>Average Rating (n)</center>"},
            {title:"<center>History</center>"}
        ],
        "columnDefs": [
            {"className": "dt-right", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},
            {"className": "dt-center", "targets": [5]},
        ],
        "scrollX": true,
        "scrollY": '300px',
        "scrollCollapse": true,
    });

    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that.search( this.value ).draw();
            }
        });
    });
    slidesOut();
    $('#back').click(function(){
        $('#tbl2').DataTable().destroy();
        slidesOut();
    });

});
function slidesIn()
{
    $('#main').hide();
    $('#edit').show();
}
function slidesOut()
{
    $('#edit').hide();
    $('#main').show();
}
function proc(id)
{
    var obj={};
    obj.ID=id;
    $.ajax({
        url:"<?= base_url('vendor/supplier_performance/get_nama/')?>"+id,
        type:"POST",
        data:obj,
        success:function(m){
            console.log(m);
            if(m!= false)
            {

                $('#nama').html(m[0].NAMA);
                slidesIn();
                tbl(id);
            }
        }
    });
}
function tbl(id)
{
    $('#tbl2 tfoot th').each( function (i) {
      var title = $('#tbl2 thead th').eq( $(this).index() ).text();
      if ($(this).text() == 'No') {
        $(this).html('');
      } else if ($(this).text() == 'History') {
        $(this).html('');
      } else {
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
      }
    });

    var table = $('#tbl2').DataTable({
        "ajax": {
            "url": "<?= base_url('vendor/supplier_performance/get_hist/') ?>"+id,
            "dataSrc": ""
        },
        "data": null,
        "searching": true,
        "paging": true,
        "columns": [
            {title:"<center>No</center>"},
            {title:"<center>Agreement No</center>"},
            {title:"<center>COR No</center>"},
            {title:"<center>Total Value</center>"}
        ],
        "columnDefs": [
            {"className": "dt-right", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
        ],
        "scrollX": true,
        "scrollY": '300px',
        "scrollCollapse": true,
    });
}
</script>
