<?php
$action_buttons = isset($action_buttons) && is_array($action_buttons) ?
    $action_buttons :
    [
        [
            'href' => base_url('/procurement/purchase_order/completed/'),
            'class' => 'btn btn-sm btn-success',
            'text' => 'Process'
        ]
    ]; 
?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= lang(@$title['IND'] ?: "Daftar Agreement yang Diterima", @$title['ENG'] ?: "Accepted Agreement List") ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
            <li class="breadcrumb-item active"><?= lang(@$title['IND'] ?: "Daftar Agreement yang Diterima", @$title['ENG'] ?: "Accepted Agreement List") ?></li>
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
                              <th>Subject Work</th>
                              <th>Agreement Date</th>
                              <th>Supplier</th>
                              <th>Accepted </th>
                              <th>Accepted By</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          if (count($pos) > 0):
                            $no = 1;
                            foreach ($pos as $po) :
                            $actor = supplier($po->completed_by);
                            ?>
                              <tr>
                                <td><?= @$no++ ?></td>
                                <td><?= @$po->po_no ?></td>
                                <td><?= @$po->msr_no ?></td>
                                <td><?= @$po->title ?></td>
                                <td><?= dateToIndo(@$po->po_date) ?></td>
                                <td><?= $po->nama_vendor?></td>
                                <td><?= dateToIndo(@$po->completed_date) ?></td>
                                <td><?= @$actor->NAMA ?></td>
                                <td class="text-center">
                                <?php foreach($action_buttons as $btn): ?>
                                    <a href="<?= rtrim(@$btn['href'], '/').'/'.$po->id?>" class="<?= @$btn['class']?>"><?= @$btn['text'] ?></a>
                                <?php endforeach; ?>
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
  })
</script>