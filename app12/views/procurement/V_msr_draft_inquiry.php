<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= lang("Daftar Draft MSR", "MSR Draft List") ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
            <li class="breadcrumb-item active"><?= lang("Daftar Draft MSR", "MSR Draft Inquiry") ?></li>
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
              </div>
              <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                  <div class="row">
                    <div class="col-md-12">
                    <?php if ($this->session->flashdata('message')): ?>
                      <?php $message = $this->session->flashdata('message') ?>
                      <div class="alert alert-dismissible alert-<?= $message['type'] ?>" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                        <?= $message['message'] ?>
                      </div>
                    <?php endif; ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table id="msr_inquiry" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 15px">No</th>
                              <th>Draft No</th>
                              <th>Subject</th>
                              <th>Company</th>
                              <th>Created Date</th>
                              <th>Created By</th>
                              <th class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          if (count($msrs) > 0):
                            $no = 1;
                            foreach ($msrs as $msr) :
                            $create_by = user($msr->create_by);
                            ?>
                              <tr>
                                <td><?= @$no++ ?></td>
                                <td><?= @$msr->id ?></td>
                                <td><?= @$msr->title ?></td>
                                <td><?= @$msr->ABBREVIATION ?></td>
                                <td><?= @$msr->create_on ?></td>
                                <td><?= @$create_by->NAME ?></td>
                                <td class="text-center">
                                  <a href="<?= base_url('procurement/msr/createFromDraft/'.$msr->id) ?>" class="btn btn-sm btn-warning">
                                    Edit
                                  </a>
                                </td>
                              </tr>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>No</th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th class="text-center">Action</th>
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
<script>
$(document).ready(function() {
$('#msr_inquiry tfoot th').each(function (i) {
  var title = $('#msr_inquiry thead th').eq($(this).index()).text();
  if ($(this).text() == 'No') {
    $(this).html('');
  } else if ($(this).text() == 'Action') {
    $(this).html('');
  } else {
    $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
  }

});
var table = $('#msr_inquiry').DataTable({
  scrollX : true,
  fixedColumns: {
      leftColumns: 0,
      rightColumns: 1
  },
});
$(table.table().container()).on('keyup', 'tfoot input', function () {
  table.column($(this).data('index')).search(this.value).draw();
});

});
</script>
