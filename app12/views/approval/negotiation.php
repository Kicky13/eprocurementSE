<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Negotiation", "Negotiation") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item">Negotiation</li>
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
                            <div class="row">
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table id="tbl" class="table table-border table-striped table-no-wrap">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>ED Number</th>
                                                    <th>Subject</th>
                                                    <th>Company</th>
                                                    <th>Invitation Date</th>
                                                    <th>Pre Bid Meeting</th>
                                                    <th>Bid Validity</th>
                                                    <th>Closing Date</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1 ?>
                                                <?php foreach ($rs_ed as $r_ed) { ?>
                                                    <tr>
                                                        <td><?= $no ?></td>
                                                        <td><?= str_replace('OR', 'OQ', $r_ed->msr_no) ?></td>
                                                        <td><?= $r_ed->subject ?></td>
                                                        <td><?= $r_ed->company ?></td>
                                                        <td><?= dateToIndo($r_ed->issued_date, false, true) ?></td>
                                                        <td><?= dateToIndo($r_ed->prebiddate, false, true) ?></td>
                                                        <td><?= dateToIndo($r_ed->bid_validity, false, true) ?></td>
                                                        <td><?= dateToIndo($r_ed->closing_date, false, true) ?></td>
                                                        <td class="text-center">
                                                            <a href="<?= base_url('procurement/ed/sop_edit/'.str_replace('OR', 'OQ', $r_ed->msr_no)) ?>" class="btn btn-warning btn-sm">Edit SOP</a>
                                                            <a href="<?= base_url('approval/approval/negotiation_detail/'.$r_ed->msr_no) ?>" class="btn btn-success btn-sm">Negotiation</a>
                                                        </td>
                                                    </tr>
                                                    <?php $no++ ?>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                </tr>
                                            </tfoot>
                                        </table>
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
    $('#tbl thead th').each(function (i) {
      var title = $('#tbl thead th').eq($(this).index()).text();
      if ($(this).is(':first-child') || $(this).is(':last-child')) {
        $('#tbl tfoot tr').append('<th>'+title+'</th>');
      } else {
        $('#tbl tfoot tr').append('<th><input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" /></th>');
      }
    });

    var table = $('#tbl').DataTable({
      scrollX: true,
      fixedColumns: {
        leftColumns: 0,
        rightColumns: 1
      }
    })

    $(table.table().container()).on('keyup', 'tfoot input', function () {
      table.column($(this).data('index')).search(this.value).draw();
    });
  })
</script>