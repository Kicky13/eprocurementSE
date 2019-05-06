<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">ED Addendum</h3>
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
                        <table id="tbl" class="table table-condensed table-striped table-no-wrap">
                          <thead>
                            <tr>
                              <th style="width: 15px">No</th>
                              <th>ED Number</th>
                              <th>Subject</th>
                              <th>Requestor Department</th>
                              <th>Procurement Specialist</th>
                              <th>Closing Date</th>
                              <th class="text-right">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=1;
                              foreach ($addendum as $row) :
                            ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?=$row->bled_no?></td>
                              <td><?=$row->subject?></td>
                              <td><?=$row->department?></td>
                              <td><?=$row->specialist?></td>
                              <td><?=dateToIndo($row->closing_date, false, true)?></td>
                              <td class="text-right">
                                <a href="<?=base_url('approval/approval/addendum_bled/'.$row->msr_no)?>" class="btn btn-sm btn-info">Adendum</a>
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
        </div>
      </section>
    </div>
  </div>
</div>
 <script type="text/javascript">
  $(document).ready(function(){
    $('#tbl thead th').each(function (i) {
      var title = $('#tbl thead th').eq($(this).index()).text();
      if ($(this).is(':first-child') || $(this).is(':last-child')) {
        $('#tbl tfoot tr').append('<th>'+title+'</th>');
      } else {
        $('#tbl tfoot tr').append('<th><input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" /></th>');
      }
    });

    var table = $('#tbl').DataTable({
      scrollX: true,
      fixedColumns: {
        leftColumns: 0,
        rightColumns: 1
      }
    })

    $(table.table().container()).on('keyup', 'tfoot input', function () {
      table.column($(this).data('index')).search(this.value).draw();
    });
  })
</script>