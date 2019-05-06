<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang( isset($title) ? $title : "ARF Approval Recommendation",  isset($title) ? $title : "ARF Approval Recommendation") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang( isset($title) ? $title : "ARF Approval Recommendation",  isset($title) ? $title : "ARF Approval Recommendation") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Agreement No</th>
                                        <th>Amendment No</th>
                                        <th>Subject</th>
                                        <th>Requested Department</th>
                                        <th>Procurement Specialist</th>
                                        <th>Amendment Notification Date</th>
                                        <th>Vendor Response Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        if($lists)
                                        {
                                            if($lists->num_rows() > 0)
                                            {
                                                $link = 'view';
                                                if(isset($create))
                                                {
                                                    $link = 'create';
                                                }
                                                $no=1;
                                                foreach ($lists->result() as $r) {
                                                    $t_arf_response = $this->db->where(['id'=>$r->id])->get('t_arf_response')->row();
                                                    $doc_no = $t_arf_response->doc_no;
                                                    $responsed_at = $t_arf_response->responsed_at;
                                                    
                                                    $t_arf = $this->db->where(['doc_no'=>$doc_no])->get('t_arf')->row();
                                                    $po_no = $t_arf->po_no;
                                                    $title = $t_arf->po_title;
                                                    $department = $t_arf->department;
                                                    
                                                    $t_arf_assignment = $this->db->where(['doc_id'=>$t_arf->id])->get('t_arf_assignment')->row();
                                                    $m_user = $this->db->where(['ID_USER'=>$t_arf_assignment->user_id])->get('m_user')->row();
                                                    $NAME = $m_user->NAME;
                                                    
                                                    $t_arf_notification = $this->db->where(['po_no'=>$t_arf->po_no])->get('t_arf_notification')->row();
                                                    $response_date = $t_arf_notification->response_date;
                                                    echo "<tr>
                                                    <td>$no</td>
                                                    <td>$po_no</td>
                                                    <td>$doc_no</td>
                                                    <td>$title</td>
                                                    <td>$department</td>
                                                    <td>$NAME</td>
                                                    <td>".dateToIndo($response_date, false, false)."</td>
                                                    <td>".dateToIndo($responsed_at, false, false)."</td>
                                                    <td><a href='".base_url('procurement/amendment_recommendation/'.$link.'/'.$r->id)."' class='btn btn-info btn-sm'>Go</a></td>
                                                    </tr>";
                                                    $no++;
                                                }
                                            }
                                        }
                                        else
                                        {
                                            echo "<tr><td colspan='8' class='text-center'>No data</td></tr>";
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <th>No</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Action</th>
                                </tfoot>
                            </table>
                        </div>
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