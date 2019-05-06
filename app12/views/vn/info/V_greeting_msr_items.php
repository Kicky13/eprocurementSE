<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">Greetings...</h3>
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
                      <div class="table-responsive">
                        <table class="table table-condensed table-striped">
                          <thead>
                            <tr>
                              <th>ED NUMBER</th>
                              <th>SUBJECT WORK</th>
                              <th>COMPANY</th>
                              <th>NEGOTIATION DATE</th>
                              <th>CLOSING DATE</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              foreach ($lists->result() as $list): 
                                $ed = $this->db->where(['msr_no'=> str_replace('OQ', 'OR', $list->bled_no)])->get('t_eq_data')->row();
                                $msr = $this->db->where(['msr_no'=> str_replace('OQ', 'OR', $list->bled_no)])->get('t_msr')->row();
                                $sql = "select * from t_bid_detail where nego = 1 and created_by = '$idVendor' and bled_no = '$list->bled_no'";
                                $tbdd = $this->db->query($sql)->row()
                            ?>
                            <tr>
                              <td><?=$list->bled_no?></td>  
                              <td><?=$ed->subject?></td>  
                              <td><?=$msr->company_desc?></td>  
                              <td><?=dateToIndo($tbdd->nego_date)?></td>  
                              <td><?=dateToIndo($ed->closing_date, false, true)?></td>  
                              <td>
                                <a href="<?=base_url('vn/info/greetings/detail/'.$type.'/'.$list->bled_no)?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
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