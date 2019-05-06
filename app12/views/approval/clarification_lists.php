<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">Clarification</h3>
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
                        <table id="tbl" class="table table-condensed table-striped" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 15px">NO</th>
                              <th>ED NUMBER</th>
                              <th>Unread Message</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                              $no=1;
                              foreach ($lists->result() as $msr) : 
                            ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?=$msr->data_id?></td>
                              <td><?=$msr->jml?></td>
                              <td>
                                <a href="<?=base_url('note/clarification_show/'.$msr->data_id)?>" class="btn btn-sm btn-info">GO</a>
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
 <script type="text/javascript">
  $(document).ready(function(){
    $('#tbl').DataTable({
      'bSort':false
    })
  })
</script>