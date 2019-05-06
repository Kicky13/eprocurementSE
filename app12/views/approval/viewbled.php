<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/daterange/daterangepicker.js" type="text/javascript"></script>
<script src="<?=base_url('ast11')?>/js/plugins/formatcurrency/simple.money.format.js" type="text/javascript"></script>

<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
          <h3 class="content-header-title mb-0">Enquiry Document Development</h3>
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
                <td>
                  <?php
                  $q = "select * from m_departement where ID_DEPARTMENT = '$msr->id_department'";
                  $s = $this->db->query($q)->row();
                  ?>
                  <?= $s ? $s->DEPARTMENT_DESC : '' ?>
                </td>
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
                <td style="width: 150px;">MSR Value  (Excl. VAT</i>)</td>
                <td class="no-padding-lr">:</td>
                <td class="text-right">
                  <?=$msr->currency?> <?=numIndo($msr->total_amount)?>
                  <?=equal_to($msr)?>
                </td>
            </tr>
          </table>
        </div>
		<div class="col-md-4">
        <table class="table table-condensed">
            <tr>
                <td style="width: 150px;">ED Number</td>
                <td class="no-padding-lr">:</td>
                <td><?=str_replace('OR', 'OQ', $msr_no)?></td>
             </tr>
             <tr>
                <td style="width: 150px;">Title</td>
                <td class="no-padding-lr">:</td>
                <td><label id="msr_title"></label></td>
            </tr>
          </table>
        </div>
	  </div>
      <div class="content-body">
        <!-- Form wizard with icon tabs section start -->
        <section id="icon-tabs">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- <div class="card-header">
                  <h4 class="card-title">Please Verify MSR <?=$msr_no?></h4>
                </div> -->
                <div class="card-content collapse show">
                  <div class="card-body card-scroll">
                    <form action="#" class="  wizard-circle" id="frm-bled">
                      <!-- data_id -->
                      <input type="hidden" name="bl_msr_no" id="bl_msr_no" value="<?=$msr->msr_no?>">
                      <!-- Step 1 -->
                      <h6><i class="step-icon fa fa-info"></i> Bidder List</h6>
                      <fieldset>
                        <div class="row">
                          <!-- <div class="col-md-4">
                            <div class="form-group">
                              <label for="firstName2">Bidder List Title :</label>
                              <input name="bl_title" id="bl_title" class="form-control" disabled value="<?=$t_bl ? $t_bl->title : $msr->title?>" >
                            </div>
                          </div> -->
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="date2">Procurement Method :</label>
                              <input name="bl_title" id="bl_title" class="form-control" disabled value="<?=pMethod($t_bl->pmethod)->PMETHOD_DESC?>" >
                            </div>
                          </div>
                        </div>
						<div class="space-1em"></div>
                        <div class="row">
                          <div class="col-sm-12">
                            <div class="table-responsive">
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Bidder(s) Name</th>
                                    <th rowspan="2">SLKA No</th>
                                    <th rowspan="2">Address</th>
                                    <th colspan="3" class="text-center">Contact</th>
                                  </tr>
                                  <tr>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                  </tr>
                                </thead>
                                <tbody id="dt-bled">

                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 2 -->
                      <h6><i class="step-icon fa fa-th-list"></i>Enquiry Data</h6>
                      <fieldset>
                          <div class="row">
							<!-- left side -->
                            <div class="col-md-6">
							  <div class="row">
								  <div class="form-group col-md-12">
									<label for="proposalTitle2">Subject :</label>
									<input  class="form-control" disabled name="subject" id="subject" value="<?=@$ed->subject?>">
								  </div>
                  <?php
                    $disabled = 'disabled';
                    $wantIssue = false;
                    if($readyIssude->num_rows() > 0 and $viewaja)
                    {
                      $wantIssue = true;
                      $disabled = '';
                    }
                  ?>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="emailAddress4">Pre Bid Date :</label>
                          <?php if($wantIssue):?>
                            <?php if($ed->prebid_loc == 0): ?>
                            <input disabled="" class="form-control dp" id="prebiddate" name="prebiddate" value="<?=dateToInput(@$ed->prebiddate, 'Y-m-d H:i')?>">
                            <?php else:?>
                            <input class="form-control dp" id="prebiddate" name="prebiddate" value="<?=dateToInput(@$ed->prebiddate, 'Y-m-d H:i')?>">
                            <?php endif;?>
                          <?php else:?>
                            <input <?=$disabled?> class="form-control dp" id="prebiddate" name="prebiddate" value="<?=dateToInput(@$ed->prebiddate, 'Y-m-d H:i')?>">
                          <?php endif;?>
                        </div>
                        <div class="form-group">
                          <label for="emailAddress4">Closing Date :</label>
                          <input <?=$disabled?> class="form-control dp" id="closing_date" name="closing_date" value="<?=dateToInput(@$ed->closing_date, 'Y-m-d H:i')?>">
                        </div>
                        <div class="form-group">
                          <label for="jobTitle3">Bid Validty :</label>
                          <input <?=$disabled?>  class="form-control tgl-aja" id="bid_validity" name="bid_validity" value="<?=@$ed->bid_validity?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="prebid_loc">Pre Bid Location :</label>
                          <?php if($wantIssue):?>
                            <?=optPreBidLocation('prebid_loc', @$ed->prebid_loc, "onchange='prebid_loc_change()' disabled")?>
                          <?php else:?>
                            <?=optPreBidLocation('prebid_loc', @$ed->prebid_loc, "onchange='prebid_loc_change()' $disabled")?>
                          <?php endif;?>
                          <?php
                          foreach ($this->db->get('m_pre_bid_location')->result() as $x) {
                            echo "<input type='hidden' id='prebid_loc_$x->id' value='$x->alamat'>";
                          }
                          ?>
                        </div>
                        <div class="form-group">
                          <label for="prebid_address">Pre Bid Address :</label>
                          <?php if($wantIssue):?>
                            <?php if($ed->prebid_loc == 0): ?>
                            <textarea disabled="" class="form-control" id="prebid_address" name="prebid_address"> <?=@$ed->prebid_address?></textarea>
                            <?php else:?>
                            <textarea disabled="" class="form-control" id="prebid_address" name="prebid_address"> <?=@$ed->prebid_address?></textarea>
                            <?php endif;?>
                          <?php else:?>
                          <textarea <?=$disabled?> class="form-control" id="prebid_address" name="prebid_address"> <?=@$ed->prebid_address?></textarea>
                          <?php endif;?>
                        </div>
                      </div>
                    </div>
                  </div>
							  </div>
                            </div>
							<!-- right side -->
                            <div class="col-md-6">
								<div class="row">
								  <div class="form-group col-md-6">
									<label for="jobTitle3">Currency :</label>
									<input class="form-control" disabled="" value="<?=$this->db->where('ID', $ed->currency)->get('m_currency')->row()->CURRENCY?>">
								  </div>
								  <div class="col-md-6"></div>
								  <div class="form-group col-md-6">
									  <label for="jobTitle3">Bid Bond : </label>
                    <?php if($wantIssue):?>
                      <select class="form-control" disabled style="margin-bottom: 10px;" name="bid_bond_type" id="bid_bond_type" onchange="bid_bond_type_change()">
                    <?php else:?>
                      <select class="form-control" <?=$disabled?> style="margin-bottom: 10px;" name="bid_bond_type" id="bid_bond_type" onchange="bid_bond_type_change()">
                    <?php endif;?>
                      <option value="3" <?=@$ed->bid_bond_type == 3 ? "selected":""?>>Value</option>
                      <option value="1" <?=@$ed->bid_bond_type == 1 ? "selected":""?>>%</option>
                      <option value="2" <?=@$ed->bid_bond_type == 2 ? "selected":""?>>Not Applicable</option>
										</select>
								  </div>
								  <div class="col-md-6">
                    <label for="jobTitle3">&nbsp;</label>
                    <?php if($wantIssue):?>
                      <?php if($ed->bid_bond_type == 2): ?>
                      <input placeholder="Fill bid here" disabled="" class="form-control" disabled id="bid_bond"  name="bid_bond" value="<?= numIndo($ed->bid_bond)?>">
                      <?php else:?>
                      <input placeholder="Fill bid here" class="form-control" disabled id="bid_bond"  name="bid_bond" value="<?= numIndo($ed->bid_bond) ?>">
                      <?php endif;?>
                    <?php else:?>
                      <input placeholder="Fill bid here" class="form-control" <?= $disabled ?> id="bid_bond"  name="bid_bond" value="<?= $disabled ? @numIndo($ed->bid_bond) : $ed->bid_bond?>">
                    <?php endif;?>
                  </div>
								  <div class="form-group col-md-6">
									<label for="jobTitle3">Bid Bond Validty :</label>
                  <?php if($wantIssue):?>
                    <?php if($ed->bid_bond_type == 2): ?>
                      <input disabled class="form-control" id="bid_bond_validity"  name="bid_bond_validity" value="<?=@$ed->bid_bond_validity?>">
                    <?php else:?>
                      <input class="form-control" id="bid_bond_validity" name="bid_bond_validity" value="<?=@$ed->bid_bond_validity?>">
                    <?php endif;?>
                  <?php else:?>
                    <input <?=$disabled?> class="form-control" id="bid_bond_validity"  name="bid_bond_validity" value="<?=@$ed->bid_bond_validity?>">
                  <?php endif;?>
								  </div>
								  <div class="form-group col-md-6">
									<label for="jobTitle3">Evaluation Method :</label>
									<input type="text" name="x" disabled="" value="<?= $ed->commercial_data ? edOptData('mix',$ed->commercial_data) : '' ?>" class="form-control">
								  </div>
								  <div class="form-group col-md-6">
									<label for="emailAddress4">Envelope System :</label>
									<select class="form-control" name="envelope_system" disabled="">
									  <option value="1" <?=@$ed->envelope_system == 1 ? "selected":"" ?> >1 Envelope</option>
									  <option value="2" <?=@$ed->envelope_system == 2 ? "selected":"" ?> >2 Envelope</option>
									</select>
								  </div>
								  <div class="form-group col-md-6">
									<label for="packet">Itemize/Packet</label>
									<select class="form-control" name="packet" id="packet" disabled="">
									  <option value="1" <?=@$ed->packet == 1 ? "selected":"" ?> >Itemize</option>
									  <option value="2" <?=@$ed->packet == 2 ? "selected":"" ?> >Packet</option>
									</select>
								  </div>
                  <?php if($msr->id_msr_type == 'MSR01') : ?>
								  <div class="form-group col-md-6">
                    <label for="incoterm">Incoterm</label>
                    <input value="<?= @$ed->DELIVERYTERM_DESC ?>" class="form-control disabled" disabled="">
                  </div>
                  <div class="form-group col-md-6">
  									<label for="dpoint">Delivery Point</label>
                    <input  value="<?= @$ed->DPOINT_DESC ?>" class="form-control disabled" disabled="">
								  </div>
                  <?php endif;?>
								</div>
                            </div>
                          </div>
                      </fieldset>
                      <!-- SOP -->
                      <?php $this->load->view('approval/sop_view', ['tbmi2'=>$tbmi2, 'msr_no'=>$msr_no]) ?>
                      <!-- Step 3 -->
                      <h6><i class="step-icon fa fa-btc"></i>Enquiry Document</h6>
                      <fieldset>
                        <div class="row">
                          <!-- <div class="col-md-12">
                            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal">UPLOAD</a>
                          </div> -->
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="table table-condensed">
                                <thead>
                                  <tr>
                                    <th>Type</th>
                                    <th>Filename</th>
                                    <th>Uploaded Date</th>
                                    <th>Uploaded By</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($doc as $key => $value) {
                                    echo "<tr>
                                      <td>".biduploadtype($value->tipe, true)."</td>
                                      <td><a href='".base_url('userfiles/temp/'.$value->file_path)."' target='_blank'>".$value->file_name."</a></td>
                                      <td>".dateToIndo($value->created_at, false, true)."</td>
                                      <td>".user($value->created_by)->NAME."</td>
                                    </tr>";
                                  }?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <h6><i class="step-icon icon-directions"></i>Approval</h6>
                      <fieldset>
                        <div class="table-responsive">
                          <table class="table">
                            <thead>
                              <tr>
                                <th width="1px">No</th>
                                <th>Role</th>
                                <th>User</th>
                                <th>Approval Status</th>
                                <th>Transaction Date</th>
                                <th>Comment</th>
                                <th class="text-center">Action</th>
                              </tr>
                            </thead>
                            <tbody id="result-approval">
                              <?php
                                $listApprovalEd = $this->approval_lib->listApprovalEd($msr_no);
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
                                  if($value->created_by == $userLogin->ID_USER and ($value->status == 0 or $value->status == 4))
                                  {

                                    $q = $this->db->select('t_approval.*')
                                    ->join('m_approval','m_approval.id = t_approval.m_approval_id','left')
                                    ->where([
                                      'data_id'       =>$msr_no,
                                      't_approval.status'   =>0,
                                      't_approval.urutan <' =>$value->urutan,
                                      'm_approval.module_kode'  => 'msr_spa'
                                    ])->get('t_approval');

                                    if($value->urutan > 1)
                                    {
                                      if($q->num_rows() > 0)
                                      {
                                        $approveLink = '';
                                        $user = user();
                                        $roles              = explode(",", $user->ROLES);
                                        $roles      = array_values(array_filter($roles));
                                        if(in_array(proc_committe, $roles))
                                        {
                                          $sql = "select * from t_approval where data_id = '$msr_no' and m_approval_id between 7 and 11 and status = 0";

                                          $t_approval  = $this->db->query($sql);
                                          if($t_approval->num_rows() > 0)
                                          {

                                          }
                                          else
                                          {
                                            $approveLink = "<a href='#' class='btn btn-primary btn-sm' onclick='apprejectmodal($value->id)'>Approve/Reject</a>";
                                          }
                                        }
                                      }
                                      else
                                      {
                                        $approveLink = "<a href='#' class='btn btn-primary btn-sm' onclick='apprejectmodal($value->id)'>Approve/Reject</a>";
                                      }
                                    }
                                    else
                                    {
                                      $approveLink = "<a href='#' class='btn btn-primary btn-sm' onclick='apprejectmodal($value->id)'>Approve/Reject</a>";
                                    }
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
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Form wizard with icon tabs section end -->
      </div>
      <div class="form-group text-right">
        <?php if($readyIssude->num_rows() > 0 and $viewaja): ?>
        <a href="javascript:void(0)" class="btn btn-success" onclick="issuedClick('frm-issued')">Issued</a>
        <?php endif;?>
      </div>
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Approval</h4>
            </div>
            <div class="modal-body">
              <form method="post" action="<?=base_url('approval/approve')?>" id="frm">
                <!-- T_APPROVAl_ID -->
                <input type="hidden" name="id" id="id" class="idnya" value="<?=$idnya?>">
                <!-- data_id -->
                <input type="hidden" name="data_id" value="<?=$msr_no?>">
                <!-- module_kode -->
                <input type="hidden" name="module_kode" value="msr_spa">
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
    </div>
  </div>
  <div class="modal fade" id="myModalIssued" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">ED Issuance</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approve')?>" class="form-horizontal" id="frm-issued">
            <!-- data_id -->
            <input type="hidden" name="id" id="id" value="<?=$idnya?>">
            <input type="hidden" name="data_id" value="<?=$msr_no?>">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="module_kode" value="msr_spa">
            <!-- <input type="hidden" name="status_str" value="issued ed"> -->
            <!-- m_approval_id -->
            <div class="form-group">
              <div class="col-sm-12 text-right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="issuedClick('frm-issued')">Issued ED</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $("#administration,#technical_data,#commercial_data").attr("disabled","disabled");
    $.ajax({
      url:"<?=base_url('approval/approval/dtBlSession/'.$msr_no.'/0')?>",
      success:function(r){
        $("#dt-bled").html(r);
      }
    });
    function issuedClick() {
      swalConfirm('ED Issuance', '<?= __('confirm_submit') ?>', function() {
        var prebid_loc = $("#prebid_loc").val();
        var prebiddate = $("#prebiddate").val();
        var prebid_address = $("#prebid_address").val();
        var closing_date = $("#closing_date").val();
        var bid_validity = $("#bid_validity").val();
        var bid_bond_validity = $("#bid_bond_validity").val();
        var bid_bond_type = $("#bid_bond_type").val();
        var bid_bond = $("#bid_bond").val();

        if(bid_bond_type == '2')
        {
          $("#bid_bond").val(null);
        }
        else
        {
          if(bid_bond)
          {

          }
          else
          {
            swal('<?= __('warning') ?>', 'Bid Bond Must be Filled', "warning");
            return false;
          }
        }

        url = "<?=base_url('approval/approval/approve')?>?prebid_loc="+prebid_loc+"&prebiddate="+prebiddate+"&prebid_address="+prebid_address+"&closing_date="+closing_date+"&bid_validity="+bid_validity+"&bid_bond_validity="+bid_bond_validity+"&bid_bond_type="+bid_bond_type+"&bid_bond="+bid_bond+"&issued=1";
        $.ajax({
          type:'post',
          data:$("#frm").serialize(),
          url:url,
          beforeSend:function(){
            start($('#myModal'));
          },
          success:function(r){
            var a = eval("("+r+")");
            //swal('Done', a.msg, "success");
            stop($('#myModal'));
            window.open("<?=base_url('home')?>","_self");
          },
            error:function(){
            stop($('#myModal'));
          }
        });
      });
    }
    function saveApprovalClick() {
      xStatus = parseInt($("#status").val());
      if(xStatus == 1)
      {
        /*approve*/ url = "<?=base_url('approval/approval/approve')?>";
      }
      else
      {
        url = "<?=base_url('approval/approval/reject2')?>";
        if($("#deskripsi").val() == '')
        {
          swal('<?= __('warning') ?>','The Comment field is required','warning')
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
          swal('Done', a.msg, "success");
          stop($('#myModal'));
          if(a.status)
          {
            $("#myModal").modal('hide');
            $.ajax({
              url:"<?= base_url('approval/ed/approval_ajax/'.$msr_no) ?>",
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
          stop($('#myModal'));
        }
      })
    }
    $(document).ready(function(){
      var prebid_loc = $("#prebid_loc").val()
      if(prebid_loc == '0')
      {
        $("#prebid_address,#prebiddate").val(null)
        $("#prebiddate,#prebid_address").attr('readonly','')
      }
      else
      {
        $("#prebiddate,#prebid_address").removeAttr('readonly','')
      }
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

		}
		});

		//hide next and previous button
		$('a[href="#next"]').hide();
		$('a[href="#previous"]').hide();

		$('#subject').keyup(function(){
		  $('#msr_title').html($('#subject').val());
		})
		.keyup()

    })
    function apprejectmodal(id) {
      $("#myModal").modal('show')
      $(".idnya").val(id)
    }
	//Format Currency Input
	  /*jQuery(function ($) {
		$('#bid_bond').simpleMoneyFormat();
	  })*/
    function prebid_loc_change() {
      var prebid_loc = $("#prebid_loc").val();
      s = $("#prebid_loc_"+prebid_loc).val();
      $("#prebid_address").val(s);
      if(prebid_loc == '0')
      {
        $("#prebid_address").val(null)
        $("#prebiddate").val(null)
        $("#prebiddate,#prebid_address").attr('readonly','')
      }
      else
      {
        $("#prebiddate,#prebid_address").removeAttr('readonly','')
      }
    }
    $(function() {
      $('#closing_date').datetimepicker({
        format:'YYYY-MM-DD HH:mm',
      });
      $('#prebiddate').datetimepicker({
        format:'YYYY-MM-DD HH:mm',
        //maxDate : ($('#closing_date').val() != '') ? $('#closing_date').val() : new Date()
      });
      $('#bid_validity').datetimepicker({
        format:'YYYY-MM-DD',
        //minDate : ($('#closing_date').val() != '') ? $('#closing_date').val()) : new Date()
      });
      $('#bid_bond_validity').datetimepicker({
        format:'YYYY-MM-DD',
        //minDate : ($('#closing_date').val() != '') ? $('#closing_date').val() : new Date()
      });
      /*$('#closing_date').on('dp.change', function() {
        $('#prebiddate').data("DateTimePicker").maxDate($('#closing_date').val());
        $('#bid_validity').data("DateTimePicker").minDate($('#closing_date').val());
        $('#bid_bond_validity').data("DateTimePicker").minDate($('#closing_date').val());
      });*/
      $('#bid_bond_type').change(function() {
        if ($('#bid_bond_type').val() == 3) {
          $('#bid_bond').prop('readonly', false);
          <?php if($disabled == 'disabled'): ?>

            <?php else:?>
              $('#bid_bond').number(true, 2, bahasa.thousand_separator, bahasa.decimal_separator);
            <?php endif;?>

          $('#bid_bond_validity').prop('readonly', false);
        } else {
          $('#bid_bond').replaceWith('<input placeholder="Fill bid here" class="form-control" id="bid_bond"  name="bid_bond" value="<?=$ed->bid_bond?>">');
          var value = toFloat($('#bid_bond').val());
          if (value > 100) {
            value = 100;
          }
          if (value < 0) {
            value = 0;
          }
          $('#bid_bond').val(value);
          if ($('#bid_bond_type').val() == '1') {
            $('#bid_bond').keyup(function() {
                if ($('#bid_bond_type').val() == 1) {
                  var value = toFloat($('#bid_bond').val());
                  if (value > 100) {
                    value = 100;
                  }
                  if (value < 0) {
                    value = 0;
                  }
                  $('#bid_bond').val(value);
                }
            });
            $('#bid_bond_validity').prop('readonly', false);
          } else {
            $('#bid_bond').prop('readonly', true);
            $('#bid_bond_validity').val('').prop('readonly', true);
          }
        }
      });
      // $('#bid_bond_type').change();
    });
  </script>