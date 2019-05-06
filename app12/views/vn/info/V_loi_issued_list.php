<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= lang("Dafter Letter of Intent", "Letter of Intent List") ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Dafter Letter of Intent", "Letter of Intent List") ?></li>
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
                              <th>Letter No.</th>
                              <th>Title</th>
                              <th>Company</th>
                              <th>Date</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          if (count($lois) > 0):
                            $no = 1;
                            foreach ($lois as $loi) :
                            ?>
                              <tr>
                                <td><?= @$no++ ?></td>
                                <td><?= @$loi->company_letter ?></td>
                                <td><?= @$loi->title ?></td>
                                <td><?= $m_master_company->find(@$loi->id_company)->DESCRIPTION ?></td>
                                <td><?= @$loi->loi_date ? dateToIndo($loi->loi_date) : '' ?></td>
                                <td class="text-center">
                                  <?php
                                  if ($loi->accepted == 1) {
                                    $btn_class = "btn-info";
                                    $url = 'vn/info/greetings/showLoi/'.$loi->id;
                                    $btn_text = 'Detail';
                                  } else {
                                    $btn_class = "btn-primary";
                                    $url = 'vn/info/greetings/loiAcceptance/'.$loi->id;
                                    $btn_text = 'Process';
                                  }
                                  ?>
                                      <a href="<?= base_url($url) ?>" class="btn btn-sm <?= $btn_class ?>"><?= $btn_text ?></a>
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
  })
</script>