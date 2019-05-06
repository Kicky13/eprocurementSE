<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
          <h3 class="content-header-title"><?= lang("ARF Verification", "ARF Verification") ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
          <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                  <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                  <li class="breadcrumb-item active"><?= lang("ARF Verification", "ARF Verification") ?></li>
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
                                  <th>No</th>
                                  <th>Requested Date</th>
                                  <th>Agreement No</th>
                                  <th>Amendment No</th>
                                  <!-- <th>Agreement Type</th> -->
                                  <th>Subject</th>
                                  <th>Requested By</th>
                                  <th>Department</th>
                                  <th>Company</th>
                                  <th class="text-center">Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php $no = 1 ?>
                              <?php foreach ($marf as $r) {
                                  echo "<tr>";
                                  echo "<td>".$no."</td>";
                                  echo "<td>".dateToIndo($r->doc_date)."</td>";
                                  echo "<td>$r->po_no</td>";
                                  echo "<td>$r->doc_no</td>";
                                  /*echo "<td>".$this->m_arf_po->enum('type', $r->po_type)."</td>";*/
                                  echo "<td>$r->title</td>";
                                  echo "<td>$r->requestor</td>";
                                  echo "<td>$r->department</td>";
                                  echo "<td>$r->abbr</td>";
                                  echo "<td class='text-center'>";
                                  if($r->edit_content == 1)
                                  {
                                      $url = base_url('procurement/arf/edit/'.$r->id);
                                      echo "<a href='$url' class=\"btn btn-warning btn-sm\">Edit</a>";
                                  }
                                  $url = base_url('procurement/arf/view/'.$r->id);
                                  echo "<a href='$url' class=\"btn btn-success btn-sm\">GO</a>";
                                  echo "</td>";
                                  echo "</tr>";
                                  $no++;
                              }
                              ?>
                          </tbody>
                          <tfoot>
                              <tr>
                                  <th>No</th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <!-- <th></th> -->
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
        </div>
      </section>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#tbl tfoot th').each(function (i) {
      var title = $('#tbl tfoot th').eq($(this).index()).text();
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