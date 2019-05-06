<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang($title, $title) ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang($title, $title) ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <th>Agreement No</th>
                                    <th>Amendment No</th>
                                    <th>Subject</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <?php if(isset($response)): ?>
                                    <th>Negotiatioin Request Date</th>
                                    <th>Supplier Response Date</th>
                                    <?php endif;?>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no=1;
                                foreach ($list as $r) {
                                    $link = isset($response) ? 'response' : 'create';
                                    $doc_no = substr($r->doc_no, -5);
                                    echo "<tr>
                                    <td>$no</td>
                                    <td>$r->po_no</td>
                                    <td>$doc_no</td>
                                    <td>$r->title</td>
                                    <td>$r->abbr</td>
                                    <td>$r->department</td>";
                                    if(isset($response)):
                                        $vendor_response_date = $r->vendor_response_date ? dateToIndo($r->vendor_response_date) : '';
                                        echo "<td>".dateToIndo($r->nego_date)."</td>
                                        <td>$vendor_response_date</td>";
                                    endif;
                                    echo "<td><a href='".base_url('procurement/arf_nego/'.$link.'/'.$r->id)."' class='btn btn-sm btn-primary'>Process</a></td>
                                    </tr>";
                                    $no++;
                                }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <?php if(isset($response)): ?>

                                    <th></th>
                                    <th></th>
                                    <?php endif;?>
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