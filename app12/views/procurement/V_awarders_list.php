<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">LOI/Agreement Preparation</h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
            <li class="breadcrumb-item active"><?= lang("Persiapan LOI/Agreement", "LOI/Agreement Preparation") ?></li>
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
                        <table id="acceptance_award_recommendation_table" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 15px">No</th>
                              <th>ED No</th>
                              <th>Subject</th>
                              <th>Company</th>
                              <th>Awarder</th>
                              <th>Acceptance Date</th>
                              <th class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          if (count($awarders) > 0):
                            $no = 1;
                            foreach ($awarders as $awarder) :
                              // $ori = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_msr')->row();
                              // $bl = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_bl')->row();
                              // $eq = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_eq_data')->row();
                               $vendor = $this->M_show_vendor->find($awarder->vendor_id);
                               $company = $this->db->where(['ID_COMPANY'=>$awarder->id_company])->get('m_company')->row();
                            ?>
                              <tr>
                                <td><?= @$no++ ?></td>
                                <td><?= @$awarder->bled_no ?></td>
                                <td><?= @$awarder->title ?></td>
                                <td><?= @$company->ABBREVIATION ?></td>
                                <td><?= @$vendor->NAMA ?></td>
                                <td><?= @$awarder->accept_award_date ?></td>
                                <td>
                                  <?php $loi_development_disabled = $awarder->loi_id && $awarder->loi_id != '' ? ' disabled' : '' ?>
                                  <a href="<?= base_url('procurement/loi/create/'.$awarder->id) ?>" class="btn btn-sm btn-primary<?= $loi_development_disabled ?>">
                                    LOI<br>Development
                                  </a>
                                  <?php /* endif; */ ?>
                                  <?php $po_development_disabled = $awarder->po_id  && $awarder->po_id != ''? ' disabled' : '' ?>
                                  <a href="<?= base_url('procurement/purchase_order/create/'.$awarder->id) ?>" class="btn btn-sm btn-success<?= $po_development_disabled ?>">
                                    Agreement<br>Development
                                  </a>
                                  <?php /* endif */ ?>
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
<script type="text/javascript">
  $(document).ready(function(){
    $('#acceptance_award_recommendation_table tfoot th').each(function (i) {
      var title = $('#acceptance_award_recommendation_table thead th').eq($(this).index()).text();
      if ($(this).text() == 'No') {
        $(this).html('');
      } else if ($(this).text() == 'Action') {
        $(this).html('');
      } else {
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
      }

    });
    var table = $('#acceptance_award_recommendation_table').DataTable({
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