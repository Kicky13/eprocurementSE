<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/daterange/daterangepicker.js" type="text/javascript"></script>

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
                <td>Company</td>
                <td width="15">:</td>
                <td><?=$msr->company_name?> <?=$idnya?></td>
            </tr>
            <tr>
                <td>Department</td>
                <td>:</td>
                <td>
                  <?php 
                  $q = "select * from m_departement where ID_DEPARTMENT = '$msr->id_department'";
                  $s = $this->db->query($q)->row();
                  ?>
                  <?= $s ? $s->DEPARTMENT_DESC : '' ?></td>
              </tr> 
          </table>
        </div>
		<div class="col-md-4">
        <table class="table table-condensed">
            <tr>
                <td>MSR Number</td>
                <td>:</td>
                <td><?=$msr_no?></td>
            </tr>
            <tr>
                <td>Proc Method</td>
                <td>:</td>
                <td><?=$msr->proc_method_name?></td>
            </tr> 
          </table>
        </div>
		<div class="col-md-4">
        <table class="table table-condensed">
            <tr>
                <td>ED Number</td>
                <td>:</td>
                <td><?=str_replace('OR', 'OQ', $msr_no)?></td>
             </tr>
            <tr>
                <td>MSR Value</td>
                <td>:</td>
                <td><?=$msr->currency?> <?=numIndo($msr->total_amount,0)?> (<small style="color:red"><i>Exclude VAT</i></small>)</td>
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
                    <form action="#" class="wizard-circle frm-bled" id="frm-bled">
                      <!-- data_id -->
                      <input type="hidden" name="bl_msr_no" id="bl_msr_no" value="<?=$msr->msr_no?>">
                      <!-- Step 1 -->
                      <h6><i class="step-icon fa fa-info"></i> Bidder List</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-3" style="display: none">
                            <div class="form-group">
                              <label for="firstName2">Bidder List Title :</label>
                              <input name="bl_title" id="bl_title" class="form-control" value="<?=$t_bl ? $t_bl->title : $msr->title?>" required>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date2">Procurement Method :</label>
                              <?php 
                                $pmethod = @$t_bl->pmethod ? @$t_bl->pmethod : $msr->id_pmethod;
                              ?>
                              <?=optMethod('bl_pm', $pmethod)?> 
                            </div>
                          </div>
						  <div class="col-md-4">
                            <div class="form-group vendor-select">
                              <label for="date2" style="display:block;">Supplier :</label>
                              <select class="form-control" id="bl_vendor" name="bl_vendor">
                              <?php foreach ($this->db->where('LENGTH(no_slka)',4)->order_by('nama','asc')->get('m_vendor')->result() as $v) : ?>
                                <option value="<?=$v->ID?>"><?=$v->NAMA?></option>
                              <?php endforeach;?>
								</select> 
                            </div>
                          </div>  
						  <div class="col-md-2" style="text-align: center;padding: 15px;">
                            <div class="form-group">
							  <a href="javascript:void(0)" class="btn btn-primary btn-md" role="button" onclick="addClick()">Add</a>
                            </div>
                          </div> 
                        </div> 
                         
						<div class="row">
						  <div class="col-sm-2">
							<label class="col-form-label">BIDDER LIST</label>
						  </div> 
                        </div>
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
                                    <th colspan="3">Contact</th>
                                    <th rowspan="2">Hapus</th>
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
									<input  class="form-control" name="subject" id="subject" value="<?= isset($ed->subject) ? $ed->subject : $msr->title?>">
								  </div>
								  <div class="form-group col-md-6">
									<label for="emailAddress4">Pre Bid Date :</label>
									<input  class="form-control dp" id="prebiddate" name="prebiddate" value="<?=@$ed->prebiddate?>">
								  </div>
								  <div class="form-group col-md-6">
									<label for="videoUrl2">Pre Bid Location :</label>
									<?=optPreBidLocation('prebid_loc', @$ed->prebid_loc, "onchange='prebid_loc_change()'")?>
								  </div>
								  <?php 
									foreach ($this->db->get('m_pre_bid_location')->result() as $x) {
									  echo "<input type='hidden' id='prebid_loc_$x->id' value='$x->alamat'>";
									}
								  ?>
								  <div class="form-group col-md-7">
									<label for="emailAddress4">Pre Bid Address :</label>
									<textarea class="form-control" id="prebid_address" name="prebid_address"></textarea>
								  </div>
								  <div class="form-group col-md-5">
									<label for="emailAddress4">Closing Date :</label>
									<input class="form-control dp" id="closing_date" name="closing_date" value="<?=@$ed->closing_date?>">
								  </div>
								  <div class="form-group col-md-5">
									<label for="emailAddress4">Envelope System :</label>
									<select class="form-control" name="envelope_system" id="envelope_system">
									  <option value="1" <?=@$ed->envelope_system == 1 ? "selected":"" ?> >1 Envelope</option>
									  <option value="2" <?=@$ed->envelope_system == 2 ? "selected":"" ?> >2 Envelope</option>
									</select>
								  </div>
								  <div class="form-group col-md-4">
									<label for="packet">Itemize/Packet</label>
									<select class="form-control" name="packet" id="packet">
									  <option value="1" <?=@$ed->packet == 1 ? "selected":"" ?> >Itemize</option>
									  <option value="2" <?=@$ed->packet == 2 ? "selected":"" ?> >Packet</option>
									</select>
								  </div>
                  <?php if($msr->id_msr_type == 'MSR01'): ?>
								  <div class="form-group col-md-3">
  									<label for="incoterm">Incoterm</label>
  									<select class="form-control" name="incoterm" id="incoterm">
  									  <option value="1" <?=@$ed->incoterm == 1 ? "selected":"" ?> >DDP</option>
  									  <option value="2" <?=@$ed->incoterm == 2 ? "selected":"" ?> >DAP</option>
  									</select>
								  </div> 
                  <div class="form-group col-md-6">
                    <label for="delivery_point">Delivery Point</label>
                    <input class="form-control" name="delivery_point" id="delivery_point" value="<?=@$ed->delivery_point?>">
                  </div> 
                  <?php else:?>
                    <input type="hidden" name="incoterm" id="incoterm" value="<?=@$ed->incoterm?>">
                    <input type="hidden" name="delivery_point" id="delivery_point"  value="<?=@$ed->delivery_point?>">
                  <?php endif;?>
								</div>
							</div>
							<!-- right side -->
              <div class="col-md-6">
								<div class="row">
								  <div class="form-group col-md-6">
									<label for="jobTitle3">Evalution Method :</label>
									<?=optEd('mix', 'commercial_data', @$ed->commercial_data)?>
								  </div>
								  <div class="form-group col-md-6">
									<label for="jobTitle3">Currency :</label>
									<?php 
									  if(@$ed->currency)
									  {
										$cur = @$ed->currency;
									  }
									  else
									  {
										$cur = $msr->id_currency;
									  }
									?>
									<?=optCurrency('currency', $cur)?>
								  </div>
								  
								  <div class="form-group col-md-6">
									<label for="jobTitle3">Bid Validty :</label>
									<input  class="form-control tgl-aja" id="bid_validity" name="bid_validity" value="<?=@$ed->bid_validity?>">
								  </div>
								  <div class="form-group col-md-6">
									<label class="jobTitle3">Bid Bond :</label> 
									  <select class="form-control col-md-8" name="bid_bond_type" id="bid_bond_type" style="margin-bottom: 10px;" onchange="bid_bond_type_change()">
										<option value="1" <?=@$ed->bid_bond_type == 1 ? "selected":""?>>%</option>
										<option value="3" <?=@$ed->bid_bond_type == 3 ? "selected":""?>>Value</option>
										<option value="2" <?=@$ed->bid_bond_type == 2 ? "selected":""?>>Not Applicable</option>
									  </select>  
									  <input placeholder="Fill bid here" class="form-control col-md-6" id="bid_bond"  name="bid_bond" value="<?=@$ed->bid_bond?>"> 
								  </div>
								  <div class="form-group col-md-6">
									<label for="jobTitle3">Bid Bond Validty:</label>
									<input  class="form-control tgl-aja" id="bid_bond_validity"  name="bid_bond_validity" value="<?=@$ed->bid_bond_validity?>">
								  </div>
								</div>
                            </div>
							
							
                             
                          </div>
                      </fieldset>
                      <!-- Step 3 -->
                      <h6><i class="step-icon fa fa-calendar"></i>Schedule of Price</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">
                             <label style="font-weight: bold;"> List Item </label>
                          </div>
                          <div class="col-md-12">
                            <table class="table table-condensed" style="background: #f9f9f9">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Item</th>
                                  <th>Qty</th>
                                  <th>UOM</th>
                                  <th>Unit Price</th>
                                  <th>Total Value</th>
                                  <th>Curr MSR</th>
                                  <th>Copy</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                  $no = 1;
                                  foreach ($tbmi2->result() as $tmbi) : 
                                ?>
                                  <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $tmbi->description ?></td>
                                    <td><?= $tmbi->qty ?></td>
                                    <td><?= $tmbi->uom ?></td>
                                    <td><?= numIndo($tmbi->priceunit) ?></td>
                                    <td><?= numIndo($tmbi->qty*$tmbi->priceunit) ?></td>
                                    <td><?= $msr->currency ?></td>
                                    <td>
                                      <a href="#" class="btn btn-primary" onclick="copyClick(<?=$tmbi->line_item?>)">Copy</a>
                                    </td>
                                  </tr>
                                <?php endforeach;?>
                              </tbody>
                            </table>
                          </div>
                          <div class="col-md-12" style="margin-top: 10px">
                             <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modalsop" onclick="addSopClick()">Add</a>
                          </div>
                          <div class="col-md-12" style="margin-top: 10px">
                            <div class="table-responsive">
                              <table class="table table-condensed sop_grid">
                                
                              </table>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <h6><i class="step-icon fa fa-btc"></i>Enquiry Document</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12" style="margin-bottom: 10px">
                            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal">Upload</a>
                          </div>
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
                                <tbody id="devbled-attachment">
                                  <?php foreach ($doc as $key => $value) {
                                    echo "<tr>
                                      <td>".biduploadtype($value->tipe, true)."</td>
                                      <td>".$value->file_name."</td>
                                      <td>".$value->created_at."</td>
                                      <td>".user($value->created_by)->NAME."</td>
                                      <td>
                                        <a href='".base_url('userfiles/temp/'.$value->file_path)."' target='_blank' class='btn btn-sm btn-primary'>Download</a>
                                        <a href='#' class='btn btn-sm btn-danger' onclick='hapusFile($value->id)'>Hapus</a>
                                      </td>
                                    </tr>";
                                  }?>
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
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Upload</h4>
              </div>
              <div class="modal-body">
                <form id="form-attachment-bled" method="post" action="<?=base_url('approval/approval/bledupload')?>" class="form-horizontal" enctype="multipart/form-data">
                  <!-- data_id -->
                  <input type="hidden" name="module_kode" value="bled">
                  <input type="hidden" name="data_id" value="<?=$msr_no?>">
                  <!-- m_approval_id -->
                  <div class="form-group">
                    <label>Type</label>
                    <div class="col-sm-12">
                      <select class="form-control" name="tipe" id="tipe">
                        <?php foreach (biduploadtype() as $key => $value) {
                          if($key == 3)
                          {
                            echo "<optgroup label='Exhibit'>";
                          } 
                            echo "<option value='$key'>$value</option>";
                          if($key == 12)
                          {
                            echo "</optgroup>";
                          } 
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>File Name</label>
                    <div class="col-sm-12">
                      <input class="form-control" name="file_name" id="file_name" />
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
                      <button type="button" onclick="devbledAttachmentClick()" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modalsop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Form SOP</h4>
              </div>
              <div class="modal-body">
                <form id="form-sop" method="post" class="form-horizontal" enctype="multipart/form-data">
                  <!-- data_id -->
                  <input type="hidden" name="id" id="id" value="">
                  <input type="hidden" name="msr_no" value="<?=$msr_no?>">
                  <!-- m_approval_id -->
                  <div class="form-group row">
                    <label class="col-sm-3">List Item</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="msr_item_id" id="msr_item_id">
                        <?php 
                          foreach ($tbmi2->result() as $tmbi): 
                        ?>
                        <option value="<?= $tmbi->line_item ?>"><?= $tmbi->description ?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3">Type</label>
                    <div class="col-sm-9">
                      <select class="form-control" name="sop_type" id="sop_type">
                        <option value="1">Mode 1</option>
                        <option value="2">Mode 2</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3">SEMIC No</label>
                    <div class="col-sm-9">
                      <?= form_dropdown('item_material_id',
                      null,
                      set_value('item-material_id'),
                      'class="select2 block form-control" placeholder="Select Semic No" id="item-material_id" style="width: 100%"');
                      ?>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3">Item</label>
                    <div class="col-sm-9">
                      <input name="item" class="form-control" id="item" />
                      <input type="hidden" name="item_semic_no_value" id="item-semic_no_value">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3">QTY 1 / UOM 1</label>
                    <div class="col-sm-3">
                      <input class="form-control" name="qty1" id="qty1" />
                    </div>
                    <div class="col-sm-6">
                      <select class="form-control" id="uom1" name="uom1">
                        <?php
                        $uom = $this->db->get("m_material_uom where STATUS = '1'");
                        foreach ($uom->result() as $value) {
                            ?>
                            <option value="<?php echo $value->MATERIAL_UOM; ?>"><?php echo $value->MATERIAL_UOM; ?> (<?php echo $value->DESCRIPTION; ?>)</option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3">QTY 2 / UOM 2</label>
                    <div class="col-sm-3">
                      <input class="form-control" name="qty2" id="qty2" />
                    </div>
                    <div class="col-sm-6">
                      <select class="form-control" id="uom2" name="uom2">
                        <option value=""></option>
                        <?php
                        $uom = $this->db->get("m_material_uom where STATUS = '1'");
                        foreach ($uom->result() as $value) {
                            ?>
                            <option value="<?php echo $value->MATERIAL_UOM; ?>"><?php echo $value->MATERIAL_UOM; ?> (<?php echo $value->DESCRIPTION; ?>)</option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="button" onclick="sop_add()" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="modal-validation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Validation</h4>
              </div>
              <div class="modal-body">
                <table class="table">
                  <tbody id="result-validation"></tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <?php if(@$approval->role_id == 9): ?>
          <?php if($approval->status == 0): ?>
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal">APPROVE/REJECT</a>
          <?php endif;?>
        <?php endif;?>
        <?php if(@$approval->role_id == 8): ?>
          <?php if($approval->status <> 4): ?>
          <!-- 1 approve, 2 reject, 4 assign -->
          <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal-assign">ASSIGN MSR</a>
          <?php endif;?>
        <?php endif;?>
        <?php if(@$approval->role_id == 27): ?>
          <!-- <a href="#" class="btn btn-success" onclick="developeBlEdClick()">Develope BL & ED</a> -->
        <?php endif;?>
        <a href="#" class="btn btn-success submit-bled" onclick="submitBlEd()">Submit</a>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  	function submitBlEd(argument) {
      /*check BL*/
      /*check ED*/
      var bl_msr_no = $("#bl_msr_no").val();
      var commercial_data = $("#commercial_data").val();
      var currency = $("#currency").val();
      var bid_bond = $("#bid_bond").val();
      var bid_bond_type = $("#bid_bond_type").val();
      var prebiddate = $("#prebiddate").val();
      var prebid_address = $("#prebid_address").val();
      var prebid_loc = $("#prebid_loc").val();
      var closing_date = $("#closing_date").val();
      var bid_validity = $("#bid_validity").val();
      var subject = $("#subject").val();
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
          alert('ED Fail, Bid Bond Must be Filled');return false;
        }
      }
      /*cek*/
      $.ajax({
        type : 'post',
        url  : "<?= base_url('approval/approval/sop_doc_validation/'.$msr_no) ?>",
        data:{subject:subject, prebid_address:prebid_address, prebid_loc:prebid_loc, closing_date:closing_date, bid_validity:bid_validity},
        success : function(e) {
          var r = eval("("+e+")")
          if(r.status)
          {
            $("#result-validation").html(r.html)
            $("#modal-validation").modal('show')
          }
          else
          {
            if(confirm('Are you sure to create Bidder List & Enquiry Document'))
            {
              url = "<?=base_url('approval/approval/submitbled/'.$msr_no.'/'.$idnya)?>";
              $.ajax({
                url:url,
                beforeSend:function(){
                  start($('#icon-tabs'));
                },
                success:function(r){
                  alert(r);
                  stop($('#icon-tabs'));
                  window.open('<?=base_url('home')?>','_self');
                },
                error: function (e) {
                  alert('Fail, Try Again');
                  stop($('#icon-tabs'));
                  $("#myModal").modal('hide');
                }
              });
            } 
          }
        }
      })
  	}

    function saveApprovalClick() {
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
        data:$("#frm").serialize(),
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
        window.open('<?=base_url('approval/approval/devbled')?>','_self');
      }
    }
    $(document).ready(function(){
      $(".select2").select2();
      $.ajax({
        url:"<?=base_url('approval/approval/dtBlSession/'.$msr_no)?>",
        success:function(r){
          $("#dt-bled").html(r);
          $.ajax({
            type: "POST",
            url: "<?=base_url('approval/approval/devbled_submit')?>",
            data: {msr_no:"<?=$msr->msr_no?>"},
            success: function (e) {
              var s = eval("("+e+")");
              if(s.status)
              {
                $(".submit-bled").show();
              }
              else
              {
                $(".submit-bled").hide();
              }
            }
          });
        }
      });
    });
    function addClick() {
      /*check*/
      $.ajax({
        type:'post',
        data:$("#frm-bled").serialize(),
        url : "<?=base_url('approval/approval/checkbl')?>",
        success:function(r){
          var s = eval("("+r+")");
          if(s.status)
          {
            url = "<?=base_url('approval/approval/addbl')?>";
            $.ajax({
              type:'post',
              data:$("#frm-bled").serialize(),
              url:url,
              success:function(r){
                $("#dt-bled").html(r);
                checkSubmit();
              }
            });
          }
          else
          {
            alert(s.msg);
          }
        }
      });
    }
    function saveDraftBl() {
      url = "<?=base_url('approval/approval/savedraftbl')?>";
      var bl_title = $("#bl_title").val();
      var bl_pm = $("#bl_pm").val();
      var bl_msr_no = $("#bl_msr_no").val();
      $.ajax({
        type:'post',
        data:{bl_title:bl_title,bl_pm:bl_pm,bl_msr_no:bl_msr_no},
        url:url,
        beforeSend:function(){
          start($('#icon-tabs'));
        },
        success:function(r){
          stop($('#icon-tabs'));
          alert(r);
          checkSubmit();
        }
      });
    }
    function saveDraftEd() {
      url = "<?=base_url('approval/approval/savedrafted')?>";
      var subject = $("#subject").val();
      /*if(!subject)
      {alert('ED Fail, Subject ED Must be Filled');return false;}*/
      var prebiddate = $("#prebiddate").val();
      /*if(!prebiddate)
      {alert('ED Fail, Pre Bid Date Must be Filled');return false;}*/
      var prebid_address = $("#prebid_address").val();
      /*if(!prebid_address)
      {alert('ED Fail, Pre Bid Address Must be Filled');return false;}*/
      var bl_msr_no = $("#bl_msr_no").val();
      var prebid_loc = $("#prebid_loc").val();
      /*if(!prebid_loc)
      {alert('ED Fail, Pre Bid Location Must be Filled');return false;}*/
      var closing_date = $("#closing_date").val();
      /*if(!closing_date){alert('ED Fail, Closing Date Must be Filled');return false;}*/
      var commercial_data = $("#commercial_data").val();
      var currency = $("#currency").val();
      var bid_validity = $("#bid_validity").val();
      // if(!bid_validity){alert('ED Fail, Bid Validty Must be Filled');return false;}
      var bid_bond = $("#bid_bond").val();
      var bid_bond_type = $("#bid_bond_type").val();
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
          alert('ED Fail, Bid Bond Must be Filled');return false;
        }
      }
      // if(!bid_bond){alert('ED Fail, Bid Bond Must be Filled');return false;}
      var bid_bond_validity = $("#bid_bond_validity").val();
      // if(!bid_bond_validity){alert('ED Fail, Bid Bond Validty Must be Filled');return false;}
      var envelope_system = $("#envelope_system").val();
      var packet = $("#packet").val();
      var incoterm = $("#incoterm").val();
      var delivery_point = $("#delivery_point").val();
      $.ajax({
        type:'post',
        data:{msr_no:bl_msr_no, subject:subject, prebiddate:prebiddate, prebid_address:prebid_address, closing_date:closing_date, commercial_data:commercial_data, currency:currency, bid_validity:bid_validity, bid_bond_type:bid_bond_type, bid_bond:bid_bond, bid_bond_validity:bid_bond_validity, prebid_loc:prebid_loc, packet:packet, envelope_system:envelope_system, incoterm:incoterm, delivery_point:delivery_point},
        url:url,
        beforeSend:function(){
          start($('#icon-tabs'));
        },
        success:function(r){
          stop($('#icon-tabs'));
          alert(r);
          checkSubmit();
        }
      });
    }
    function saveDraft(argument) {
      saveDraftBl();
      saveDraftEd();
    }
    function hapusBlClick(vendorId) {
        url = "<?=base_url('approval/approval/removebl')?>/"+vendorId;
        $.ajax({
          url:url,
          success:function(r){
            $.ajax({
              url:"<?=base_url('approval/approval/dtBlSession/'.$msr_no)?>",
              success:function(r){
                $("#dt-bled").html(r);
                checkSubmit();
              }
            });
          }
        });
      }
      function hapusFile(argument) {
        if(confirm('Are delete this data?'))
        {
          $.ajax({
            url:'<?=base_url('approval/approval/hapusattachmentbled')?>/'+argument,
            beforeSend:function(){
              start($('#icon-tabs'));
            },
            success: function (data) {
              $("#devbled-attachment").html(data);
              stop($('#icon-tabs'));
              checkSubmit();
            },
            error: function (e) {
              alert('Fail, Try Again');
              stop($('#icon-tabs'));
            }
          });
        }
      }
      function devbledAttachmentClick() {
        var form = $("#form-attachment-bled")[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?=base_url('approval/approval/bledupload')?>",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            beforeSend:function(){
              start($('#icon-tabs'));
            },
            success: function (data) {
              $("#devbled-attachment").html(data);
              stop($('#icon-tabs'));
              $("#myModal").modal('hide');
              checkSubmit();
              $("#file_path").val('');
              $("#file_name").val('');
            },
            error: function (e) {
              alert('Fail, Try Again');
              stop($('#icon-tabs'));
              $("#myModal").modal('hide');
            }
        });
      }
      function checkSubmit() {
        $.ajax({
          type: "POST",
          url: "<?=base_url('approval/approval/devbled_submit')?>",
          data: {msr_no:"<?=$msr->msr_no?>"},
          success: function (e) {
            var s = eval("("+e+")");
            if(s.status)
            {
              $(".submit-bled").show();
            }
            else
            {
              $(".submit-bled").hide();
            }
          }
        });
      }
      // checkSubmit();
  </script>
  <script type="text/javascript">
    function prebid_loc_change() {
      var prebid_loc = $("#prebid_loc").val();
      s = $("#prebid_loc_"+prebid_loc).val();
      $("#prebid_address").val(s);
    }
  $(document).ready(function(){
    $.ajax({
      data:{msr_no:"<?= $msr_no ?>"},
      url:"<?= base_url('approval/approval/sop_grid') ?>",
      type:'post',
      success:function(q){
        $(".sop_grid").html(q);
      }
    });
    var prebid_loc = $("#prebid_loc").val();
    s = $("#prebid_loc_"+prebid_loc).val();
    $("#prebid_address").html(s);
    function sop_type() {
      var r = $("#sop_type").val();
      if(r == '1')
      {
        $("#qty2,#uom2").attr("disabled","disabled");
      }
      else
      {
        $("#qty2,#uom2").removeAttr("disabled");
      }
    }
    sop_type();
    $("#sop_type").change(function(){
      sop_type();
    });
  });

  function sop_add() {
    $("#uom1").removeAttr("disabled");
    sop = $("#form-sop").serialize();
    $.ajax({
      beforeSend:function(){
        start($('#icon-tabs'));
      },
      data:sop,
      type:"post",
      url:"<?= base_url('approval/approval/sop_store') ?>",
      success:function(e){
        var r = eval("("+e+")");
        alert(r.msg);
        stop($('#icon-tabs'));
        if(r.status)
        {
          sop_grid();
          $("#modalsop").modal('hide');
        }
        $.ajax({
          type: "POST",
          url: "<?=base_url('approval/approval/devbled_submit')?>",
          data: {msr_no:"<?=$msr->msr_no?>"},
          success: function (e) {
            var s = eval("("+e+")");
            if(s.status)
            {
              $(".submit-bled").show();
            }
            else
            {
              $(".submit-bled").hide();
            }
          }
        });
      },
      error:function(){
        alert('Fail, Try Again');
        stop($('#icon-tabs'));
      }
    });
  }
  function sop_grid(){
    $.ajax({
      data:{msr_no:"<?= $msr_no ?>"},
      type:'post',
      url:"<?= base_url('approval/approval/sop_grid') ?>",
      success:function(q){
        $(".sop_grid").html(q);
      }
    });
  }
  function editSopClick(id) {
    // preventDefault();
    $.ajax({
      data:{id:id},
      type:'post',
      url:"<?= base_url('approval/approval/edit_sop') ?>",
      success:function(q){
        var r = eval("("+q+")");
        $("#id").val(r.id);
        $("#item-semic_no_value").val(r.item_semic_no_value);
        $("#item").val(r.item);
        $("#uom1").val(r.uom1);
        $("#uom2").val(r.uom2);
        $("#qty1").val(r.qty1);
        $("#qty2").val(r.qty2);
        $("#tax").val(r.tax);
        $("#sop_type").val(r.sop_type);
        $("#msr_item_id").val(r.msr_item_id);
        if(r.item_semic_no_value)
        {
          $("#item").attr("readonly","")
          $("#uom1").attr("disabled","")
          /*var data = [{
                      "id": r.item_material_id,
                      "semic_no": r.item_semic_no_value,
                      "name" : r.item,
                    }];
          console.log(data)*/
          $("#item-material_id").empty().append('<option value="'+r.item_material_id+'">'+r.item_semic_no_value+'-'+r.item+'</option>').val(r.item_material_id).trigger('change');
        }
        $("#modalsop").modal('show');
      }
    });
  }
  function addSopClick() {
    $("#id").val(0);
    $("#item").val('');
    $("#item").removeAttr('readonly');
    $("#uom1").val('');
    $("#uom1").removeAttr('disabled');
    $("#uom2").val('');
    $("#qty1").val('');
    $("#qty2").val('');
    $("#tax").val('');
    $("#msr_item_id").val('');
    $("#item-material_id").val(null).trigger('change')
    $("#item-semic_no_value").val(null)
  }
  function deleteSopClick(id) {
    if(confirm('Are you sure?'))
    {
      $.ajax({
        beforeSend:function(){
          start($('#icon-tabs'));
        },
        data:{id:id},
        type:'post',
        url:"<?= base_url('approval/approval/sop_delete') ?>",
        success:function(q){
          sop_grid();
          stop($('#icon-tabs'));
          $.ajax({
            type: "POST",
            url: "<?=base_url('approval/approval/devbled_submit')?>",
            data: {msr_no:"<?=$msr->msr_no?>"},
            success: function (e) {
              var s = eval("("+e+")");
              if(s.status)
              {
                $(".submit-bled").show();
              }
              else
              {
                $(".submit-bled").hide();
              }
            }
          });
        }
      });
    }
  }
  $(document).ready(function(){
    $("#bl_title").keyup(function(){
        $("#subject").val($(this).val());
    });
    $("#subject").keyup(function(){
        $("#bl_title").val($(this).val());
    });
    $('#item-material_id').select2({
      // since select2 version 4, dropdownParent property must be defined to show up at modal
      // @see https://stackoverflow.com/questions/18487056/select2-doesnt-work-when-embedded-in-a-bootstrap-modal/33884094#33884094
      dropdownParent: $("#modalsop"),
      minimumInputLength: 1,
      allowClear: true,
      placeholder :'Please Select',
      escapeMarkup: function(markup) {
        return markup
      },
      ajax: {
        url: "<?php echo base_url() . '/procurement/msr/findItem' ?>",
        dataType: 'json',
        cache: true,
        data: function(params) {
          var query = {
            query: params.term,
            itemtype_category: 'SEMIC'
          }

          return query
        },
        marker: function(marker) {
          return marker;
        },
        processResults: function (data) {
          var items = data.map(function(r) {
            return {
              "id": r.id,
              "text": r.semic_no + ' - ' + r.name,
              "semic_no": r.semic_no,
              "name": r.name
            }
          });

          return {
            results: items
          };
        },
        templateResult: function(row) {
          return "<div class=\"select2-result-repository clearfix\">"
          + "<div class=\"select2-result-repository__title\">"+ row.name +"</div>"
          + "<div class=\"select2-result-repository__description\">"+ row.semic_no +"</div>"
          + "</div>";
        },
        templateSelection: function(row) {
            console.log(row);
            return row.semic_no
        }
      }
    })
    .on('select2:select', function(e,d,c) {
      /*console.log(e,d,c);*/
      var selected_material = $('#item-material_id').select2('data')[0];
      // alert(selected_material.semic_no);
      var material = {
        semic_no: selected_material.semic_no,
        description: selected_material.name
      }

      semic_no_global = material.semic_no
      // console.log(material.semic_no);
      $('#item-semic_no_value').val(material.semic_no);

      $('#item').val(material.description);
      $("#item").attr("readonly","");
      $.get('<?= base_url()."/procurement/msr/findItemAttributes" ?>', {
          material_id : $(this).val(),
          type: 'GOODS',
          itemtype_category: 'SEMIC'
        }, function(data) {
          if (data.group_code) {
            $('#uom1').val(data.uom_name)
            $('#uom1').attr('disabled', true);
          }
        })
        .fail(function(error) {
          alert('Cannot fetch material attributes. Please try again in few moments')
          console.error(error)
        })
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
    }
	});	  

	//hide next and previous button
	$('a[href="#next"]').hide();
	$('a[href="#previous"]').hide(); 
	
	
  })
  $("#item-material_id").on("select2:unselect", function() { 
    $("#item-material_id").val(null).trigger('change')
    $("#item-semic_no_value").val(null)
    $("#item").val(null)
    $("#item").removeAttr('readonly')
    $("#uom1").removeAttr('disabled')
  });
  function copyClick(id) {
    $.ajax({
      beforeSend:function(){
        start($('#icon-tabs'));
      },
      data:{id:id,msr_no:"<?=$msr->msr_no?>"},
      type:"post",
      url:"<?= base_url('approval/approval/sop_copy') ?>",
      success:function(e){
        var r = eval("("+e+")");
        alert(r.msg);
        stop($('#icon-tabs'));
        if(r.status)
        {
          sop_grid();
          $("#modalsop").modal('hide');
        }
        $.ajax({
          type: "POST",
          url: "<?=base_url('approval/approval/devbled_submit')?>",
          data: {msr_no:"<?=$msr->msr_no?>"},
          success: function (e) {
            var s = eval("("+e+")");
            if(s.status)
            {
              $(".submit-bled").show();
            }
            else
            {
              $(".submit-bled").hide();
            }
          }
        });
      },
      error:function(){
        alert('Fail, Try Again');
        stop($('#icon-tabs'));
      }
    });
  }
  jQuery(function ($) {
    $("#bl_vendor").select2({
        placeholder: 'select',
        allowClear: true
    }).on('select2-open', function () {
        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
    });
  })
  function bid_bond_type_change() {
    if($("#bid_bond_type").val() == '2')
    {
      $("#bid_bond").attr('readonly','');
      $("#bid_bond").val(null);
    }
    else
    {
      $("#bid_bond").removeAttr('disabled');
    }
  }
</script>