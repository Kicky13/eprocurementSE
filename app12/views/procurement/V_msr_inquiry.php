<?php
$page_title = isset($page_title) ? $page_title : ['IND' => 'MSR List', 'ENG' => 'MSR List'];
?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">

<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= lang(@$page_title['IND'], @$page_title['ENG']) ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
            <li class="breadcrumb-item active"><?= lang(@$page_title['IND'], @$page_title['ENG']) ?></li>
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
                    <div class="col-md-12 text-right">
                      <!--<a href="<?= base_url('procurement/msr/create') ?>" class="btn btn-success"><i class="fa fa-plus-circle"></i> Create</a>-->
                    </div>
                    <div class="col-md-12">
                        <table id="msr_inquiry" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 15px">No</th>
                              <th>MSR No</th>
                              <th>Subject</th>
                              <th>Company</th>
                              <th>Created Date</th>
                              <th>Created By</th>
                              <th>Currency</th>
                              <th class="text-right">MSR Value</th>
                              <th>Approval Status</th>
                              <th>Proc. Specialist</th>
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
                                <td><?= @$msr->msr_no ?></td>
                                <td><?= @$msr->title ?></td>
                                <td><?= @$msr->ABBREVIATION ?></td>
                                <td><?= @dateToIndo($msr->create_on, false, true) ?></td>
                                <td><?= @$create_by->NAME ?></td>
                                <td><?= @$msr->CURRENCY ?></td>
                                <td class="text-right"><?= @numIndo($msr->total_amount) ?>
                                <td><a class="approval-history" data-msr_no="<?= @$msr->msr_no ?>" href="<?= base_url('procurement/msr/logHistory/'. $msr->msr_no)?>"><?= @$msr->action_to_role_description ?></a></td>
                                <td><?= @$msr->procurement_specialist_name ?></td>
                                <td class="text-center">
                                  <a href="<?= base_url('procurement/msr/show/'.$msr->msr_no) ?>" class="btn btn-sm btn-info">
                                    Detail
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
      </section>
    </div>
  </div>
</div>

<div id="approval-history-modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Approval History <strong>#<span id="approval-history-msr_no"></span></strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="approval-history-table" class='table table-stripped table-condensed' style="width: 100%">
          <thead>
          <tr>
            <th data-name="activity" data-data="activity">Activity</th>
            <th data-name="comment" data-data="comment">Comment</th>
            <th data-name="created_at" data-data="created_at">Transaction Date</th>
          </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
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
$('#approval-history-table').DataTable({
  'scrollY'   : true,
  'scrollX'   : false,
  "paging"    : false,
  "info"      : false,
  "searching" : false,
  "ordering"  : false,
  "processing": true,
  "deferRender": true,
  "deferLoading": true,
  "ajax": {
    "method": "GET",
    "url": '<?= base_url('procurement/msr/logHistory')?>' + '/-'
  }
});

$('#msr_inquiry').on('click', 'a.approval-history', function(e) {
    e.preventDefault()

    $('#approval-history-msr_no').text($(this).data('msr_no'))
    $('#approval-history-table').DataTable().ajax.url($(this).prop('href'))
    // show modal
    $('#approval-history-modal').modal('show')
})

$('#approval-history-modal').on('show.bs.modal', function() {
    $('#approval-history-table').DataTable()
      .clear().draw()
      .ajax.reload().draw()
})

});
</script>
