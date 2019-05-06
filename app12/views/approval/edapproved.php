<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= lang("ED Approval", "ED Approval") ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
            <li class="breadcrumb-item"><?= lang("ED Approval", "ED Approval") ?></li>
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
                              <th width="1px">No</th>
                              <th>ED Number</th>
                              <th>Subject</th>
                              <th>Requestor Department</th>
                              <th>Procurement Specialist</th>
                              <th>Currency</th>
                              <th class="text-right">MSR Value</th>
                              <th>Closing Date</th>
                              <!--<th>Status</th>-->
                              <th class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=1;
                              $data_id = '';
                              foreach ($greetings as $msr) :
                                // $idUser = $this->session->userdata('ID_USER');
                                // $q = "select * from t_approval where data_id = '$msr->data_id' and create_by = $idUser";
                                $log = $this->approval_lib->getLog(['data_id'=>$msr->data_id,'module_kode'=>'msr_spa']);
                                if($log->num_rows() > 0)
                                {
                                  $logs = $log->row();
                                  $user = $this->db->where(['ID_USER'=>$logs->created_by])->get('m_user')->row();
                                  if($user)
                                  {
                                    $desc = $logs->description.' by '.$user->NAME;
                                  }
                                  else
                                  {
                                    $desc = $logs->description;
                                  }
                                }
                                else
                                {
                                  $desc = '';
                                }
                                if($msr->data_id != $data_id)
                                {
                                  $ori = $this->db->where(['msr_no'=>$msr->data_id])->get('t_msr')->row();
                                  $ed  = $this->db->where(['msr_no'=>$msr->data_id])->get('t_eq_data')->row();
                                  $type = $this->db->where(['ID_MSR'=>$ori->id_msr_type])->get('m_msrtype')->row();
                                  $user = $this->db->where(['ID_USER'=>$ori->create_by])->get('m_user')->row();
                                  $pc = $this->db->where(['ID_USER'=>$ed->created_by])->get('m_user')->row();
                                  $company = $this->db->where(['ID_COMPANY'=>$ori->id_company])->get('m_company')->row();
                                  $department = $this->db->where(['ID_DEPARTMENT'=>$user->ID_DEPARTMENT])->get('m_departement')->row();
                                  $cur = $this->db->where(['ID'=>$ori->id_currency])->get('m_currency')->row();

                                ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?= str_replace('OR', 'OQ', $msr->data_id) ?></td>
                              <!-- <td><?=$type->MSR_DESC?></td> -->
                              <td><?=$ed->subject?></td>
                              <td><?=$department->DEPARTMENT_DESC?></td>
                              <td><?=$pc->NAME?></td>
                              <td><?=$cur->CURRENCY?></td>
                              <td class="text-right"><?= numIndo($ori->total_amount) ?></td>
                              <td><?=dateToIndo($ed->closing_date, false, true)?></td>
                              <!--<td>
                                <?php if($log->num_rows() > 0): ?>
                                  <?php
                                    //$status = $ed->approval_posisition;
                                    $status = "Approval";
                                    $issued = $this->db->where(['data_id'=>$ed->msr_no, 'm_approval_id'=>13, 'status'=>1])->get('t_approval');
                                    if($issued->num_rows() > 0)
                                    {
                                      $status = 'ED Issued';
                                    }
                                    if($ed->bid_opening == 1)
                                    {
                                      $status = 'Evaluation';
                                    }
                                    echo $status;
                                  ?>
                                <?php else:?>
                                  Approval
                                <?php endif;?>
                              </td>-->
                              <td>
                                <a href="<?=base_url('approval/approval/viewbled/'.$msr->data_id.'/'.$msr->id)?>" class="btn btn-sm btn-success">GO</a>
                              </td>
                            </tr>
                            <?php
                                }
                                $data_id = $msr->data_id;
                              endforeach;
                            ?>
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