<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">
          <?php
            $xTitle = isset($_GET['reject']) ? "MSR Rejected" : "MSR Approval";
          ?>
          <?= lang($xTitle, $xTitle) ?>
         </h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
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
                        <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Requested Date</th>
                              <th>MSR No</th>
                              <th>MSR Type</th>
                              <th>Subject</th>
                              <th>Currency</th>
                              <th>MSR Value</th>
                              <th>Requested By</th>
                              <th>Department</th>
                              <th>Company</th>
                              <th class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=1;
                              foreach ($greetings->result() as $msr) :
                                $ori = $this->msr->approval_list($msr->data_id)->row();
                                  /*$ori = $this->db->select('t_msr.*,m_currency.CURRENCY,m_msrtype.MSR_DESC,m_user.NAME,m_departement.DEPARTMENT_DESC,m_company.ABBREVIATION')
                                  ->join('m_currency','m_currency.ID = t_msr.id_currency')
                                  ->join('m_msrtype','m_msrtype.ID_MSR = t_msr.id_msr_type')
                                  ->join('m_user','m_user.ID_USER = t_msr.create_by')
                                  ->join('m_departement','m_departement.ID_DEPARTMENT = m_user.ID_DEPARTMENT')
                                  ->join('m_company','m_company.ID_COMPANY = t_msr.id_company')
                                  ->where(['t_msr.msr_no'=>$msr->data_id])
                                  ->get('t_msr')->row();*/
                                  // $type = $this->db->where(['ID_MSR'=>$ori->id_msr_type])->get('m_msrtype')->row();
                                  // $user = $this->db->where(['ID_USER'=>$ori->create_by])->get('m_user')->row();
                                  // $company = $this->db->where(['ID_COMPANY'=>$ori->id_company])->get('m_company')->row();
                                  // $department = $this->db->where(['ID_DEPARTMENT'=>$user->ID_DEPARTMENT])->get('m_departement')->row();
                            ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?=dateToIndo($ori->create_on)?></td>
                              <td><?=$msr->data_id?></td>
                              <td><?=$ori->MSR_DESC?></td>
                              <td><?=$ori->title?></td>
                              <td><?=$ori->CURRENCY?></td>
                              <td align="right"><?=@numIndo($ori->total_amount)?></td>
                              <td><?=$ori->NAME?></td>
                              <td><?=$ori->DEPARTMENT_DESC?></td>
                              <td><?=$ori->ABBREVIATION?></td>
                              <td class="text-center">
                                <a href="<?=base_url('procurement/msr/show/'.$msr->data_id)?>" class="btn btn-sm btn-success">GO</a>
                              </td>
                            </tr>
                            <?php endforeach;?>
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
<script type="text/javascript">
  $(document).ready(function(){
    $('#tbl tfoot th').each(function (i) {
      var title = $('#tbl thead th').eq($(this).index()).text();
      if ($(this).text() == 'No') {
        $(this).html('');
      } else if ($(this).text() == 'Action') {
        $(this).html('');
      } else {
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
      }

    });
    var table = $('#tbl').DataTable({
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