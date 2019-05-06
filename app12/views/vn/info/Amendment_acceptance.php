<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title">Amendment Acceptance</h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
                        <li class="breadcrumb-item">Amendment Acceptance</li>
                    </ol>
                </div>
            </div>
        </div>
        <?php $this->load->view('V_alert') ?>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Agreement No</th>
                                                            <th>Amendment No</th>
                                                            <th>Subject</th>
                                                            <th>Company</th>
                                                            <th>Amendment Date</th>
                                                            <!-- <th class="text-center">Status</th> -->
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $no = 1;
                                                        foreach ($model as $row) { ?>
                                                            <tr>
                                                                <td><?= $no++ ?></td>
                                                                <td><?= $row->po_no ?></td>
                                                                <td><?= substr($row->doc_no, -5) ?></td>
                                                                <td><?= $row->title ?></td>
                                                                <td><?= $row->company ?></td>
                                                                <td><?= dateToIndo($row->doc_date) ?></td>
                                                                <!-- <td class="text-center">
                                                                    <?php if ($row->acceptance) { ?>
                                                                        Accepted
                                                                    <?php } else { ?>
                                                                        Unaccept
                                                                    <?php } ?>
                                                                </td> -->
                                                                <td class="text-center">
                                                                    <a href="<?= base_url('vn/info/amendment_acceptance/create/'.$row->id) ?>" class="btn btn-primary btn-sm">Acceptance</a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>No</th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Action</th>
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
                </div>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#tbl tfoot th').each(function (i) {
      var title = $('#tbl thead th').eq($(this).index()).text();
      if ($(this).text() == 'No') {
        $(this).html('');
      } else if ($(this).text() == 'Action') {
        $(this).html('');
      } else {
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
      }

    });
    var table = $('#tbl').DataTable({
      scrollX : true,
      fixedColumns: {
          leftColumns: 0,
          rightColumns: 1
      },
    });
    $(table.table().container()).on('keyup', 'tfoot input', function () {
      table.column($(this).data('index')).search(this.value).draw();
    });
  })
</script>