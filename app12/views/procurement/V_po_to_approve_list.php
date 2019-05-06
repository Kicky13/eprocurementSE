<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">Agreement to be Approved</h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
            <li class="breadcrumb-item active"><?= lang("Agreement", "Agreement") ?></li>
            <li class="breadcrumb-item active"><?= lang("Agreement to be Approved", "Agreement to be Approved") ?></li>
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
                      <div class="table-responsive">
                        <table id="acceptance_award_recommendation_table" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                          <thead>
                            <tr>
                              <th style="1">No</th>
                              <th>Agreement No</th>
                              <th>Subject</th>
                              <th>Company</th>
                              <th>Supplier</th>
                              <th class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          if (count($pos) > 0):
                            foreach ($pos as $i => $po) :
                              // $ori = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_msr')->row();
                              // $bl = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_bl')->row();
                              // $eq = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_eq_data')->row();
                               $vendor = $this->M_show_vendor->find($po->id_vendor);
                               $msr = $this->M_msr->find($po->msr_no);
                               $company = @$this->M_master_company->find($po->id_company);
                            ?>
                              <tr>
                                <td><?= @$i + 1 ?></td>
                                <td><?= @$po->po_no?></td>
                                <td><?= @$po->title ?></td>
                                <td><?= @$company->ABBREVIATION ?></td>
                                <td><?= @$vendor->NAMA ?></td>
                                <td class="text-center">
                                  <?php /* if has ability to develop PO */ ?>
                                  <a href="<?= base_url('procurement/purchase_order/toApprove/'.$po->data_id) ?>" class="btn btn-sm btn-success">
                                    GO
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