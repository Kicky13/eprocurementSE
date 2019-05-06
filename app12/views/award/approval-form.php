<?php
  $msri = $this->approval_lib->msrItem($ed->msr_no);
  // $msr = $this->db->where(['msr_no'=>$ed->msr_no])->get('t_msr')->row();
?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?=isset($titleApp) ? $titleApp : '';?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item"><?= $titleApp ?> </li>
          </ol>
        </div>
      </div>
    </div>
    <div class="row info-header">
      <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
              <td style="width: 150px;">Company</td>
              <td class="no-padding-lr">:</td>
              <td><?=$msr->company_name?></td>
          </tr>
          <tr>
              <td style="width: 150px;">Department</td>
              <td class="no-padding-lr">:</td>
              <td><?=$msr->department_desc?></td>
            </tr>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
              <td style="width: 150px;">MSR Number</td>
              <td class="no-padding-lr">:</td>
              <td><?=$msr_no?></td>
          </tr>
          <tr>
              <td style="width: 150px;">MSR Value (Excl. VAT)</td>
              <td class="no-padding-lr">:</td>
              <td>
                <?=$msr->currency?> <?=numIndo($msr->total_amount)?>
                <?=equal_to($msr)?>
              </td>
          </tr>
          <?php if($ed->ee_value > 0): ?>
          <tr>
              <td style="width: 125px;">Rev. MSR Value</td>
              <td class="no-padding-lr">:</td>
              <td>
                <?php
                  $edc = $this->db->where(['ID'=>$ed->currency])->get('m_currency')->row();
                  echo $edc->CURRENCY;
                ?>
                <?=numIndo($ed->ee_value)?>
              </td>
          </tr>
          <?php endif;?>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
              <td style="width: 105px;">ED Number</td>
              <td class="no-padding-lr">:</td>
              <td><?=str_replace('OR', 'OQ', $msr_no)?></td>
           </tr>
          <tr>
              <td style="width: 105px;">Title</td>
              <td class="no-padding-lr">:</td>
              <td><?=$ed->subject?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="content-body">
      <section id="icon-tabs">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-content collapse show">
                <div class="card-body card-scroll">
                  <form action="<?=base_url('approval/approval/closingopening')?>" class="frm-bled" id="frm-bled">
                    <?php if($bod): ?>

                    <h6><i class="step-icon fa fa-th-list"></i>Evaluation</h6>
                    <?php $this->load->view('award/tab-evaluation', ['blDetails'=>$blDetails, 'ed'=>$ed, 'bod'=>$bod])?>

                    <h6><i class="step-icon fa fa-download"></i>Approval</h6>
                    <fieldset>
                        <div class="table-responsive">
                          <table class="table">
                            <thead>
                              <tr>
                                <th width="15">No</th>
                                <th>Role Access</th>
                                <th>User</th>
                                <th>Approval Status</th>
                                <th>Transaction Date</th>
                                <th>Comment</th>
                                <th class="text-center">Action</th>
                              </tr>
                            </thead>
                            <tbody id="result-approval">
                              <?php
                                $listApprovalEd = $this->approval_lib->listApprovalAward($msr_no);
                                $no = 1;
                                $userLogin = user();
                                foreach ($listApprovalEd->result() as $key => $value) {
                                  $approvalStr = '';
                                  $approvalDate = '';
                                  if($value->status == 0){
                                    $approvalStr = '';
                                    $approvalDate = '';
                                  }
                                  if($value->status == 1){
                                    $approvalStr = 'Approve';
                                    $approvalDate = $value->created_at;
                                  }
                                  if($value->status == 2){
                                    $approvalStr = 'Reject';
                                    $approvalDate = $value->created_at;
                                  }
                                  $approveLink = '';
                                  if($value->created_by == $userLogin->ID_USER and ($value->status == 0 or $value->status == 2))
                                  {
                                    $approveLink = "<a href='#' class='btn btn-primary btn-sm' onclick='apprejectmodal($value->id)'>Approve/Reject</a>";
                                  }
                                  $desc = '';
                                  if($value->status == 2 || $value->status == 1)
                                  {
                                    $desc = $value->deskripsi;
                                  }
                                  echo "<tr>
                                  <td>$no</td>
                                  <td>$value->role_name</td>
                                  <td>$value->user_nama</td>
                                  <td>$approvalStr</td>
                                  <td>".dateToIndo($approvalDate, false, true)."</td>
                                  <td>$desc</td>
                                  <td class='text-center'>$approveLink</td>
                                  </tr>";
                                  $no++;
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                    </fieldset>

                    <?php else:?>
                    <!-- Step 1 -->
                    <h6><i class="step-icon fa fa-info"></i> Quotation</h6>
                    <fieldset>
                      <?php $this->load->view('approval/quotation_view', ['ed'=>$ed, 't_bl'=>$t_bl])?>
                    </fieldset>

                    <h6><i class="step-icon fa fa-th-list"></i>Evaluation</h6>
                    <?php $this->load->view('award/tab-evaluation', ['blDetails'=>$blDetails])?>
                    <!-- Step 2 -->
                    <h6><i class="step-icon fa fa-th-list"></i>Enquiry Data</h6>
                    <fieldset>
                      <?php $this->load->view('approval/tab_ed_view', ['ed'=>$ed, 'msr'=>$msr]); ?>
                    </fieldset>
                    <!-- Step 3 -->
                    <h6><i class="step-icon fa fa-download"></i>Enquiry Document</h6>
                    <?php $this->load->view('award/tab-attachment', ['doc'=>$doc])?>
                    <!-- Step 3 -->
                    <h6><i class="step-icon fa fa-download"></i>Approval</h6>
                    <fieldset>
                        <div class="table-responsive">
                          <table class="table table-row-border">
                            <thead>
                              <tr>
                                <th width="15">No</th>
                                <th>Role Access</th>
                                <th>User</th>
                                <th>Approval Status</th>
                                <th>Transaction Date</th>
                                <th>Comment</th>
                                <th class="text-center">Action</th>
                              </tr>
                            </thead>
                            <tbody id="result-approval">
                              <?php
                                $listApprovalEd = $this->approval_lib->listApprovalAward($msr_no);
                                $no = 1;
                                $userLogin = user();
                                foreach ($listApprovalEd->result() as $key => $value) {
                                  $approvalStr = '';
                                  $approvalDate = '';
                                  if($value->status == 0){
                                    $approvalStr = '';
                                    $approvalDate = '';
                                  }
                                  if($value->status == 1){
                                    $approvalStr = 'Approve';
                                    $approvalDate = $value->created_at;
                                  }
                                  if($value->status == 2){
                                    $approvalStr = 'Reject';
                                    $approvalDate = $value->created_at;
                                  }
                                  $approveLink = '';
                                  if($value->created_by == $userLogin->ID_USER and ($value->status == 0 or $value->status == 2))
                                  {
                                    $approveLink = "<a href='#' class='btn btn-primary btn-sm' onclick='apprejectmodal($value->id)'>Approve/Reject</a>";
                                  }
                                  $desc = '';
                                  if($value->status == 2 || $value->status == 1)
                                  {
                                    $desc = $value->deskripsi;
                                  }
                                  echo "<tr>
                                  <td>$no</td>
                                  <td>$value->role_name</td>
                                  <td>$value->user_nama</td>
                                  <td>$approvalStr</td>
                                  <td>".dateToIndo($approvalDate, false, true)."</td>
                                  <td>$desc</td>
                                  <td class='text-right'>$approveLink</td>
                                  </tr>";
                                  $no++;
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                    </fieldset>
                    <?php endif;?>

                    <?php $this->load->view('approval/review_ee_tab');?>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="content-footer text-right">
      <!--
      <?php if(isset($approval)): ?>
        <a href="#" class="btn btn-success" data-toggle='modal' data-target='#modal-frm-recomendation' >Approval Award Recomendation </a>
      <?php endif;?>
      <?php if(isset($ack)): ?>
        <a href="#" class="btn btn-success" data-toggle='modal' data-target='#modal-frm-recomendation' >Acknowledge Award Recomendation </a>
      <?php endif;?>
      <?php if(isset($ackapproval)): ?>
        <a href="#" class="btn btn-success" data-toggle='modal' data-target='#modal-frm-recomendation' >Approval Acknowledge Award Recomendation </a>
      <?php endif;?>
      <?php if(isset($receiveawardrecev)): ?>
        <a href="#" class="btn btn-success" data-toggle='modal' data-target='#modal-frm-recomendation' >Approval Award Recomendation & Evaluation </a>
      <?php endif;?>
      -->
    </div>
  </div>
</div>
<div class="modal fade" id="modal-frm-recomendation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">
            <?php if(isset($approval)): ?>
              Approval Award Recomendation
            <?php endif;?>
            <?php if(isset($ack)): ?>
              Acknowledge Award Recomendation
            <?php endif;?>
            <?php if(isset($ackapproval)): ?>
              Approval Acknowledge Award Recomendation
            <?php endif;?>
            <?php if(isset($receiveawardrecev)): ?>
              Approval Award Recomendation & Evaluation
            <?php endif;?>
          </h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/award/approval')?>" class="form-horizontal" id="frm-recomendation">
            <input type="hidden" name="id" id="id" value="<?=$ed->id?>">
            <?php if(isset($approval)): ?>
            <div class="form-group row">
              <label class="col-md-3"><?=lang('Pilih Salah Satu','Choose One')?></label>
              <div class="col-sm-9">
                <select class="form-control" name="award">
                  <option value="4">Approve</option>
                  <option value="5">Reject</option>
                </select>
              </div>
            </div>
            <?php endif;?>
            <?php if(isset($ack)): ?>
              <div class="form-group">
                <p class="form-control-static">Are you Sure to Acknowledge Award Recomendation?</p>
              </div>
              <input type="hidden" name="award" id="award" value="6">
            <?php endif;?>
            <?php if(isset($ackapproval)): ?>
              <div class="form-group row">
                <label class="col-md-3"><?=lang('Pilih Salah Satu','Choose One')?></label>
                <div class="col-sm-9">
                  <select class="form-control" name="award">
                    <option value="7">Approve</option>
                    <option value="5">Reject</option>
                  </select>
                </div>
              </div>
            <?php endif;?>
            <?php if(isset($receiveawardrecev)): ?>
              <div class="form-group row">
                <label class="col-md-3"><?=lang('Pilih Salah Satu','Choose One')?></label>
                <div class="col-sm-9">
                  <select class="form-control" name="award">
                    <option value="8">Approve</option>
                    <option value="5">Reject</option>
                  </select>
                </div>
              </div>
            <?php endif;?>
            <div class="form-group">
              <div class="col-sm-12">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="formSubmitAjax('frm-recomendation')" class="btn btn-success">Yes Continue</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Approval</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approve')?>" class="form-horizontal" id="frm">
            <!-- T_APPROVAl_ID -->
            <input type="hidden" name="id" id="id" class="idnya" value="">
            <!-- data_id -->
            <input type="hidden" name="data_id" value="<?=$msr_no?>">
            <!-- module_kode -->
            <input type="hidden" name="module_kode" value="award">
            <div class="form-group">
              <label>Status</label>
              <select class="form-control" name="status" id="status">
                <option value="1">Approve</option>
                <option value="2">Reject</option>
              </select>
            </div>
            <div class="form-group">
              <label>Comment</label>
              <textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
            </div>
            <div class="form-group text-right">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="saveApprovalClick()">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    function formSubmitAjax(frm) {
      var f = $("#"+frm).attr('action');
      $.ajax({
        type: "POST",
        url: f,
        data: $('#'+frm).serialize(),
        beforeSend:function(){
          start($('#modal-'+frm));
        },
        success: function (data) {
          alert(data);
          stop($('#modal-'+frm));
          $('#modal-'+frm).modal('hide');
        },
        error: function (e) {
          alert('Fail, Try Again');
          stop($('#modal-'+frm));
          $('#modal-'+frm).modal('hide');
        }
      })
    }
  </script>
  <script type="text/javascript">
    function saveApprovalClick() {
      xStatus = parseInt($("#status").val());
      if(xStatus == 1)
      {
        /*approve*/ url = "<?=base_url('approval/approval/approve')?>";
      }
      else
      {
        url = "<?=base_url('approval/approval/reject_award')?>";
        if($("#deskripsi").val() == '')
        {
          swal('<?= __('warning') ?>','Comments shall be filled in','warning')
          return false;
        }
      }
      $.ajax({
        type:'post',
        data:$("#frm").serialize(),
        url:url,
        beforeSend:function(){
          start($('#myModal'));
        },
        success:function(r){
          var a = eval("("+r+")");
          swal('Done',a.msg,'success')
          stop($('#myModal'));
          if(a.status)
          {
            $("#myModal").modal('hide');
            $.ajax({
              url:"<?= base_url('approval/award/approval_ajax/'.$msr_no) ?>",
              success:function(e)
              {
                $("#result-approval").html(e);
              }
            })
          }
          else
          {
            window.open("<?=base_url('home')?>","_self");
          }
        },
          error:function(){
          swal('<?= __('warning') ?>','Something went wrong!','warning')
          stop($('#myModal'));
        }
      })
    }
    $(document).ready(function(){
      $("#status").change(function(){
        s = $(this).val();
        if(s == '2')
        {
          $("#deskripsi").attr("required","");
        }
        else
        {
          $("#deskripsi").removeAttr("required");
        }
      })

	  //form step
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

      if (!($('.modal.in').length)) {
        $('.modal-dialog').css({
          top: 0,
          left: 0
        });
      }
      $('.modal-dialog').draggable({
        handle: ".modal-header"
      });
    })
    function apprejectmodal(id) {
      $("#myModal").modal('show')
      $(".idnya").val(id)
    }


  </script>