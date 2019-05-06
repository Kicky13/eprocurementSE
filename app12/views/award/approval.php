<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
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
            <li class="breadcrumb-item">Award Recomendation</li>
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
                              <th style="width: 1px">No</th>
                              <th>ED No</th>
                              <th>Subject</th>
                              <th>Company</th>
                              <th>Invitation Date</th>
                              <th>Pre Bid Meeting</th>
                              <th>Bid Validity</th>
                              <th>Closing Date</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=1;
                              foreach ($greetings as $r) :
                                // print_r($r);
                                if(isset($awardtobeissued))
                                {
                                  $msr_no = $r;
                                }
                                else
                                {
                                  $msr_no = $r->data_id;
                                }
                                $bl = $this->db->where(['msr_no'=>$msr_no])->get('t_bl')->row();

                                $ori = $this->db->where(['msr_no'=>$bl->msr_no])->get('t_msr')->row();
                                $eq = $this->db->where(['msr_no'=>$bl->msr_no])->get('t_eq_data')->row();
                                $company = $this->db->where(['ID_COMPANY'=>$ori->id_company])->get('m_company')->row();
                            ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?=$bl->bled_no?></td>
                              <td><?=$bl->title?></td>
                              <td>
                                <?=$company->ABBREVIATION?>
                              </td>
                              <td><?=dateToIndo($bl->created_at)?></td>
                              <td><?=dateToIndo($eq->prebiddate, false, true)?></td>
                              <td><?=dateToIndo($eq->bid_validity, false, false)?></td>
                              <td><?=dateToIndo($eq->closing_date, false, true)?></td>
                              <td>Approval</td>
                              <td class="text-center">
                                <a href="<?=base_url('approval/award/'.$link.'/'.$msr_no)?>" class="btn btn-sm btn-success">GO</a>
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