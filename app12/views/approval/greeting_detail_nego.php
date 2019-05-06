
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
          <h3 class="content-header-title mb-0">Please Verify MSR <?=$msr_no?></h3>
        </div>
        <div class="content-header-right col-md-6 col-12 mb-2">
          <div class="table-responsive">
            <table class="table table-condensed table-striped">
              <tr>
                <td width="50%">Total (Exc VAT)</td>
                <td width="15">:</td>
                <td class="text-right"><?=numIndo($msr->total_amount,0)?> IDR</td>
              </tr>
              <tr>
                <td>VAT</td>
                <td>:</td>
                <td class="text-right"><?=numIndo(msrPajak($msr->total_amount),0)?> IDR</td>
              </tr>
              <tr>
                <td>Total (Incl. VAT)</td>
                <td>:</td>
                <td class="text-right"><?=numIndo(msrPajak($msr->total_amount, true),0)?> IDR</td>
              </tr>
            </table>
          </div>
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
                  <div class="card-body">
                    <form action="#" class="icons-tab-steps wizard-circle">
                      <!-- Step 1 -->
                      <h6><i class="step-icon fa fa-info"></i> Header</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="firstName2">Company :</label>
                              <input type="text" class="form-control" value="<?=$msr->company_name?>" disabled="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="lastName2">Require Date :</label>
                              <input type="text" class="form-control" value="<?=$msr->req_date?>" disabled="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="emailAddress3">MSR Type :</label>
                              <input type="email" class="form-control" value="<?=$msr->msr_name?>" disabled="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="location2">Lead Time :</label>
                              <input type="email" class="form-control" value="<?=$msr->lead_time?>" disabled="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="phoneNumber2">Title :</label>
                              <input class="form-control" value="<?=$msr->title?>" disabled="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="date2">Procurement Location :</label>
                              <input class="form-control" value="<?=$msr->proc_location_name?>" disabled="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="phoneNumber2">Cost Center :</label>
                              <input class="form-control" value="<?=$msr->cost_center_name?>" disabled="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="date2">Procurement Method :</label>
                              <input class="form-control" value="<?=$msr->proc_method_name?>" disabled="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="phoneNumber2">Currency :</label>
                              <input class="form-control" value="<?=$msr->currency?>" disabled="">
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 2 -->
                      <h6><i class="step-icon fa fa-th-list"></i>Detail</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="proposalTitle2">Delivery Point :</label>
                              <input value="<?=$msr->dpoint_desc?>" class="form-control" disabled="">
                            </div>
                            <div class="form-group">
                              <label for="emailAddress4">Request For :</label>
                              <input value="<?=$msr->requestfor_desc?>" class="form-control" disabled="">
                            </div>
                            <div class="form-group">
                              <label for="videoUrl2">Delivery Term :</label>
                              <input value="<?=$msr->deliveryterm_desc?>" class="form-control" id="proposalTitle2" disabled="">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="jobTitle3">Importation :</label>
                              <input value="" class="form-control" id="proposalTitle2" disabled="">
                            </div>
                            <div class="form-group">
                              <label for="jobTitle3">Inspection :</label>
                              <input value="" class="form-control" id="proposalTitle2" disabled="">
                            </div>
                            <div class="form-group">
                              <label for="jobTitle3">Freight :</label>
                              <input value="" class="form-control" id="proposalTitle2" disabled="">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="table table-condensed">
                                <thead>
                                  <tr>
                                    <th>NO</th>
                                    <th>ITEM TYPE</th>
                                    <th>SEMIC NO</th>
                                    <th>DESC OF UNIT</th>
                                    <th>GROUP</th>
                                    <th>SUB GROUP</th>
                                    <th>QTY REQ</th>
                                    <th>QTY QH</th>
                                    <th>QTY ORD</th>
                                    <th>UOM</th>
                                    <th>EST UNIT PRICE</th>
                                    <th>EST TOTAL VALUE</th>
                                    <th>CUR</th>
                                    <th>IMPORTATION</th>
                                    <th>DELIVERY POINT LOCATION</th>
                                    <th>COST CENTER</th>
                                    <th>ACCOUNT SUBSIDIARY</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 3 -->
                      <h6><i class="step-icon fa fa-btc"></i>Budget</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="table table-condensed">
                                <thead>
                                  <tr>
                                    <th>COST CENTER</th>
                                    <th>COST CENTER DESC</th>
                                    <th>ACCOUNT SUBSIDIARY</th>
                                    <th>ACCOUNT SUBSIDIARY DESC</th>
                                    <th>MSR BOOKING AMOUNT</th>
                                    <th>MSR BUDGET STATUS</th>
                                    <th>AVAILABLE BUDGET</th>
                                    <th>STATUS BUDGET</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 4 -->
                      <h6><i class="step-icon fa fa-paperclip"></i>Attachment</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="table table-condensed">
                                <thead>
                                  <tr>
                                    <th>TYPE</th>
                                    <th>SEQ</th>
                                    <th>FILE NAME</th>
                                    <th>UPLOAD AT</th>
                                    <th>UPLOADER</th>
                                    <th>ACTION</th>
                                  </tr>
                                </thead>
                              </table>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 5 -->
                      <h6><i class="step-icon fa fa-envelope"></i>Note</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-1">
                            <i class="fa fa-3x fa-user"></i>
                          </div>
                          <div class="col-md-10">
                            <input class="form-control input-lg" name="msg" id="msg">
                          </div>
                          <div class="col-md-1">
                            <a href="#" class="btn btn-primary">Kirim</a>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="table table-condensed">
                                <tbody>
                                  <tr>
                                    <td width="50">
                                      <i class="fa fa-user fa-3x"></i>
                                    </td>
                                    <td>
                                      Nama : msg
                                      <br>
                                      <?=date("Y-m-d H:i:s")?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 6 -->
                      <h6><i class="step-icon fa fa-history"></i>History</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="table table-condensed">
                                <tbody>
                                  <tr>
                                    <td>
                                      xxx-approve
                                      <br>
                                      <?=date("Y-m-d H:i:s")?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
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
      <div class="content-footer">
        <div class="modal fade" id="myModalIssued" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">ISSUED</h4>
              </div>
              <div class="modal-body">
                <form method="post" action="<?=base_url('approval/approve')?>" class="form-horizontal open-this" id="frm-issued">
                  <!-- data_id -->
                  <input type="hidden" name="id" id="id" value="<?=$idnya?>">
                  <input type="hidden" name="data_id" value="<?=$msr_no?>">
                  <input type="hidden" name="status" value="1">
                  <!-- m_approval_id -->
                  <div class="form-group">
                    <div class="col-sm-12">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary pull-right" onclick="saveApprovalClick('frm-issued')">Save changes</button>
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
                <h4 class="modal-title" id="myModalLabel">Approve</h4>
              </div>
              <div class="modal-body">
                <form method="post" action="<?=base_url('approval/approve')?>" class="form-horizontal" id="frm">
                  <!-- data_id -->
                  <input type="hidden" name="id" id="id" value="<?=$idnya?>">
                  <input type="hidden" name="data_id" value="<?=$msr_no?>">
                  <!-- m_approval_id -->
                  <!-- <input type="text" name="m_approval_id" value="<?=$m_approval_id?>"> -->
                  <div class="form-group">
                    <label>Status</label>
                    <div class="col-sm-12">
                      <select class="form-control" name="status" id="status">
                        <option value="1">Approve</option>
                        <option value="2">Reject</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Deskripsi</label>
                    <div class="col-sm-12">
                      <textarea class="form-control" name="deskripsi"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" onclick="saveApprovalClick('frm')">Save changes</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="myModal-assign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">MSR Assignment</h4>
              </div>
              <div class="modal-body">
                <form method="post" action="<?=base_url('approval/msr_assign')?>" class="form-horizontal" id="frm-assign">
                  <!-- data_id -->
                  <input type="hidden" name="t_approval_id" id="t_approval_id" value="<?=$idnya?>">
                  <input type="hidden" name="msr_no" value="<?=$msr_no?>">
                  <!-- m_approval_id -->
                  <!-- <input type="text" name="m_approval_id" value="<?=$m_approval_id?>"> -->
                  <div class="row form-group">
                    <div class="col-sm-12">
                      <label>Select Procurement List</label>
                      <?php foreach ($this->db->like('ROLES',27)->get('m_user')->result() as $r) : ?>
                      <div class="row" style="margin-top: 10px">
                        <div class="col-sm-2">
                          
                        </div>
                        <div class="col-sm-8">
                          <?=$r->NAME?>
                        </div>
                        <div class="col-sm-1">
                          <input type="radio" name="user_id" value="<?=$r->ID_USER?>">
                        </div>
                      </div>
                      <?php endforeach;?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>MSR Type</label>
                    <div class="col-sm-12">
                      <select class="form-control" name="msr_type">
                        <?php foreach ($this->db->get('m_msrtype')->result() as $r) {
                          echo '<option value="'.$r->ID_MSR.'">'.$r->MSR_DESC.'</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Procurement Method</label>
                    <div class="col-sm-12">
                      <select class="form-control" name="proc_method">
                        <?php foreach ($this->db->get('m_pmethod')->result() as $r) {
                          echo '<option value="'.$r->ID_PMETHOD.'">'.$r->PMETHOD_DESC.'</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Deskripsi</label>
                    <div class="col-sm-12">
                      <textarea class="form-control" name="deskripsi"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" onclick="assignSend()">Save changes</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php if($approval->role_id == 9): ?>
          <?php if($approval->status == 0): ?>
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal">APPROVE/REJECT</a>
          <?php endif;?>
        <?php endif;?>
        <?php if($approval->role_id == 23): ?>
          <?php if($approval->status <> 4): ?>
          <!-- 1 approve, 2 reject, 4 assign -->
          <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal-assign">ASSIGN MSR</a>
          <?php endif;?>
        <?php endif;?>
        <?php if($readyIssude->num_rows() > 0): ?>
          <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModalIssued">ISSUED</a>
        <?php else:?>
          <?php if($approval->role_id == 28): ?>
            <a href="#" class="btn btn-success" onclick="developeBlEdClick()">Develope BL & ED</a>
          <?php endif;?>
        <?php endif;?>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    function saveApprovalClick(param) {
      xStatus = parseInt($("#status").val());
      if(xStatus == 1)
      {
        /*approve*/ url = "<?=base_url('approval/approval/approve')?>";
      }
      else
      {
        url = "<?=base_url('approval/approval/reject')?>";
      }
      $.ajax({
        type:'post',
        data:$("#"+param).serialize(),
        url:url,
        success:function(r){
          var a = eval("("+r+")");
          alert(a.msg);
          location.reload();
        }
      })
    }
    function assignSend() {
      url = "<?=base_url('approval/approval/assignment')?>";
      $.ajax({
        type:'post',
        data:$("#frm-assign").serialize(),
        url:url,
        success:function(r){
          var a = eval("("+r+")");
          alert(a.msg);
          location.reload();
        }
      })
    }
    function developeBlEdClick() {
      if(confirm('Are you sure to develope Bidder List & Enquiry Document?'))
      {
        window.open('<?=base_url('approval/approval/devbled/'.$msr_no.'/'.$idnya)?>','_self');
      }
    }
  </script>