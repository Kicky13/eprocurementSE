<div class="app-content content V_perform_itp_accepted">
    <div class="content-wrapper">
      <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-1">
              <h3 class="content-header-title"><?= lang("ITP Accepted", "ITP Accepted") ?></h3>
          </div>
          <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
              <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="<?= base_url() ?>vn/info/greetings">Home</a></li>
                      <li class="breadcrumb-item active"><?= lang("ITP Document", "ITP") ?></li>
                      <li class="breadcrumb-item active"><?= lang("ITP Accepted", "ITP Accepted") ?></li>
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
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <div class="heading-elements">
                                            <h5 class="title pull-right">

                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-content collapse show itp_agrement">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tbl_itp_accepted" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                                <tfoot>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                        <th><center><?= lang("No Persetujuan", "Agrement No") ?></center></th>
                                                        <th><center><?= lang("PO", "PO") ?></center></th>
                                                        <th><center><?= lang("Contractor", "Contractor") ?></center></th>
                                                        <th><center><?= lang("Date", "Date") ?></center></th>
                                                        <th><center><?= lang("Aksi", "Action") ?></center></th>
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

<?php $this->load->view('vn/info/V_perform_itp') ?>

<script type="text/javascript">
  $(document).ready(function() {
    $(".V_perform_itp").hide();

    $('#tbl_itp_accepted tfoot th').each(function (i) {
            var title = $('#tbl_itp_accepted thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" data-index="' + i + '" />');
    });
    var table=$('#tbl_itp_accepted').DataTable({
        "ajax": {
            "url": "<?= base_url('vn/info/Perform_itp/show_itpuser_accepted') ?>",
            "dataSrc": ""
        },
        "data": null,
        "searching": true,
        "paging": true,
        "columns": [
          {title: "<center>No</center>"},
          {title: "<center><?= lang("No Persetujuan", "Agrement No") ?></center>"},
          {title: "<center><?= lang("ITP No", "ITP No") ?></center>"},
          {title: "<center><?= lang("Contractor", "Contractor") ?></center>"},
          {title: "<center><?= lang("Status", "Status") ?></center>"},
          {title: "<center><?= lang("Tgl Dokumen Dibuat", "Date Created Document") ?></center>"},
          {title: "<center><?= lang("Aksi", "Action") ?></center>"}
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
    $(table.table().container()).on('keyup', 'tfoot input', function () {
      table.column($(this).data('index')).search(this.value).draw();
    });
  });
</script>
