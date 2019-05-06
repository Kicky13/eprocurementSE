<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= $title ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
            <li class="breadcrumb-item"><?= $title ?></li>
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
                        <table id="dt" class="table table-striped table-bordered table-hover table-no-wrap display">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>ED No</th>
                              <th>Subject</th>
                              <th>Company</th>
                              <th>Invitation Date</th>
                              <th>Pre Bid Date</th>
                              <th>Closing Date</th>
                              <th>Status</th>
                              <th>Notification</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $un   = $this->vendor_lib->greeting_list($type)->result();
                              // echo $this->db->last_query();
                              $no = 1;
                              foreach ($un as $r):
                                if ($type == 11) {
                                  $status = $r->status_closing_date;
                                } else {
                                  if ($r->confirmed == 1) {
                                    if (strtotime($r->closing_date) <= strtotime(date('Y-m-d H:i:s'))) {
                                      $status = 'Proposal Not Submitted';
                                    } else {
                                      $status = 'Open';
                                    }
                                  } else {
                                      if ($type == 0) {
                                        $status = 'Unconfirmed';
                                      } else {
                                        $status = $this->vendor_lib->get_confirmed_status($r->confirmed);
                                      }
                                  }
                                }
                            ?>
                            <tr>
                              <td><?= $no ?></td>
                              <td><?=$r->bled_no?></td>
                              <td><?=$r->title?></td>
                              <td><?=$r->abbreviation?></td>
                              <td><?=dateToIndo($r->issued_date)?></td>
                              <td><?=dateToIndo($r->prebiddate, false, true)?></td>
                              <td><?=dateToIndo($r->closing_date, false, true)?></td>
                              <td><?= $status ?></td>
                              <td>
                                <?php
                                if ($r->unread_message <> 0) {
                                    echo ' <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="'.$r->unread_message.' Clarification"><i class="fa fa-bell fa-fw"></i> '.$r->unread_message.'</span>';
                                  }
                                  if ($r->addendum <> 0) {
                                    echo ' <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="'.$r->addendum.' Addendum"><i class="fa fa-exclamation fa-fw"></i> '.$r->addendum.'</span>';
                                  }
                                ?>
                              </td>
                              <td class="text-center">
                                <a href="<?=base_url('vn/info/greetings/detail/'.$type.'/'.$r->bled_no)?>" class="btn btn-sm btn-info">Detail</a>
                              </td>
                            </tr>
                            <?php $no++ ?>
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


    $('#dt thead th').each(function (i) {
      var title = $('#dt thead th').eq($(this).index()).text();
      if ($(this).is(':first-child') || $(this).is(':last-child')) {
        $('#dt tfoot tr').append('<th>'+title+'</th>');
      } else {
        $('#dt tfoot tr').append('<th><input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" /></th>');
      }
    });

    var table = $('#dt').DataTable({
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