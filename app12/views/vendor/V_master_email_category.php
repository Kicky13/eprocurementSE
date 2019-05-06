<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>

<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">
<script src="<?= base_url() ?>ast11/js/plugins/summernote/summernote.min.js"></script>

<script src="<?php echo base_url()?>ast11/filter/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>ast11/filter/scripts.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>


<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-1">
          <h3 class="content-header-title"><?= lang('Master Email', 'Master Email') ?></h3>
        </div>
        <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Home</a>
              </li>
              <li class="breadcrumb-item"><a href="#"><?= lang("Managemen Supplier", "Supplier Management") ?></a>
              </li>
              <li class="breadcrumb-item active"><?= lang("Master Email Category", "Master Email Category") ?>
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
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                    <tfoot>
                                        <tr>
                                            <th><center>No</center></th>
                                            <th><center>code</center></th>
                                            <th><center>code</center></th>
                                            <th><center>aksi</center></th>
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
</div>
<script type="text/javascript">
  $(document).ready(function() {

  });

  
  $('#tbl tfoot th').each( function (i) {
    var title = $('#tbl thead th').eq( $(this).index() ).text();
    $(this).html( '<input type="text" placeholder="Search '+title+'" data-index="'+i+'" />' );
  });
  lang();

  var table=$('#tbl').DataTable({
    ajax: {
        url: '<?= base_url('vendor/Master_email/show_email_category') ?>',
        dataSrc: ''
    },
    scrollX: true,
    scrollY: '300px',
    scrollCollapse: true,
    paging: true,
    filter: true,
    info:true,
    columns: [
        {title: "<center>No</center>"},
        {title: "<center><?= lang('Email Category', 'Email Category') ?></center>"},
        {title: "<center><?= lang('Create Date', 'Create Date') ?></center>"},
        {title: "<center><?= lang("Aksi", "Action") ?></center>", "width": "50px"},
    ],
    "columnDefs": [
      {"className": "dt-center", "targets": [0]},
      {"className": "dt-center", "targets": [1]},
      {"className": "dt-center", "targets": [2]},
      {"className": "dt-center", "targets": [3]},
    ]
  });
  $(table.table().container() ).on( 'keyup', 'tfoot input', function () {
          table.column( $(this).data('index') )
          .search( this.value )
          .draw();
  });
</script>
