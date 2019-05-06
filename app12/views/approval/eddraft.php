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
                        <table id="tbl" class="table table-bordered table-condensed nowrap table-striped" width="100%">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Requested Date</th>
                              <th>MSR No</th>
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
                              foreach ($rs->result() as $msr) :
                                $t_approval = $this->db->where(['data_id'=>$msr->msr_no, 'm_approval_id'=>13])->get('t_approval')->row();
                                $ori = $this->db->where(['msr_no'=>$msr->msr_no])->get('t_msr')->row();
                                $type = $this->db->where(['ID_MSR'=>$ori->id_msr_type])->get('m_msrtype')->row();
                                $user = $this->db->where(['ID_USER'=>$ori->create_by])->get('m_user')->row();
                                $company = $this->db->where(['ID_COMPANY'=>$ori->id_company])->get('m_company')->row();
                                $department = $this->db->where(['ID_DEPARTMENT'=>$user->ID_DEPARTMENT])->get('m_departement')->row();
                            ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?=dateToIndo($ori->create_on, false, true)?></td>
                              <td><?=$msr->msr_no?></td>
                              <td><?=$type->MSR_DESC?></td>
                              <td><?=$ori->title?></td>
                              <td><?=$user->NAME?></td>
                              <td><?=$department->DEPARTMENT_DESC?></td>
                              <td><?=$company->ABBREVIATION?></td>
                              <th class="text-center">
                                <a href="<?=base_url('approval/approval/devbled/'.$msr->msr_no.'/'.$t_approval->id)?>" class="btn btn-sm btn-info">Process</a>
                              </td>
                            </tr>
                            <?php endforeach;?>
                          </tbody>
                          <tfoot>
                              <tr>
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
  var tbl;
  $(document).ready(function(){
    $('#tbl thead th').each(function (i) {
        var title = $('#tbl thead th').eq($(this).index()).text();
        if ($(this).is(':first-child') || $(this).is(':last-child')) {
            $('#tbl tfoot tr').append('<th>'+title+'</th>');
        } else {
            $('#tbl tfoot tr').append('<th><input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" /></th>');
        }
    });

    tbl = $("#tbl").dataTable({
      scrollX : true,
      fixedColumns: {
          leftColumns: 0,
          rightColumns: 1
      }
    });

    $(tbl.api().table().container()).on('keyup', 'tfoot input', function () {
        tbl.api().column($(this).data('index')).search(this.value).draw();
    });
  })
</script>