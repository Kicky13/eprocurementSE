<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= lang($titleApp, $titleApp) ?></h3>
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
                              <th style="width: 15px">No</th>
                              <th>Requested Date</th>
                              <th>MSR Number</th>
                              <th>MSR Type</th>
                              <th>Subject</th>
                              <th>Requested By</th>
                              <th>Department</th>
                              <th>Company</th>
                              <th class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=1;
                              foreach ($greetings['msrtobeverify']->result() as $msr) :
                                $ori = $this->db->where(['msr_no'=>$msr->data_id])->get('t_msr')->row();
                                $type = $this->db->where(['ID_MSR'=>$ori->id_msr_type])->get('m_msrtype')->row();
                                $user = $this->db->where(['ID_USER'=>$ori->create_by])->get('m_user')->row();
                                $company = $this->db->where(['ID_COMPANY'=>$ori->id_company])->get('m_company')->row();
                                $department = $this->db->where(['ID_DEPARTMENT'=>$user->ID_DEPARTMENT])->get('m_departement')->row();
                            ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?=dateToindo($ori->create_on, false, true)?></td>
                              <td><?=$msr->data_id?></td>
                              <td><?=$type->MSR_DESC?></td>
                              <td><?=$ori->title?></td>
                              <td><?=$user->NAME?></td>
                              <td><?=$department->DEPARTMENT_DESC?></td>
                              <td><?=$company->ABBREVIATION?></td>
                              <td class="text-center">
                                <a href="<?=base_url('approval/approval/selection/'.$msr->data_id.'/'.$msr->approval_id)?>" class="btn btn-sm btn-info">Process</a>
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