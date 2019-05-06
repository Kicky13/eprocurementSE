<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Acceptance Amendment", "Acceptance Amendment") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/vn/info/greetings">Home</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-table" class="table table-bordered table-no-wrap" style="min-width:100%">
                                <thead>
                                    <tr>
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
                                                foreach ($lists->result() as $r) {
                                                    $doc_no = explode('-', $r->doc_no);
                                                    $count = count($doc_no);
                                                    $end = $doc_no[$count];
                                                    echo "<tr>
                                                    <td>$r->doc_no</td>
                                                    <td>$r->doc_no</td>
                                                    <td>$r->title</td>
                                                    <td>$r->department_desc</td>
                                                    <td>$r->NAME</td>
                                                    <td>".dateToIndo($r->response_date, false, false)."</td>
                                                    <td>".dateToIndo($r->responsed_at, false, false)."</td>
                                                    <td><a href='".base_url('procurement/amendment_recommendation/view/'.$r->id)."' class='btn btn-info btn-sm'>Go</a></td>
                                                    </tr>";
                                                }
                                            }
                                        }
                                        else
                                        {
                                            echo "<tr><td colspan='8' class='text-center'>No data</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /*var dataTable;
    $(function() {
        dataTable = $('#data-table').dataTable();
    });*/
</script>