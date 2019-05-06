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
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              foreach ($lists->result() as $list): 
                            ?>
                            <tr>
                              <td><?=$list->bled_no?></td>  
                              <td><?=$list->title?></td>  
                              <td><?=$list->company_name?></td>  
                              <td>
                                <a href="<?=base_url('vn/info/greetings/award/'.$status.'/'.$list->bled_no)?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
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