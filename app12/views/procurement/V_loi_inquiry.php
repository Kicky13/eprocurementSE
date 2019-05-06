<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/jquery.dataTables.min.css">

<style>
body {
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    font-weight: normal;
}
</style>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= lang("Daftar LOI", "Letter of Intent List") ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
            <li class="breadcrumb-item active"><?= lang("Daftar LOI", "LOI List") ?></li>
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
                        <table id="loi_inquiry" class="table table-condensed table-striped" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 15px">No</th>
                              <th>Letter No</th>
                              <th>MSR No</th>
                              <th>Subject Work</th>
                              <th>Contractor</th>
                              <th>Create Date</th>
                              <th>Create By</th>
                              <!-- <th>Approval Status</th> -->
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          if (count($lois) > 0):
                            $no = 1;
                            foreach ($lois as $loi) :
                            $create_by = user($loi->create_by);
                            ?>
                              <tr>
                                <td><?= @$no++ ?></td>
                                <td><?= @$loi->company_letter ?></td>
                                <td><?= @$loi->msr_no ?></td>
                                <td><?= @$loi->title ?></td>
                                <td><?= @$loi->nama_vendor?></td>
                                <td><?= @$loi->create_on ?></td>
                                <td><?= @$create_by->NAME ?></td>
                                <!--
                                <td><a class="approval-history" data-loi_id="<?= @$loi->id ?>" href="<?= base_url('procurement/loi/logHistory/'. $loi->id)?>"><?= @$loi->action_to_role_description ?></a></td>
                                -->
                                <td>
                                  <a href="<?= base_url('procurement/loi/show/'.$loi->id) ?>" class="btn btn-sm btn-success">
                                    Show 
                                  </a>
                                </td>
                              </tr>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </tbody>
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
      <h5 class="modal-title">Approval History <strong>#<span id="approval-history-loi_no"></span></strong><input type="hidden" id="approval-history-loi_id"></h5>
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

<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {

$('#loi_inquiry').DataTable({
  'scrollY'   : true,
  'scrollX'   : true,
  "paging"    : true,
  "info"      : true,
  "searching" : true,
  "ordering"  : false,
  "processing": true,
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
    "url": '<?= base_url('procurement/loi/logHistory')?>' + '/-'
  }
});

$('#loi_inquiry').on('click', 'a.approval-history', function(e) {
    e.preventDefault()

    $('#approval-history-loi_id').text($(this).data('loi_id'))
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
