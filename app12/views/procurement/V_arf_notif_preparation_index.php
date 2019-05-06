<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 id="arfn_title1" class="content-header-title onprepare">
          <?= lang("Persiapan Notifikasi ARF", "ARF Notification Preparation") ?>
        </h3>
        <h3 id="arfn_title2" class="content-header-title onprogress" style="display: none;">
          <?=lang("Progres Notifikasi ARF", "ARF Notification On Progress")?>
        </h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
            <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
            <li class="breadcrumb-item active"><?= lang("Persiapan Notifikasi ARF", "ARF Notification Preparation") ?></li>
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
                    <div class="col-md-12 text-right">
                      <button id="cpm_btn1" class="btn btn-primary onprogress" onclick="show_prepare()" style="display: none;">
                          <i class="fa fa-exchange"></i>
                          <?=lang("Persiapan", "Preparation")?>
                      </button>
                      <button id="cpm_btn2" class="btn btn-primary onprepare" onclick="show_progress()">
                          <i class="fa fa-exchange"></i>
                          <?=lang("Progres", "On Progress")?>
                      </button>
                    </div>
                    <div class="col-md-12 onprepare">
                      <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                          <thead>
                            <tr>
                              <th width="15">No</th>
                              <th>Requested At</th>
                              <th>Agreement No</th>
                              <th>Amendment No</th>
                              <th>Agreement Type</th>
                              <th>Title</th>
                              <th>Requested By</th>
                              <th>Department</th>
                              <th>Company</th>
                              <th class="text-center">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $no=1;
                              foreach ($list1 as $r) :
                            ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?=dateToIndo($r['doc_date'])?></td>
                              <td><?=$r['po_no']?></td>
                              <td><?=$r['doc_no']?></td>
                              <td><?=$r['po_type']?></td>
                              <td><?=$r['po_title']?></td>
                              <td><?=$r['requestor']?></td>
                              <td><?=$r['department']?></td>
                              <td><?=$r['abbr']?></td>
                              <td class="text-center">
                                <a href="<?=base_url('procurement/arf/view/'.$r['id'])?>" class="btn btn-sm btn-info">Process</a>
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
                              <th class="text-center">Action</th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                    <div class="col-md-12 onprogress">
                      <!--  
              {title:"<?= lang("Permintaan Pada", "Requested At") ?>"},
                {title:"<?= lang("No Perjanjian", "Agreement No") ?>"},
                {title:"<?= lang("No Amandemen", "Amendment No") ?>"},
                {title:"<?= lang("Tipe Perjanjian", "Agreement Type") ?>"},
                {title:"<?= lang("Nama", "Title") ?>"},
                {title:"<?= lang("Jabatan Persetujuan", "Approval Role") ?>"},
                {title:"<?= lang("Status Persetujuan", "Approval Status") ?>"},
                {title:"<?= lang("Tanggal Persetujuan", "Approval Date") ?>"},
                {title:"<?= lang("Aksi", "Action") ?>"},-->
                      <table id="tbl2" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                        <thead>
                          <tr>
                            <th width="15">No</th>
                            <th>Requested At</th>
                            <th>Agreement No</th>
                            <th>Amendment No</th>
                            <th>Agreement Type</th>
                            <th>Title</th>
                            <th>Approval Role</th>
                            <th>Approval Status</th>
                            <th>Approval Date</th>
                            <th class="text-center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- $dt[$k][1] = date('M j, Y', strtotime($v['doc_date']));
                $dt[$k][2] = $v['po_no'];
                $dt[$k][3] = $v['doc_no'];
                $dt[$k][4] = $v['po_type'];
                $dt[$k][5] = $v['po_title'];
                $dt[$k][6] = $v['user_roles'];
                $dt[$k][7] = $status;
                $dt[$k][8] = ($v['status_approve'] == 0 ? '' : date('M j, Y H:i', strtotime($v['update_date'])));
                if ($v['status_approve'] == 2 && $v['assignee'] == $this->session->ID_USER) {
                    $dt[$k][9] = "<button class='btn btn-sm btn-success proc_resub'>Rework</button>";
                } else {
                    $dt[$k][9] = "<button class='btn btn-sm btn-success proc_watch'>Detail</button>";
                } -->
                          <?php
                            $no=1;
                            foreach ($list2 as $v) :
                              if ($v['status_approve'] == 2) {
                                  $status = "<td><span class='badge badge badge-pill badge-danger'>Rejected</span></td>";
                              } else if ($v['status_approve'] == 1) {
                                  $status = "<td><span class='badge badge badge-pill badge-success'>" . ($v['sequence'] == 1 ? "Prepared" : "Approved") . "</span></td>";
                              } else {
                                  $status = "<td><span class='badge badge badge-pill badge-light'>Unconfirmed</span></td>";
                              }
                          ?>
                          <tr>
                            <td><?=$no++?></td>
                            <td><?=dateToIndo($v['doc_date'])?></td>
                            <td><?=$v['po_no']?></td>
                            <td><?=$v['doc_no']?></td>
                            <td><?=$v['po_type']?></td>
                            <td><?=$v['po_title']?></td>
                            <td><?=$v['user_roles']?></td>
                            <td><?=$status?></td>
                            <td>
                              <?= ($v['status_approve'] == 0 ? '' : dateToIndo($v['update_date'])); ?>
                            </td>
                            <td class="text-center">
                            <?php
                              if ($v['status_approve'] == 2 && $v['assignee'] == $this->session->ID_USER) {
                                  echo "<button class='btn btn-sm btn-success proc_resub'>Rework</button>";
                              } else {
                                  echo "<button class='btn btn-sm btn-success proc_watch'>Detail</button>";
                              }
                            ?>
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

    $('#tbl2 tfoot th').each(function (i) {
      var title = $('#tbl2 thead th').eq($(this).index()).text();
      if ($(this).text() == 'No') {
        $(this).html('');
      } else if ($(this).text() == 'Action') {
        $(this).html('');
      } else {
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
      }

    });
    var tbl2 = $('#tbl2').DataTable({
      scrollX : true,
      fixedColumns: {
          leftColumns: 0,
          rightColumns: 1
      },
    });
    $(tbl2.table().container()).on('keyup', 'tfoot input', function () {
      tbl2.column($(this).data('index')).search(this.value).draw();
    });
    $(".onprogress").hide()
  })
  function show_prepare() {
      $('.onprepare').show();
      $('.onprogress').hide();
  }

  function show_progress() {
      $('.onprepare').hide();
      $('.onprogress').show();
  }
</script>