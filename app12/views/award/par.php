<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?=isset($titleApp) ? $titleApp : '';?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
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
                              <th>ED NO</th>
                              <th>SUBJECT WORK</th>
                              <th>COMPANY</th>
                              <th>INVITATION DATE</th>
                              <th>PRE BID MEETING</th>
                              <th>BID VALIDITY</th>
                              <th>CLOSING DATE</th>
                              <th>STATUS</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                              $no=1;
                              foreach ($greetings->result_array() as $r) : 
                                $msr_no = $r['msr_no'];
                                $bl = $this->db->where(['msr_no'=>$msr_no])->get('t_bl')->row();
                                
                                $ori = $this->db->where(['msr_no'=>$bl->msr_no])->get('t_msr')->row();
                                $eq = $this->db->where(['msr_no'=>$bl->msr_no])->get('t_eq_data')->row();
                                $company = $this->db->where(['ID_COMPANY'=>$ori->id_company])->get('m_company')->row();
                            ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?=$bl->bled_no?></td>
                              <td><?=$bl->title?></td>
                              <td><?=$company->DESCRIPTION?></td>
                              <td><?=dateToIndo($bl->created_at)?></td>
                              <td><?=dateToIndo($eq->prebiddate, false, true)?></td>
                              <td><?=dateToIndo($eq->bid_validity, false, true)?></td>
                              <td><?=dateToIndo($eq->closing_date, false, true)?></td>
                              <td><?=statusBidOpening($eq->bid_opening)?></td>
                              <td>
                                <a href="<?=base_url('approval/award/par/'.$msr_no)?>" class="btn btn-sm btn-info">GO</a>
                              </td>
                            </tr>
                            <?php endforeach;?>
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
 <!-- (3501010,3501010,3501010) -->