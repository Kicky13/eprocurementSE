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
          <h3 class="content-header-title mb-0">ADDENDUM TO ED</h3>
        </div>
      </div>
      <div class="row info-header">
    <div class="col-md-4">
      <table class="table table-condensed">
            <tr>
                <td style="width: 105px;">Company</td>
                <td class="no-padding-lr">:</td>
                <td><?=$msr->company_name?></td>
            </tr>
            <tr>
                <td style="width: 105px;">Department</td>
                <td class="no-padding-lr">:</td>
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
                <td style="width: 105px;">MSR Number</td>
                <td class="no-padding-lr">:</td>
                <td><?=$msr_no?></td>
            </tr>
            <tr>
              <td style="width: 105px;">MSR Value</td>
              <td class="no-padding-lr">:</td>
              <td><?=$msr->currency?> <?=numIndo($msr->total_amount)?> (<small style="color:red"><i>Exclude VAT</i></small>)</td>
            </tr>
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
                  <div class="card-body">
                    <form action="#" class="wizard-circle frm-bled" id="frm-bled">
                      <!-- data_id -->
                      <input type="hidden" name="bl_msr_no" id="bl_msr_no" value="<?=$msr->msr_no?>">
                      <!-- Step 1 -->
                      <h6><i class="step-icon fa fa-pencil"></i> Addendum</h6>
                      <fieldset>
                        <div class="form-group">
                          <label>Addendum No</label>
                          <input type="text" name="no_addendum" id="no_addendum" class="form-control">
                        </div>
                        <div class="form-group">
                          <textarea name="resume" id="resume" class="form-control" placeholder="Resume" style="height: 300px;"></textarea>
                        </div>
                        <h4>Log Resume</h4>
                        <hr>
                        <?php foreach ($addendum as $row) { ?>
                          <div>
                            <p><i>#<?= $row->no_addendum ?></i><br><small><span class="fa fa-user"></span> <?= $row->creator ?> | <span class="fa fa-clock-o"></span> <?= dateToIndo($row->created_at, false, true) ?></small></p>
                            <p><?= nl2br($row->resume) ?></p>
                          </div>
                          <hr>
                        <?php } ?>
                      </fieldset>
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
                              <?=optMethod('bl_pm', $pmethod, 'disabled')?>
                            </div>
                          </div>
              <div class="col-md-4">
                            <div class="form-group vendor-select">
                              <label for="date2" style="display:block;">Supplier :</label>
                              <select class="form-control" id="bl_vendor" name="bl_vendor" disabled style="width:100%;">
                                <option value="">Please Select</option>
                              <?php foreach ($this->db->where('LENGTH(no_slka)',4)->order_by('nama','asc')->get('m_vendor')->result() as $v) : ?>
                                <option value="<?=$v->ID?>"><?=$v->NAMA?></option>
                              <?php endforeach;?>
                </select>
                            </div>
                          </div>
              <div class="col-md-2" style="text-align: center;padding: 15px;">
                            <div class="form-group">
                <a href="javascript:void(0)" class="btn btn-primary btn-md disabled" role="button" onclick="addClick()">Add</a>
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
                                    <th rowspan="2">Action</th>
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
                              <input  class="form-control" id="prebiddate" name="prebiddate" value="<?= dateToInput(@$ed->prebiddate, 'Y-m-d H:i') ?>">
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
                              <div class="form-group col-md-6">
                              <label for="emailAddress4">Closing Date :</label>
                              <input class="form-control" id="closing_date" name="closing_date" value="<?=@$ed->closing_date?>">
                              </div>
                              <div class="form-group col-md-6">
                              <label for="emailAddress4">Pre Bid Address :</label>
                              <textarea class="form-control" id="prebid_address" name="prebid_address"><?= @$ed->prebid_address ?></textarea>
                              </div>
                              <div class="form-group col-md-6">
                              <label for="jobTitle3">Bid Validty :</label>
                              <input  class="form-control" id="bid_validity" name="bid_validity" id="bid_validity" value="<?=@$ed->bid_validity?>">
                              </div>
                            </div>
                          </div>
                          <!-- right side -->
                          <div class="col-md-6">
                            <div class="row">
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
                              <div class="col-md-6"></div>
                              <div class="form-group col-md-6">
                                <label class="jobTitle3">Bid Bond :</label>
                                <select class="form-control" name="bid_bond_type" id="bid_bond_type" style="margin-bottom: 10px;" onchange="bid_bond_type_change()">
                                  <option value="3" <?=@$ed->bid_bond_type == 3 ? "selected":""?>>Value</option>
                                  <option value="1" <?=@$ed->bid_bond_type == 1 ? "selected":""?>>%</option>
                                  <option value="2" <?=@$ed->bid_bond_type == 2 ? "selected":""?>>Not Applicable</option>
                                </select>
                              </div>
                              <div class="col-md-6">
                                <label class="jobTitle3">&nbsp;</label>
                                <input placeholder="Fill bid here" class="form-control" id="bid_bond"  name="bid_bond" value="<?=@$ed->bid_bond?>">
                              </div>
                              <div class="form-group col-md-6">
                                <label for="jobTitle3">Bid Bond Validty:</label>
                                <input  class="form-control" id="bid_bond_validity"  name="bid_bond_validity" value="<?=@$ed->bid_bond_validity?>">
                              </div>
                              <div class="form-group col-md-6">
                                <label for="jobTitle3">Evalution Method :</label>
                                <?=optEd('mix', 'commercial_data', @$ed->commercial_data)?>
                              </div>
                              <div class="form-group col-md-6">
                                <label for="emailAddress4">Envelope System :</label>
                                <select class="form-control" name="envelope_system" id="envelope_system">
                                  <option value="1" <?=@$ed->envelope_system == 1 ? "selected":"" ?> >1 Envelope</option>
                                  <option value="2" <?=@$ed->envelope_system == 2 ? "selected":"" ?> >2 Envelope</option>
                                </select>
                              </div>
                              <div class="form-group col-md-6">
                                <label for="packet">Itemize/Packet</label>
                                <select class="form-control" name="packet" id="packet">
                                  <option value="1" <?=@$ed->packet == 1 ? "selected":"" ?> >Itemize</option>
                                  <option value="2" <?=@$ed->packet == 2 ? "selected":"" ?> >Packet</option>
                                </select>
                              </div>
                              <?php if($msr->id_msr_type == 'MSR01'): ?>
                              <div class="form-group col-md-6">
                                <label for="incoterm">Incoterm</label>
                                <?php $inco = @$ed ? @$ed->incoterm : $msr->id_deliveryterm; ?>
                                <?= optIncoterm('incoterm', $inco) ?>
                              </div>
                              <div class="form-group col-md-6">
                                <label for="delivery_point">Delivery Point</label>
                                <?php
                                  $dp = @$ed ? @$ed->delivery_point : $msr->id_dpoint;
                                  echo optDpoint('delivery_point', $dp);
                                ?>
                              </div>
                              <?php else:?>
                                <input type="hidden" name="incoterm" id="incoterm" value="<?=@$ed->incoterm?>">
                                <input type="hidden" name="delivery_point" id="delivery_point"  value="<?=@$ed->delivery_point?>">
                              <?php endif;?>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 3 -->
                      <h6><i class="step-icon fa fa-calendar"></i>Schedule of Price</h6>
                      <fieldset>
                        <div class="form-group">
                          <button type="button" id="btn-unlock-sop" class="btn btn-danger" onclick="unlock_sop()"><i class="fa fa-lock"></i> Unlock SOP</button>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                             <label style="font-weight: bold;">MSR List Item </label>
                          </div>
                          <div class="col-md-12">
                            <table class="table table-condensed" style="background: #f9f9f9">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Item</th>
                                  <th class="text-center">Qty</th>
                                  <th class="text-center">UOM</th>
                                  <th class="text-right">Unit Price</th>
                                  <th class="text-right">Total Value</th>
                                  <th class="text-center">Curr MSR</th>
                                  <th class="text-right">Action</th>
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
                                    <td class="text-center"><?= $tmbi->qty ?></td>
                                    <td class="text-center"><?= $tmbi->uom ?></td>
                                    <td class="text-right"><?= numIndo($tmbi->priceunit) ?></td>
                                    <td class="text-right"><?= numIndo($tmbi->qty*$tmbi->priceunit) ?></td>
                                    <td class="text-center"><?= $msr->currency ?></td>
                                    <td class="text-right">
                                      <a href="#" class="btn btn-primary btn-sm" onclick="copyClick(<?=$tmbi->line_item?>)">Adopt</a>
                                    </td>
                                  </tr>
                                <?php endforeach;?>
                              </tbody>
                            </table>
                          </div>
                          <div class="col-md-12" style="margin-top: 10px">
                             <a href="#" class="btn btn-primary" onclick="addSopClick()">Add</a>
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
                                        <a href='#' class='btn btn-sm btn-danger disabled' onclick='hapusFile($value->id)'>Delete</a>
                                      </td>
                                    </tr>";
                                  }?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <?php
                        $cekApprovalReject = $this->db->select('t_approval.*')
                        ->join('m_approval','t_approval.m_approval_id = m_approval.id')
                        ->where('t_approval.status', 2)
                        ->get('t_approval');
                        if($cekApprovalReject->num_rows() > 0):
                      ?>
                      <h6><i class="step-icon icon-directions"></i>Approval</h6>
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
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody id="result-approval">
                              <?php
                                $listApprovalEd = $this->approval_lib->listApprovalEd($msr_no);
                                $no = 1;
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
                                  </tr>";
                                  $no++;
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </fieldset>
                      <?php endif;?>
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
                      <button type="button" onclick="devbledAttachmentClick()" class="btn btn-primary">Upload</button>
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
                  <div class="row form-group">
                    <div class="col-sm-12">
                      <label>Select Procurement List</label>
                      <?php foreach ($this->db->like('ROLES',28)->get('m_user')->result() as $r) : ?>
                      <div class="row" style="margin-top: 10px">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-7">
                          <?=$r->NAME?>
                        </div>
                        <div class="col-sm-1">
                          <input type="radio" name="user_id" value="<?=$r->ID_USER?>">
                        </div>
                        <div class="col-sm-2">
                          <button style="width: 100%" class="btn btn-sm btn-danger"> <?= $this->approval_lib->getAssignmentAgreement($r->ID_USER) ?> </button>
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
        <div class="modal fade" id="modalsop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-lg modal-form" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Form SOP</h4>
              </div>
              <form id="form-sop" method="post" class="form-horizontal" enctype="multipart/form-data">
              <!-- data_id -->
              <div id="sub_acc_placer" style="display: none;"></div>
              <input type="hidden" name="id" id="id" value="">
              <input type="hidden" name="msr_no" value="<?=$msr_no?>">
              <div class="modal-body row">
                  <!-- m_approval_id -->
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <label class="col-form-label col-sm-3">List Item</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="msr_item_id" id="msr_item_id" required>
                          <option value="">Please Select</option>
                          <?php
                            foreach ($tbmi2->result() as $tmbi):
                          ?>
                          <option value="<?= $tmbi->line_item ?>"><?= $tmbi->description ?></option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-sm-3">Item Type</label>
                      <div class="col-sm-9">
                        <?= form_dropdown('item-item_type',
                        $opt_itemtype,
                        set_value('item-item_type'),
                        'class="form-control custom-select" placeholder="Select Item Type" id="item-item_type" required');
                        ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-sm-3">Category</label>
                      <div class="col-sm-9">
                        <?= form_dropdown('item-itemtype_category',
                        array(),
                        set_value('item-itemtype_category'),
                        'class="form-control custom-select" placeholder="Select Category" id="item-itemtype_category" required');
                        ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-sm-3" id="semic_title">SEMIC No</label>
                      <div class="col-sm-9">
                        <?= form_dropdown('item-material_id',
                        null,
                        set_value('item-material_id'),
                        'class="select2 block form-control" placeholder="Select Semic No" id="item-material_id" style="width: 100%" required');
                        ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-sm-3">Unit Description</label>
                      <div class="col-sm-9">
                        <input name="item" class="form-control" id="item" required/>
                        <input type="hidden" name="item-semic_no_value" id="item-semic_no_value">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-sm-3">Classification</label>
                      <div class="col-sm-9">
                        <input type="text" readonly="readonly" id="item-group" class="form-control-plaintext" style="width:100%">
                        <input type="hidden" name="item-group_value" id="item-group_value">
                        <input type="hidden" name="item-group_name" id="item-group_name">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-sm-3">Group / Category</label>
                      <div class="col-sm-9">
                        <input type="text" readonly="readonly" id="item-subgroup" class="form-control-plaintext" style="width:100%">
                        <input type="hidden" name="item-subgroup_value" id="item-subgroup_value">
                        <input type="hidden" name="item-subgroup_name" id="item-subgroup_name">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group row" id="item-inv_thinker">
                      <label class="col-form-label col-sm-3">Inventory Type</label>
                      <div class="col-sm-9">
                        <?= form_dropdown('item-inventory_type',
                        $opt_invtype,
                        set_value('item-inventory_type'),
                        'class="form-control custom-select" id="item-inventory_type" placeholder="Select Account Subsidiary" required')
                        ?>
                      </div>
                    </div>
                    <div class="form-group row" id="item-mod_thinker" style="display: none;">
                      <label class="col-form-label col-sm-3">Item Modification</label>
                      <div class="col-sm-9">
                        <div class="form-check">
                        <input type="checkbox" class="form-check-input position-static" name="item-item_modification" id="item-item_modification" value="1">
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-sm-3">Qty Type</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="sop_type" id="sop_type">
                          <option value="1">Type 1</option>
                          <option value="2">Type 2</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-sm-3">Qty 1/UoM 1</label>
                      <div class="col-sm-3">
                        <input class="form-control" name="qty1" id="qty1" required/>
                      </div>
                      <div class="col-sm-6">
                        <select class="form-control" id="uom1" name="uom1" required>
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
                      <label class="col-form-label col-sm-3">Qty 2/UoM 2</label>
                      <div class="col-sm-3">
                        <input class="form-control" name="qty2" id="qty2"/>
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
                    <div class="form-group row">
                      <label class="col-form-label col-sm-3">Cost Center</label>
                      <div class="col-sm-9">
                        <?= form_dropdown('item-cost_center',
                        $opt_costcenter,
                        set_value('item-cost_center'),
                        'class="form-control custom-select" id="item-cost_center" placeholder="Select Cost Center" required')
                        ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-form-label col-sm-3">Account Subsidiary</label>
                      <div class="col-sm-9">
                        <?= form_dropdown('item-account_subsidiary',
                        $opt_accountsub,
                        set_value('item-account_subsidiary'),
                        'class="form-control custom-select" id="item-account_subsidiary" placeholder="Select Account Subsidiary" required')
                        ?>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Process</button>
              </div>
              </form>
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
        <div class="form-group text-right">
          <a href="javascript:void(0)" class="btn btn-primary" onclick="saveAddendum()">Submit</a>
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
  <script type="text/javascript">
    var itemTypeCategoryByParent = JSON.parse('<?= @json_encode($opt_itemtype_category_by_parent, JSON_HEX_QUOT | JSON_HEX_APOS) ?>');
    var itemTypeCategory = JSON.parse('<?= @json_encode($opt_itemtype_category, JSON_HEX_QUOT | JSON_HEX_APOS) ?>');
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
          $('#dt-bled .btn').addClass('disabled');
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
            swal('Done', 'Data is successfully added', 'success');
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
    function saveDraft() {
      /*inisialisasi data ED*/
      var subject = $("#subject").val();
      var prebiddate = $("#prebiddate").val();
      var prebid_address = $("#prebid_address").val();
      var bl_msr_no = $("#bl_msr_no").val();
      var prebid_loc = $("#prebid_loc").val();
      var closing_date = $("#closing_date").val();
      var commercial_data = $("#commercial_data").val();
      var currency = $("#currency").val();
      var bid_validity = $("#bid_validity").val();
      var bid_bond = $("#bid_bond").val();
      var bid_bond_type = $("#bid_bond_type").val();
      var bid_bond_validity = $("#bid_bond_validity").val();
      var envelope_system = $("#envelope_system").val();
      var packet = $("#packet").val();
      var incoterm = $("#incoterm").val();
      var delivery_point = $("#delivery_point").val();
      /*inisialisasi data BL*/
      var bl_title = $("#bl_title").val();
      var bl_pm = $("#bl_pm").val();
      /*url = "<?=base_url('approval/approval/savedraftbl')?>";

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
      });*/
      $.ajax({
        type:'post',
        url : "<?=base_url('approval/ed/savedraft')?>",
        data : {
          msr_no            :bl_msr_no,
          subject           :subject,
          prebiddate        :prebiddate,
          prebid_address    :prebid_address,
          closing_date      :closing_date,
          commercial_data   :commercial_data,
          currency          :currency,
          bid_validity      :bid_validity,
          bid_bond_type     :bid_bond_type,
          bid_bond          :bid_bond,
          bid_bond_validity :bid_bond_validity,
          prebid_loc        :prebid_loc,
          packet            :packet,
          envelope_system   :envelope_system,
          incoterm          :incoterm,
          delivery_point    :delivery_point,
          bl_pm             :bl_pm
        },
        beforeSend:function(){
          start($('#icon-tabs'));
        },
        success:function(r){
          var s = eval("("+r+")");
          stop($('#icon-tabs'));
          alert(s.msg);
        },
        error:function(){
          alert('Fail, Please Try Again')
          stop($('#icon-tabs'))
        }
      })
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
      swalConfirm('Addendum', 'Are you sure to proceed ?', function() {
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
            swal('Ooopss', 'Fail, Try Again', 'warning');
            stop($('#icon-tabs'));
          }
        });
      });
    }
    function submitBlEd() {
      if(confirm('Are you sure to create Bidder List & Enquiry Document'))
      {
        url = "<?=base_url('approval/ed/submitbled/'.$msr_no.'/'.$idnya)?>";
        $.ajax({
          type:'post',
          url:url,
          data:$("#frm-bled").serialize(),
          beforeSend:function(){
            start($('#icon-tabs'));
          },
          success:function(e){
            var r = eval("("+e+")")
            if(r.status)
            {
              $("#result-validation").html(r.html)
              $("#modal-validation").modal('show')
            }
            else
            {
              alert(r.msg)
              window.open('<?=base_url('home')?>','_self')
            }
            stop($('#icon-tabs'));
          },
          error: function () {
            alert('Fail, Try Again');
            stop($('#icon-tabs'));
            // $("#myModal").modal('hide');
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
      //$("#prebid_address").html(s);
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

      $("#msr_item_id").change(function(){
        obj = {};
        obj.id = $("#msr_item_id").val();
        $.ajax({
            data: obj,
            type: "post",
            url: "<?= base_url('approval/approval/get_item_costcenter') ?>",
            success: function(r) {
              r = JSON.parse(r);
              $("#item-cost_center").val(r.id_costcenter).change();
            },
            error: function() {
              alert('Oops, something went wrong!');
              stop($('#icon-tabs'));
            }
        });
      });

      $("#form-sop").submit(function(e) {
        e.preventDefault();
        check = true;

        if (!$('#uom2').prop('disabled')) {
          if ($('#uom2').val() == '') {
            $('#qty2').val(0);
          } else if ($('#qty2').val() <= 0) {
            check = false;
          }
        }

        $("#uom1").prop("disabled", false);
        $("#item-cost_center").prop("disabled", false);
        sop = $("#form-sop").serializeArray();

        if ($("#item-itemtype_category").val() == 'SEMIC')
          $("#uom1").prop("disabled", true);

        if ($('#item-cost_center').val()) {
          choice = $('#item-cost_center option:selected').text();
          choice = choice.split(' - ');
          choice.shift();
          sop.push({name: 'item-cost_center_name', value: choice.join(' - ')});
        }
        $("#item-cost_center").prop("disabled", true);

        if ($('#item-account_subsidiary').val()) {
          choice = $('#item-account_subsidiary option:selected').text();
          choice = choice.split(' - ');
          choice.shift();
          sop.push({name: 'item-account_subsidiary_name', value: choice.join(' - ')});
        }

        // if (check) {
        //   for (var i = 0; i < sop.length; i++) {
        //     if (sop[i].name != 'id' && sop[i].name != 'qty2' && sop[i].name != 'uom2' && sop[i].name != 'uom2' && (sop[i].value == '' || sop[i].value <= 0)) {
        //       check = false;
        //       break;
        //     }
        //   }
        // }

        if (check) {
          $.ajax({
            beforeSend:function(){
              start($('#icon-tabs'));
            },
            data: sop,
            type: "post",
            url: "<?= base_url('approval/approval/sop_store') ?>",
            success: function(e) {
              var r = eval("("+e+")");
              // alert(r.msg);
              // swal('Done',r.msg,'success')
              stop($('#icon-tabs'));
              if (r.status) {
                sop_grid();
                $("#modalsop").modal('hide');
              }
              $.ajax({
                type: "POST",
                url: "<?=base_url('approval/approval/devbled_submit')?>",
                data: {msr_no:"<?=$msr->msr_no?>"},
                success: function (e) {
                  var s = eval("("+e+")");
                  if(s.status) {
                    $(".submit-bled").show();
                  } else {
                    $(".submit-bled").hide();
                  }
                }
              });
            },
            error: function() {
              swal('Ooopss','Something went wrong!','warning')
              stop($('#icon-tabs'));
            }
          });
        } else {
          swal('Ooopss','There are empty input!','warning')
        }
      });
    });

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
      if (sop_lock_alert()) {
        return false;
      }
      // preventDefault();
      $.ajax({
        data:{id:id},
        type:'post',
        url:"<?= base_url('approval/approval/edit_sop') ?>",
        success:function(q){
          var r = eval("("+q+")");
          $("#id").val(r.id);
          $("#msr_item_id").val(r.msr_item_id).change();
          $("#item-semic_no_value").val(r.item_semic_no_value);
          $("#item-item_type").val(r.id_itemtype).change();
          $("#item-itemtype_category").val(r.id_itemtype_category).change();

          $("#item-material_id").empty();
          var option = document.createElement('option');
          option.value = r.item_material_id;
          if (r.id_itemtype_category == 'SEMIC')
            option.text = r.item_semic_no_value + ' - ' + r.item;
          else
            option.text = r.item_semic_no_value + ' - ' + r.sub_groupcat_desc;
          $("#item-material_id").append(option);
          $("#item-material_id").val(r.item_material_id);
          $('#item-group').val(r.groupcat + '. ' + r.groupcat_desc);
          $('#item-group_value').val(r.groupcat);
          $('#item-group_name').val(r.groupcat_desc);
          $('#item-subgroup').val(r.sub_groupcat + '. ' + r.sub_groupcat_desc);
          $('#item-subgroup_value').val(r.sub_groupcat);
          $('#item-subgroup_name').val(r.sub_groupcat_desc);

          if (r.item_modification == 1)
            $("#item-item_modification").prop('checked', true);
          else
            $("#item-item_modification").prop('checked', false);

          $("#item-inventory_type").val(r.inv_type).change();
          $("#item").val(r.item);
          $("#qty1").val(r.qty1);
          $("#uom1").val(r.uom1);
          $("#sop_type").val(r.sop_type).change();
          if (r.sop_type == 1) {
            $("#qty2").val('');
            $("#uom2").val('');
          } else {
            $("#qty2").val(r.qty2);
            $("#uom2").val(r.uom2);
          }
          $("#tax").val(r.tax);
          $("#sub_acc_placer").html(r.id_accsub);
          // $("#item-cost_center").val(r.id_costcenter).change();
          $("#item-cost_center").prop('disabled', true);
          $("#modalsop").modal('show');
        }
      });
    }
    function addSopClick() {
      if (sop_lock_alert()) {
        return false;
      }
      $("#msr_item_id").val('').change();
      $("#id").val(0);
      $("#item").val('');
      $("#item").removeAttr('readonly');
      $("#uom1").val('');
      $("#uom1").removeAttr('disabled');
      $("#uom2").val('');
      $("#qty1").val('');
      $("#qty2").val('');
      $("#tax").val('');
      $("#item-material_id").empty();
      $("#sub_acc_placer").html('');
      $("#item-item_type").val('').trigger('change');
      $("#item-cost_center").val('').trigger('change');
      $("#item-cost_center").prop('disabled', true);
      $('#modalsop').modal('show');
    }
    function deleteSopClick(id) {
      if (sop_lock_alert()) {
        return false;
      }
      swalConfirm('Addendum', 'Are you sure to proceed ?', function() {
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
      });
    }
    $(document).ready(function(){
      $("#bl_title").keyup(function(){
          $("#subject").val($(this).val());
      });
      $("#subject").keyup(function(){
          $("#bl_title").val($(this).val());
      $('#msr_title').html($(this).val());
      });
      $("#subject").keyup();


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
              type: $('#item-item_type').val(),
              itemtype_category: $('#item-itemtype_category').val(),
              id_company:"<?=$msr->id_company?>"
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

        $.get('<?= base_url()."/procurement/msr/findItemAttributes" ?>', {
            material_id : $(this).val(),
            type: $('#item-item_type').val(),
            itemtype_category: $('#item-itemtype_category').val()
          }, function(data) {
            if (data.group_code) {
              $('#item-group').val(data.group_code + '. ' + data.group_name);
              $('#item-group_value').val(data.group_code);
              $('#item-group_name').val(data.group_name);
              $('#item-subgroup').val(data.subgroup_code + '. ' + data.subgroup_name);
              $('#item-subgroup_value').val(data.subgroup_code);
              $('#item-subgroup_name').val(data.subgroup_name);
              if ($('#item-itemtype_category').val() == 'SEMIC') {
                $('#item').val(material.description);
                $('#uom1').val(data.uom_name);
              }
            }
          })
          .fail(function(error) {
            swal('Ooopss', 'Cannot fetch material attributes. Please try again in few moments', 'warning')
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
      },
      onStepChanged: function (event, currentIndex, priorIndex) {

      }
    });
  //hide next and previous button
  $('a[href="#next"]').hide();
  $('a[href="#previous"]').hide();
  });

  $("#item-material_id").on("select2:unselect", function() {
    $("#item-material_id").val(null).trigger('change')
    $("#item-semic_no_value").val(null)
    $("#item").val(null)
    $("#item").removeAttr('readonly')
    $("#uom1").removeAttr('disabled')
  });
  function copyClick(id) {
    if (sop_lock_alert()) {
      return false;
    }
    $.ajax({
      beforeSend:function(){
        start($('#icon-tabs'));
      },
      data:{id:id,msr_no:"<?=$msr->msr_no?>"},
      type:"post",
      url:"<?= base_url('approval/approval/sop_copy') ?>",
      success:function(e){
        var r = eval("("+e+")");
        swal('Done', 'Data is successfully adopted', 'success');
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
        swal('Ooopss', 'Fail, Try Again', 'warning');
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
      $("#bid_bond_validity").attr('readonly','');
      $("#bid_bond_validity").removeAttr('readonly');
    }
  }

  $(function() {
    $('#closing_date').datetimepicker({
      format:'YYYY-MM-DD HH:mm',
    });
  });


  function load_account_subsidiary(sub_acc_val) {
    var company_id = "<?= $msr->id_company; ?>";
    var costcenter_id = $('#item-cost_center').val();

    $('#item-account_subsidiary').html('')

    $.get('<?= base_url('procurement/msr/getAccountSubsidiaries') ?>', {
        company_id : company_id,
        costcenter_id: costcenter_id
    })
    .done(function(data) {
      if (data.length > 0) {
        var option = document.createElement('option');
        option.value = '';
        option.text = 'Please select';
        $('#item-account_subsidiary').append(option);

        data.map(function(v, k) {
          var option = document.createElement('option');
          option.value = v.id_account_subsidiary;
          option.text = v.id_account_subsidiary + ' - ' + v.account_subsidiary_desc;
          $('#item-account_subsidiary').append(option)
        });

        $('#item-account_subsidiary').val(sub_acc_val).change();
      } else {
        var option = document.createElement('option');
        option.value = '';
        option.text = 'No subsidiary';
        $('#item-account_subsidiary').append(option);
      }
    })
    .fail(function(data) {
      swal('Ooopss', 'Failed fetching account subsidiaries', 'warning')
    })
  }

  $('#item-item_type').change(function() {
    var itemtype = $('#item-item_type').val()
    //console.log("should fetch data")
    // 0. clear semic_no data

    // MSR - Tambah Inputan inventory type
    $("#item-inventory_type").val("");
    $("#item-account_subsidiary").val("");
    $('#item-inventory_type').val('').trigger('change');
    $("#item-inventory_type").prop("disabled", true);
    $("#item-item_modification").prop("disabled", true);
    // MSR - Tambah Inputan inventory type

    $("#item-itemtype_category").empty();
    $("#item-itemtype_category").append(new Option('Please select', ''))
    $.each(itemTypeCategoryByParent[itemtype], function(id, text) {
      $('#item-itemtype_category').append(new Option(text, id));
    })

    // 1. clear description, qty_oh, qty_ordered, classification, group value
    $('#item-description_of_unit').val('');
    $('#item').val('');
    $('#qty1').val('');
    $('#uom1').val('');
    $('#item-group').val('');
    $('#item-subgroup').val('');
    $('#uom1').prop('disabled', true);
    $('#item').prop('readonly', true);

    $('#item-material_id').select2('data', null);
    $('#item-material_id').val('').trigger('change');
    $('#item-material_id').prop("disabled", true);

    if (itemtype == 'GOODS') {
      $("#item-inv_thinker").show();
      $("#item-mod_thinker").hide();
    } else if (itemtype == 'SERVICE') {
      $("#item-inv_thinker").hide();
      $("#item-mod_thinker").show();
    }
  });

  $('#item-itemtype_category').change(function(e) {
    var itemtype = $('#item-item_type').val()
    var itemtype_category = $(this).val()

    // MSR - Tambah Inputan inventory type
    $("#item-inventory_type").val("");
    $("#item-account_subsidiary").val("");
    // MSR - Tambah Inputan inventory type

    $('#item-description_of_unit').val('');
    $('#item').val('');
    $('#qty1').val('');
    $('#uom1').val('');
    $('#item-group').val('');
    $('#item-subgroup').val('');
    $('#uom1').prop('disabled', true);
    $('#item-inventory_type').val('').trigger('change');
    $("#item-inventory_type").prop("disabled", true);
    $('#item').prop('readonly', true);
    $('#item-material_id').select2('data', null);
    $('#item-material_id').val('').trigger('change');
    $('#item-material_id').prop("disabled", true);

    switch (itemtype_category.toUpperCase()) {
      case 'MATGROUP':
        $('#semic_title').html('Material Group');
        break
      case 'CONSULTATION':
        $('#semic_title').html('Consultation Category');
        break
      case 'WORKS':
        $('#semic_title').html('Works Category');
        break
      case 'SEMIC':
      default:
        $('#semic_title').html('Semic No');
        break
    }

    if (itemtype == 'GOODS') {
      if (itemtype_category == 'SEMIC') {
        $("#item-inventory_type").prop("disabled", false);
        $('#item-material_id').prop("disabled", false);
      } else if (itemtype_category != '') {
        $('#item-material_id').prop("disabled", false);
        $('#uom1').prop('disabled', false);
        $('#item').prop('readonly', false);
      }
    } else if (itemtype != '') {
        $("#item-item_modification").prop("disabled", false);
        $('#item-material_id').prop("disabled", false);
        $('#uom1').prop('disabled', false);
        $('#item').prop('readonly', false);
    }
  });

  $('#item-inventory_type').change(function() {
    if ($(this).val() == 1) {
      // $('#item-cost_center').prop('disabled', true);
      $('#item-account_subsidiary').prop('disabled', true);
    } else {
      // $('#item-cost_center').prop('disabled', false);
      $('#item-account_subsidiary').prop('disabled', false);
    }
  });

  $('#item-cost_center').change(function(e) {
    sub_placer = $('#sub_acc_placer').html();
    $('#sub_acc_placer').html('');
    load_account_subsidiary(sub_placer);
  });

  $(function() {
    $('#prebiddate').datetimepicker({
      format:'YYYY-MM-DD HH:mm'
      //maxDate : ($('#closing_date').val() != '') ? $('#closing_date').val() : new Date()
    });
    $('#bid_validity').datetimepicker({
      format:'YYYY-MM-DD'
      //minDate : ($('#closing_date').val() != '') ? $('#closing_date').val()) : new Date()
    });
    $('#bid_bond_validity').datetimepicker({
      format:'YYYY-MM-DD'
      //minDate : ($('#closing_date').val() != '') ? $('#closing_date').val() : new Date()
    });
    /*$('#closing_date').on('dp.change', function() {
      $('#prebiddate').data("DateTimePicker").maxDate($('#closing_date').val());
      $('#bid_validity').data("DateTimePicker").minDate($('#closing_date').val());
      $('#bid_bond_validity').data("DateTimePicker").minDate($('#closing_date').val());
    });*/
    if ($('#prebid_loc').val() == 0) {
      $("#prebiddate,#prebid_address").prop('readonly', true);
    } else {
      $("#prebiddate,#prebid_address").prop('readonly', false);
    }

    if ($('#bid_bond_type').val() == 3) {
      $('#bid_bond').prop('readonly', false);
      $('#bid_bond_validity').prop('disabled', false);
      $('#bid_bond').number(true, 2, bahasa.thousand_separator, bahasa.decimal_separator);
    } else {
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
    }

    $('#bid_bond_type').change(function() {
      if ($('#bid_bond_type').val() == 3) {
        $('#bid_bond').prop('readonly', false);
        $('#bid_bond_validity').prop('disabled', false);
        $('#bid_bond').val('');
        $('#bid_bond').number(true, 2, bahasa.thousand_separator, bahasa.decimal_separator);
      } else {
        $('#bid_bond').replaceWith('<input placeholder="Fill bid here" class="form-control" id="bid_bond"  name="bid_bond">');
        if ($('#bid_bond_type').val() == 1) {
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
          $('#bid_bond_validity').prop('disabled', false);
        } else {
          $('#bid_bond').prop('readonly', true);
          $('#bid_bond_validity').prop('disabled', true);
        }
      }
    });

  });

var sop_lock_status = true;

function sop_lock_alert() {
    if (sop_lock_status) {
        swal('Ooopss', 'You have to click unlock SOP to modify!', 'warning');
        return true;
    } else {
        return false;
    }
}

function unlock_sop() {
    swalConfirm('Addendum', 'Unlock SOP will be reset all vendor submitted data. Are you sure to continue unlock SOP ?', function() {
        $.ajax({
            url : '<?= base_url('approval/approval/unlock_sop/'.str_replace('OR', 'OQ', $msr_no)) ?>',
            dataType : 'json',
            success : function(response) {
                if (response.success) {
                    sop_lock_status = false;
                    $('#btn-unlock-sop').prop('disabled', true);
                }
            }
        });
    });
}

function saveAddendum() {
    swalConfirm('Addendum to ED', 'Are you sure to proceed ?', function() {
      $('#error-message').remove();
      var subject = $("#subject").val();
      var prebiddate = $("#prebiddate").val();
      var prebid_address = $("#prebid_address").val();
      var bl_msr_no = $("#bl_msr_no").val();
      var prebid_loc = $("#prebid_loc").val();
      var closing_date = $("#closing_date").val();
      var commercial_data = $("#commercial_data").val();
      var currency = $("#currency").val();
      var bid_validity = $("#bid_validity").val();
      var bid_bond = $("#bid_bond").val();
      var bid_bond_type = $("#bid_bond_type").val();
      var bid_bond_validity = $("#bid_bond_validity").val();
      var envelope_system = $("#envelope_system").val();
      var packet = $("#packet").val();
      var incoterm = $("#incoterm").val();
      var delivery_point = $("#delivery_point").val();
      var bl_title = $("#bl_title").val();
      var bl_pm = $("#bl_pm").val();

      $.ajax({
          type:'post',
          url : "<?=base_url('approval/ed/save_addendum')?>",
          data : {
              msr_no            :bl_msr_no,
              subject           :subject,
              prebiddate        :prebiddate,
              prebid_address    :prebid_address,
              closing_date      :closing_date,
              commercial_data   :commercial_data,
              currency          :currency,
              bid_validity      :bid_validity,
              bid_bond_type     :bid_bond_type,
              bid_bond          :bid_bond,
              bid_bond_validity :bid_bond_validity,
              prebid_loc        :prebid_loc,
              packet            :packet,
              envelope_system   :envelope_system,
              incoterm          :incoterm,
              delivery_point    :delivery_point,
              bl_pm             :bl_pm,
              no_addendum       :$('#no_addendum').val(),
              resume            :$('#resume').val()
          },
          beforeSend:function(){
              start($('#icon-tabs'));
          },
          success:function(r){
              var response = $.parseJSON(r);
              if (response.success) {
                  setTimeout(function() {
                    swalAlert('Done', 'Data is successfully submitted', function() {
                      document.location.reload();
                    });
                  }, swalDelay);
              } else {
                  $('.card-body').prepend('<div id="error-message" class="alert alert-danger">'+response.message+'</div>');
                  $('html,body').animate({ scrollTop: 0 }, 'slow');
              }
              stop($('#icon-tabs'))
          },
          error:function(){
              setTimeout(function() {
                swal('Ooopss', 'Fail, Please Try Again', 'warning')
                stop($('#icon-tabs'))
              }, swalDelay);
          }
      });
    });
}
</script>