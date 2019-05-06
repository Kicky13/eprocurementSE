<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/jquery.dataTables.min.css">
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">Cancel MSR</h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
            <li class="breadcrumb-item active"><?= lang("Cancel MSR", "Cancel MSR") ?></li>
          </ol>
        </div>
      </div>
      <?php if($this->uri->rsegment(3)): ?>
      <div class="row info-header">
        <div class="col-md-12">
          <table class="table table-condensed">
            <tr>
              <td style="width: 105px;">Title</td>
              <td class="no-padding-lr">:</td>
              <td><?= $msr->title ?></td>
              <td style="width: 105px;">Company</td>
              <td class="no-padding-lr">:</td>
              <td><?=$msr->company_desc?></td>
              <td style="width: 105px;">MSR Number</td>
              <td class="no-padding-lr">:</td>
              <td><?=$msr->msr_no?></td>
            </tr>
            <tr>
              <td style="width: 105px;">Supplier</td>
              <td class="no-padding-lr">:</td>
              <td>
                <?php 
                  if($supplier->num_rows() > 0)
                  {
                    foreach ($supplier->result() as $r) {
                      echo $r->NAMA;
                      echo "<br>";
                    }
                  }
                  else
                  {
                    echo "-";
                  }
                ?>
              </td>
              <td style="width: 105px;">MSR Value</td>
              <td class="no-padding-lr">:</td>
              <td><?=$currency->CURRENCY ?> <?=numIndo($msr->total_amount)?> (<small style="color:red"><i>Exclude VAT</i></small>)</td>
              <td style="width: 105px;">ED Number</td>
              <td class="no-padding-lr">:</td>
              <td><?= $ed ? str_replace('OR', 'OQ', $ed->msr_no) : '-'?></td>
              </tr>
            </tr>
          </table>
        </div>
      </div>
      <?php endif;?>
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
                      <?php if($this->uri->rsegment(3)): ?>
                      <form action="#" class="wizard-circle frm-bled" id="frm-bled">
                        <h6><i class="step-icon fa fa-paper-clip"></i> Cancel MSR Document</h6>
                        <fieldset>
                          <div class="row">
                            <?php if(isset($head)): ?>
                  
                            <?php else:?>
                            <div class="col-md-12" style="margin-bottom: 10px">
                              <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal">Upload</a>
                            </div>
                            <?php endif;?>
                            <div class="col-md-12">
                              <div class="table-responsive">
                                <table class="table table-condensed">
                                  <thead>
                                    <tr>
                                      <th>TYPE</th>
                                      <th>FILE NAME</th>
                                      <th>UPLOAD AT</th>
                                      <th>UPLOADER</th>
                                      <th>ACTION</th>
                                    </tr>
                                  </thead>
                                  <tbody id="dt-attachment">
                                    <?php foreach ($doc as $key => $value) {
                                      $btnHapus = isset($head) ? '': "<a href='#' class='btn btn-sm btn-danger' onclick='hapusFile($value->id)'>Hapus</a>";
                                      echo "<tr>
                                        <td>".$value->tipe."</td>
                                        <td>".$value->file_path."</td>
                                        <td>".$value->created_at."</td>
                                        <td>".user($value->created_by)->NAME."</td>
                                        <td>
                                          <a href='".base_url('userfiles/temp/'.$value->file_path)."' target='_blank' class='btn btn-sm btn-primary'>Download</a>
                                          $btnHapus
                                        </td>
                                      </tr>";
                                    }?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </fieldset>
                        <h6><i class="step-icon icon-directions"></i> Approval</h6>
                        <fieldset>
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Role Access</th>
                                  <th>User</th>
                                  <th>Approval Status</th>
                                  <th>Transaction Date</th>
                                  <th>Comment</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                  foreach ($approval_list->result() as $r): 
                                    $user = $this->M_view_user->getByRole($r->role_id)[0];
                                ?>
                                <tr>
                                  <td><?=$r->DESCRIPTION?></td>
                                  <td><?=$user->NAME?></td>
                                  <td>
                                    <?php 
                                      $status = '';
                                      if(isset($r->status))
                                      {
                                        $status == 1 ? "Approve":"Reject" ;
                                      }
                                      echo $status;
                                    ?>  
                                  </td>
                                  <td>
                                    <?php 
                                    $created_at = '';
                                    if(isset($r->created_at) and $r->status > 0)
                                    {
                                      $created_at = dateToIndo($r->created_at, false, true);
                                    }
                                    echo $created_at;
                                    ?>
                                  </td>
                                  <td>
                                    <?=@$r->deskripsi == 'procurement_head' ? "":$r->deskripsi?>
                                  </td>
                                  <td>
                                    <?php if(isset($head)): ?>
                                    <a href="#" data-id="<?= $r->t_approval_id ?>" class="btn btn-primary btn-sm btn-modal-approve" data-toggle="modal" data-target="#modal-approve">Approve/Reject</a>
                                    <div class="modal fade" id="modal-approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h4 class="modal-title" id="myModalLabel">Approval</h4>
                                        </div>
                                        <div class="modal-body">
                                          <form id="form-approval-<?=$r->t_approval_id?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                                            <!-- data_id -->
                                            <input type="hidden" name="t_approval_id" value="<?=$r->t_approval_id?>">
                                            <!-- m_approval_id -->
                                            <div class="form-group row">
                                              <label class="col-md-3">Status</label>
                                              <div class="col-sm-9">
                                                <select class="form-control" name="status" id="status-<?=$r->t_approval_id?>">
                                                  <option value="1">Approve</option>
                                                  <option value="2">Reject</option>
                                                </select>
                                              </div>
                                            </div>
                                            <div class="form-group row">
                                              <label class="col-md-3">Comments</label>
                                              <div class="col-sm-9">
                                                <textarea id="desc-<?=$r->t_approval_id?>" name="desc" class="form-control"></textarea>
                                              </div>
                                            </div>
                                            <div class="form-group">
                                              <div class="col-sm-12">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" onclick="approveClick(<?=$r->t_approval_id?>)" class="btn btn-primary">Save Changes</button>
                                              </div>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                    <?php endif;?>
                                  </td>
                                </tr>
                              <?php endforeach;?>
                              </tbody>
                            </table>
                        </fieldset>
                      </form>
                      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">Upload</h4>
                            </div>
                            <div class="modal-body">
                              <form id="form-upload" method="post" class="form-horizontal" enctype="multipart/form-data">
                                <!-- data_id -->
                                <input type="hidden" name="module_kode" value="msr-reject">
                                <input type="hidden" name="data_id" value="<?=$msr->msr_no?>">
                                <!-- m_approval_id -->
                                <div class="form-group">
                                  <label>Type</label>
                                  <div class="col-sm-12">
                                    <input class="form-control" name="tipe" id="tipe" required="">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label>File</label>
                                  <div class="col-sm-12">
                                    <input type="file" class="form-control" name="file_path" id="file_path" />
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-sm-12">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" onclick="uploadClick()" class="btn btn-primary">Upload</button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php else:?>
                      <div class="table-responsive">
                        <table id="tbl" class="table table-condensed table-striped" width="100%">
                          <thead>
                            <tr>
                              <th style="width: 15px">NO</th>
                              <th>MSR NUMBER</th>
                              <th>MSR TITLE</th>
                              <th>COMPANY</th>
                              <th>CREATE DATE</th>
                              <th>CREATE BY</th>
                              <th>ACTION</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                              $no=1;
                              foreach ($msr->result() as $row) :          
                            ?>
                            <tr>
                              <td><?=$no++?></td>
                              <td><?=$row->msr_no?></td>
                              <td><?=$row->title?></td>
                              <td><?=$row->company_desc?></td>
                              <td><?=dateToIndo($row->create_on)?></td>
                              <td><?=user($row->create_by)->NAME?></td>
                              <td>
                                <?php if(isset(($head))): ?>
                                <a href="<?= base_url('approval/approval/will_cancel/'.$row->msr_no) ?>" class="btn btn-sm btn-danger">Cancel MSR</a>
                                <?php else: ?>
                                  <?php if($row->status == 0): ?>
                                  <a href="#" data-id="<?=$row->msr_no?>" class="btn btn-sm btn-danger btn-cancel-msr" title="Cancel MSR" url="<?= base_url('approval/approval/will_cancel/'.$row->msr_no) ?>">Cancel MSR</a>
                                  <?php else:?>
                                  <a href="#" data-id="<?=$row->msr_no?>" class="btn btn-sm btn-danger btn-cancel-msr btn-block" url="<?= base_url('approval/approval/will_cancel/'.$row->msr_no) ?>" title="Cancel MSR">Cancel MSR</a>
                                  <a href="#" data-id="<?=$row->msr_no?>" class="btn btn-sm btn-primary btn-cancel-msr btn-block" url="<?= base_url('approval/approval/will_cancel/'.$row->msr_no) ?>?release=1" title="Release MSR">Release MSR</a>
                                  <?php endif;?>
                                <?php endif;?>
                              </td>
                            </tr>
                            <?php endforeach;?>
                          </tbody>
                        </table>
                      </div>
                      <?php endif;?>
                    </div>
                  </div>
                </div>
                <?php if($this->uri->rsegment(3)): ?>
                  <?php if(isset($head)): ?>
                  
                  <?php else:?>
                  <div class="card-footer">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal-submit-cancel-msr">
                      <?php echo $this->input->get('release') ? 'Release' : 'Submit'; ?>
                    </a>
                  </div>
                  <div class="modal fade" id="modal-submit-cancel-msr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title" id="myModalLabel">Submit Confirmation</h4>
                        </div>
                        <div class="modal-body">
                          <form method="post" class="form-horizontal" id="frm-submit-confirmation">
                            <div class="row form-group">
                              <div class="col-md-12">
                                Are You Want To Proceed?
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-sm-12">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="submitCancelMsr()">Ok</button>
                                <?php 
                                  $submitCancelMsrUrl = $this->input->get('release') ? "approval/approval/cancel_msr_doc/".$msr->msr_no."?release=1" : "approval/approval/cancel_msr_doc/".$msr->msr_no."?submit-cancel-msr=1";
                                ?>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endif;?>
                <?php endif;?>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-submit-confirmation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Submit Confirmation</h4>
      </div>
      <div class="modal-body">
        <form method="post" class="form-horizontal" id="frm-submit-confirmation">
          <input type="hidden" id="msr_no" name="msr_no">
          <div class="row form-group">
            <div class="col-md-12 title-submit-confirmaton">
              Are You Sure Cancel MSR?
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="okClick()">Ok</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="url" name="url">
<script type="text/javascript">
  $(document).ready(function(){
    $('#tbl').DataTable({
      'scrollY'   : true,
      'scrollX'   : true,
      "paging"    : true,
      "info"      : true,
      "searching" : true,
      "ordering"  : false,
      "processing": true,
    });
    $(".btn-cancel-msr").click(function(){
      var msr_no = $(this).attr('data-id')
      var title = $(this).attr('title')
      var url = $(this).attr('url')
      $("#msr_no").val(msr_no)
      $("#modal-submit-confirmation").modal('show')
      $(".title-submit-confirmaton").html(title)
      $("#url").val(url)
    })
    $("#frm-bled").steps({
      headerTag: "h6",
      bodyTag: "fieldset",
      transitionEffect: "fade",
      titleTemplate: '#title#',
      enableFinishButton: false,
      enablePagination: true,
      enableAllSteps: true,
      labels: {
          finish: 'Done'
      },
      onFinished: function (event, currentIndex) {
          // alert("Form submitted.");
      },
      onStepChanged: function (event, currentIndex, priorIndex) {

      }
    });
    //hide next and previous button
    $('a[href="#next"]').hide();
    $('a[href="#previous"]').hide();
  })
  function okClick(){
    var msr_no = $("#msr_no").val()
    var url = $("#url").val()
    window.open(url,"_self")
  }
  <?php if($this->uri->rsegment(3)): ?>
  function uploadClick() {
    var form = $("#form-upload")[0];
    var data = new FormData(form);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "<?=base_url('approval/approval/cancel_msr_doc')?>",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        beforeSend:function(){
          start($('#configuration'));
        },
        success: function (data) {
          $("#dt-attachment").html(data);
          stop($('#configuration'));
          $("#myModal").modal('hide');
          $("#file_path").val('');
          $("#file_name").val('');
        },
        error: function (e) {
          alert('Fail, Try Again');
          stop($('#configuration'));
          $("#myModal").modal('hide');
        }
    });
  }
  function hapusFile(argument) {
    if(confirm('Are delete this data?'))
    {
      $.ajax({
        url:'<?=base_url('approval/approval/cancel_msr_doc')?>/'+argument+'/?delete=1',
        beforeSend:function(){
          start($('#configuration'));
        },
        success: function (data) {
          $("#dt-attachment").html(data);
          stop($('#configuration'));
        },
        error: function (e) {
          alert('Fail, Try Again');
          stop($('#configuration'));
        }
      });
    }
  }
  <?php if(isset($head)): ?>
  function approveClick(t_approval_id) {
    var status = $("#status-"+t_approval_id).val()
    var desc = $("#desc-"+t_approval_id).val()
    if(status == 1)
    {

    }
    else
    {
      if($("#desc-"+t_approval_id).val())
      {

      }
      else
      {
        alert('Comments shall be filled in')
        return false;
      }
    }
    $.ajax({
      type:'post',
      data:{status:status,desc:desc,t_approval_id:t_approval_id},
      url:'<?=base_url('approval/approval/cancel_msr_doc/'.$msr->msr_no)?>?approve=1',
      beforeSend:function(){
        start($('#configuration'));
      },
      success: function (data) {
        var r = eval("("+data+")")
        if(r.status)
        {
          alert(r.msg)
          window.open("<?= base_url('home') ?>","_self")
        }
        else
        {
          alert('Fail, Try Again')
        }
        stop($('#configuration'));
      },
      error: function (e) {
        alert('Fail, Try Again');
        stop($('#configuration'));
      }
    });
  }
  <?php else:?>
  function submitCancelMsr() {
    $.ajax({
      url:'<?=base_url()?>/<?=$submitCancelMsrUrl?>',
      beforeSend:function(){
        start($('#configuration'));
      },
      success: function (data) {
        var r = eval("("+data+")")
        if(r.status)
        {
          alert(r.msg)
          window.open("<?= base_url('home') ?>","_self")
        }
        else
        {
          alert('Fail, Try Again')
        }
        stop($('#configuration'));
      },
      error: function (e) {
        alert('Fail, Try Again');
        stop($('#configuration'));
      }
    });
  }
  <?php endif;?>
  <?php endif;?>
</script>