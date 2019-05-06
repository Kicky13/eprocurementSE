<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= lang("Daftar LOI yang Diterima", "Accepted Letter of Intent List") ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
            <li class="breadcrumb-item active"><?= lang("LOI yang Diterima", "Accepted LOI List") ?></li>
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
                        <table id="loi_inquiry" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 15px">No</th>
                              <th>Letter No</th>
                              <th>MSR No</th>
                              <th>Subject Work</th>
                              <th>Contractor</th>
                              <th>Accepted Date</th>
                              <th>Accepted By</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          if (count($lois) > 0):
                            $no = 1;
                            foreach ($lois as $loi) :
                            $accepted_by = user($loi->accepted_by);
                            ?>
                              <tr>
                                <td><?= @$no++ ?></td>
                                <td><?= @$loi->company_letter ?></td>
                                <td><?= @$loi->msr_no ?></td>
                                <td><?= @$loi->title ?></td>
                                <td><?= @$loi->nama_vendor?></td>
                                <td><?= dateToIndo(@$loi->accept_award_date) ?></td>
                                <td><?= @$accepted_by->NAME ?></td>
                                <!--
                                <td><a class="approval-history" data-loi_id="<?= @$loi->id ?>" href="<?= base_url('procurement/loi/logHistory/'. $loi->id)?>"><?= @$loi->action_to_role_description ?></a></td>
                                -->
                                <td class="text-center">
                                  <a href="<?= base_url('procurement/loi/show/'.$loi->id) ?>" class="btn btn-sm btn-success">
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

</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#loi_inquiry tfoot th').each(function (i) {
      var title = $('#loi_inquiry thead th').eq($(this).index()).text();
      if ($(this).text() == 'No') {
        $(this).html('');
      } else if ($(this).text() == 'Action') {
        $(this).html('');
      } else {
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
      }

    });
    var table = $('#loi_inquiry').DataTable({
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