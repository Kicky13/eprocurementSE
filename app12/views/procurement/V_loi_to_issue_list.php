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
         <h3 class="content-header-title">LOI to be Approved</h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
            <li class="breadcrumb-item active"><?= lang("LOI", "LOI") ?></li>
            <li class="breadcrumb-item active"><?= lang("LOI to be Issued", "LOI to be Issued") ?></li>
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
                        <table id="acceptance_award_recommendation_table" class="table table-condensed table-striped" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 15px">No</th>
                              <th>ED No</th>
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
                            foreach ($lois as $loi) :
                              // $ori = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_msr')->row();
                              // $bl = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_bl')->row();
                              // $eq = $this->db->where(['msr_no'=>$awarder->data_id])->get('t_eq_data')->row();
                               $vendor = $this->M_show_vendor->find($loi->awarder_id);
                               $company = $this->db->where(['ID_COMPANY'=>$loi->id_company])->get('m_company')->row();
                               $bl = $this->M_bl->getAwarderById($loi->bl_detail_id);
                            ?>
                              <tr>
                                <td><?= @$no++ ?></td>
                                <td><?= @$loi->rfq_no ?></td>
                                <td><?= @$loi->title ?></td>
                                <td><?= @$company->DESCRIPTION ?></td>
                                <td><?= @$vendor->NAMA ?></td>
                                <td><?= @$bl->awarder_date ?></td>
                                <td>
                                  <?php /* if has ability to develop LOI */ ?>
                                  <a href="<?= base_url('procurement/loi/toIssue/'.$loi->id) ?>" class="btn btn-sm btn-primary">
                                    Details
                                  </a>
                                  <?php /* endif */ ?>
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

<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
$(document).ready(function() {

$('#acceptance_award_recommendation_table').DataTable({
  'scrollY'   : true,
  'scrollX'   : true,
  "paging"    : false,
  "info"      : false,
  "searching" : false,
  "ordering"  : false,
  "processing": true,
});

});
</script>
