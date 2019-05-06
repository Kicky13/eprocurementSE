<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">ED LIST</h3>
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
              <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
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
                              <th>Status</th>
                              <th class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no = 1;
                              foreach ($data->result() as $ed) :
                                $log = $this->approval_lib->getLog(['data_id'=>$ed->msr_no,'module_kode'=>'msr_spa']);
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
                            ?>
                            <?php
                              if($log->num_rows() > 0):
                            ?>

                            <?php endif;?>
                            <tr>
                              <td><?= $no ?></td>
                              <td><?= $ed->ed_no ?></td>
                              <td><?= $ed->subject ?></td>
                              <td><?= $ed->department ?></td>
                              <td><?= $ed->specialist ?></td>
                              <td><?= $ed->CURRENCY ?></td>
                              <td class="text-right"><?= numIndo($ed->total_amount) ?></td>
                              <td><?= dateToIndo($ed->closing_date, false, true) ?></td>
                              <td>
                                <?php if($log->num_rows() > 0): ?>
                                <a href="#" class="text-primary" data-toggle="modal" data-target="#myModal<?=$ed->ed_no?>">
                                  <?php
                                    $status = "ED Approval ".$ed->approval_posisition;
                                    $issued = $this->db->where(['data_id'=>$ed->msr_no, 'm_approval_id'=>13, 'status'=>1])->get('t_approval');
                                    if($issued->num_rows() > 0)
                                    {
                                      $status = 'ED Issued';
                                    }
                                    if($ed->bid_opening == 1)
                                    {
                                      $status = 'Evaluation';
                                    }
                                    if($ed->commercial == 1 and $ed->award == 1)
                                    {
                                      $status = 'Award Recommendation';
                                    }
                                    if($ed->award == 9)
                                    {
                                      $status = 'Awarded';
                                    }
                                    echo $status;
                                  ?>
                                </a>
                                <?php else:?>
                                  Procurement Head
                                <?php endif;?>
                              </td>
                              <th class="text-center">
                                <a href="<?= base_url('approval/approval/viewbled/'.$ed->msr_no) ?>" class="btn btn-primary btn-sm">ED</a>
                                <?php if($ed->bid_opening == 1) : ?>
                                <a href="<?= base_url('approval/approval/evaluation/'.$ed->msr_no) ?>" class="btn btn-success btn-sm">Evaluation</a>
                                <?php endif;?>
                                <?php if($ed->commercial == 1) : ?>
                                  <a href="<?= base_url('approval/approval/evaluation/'.$ed->msr_no) ?>?award=1" class="btn btn-info btn-sm">Award</a>
                                <?php endif;?>
                              </th>
                            </tr>
                            <?php $no++; ?>
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
<?php
  foreach ($data->result() as $ed) :
    $log = $this->approval_lib->getLog(['data_id'=>$ed->msr_no,'module_kode'=>'msr_spa']);
    $n = 1;
    if($log->num_rows() > 0):
?>
    <div id="myModal<?=$ed->ed_no?>" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Log History Of <?=$ed->ed_no?></h4>
          </div>
          <div class="modal-body" style="font-size:12px;">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Transaction Date</th>
                    <th>Comment</th>
                    <th>Description</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $log_history = $this->db->where(['data_id'=>$ed->msr_no])->where_in('module_kode', ['technical evaluation','admin evaluation','award'])->order_by('created_at','desc')->get('log_history');
                    foreach ($log_history->result() as $r) {
                      $user = user($r->created_by);
                      $desc = $r->description.' by '.$user->NAME;
                      echo "<tr>
                      <td>".$n++."</td>
                      <td>".dateToIndo($r->created_at, false, true)."</td>
                      <td>".$r->keterangan."</td>
                      <td>".$desc."</td>
                      </tr>";
                      $no++;
                    }
                  ?>
                  <?php
                    foreach ($log->result() as $logx) :
                      $user = $this->db->where(['ID_USER'=>$logx->created_by])->get('m_user')->row();
                      $desc = $logx->description.' by '.$user->NAME;
                  ?>
                  <tr>
                    <td><?= $n++ ?></td>
                    <td><?= dateToIndo($logx->created_at, false, true) ?></td>
                    <td><?= $logx->keterangan ?></td>
                    <td><?= $desc ?></td>
                  </tr>
                  <?php endforeach;?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  <?php endif;?>
<?php endforeach;?>
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