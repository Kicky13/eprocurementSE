<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= $titleApp ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
            <li class="breadcrumb-item active"><?= $titleApp ?></li>
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
                        <table id="tbl" class="table table-condensed table-striped" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 15px">NO</th>
                              <th>ED NUMBER</th>
                              <th>ED TITLE</th>
                              <th>REQUESTED BY</th>
                              <th>DEPARTMENT</th>
                              <th>COMPANY</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                              $no=1;
                              if(count($lists) > 0):
                              foreach ($lists as $msr_no) : 
                                $row = $this->db->where(['msr_no'=>$msr_no])->get('t_msr')->row();
                                $ed = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
                            ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?=str_replace('OR', 'OQ', $msr_no)?></td>
                              <td><?=$ed->subject?></td>
                              <td><?=user($row->create_by)->NAME?></td>
                              <td><?=$row->department_desc?></td>
                              <td><?=$row->company_desc?></td>
                              <td>
                                <a href="<?=base_url('approval/ed/bod_contract_review/'.$row->msr_no)?>" class="btn btn-sm btn-info">GO</a>
                              </td>
                            </tr>
                            <?php endforeach;?>
                            <?php else:?>
                              <tr>
                                <td colspan="8" class="text-center">No Data</td>
                              </tr>
                            <?php endif;?>
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