<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">LOI to be Approved</h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
            <li class="breadcrumb-item active"><?= lang("LOI", "LOI") ?></li>
            <li class="breadcrumb-item active"><?= lang("LOI to be Approved", "LOI to be Approved") ?></li>
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
                              <th style="width: 15px">No</th>
                              <th>ED Number</th>
                              <th>Subject Work</th>
                              <th>Company</th>
                              <th>Awarder</th>
                              <th>Acceptance Date</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          if (count($lois) > 0):
                            $no = 1;
                            foreach ($lois as $loi) :
                              // $ori = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_msr')->row();
                              // $bl = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_bl')->row();
                              // $eq = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_eq_data')->row();
                               $vendor = $this->M_show_vendor->find($loi->awarder_id);
                               $company = @$this->M_master_company->find($loi->id_company);
                               $bl = $this->M_bl->getAwarderById($loi->bl_detail_id);
                            ?>
                              <tr>
                                <td><?= @$no++ ?></td>
                                <td><?= @$loi->rfq_no ?></td>
                                <td><?= @$loi->title ?></td>
                                <td><?= @$company->DESCRIPTION ?></td>
                                <td><?= @$vendor->NAMA ?></td>
                                <td><?= dateToIndo(@$bl->awarder_date) ?></td>
                                <td class="text-center">
                                  <?php /* if has ability to develop LOI */ ?>
                                  <a href="<?= base_url('procurement/loi/toApprove/'.$loi->data_id) ?>" class="btn btn-sm btn-primary">
                                    Detail
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