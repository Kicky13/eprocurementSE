<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.full.js"></script>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title"><?= $title ?></h3>
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
      <section id="icon-tabs">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-content collapse show">
                <div class="card-body card-scroll">
                  <div class="col-12">
                    <a href="#" class="btn btn-primary btn-md" data-toggle="modal" data-target="#modal-form" onclick="addClick()">Add</a>
                  </div>
                  <div class="col-12">
                    <div class="table-responsive">
                      <table class="table table-table-condensed" id="dt">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Supervisor</th>
                            <th>User</th>
                            <th>Title/Position</th>
                            <th>Role</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $no=1;
                          foreach ($data as $r) {
                          $edit= "<a href='#' data-toggle='modal' data-target='#modal-form' class='btn btn-sm btn-info' onclick='editClick($r->id)'>Edit</a>";
                          $delete= "<a href='#' class='btn btn-sm btn-danger' onclick='deleteClick($r->id)'>Delete</a>";
                          echo "<tr><td>$no</td><td>$r->parent_name</td><td>$r->user_name</td><td>$r->title</td><td>".portal_rule($r->portal_rule)."</td><td>$edit $delete</td></tr>";
                            $no++;
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
      </section>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Form</h4>
        </div>
        <div class="modal-body">
          <form method="post" class="form-horizontal" id="form-result">
            
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary pull-right" onclick="saveClick()">Save changes</button>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $(document).ready(function(){
    $("#dt").DataTable({
      'bSort':false,
      'bFilter':false
    });
  })
  function addClick() {
    $.ajax({
      type:'post',
      url:"<?= base_url('cmms/position/form') ?>",
      success:function(e){
        $("#form-result").html(e)
      }
    })
  }
  function editClick(id) {
    $.ajax({
      type:'post',
      data:{id:id},
      url:"<?= base_url('cmms/position/form') ?>",
      success:function(e){
        $("#form-result").html(e)
      }
    })
  }
  function saveClick() {
    $.ajax({
      type:'post',
      url:"<?= base_url('cmms/position/store') ?>",
      data:$("#form-result").serialize(),
      success:function(e){
        location.reload()
      }
    })
  }
  function deleteClick(id) {
    if(confirm('Are You Sure?'))
    {
      window.open("<?= base_url('cmms/position/delete/') ?>/"+id,"_self")
    }
  }

</script>