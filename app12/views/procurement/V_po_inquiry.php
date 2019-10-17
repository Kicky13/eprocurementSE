<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= lang("Daftar Agreement", "Agreement List") ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
            <li class="breadcrumb-item active"><?= lang("Daftar Agreement", "Agreement List") ?></li>
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
                        <table id="po_inquiry" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 15px">No</th>
                              <th>Agreement No</th>
                              <th>MSR No</th>
                              <th>JDE No</th>
                              <th>Subject Work</th>
                              <th>Agreement Date</th>
                              <th>Requestor Department</th>
                              <th>Supplier</th>
                              <th>Expiry Date/Delivery Date</th>
                              <th>Proc.Specialist</th>
                              <th>Currency</th>
                              <th class="text-right">Agreement Value</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          if (count($pos) > 0):
                            $no = 1;
                            foreach ($pos as $po) :
                            $create_by = user($po->create_by);
                            ?>
                              <tr>
                                <td><?= @$no++ ?></td>
                                <td><?= @$po->po_no ?></td>
                                <td><?= @$po->msr_no ?></td>
                                <td><?= @$po->isclosed ? $po->doc_no : '' ?></td>
                                <td><?= @$po->title ?></td>
                                <td><?= @dateToIndo($po->po_date) ?></td>
                                <td><?= @$po->department_requestor ?></td>
                                <td><?= $po->nama_vendor?></td>
                                <td><?= @dateToIndo($po->delivery_date) ?></td>
                                <td><?= @$create_by->NAME ?></td>
                                <td><?= @$po->CURRENCY ?></td>
                                <td class="text-right"><?= @numIndo($po->total_amount) ?></td>
                                <td><a class="approval-history" data-po_no="<?= @$po->po_no ?>" data-po_id="<?= @$po->id ?>" href="<?= base_url('procurement/purchase_order/logHistory/'. $po->id)?>"><?= @$po->action_to_role_description ?></a></td>
                                <td class="text-center">
                                  <a href="<?= base_url('procurement/purchase_order/show/'.$po->id) ?>" class="btn btn-sm btn-info">
                                    View
                                  </a>
                                  <?php 
                                    foreach ($po_issued as $arf) {
                                      if($arf->po_no == $po->po_no)
                                      {
                                        echo "<a href='#' class='btn btn-sm btn-danger' onclick=\"arfClick('$arf->po_no')\">AMD</a>";
                                      }
                                    }
                                  ?>
                                </td>
                              </tr>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th>No</th>
                              <th>Agreement No</th>
                              <th>MSR No</th>
                              <th>JDE No</th>
                              <th>Subject Work</th>
                              <th>Agreement Date</th>
                              <th>Requestor Department</th>
                              <th>Supplier</th>
                              <th>Expiry Date/Delivery Date</th>
                              <th>Proc.Specialist</th>
                              <th>Currency</th>
                              <th>Agreement Value</th>
                              <th>Status</th>
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

<div id="approval-history-modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Approval History <strong>#<span id="approval-history-po_no"></span></strong><input type="hidden" id="approval-history-po_id"></h5>
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

<div id="arf-modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">ARF List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body arf-list">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

$('#po_inquiry tfoot th').each(function (i) {
  var title = $('#po_inquiry thead th').eq($(this).index()).text();
  if ($(this).text() == 'No') {
    $(this).html('');
  } else if ($(this).text() == 'Action') {
    $(this).html('');
  } else {
    $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
  }

});
var table = $('#po_inquiry').DataTable({
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
    "url": '<?= base_url('procurement/purchase_order/logHistory')?>' + '/-'
  }
});

$('#po_inquiry').on('click', 'a.approval-history', function(e) {
    e.preventDefault()

    $('#approval-history-po_id').text($(this).data('po_id'))
    $('#approval-history-po_no').text($(this).data('po_no'))
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
var arf_issued = <?= json_encode($arf_issued) ?>;
function arfClick(po_no) {
  $(".arf-list").html('');
  $.each(arf_issued, function (index, value){
    if(value.po_no == po_no)
    {
      $(".arf-list").append("<a href='<?= base_url('procurement/amendment_recommendation/amd_view') ?>/"+ value.arf_response_id +"/?amd=1' class='btn btn-primary btn-block' target='_blank '>"+value.doc_no+"</a>");
    }
  });
  $("#arf-modal").modal('show')
}
</script>
