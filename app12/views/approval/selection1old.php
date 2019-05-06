<style>
.msr-development-detail-list-table, .msr-development-budget-table {
margin-bottom: 20px;
margin-top: 5px;
}
body {
font-family: "Open Sans", sans-serif;
font-size: 14px;
font-weight: normal;
}
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/daterange/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/pickers/daterange/daterange.min.css">
<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<?php /* page specific */ ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/jquery.dataTables.min.css">

<script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?= base_url() ?>ast11/filter/perfect-scrollbar.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/dataTables.select.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/daterange/daterangepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<?php 
  $total_amount_text = display_multi_currency_format(
    numEng($msr->total_amount),
    $msr->currency,
    numEng($msr->total_amount_base),
    base_currency_code()
  ); 

  $total_tax_text = display_multi_currency_format(
    numEng(msrPajak($msr->total_amount, true)),
    $msr->currency,
    numEng(msrPajak($msr->total_amount_base, true)),
    base_currency_code()
  ); 

  $total_amount_with_tax_text = display_multi_currency_format(
    numEng(msrPajak($msr->total_amount, 0)),
    $msr->currency,
    numEng(msrPajak($msr->total_amount_base, 0)),
    base_currency_code()
  ); 
?>
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
          <h3 class="content-header-title">MSR Number <?=$msr_no?></h3>
        </div>
      </div>
      <div class="row info-header">
      <div class="col-md-3">
        <table class="table table-condensed">
            <tr>
              <td width="20%">Title</td>
              <td class="no-padding-lr">:</td>
              <td width="68%"><span><?=$msr->title?></span></td>
            </tr>
            
          </table>
        </div>
        <div class="col-md-4">
          <div class="table-responsive">
            <table class="table table-condensed table-striped">
              <tr>
				  <td width="20%">User Requestor</td>
				  <td class="no-padding-lr">:</td>
				  <td><span><?= $_POST['create_by_name'] ?></span></td>
				</tr>
				<tr>
				  <td width="20%">Department</td>
				  <td class="no-padding-lr">:</td>
				  <td><span><?= $_POST['creator_department_name'] ?></span></td>
				</tr> 
            </table>
          </div>
        </div>
		<div class="col-md-5">
          <div class="table-responsive">
            <table class="table table-condensed table-striped"> 
			  <tr>
                <td width="30%">Total (excl. VAT)</td>
                <td class="no-padding-lr">:</td>
                <td class="pull-right"><?=$total_amount_text?></td>
              </tr>
              <tr>
                <td width="30%">VAT</td>
                <td class="no-padding-lr">:</td>
                <td class="pull-right"><?=$total_tax_text?></td>
              </tr>
              <tr>
                <td width="30%">Total (incl. VAT)</td>
                <td class="no-padding-lr">:</td>
                <td class="pull-right"><?=$total_amount_with_tax_text?> </td>
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
                <div class="card-content collapse show">
                  <div class="card-body card-scroll">
                    <form id="msr-development-form" class="wizard-circle" method="POST">
                      <!-- Step 1 -->
                      <h6><i class="step-icon icon-info"></i> Header</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="company">
                                Company :
                                <span class="danger">*</span>
                                </label>
                                <input type="text" class="form-control" value="<?=$msr->company_name?>" disabled="">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="plocation">Procurement Location :
                                <span class="danger">*</span>
                              </label>
                              <input class="form-control" value="<?=$msr->proc_location_name?>" disabled="">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="required_date">
                                Required Date :
                                <span class="danger">*</span>
                              </label>
                              <input type="text" class="form-control" value="<?=$msr->req_date?>" disabled="">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="lead_time">
                                Lead Time :
                                <span class="danger">*</span>
                              </label>
                              <div class="input-group">
                                <input type="email" class="form-control" value="<?=$msr->lead_time?>" disabled="">
                                <span class="input-group-addon">Week(s)</span>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="title">Title :
                                <span class="danger">*</span>
                              </label>
                              <textarea class="form-control" disabled=""><?=$msr->title?></textarea>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="pmethod">
                                Proposed Procurement Method :
                                <span class="danger">*</span>
                              </label>
                              <input class="form-control" value="<?=$msr->proc_method_name?>" disabled="">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="procure_processing_time">
                                Procurement Processing Time :
                              </label>
                              <div class="input-group">
                                <input class="form-control" value="<?=$msr->procure_processing_time?>" disabled="">
                                <span class="input-group-addon">days </span> 
                              </div>
                              <p><small class="text-muted">Excluding lead time. After MSR received by Procurement.</small></p>
                            </div>
                          </div>
                        </div>

                        <div class="row"> 
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="msr_type">
                                MSR Type :
                                <span class="danger">*</span>
                              </label>
                              <input class="form-control" value="<?=$msr->msr_name?>" disabled="">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="msr_type">
                                Blanket Type :
                                <span class="danger">*</span>
                              </label>
                              <input class="form-control" value="<?=$msr->blanket?>" disabled="">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="cost_center">
                                Cost Center :
                                <span class="danger">*</span>
                              </label>
                              <input class="form-control" value="<?=$msr->cost_center_name?>" disabled="">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="currency">
                                Currency :
                                <span class="danger">*</span>
                              </label>
                              <input class="form-control" value="<?=$msr->currency?>" disabled="">
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 2 -->
                      <h6><i class="step-icon icon-list"></i>Detail</h6>
                      <fieldset>
                        <?php if ($msr->id_msr_type == 'MSR01'): /* Jika MSR type = MSR Services */ ?>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="proposalTitle2">Delivery Point :</label>
                              <input value="<?=$msr->dpoint_desc?>" class="form-control" disabled="">
                            </div> 
                          </div>
						  <div class="col-md-3"> 
                            <div class="form-group">
                              <label for="emailAddress4">Request For :</label>
                              <input value="<?=$msr->requestfor_desc?>" class="form-control" disabled="">
                            </div> 
                          </div>
						  <div class="col-md-3"> 
                            <div class="form-group">
                              <label for="videoUrl2">Delivery Term :</label>
                              <input value="<?=$msr->deliveryterm_desc?>" class="form-control" id="proposalTitle2" disabled="">
                            </div>
                          </div>
						  <div class="col-md-3">
                            <div class="form-group">
                              <label for="jobTitle3">Freight :</label>
                              <input value="<?=$msr->freight_desc?>" class="form-control" id="proposalTitle2" disabled="">
                            </div> 
                          </div>
						</div>
						<div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="jobTitle3">Importation :</label>
                              <input value="<?=$msr->importation_desc?>" class="form-control" id="proposalTitle2" disabled="">
                            </div> 
                          </div>
						  <div class="col-md-3"> 
                            <div class="form-group">
                              <label for="jobTitle3">Inspection :</label>
                              <input value="<?=$msr->inspection_desc?>" class="form-control" id="proposalTitle2" disabled="">
                            </div> 
                          </div>
                        </div>
                        <?php endif; ?>
                        <?php if ($msr->id_msr_type == 'MSR02'): /* Jika MSR type = MSR Services */ ?>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="scope_of_work">Brief of Scope of Work :
                                <span class="danger">*</span>
                              </label>
                              <textarea disabled="" class="form-control" rows="4" name="scope_of_work" id="scope_of_work"><?=$msr->scope_of_work?></textarea>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="location">Location :</label>
                              <input value="<?=$msr->dpoint_desc?>" class="form-control" id="dpoint_desc" disabled="">
                            </div>
                          </div>
                        </div> 
                        <?php endif; ?>

                        <div class="row msr-development-detail-list-table">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table id="msr-development-detail-list" class="table table-condensed">
                                <thead>
                                  <tr>
                                    <th>NO</th>
                                    <th>ITEM TYPE</th>
                                    <th>SEMIC NO</th>
                                    <th>DESC OF UNIT</th>
                                    <th>GROUP</th>
                                    <th>SUB GROUP</th>
                                    <th>QTY</th>
                                    <th>UOM</th>
                                    <th>EST UNIT PRICE</th>
                                    <th>EST TOTAL VALUE</th>
                                    <th>IMPORTATION</th>
                                    <th>DELIVERY POINT LOCATION</th>
                                    <th>COST CENTER</th>
                                    <th>ACCOUNT SUBSIDIARY</th>
                                  </tr>

                                </thead>
                                <tbody>
                                  <?php
                                  // print_r( $msr_items );
                                    $no=1;
                                    foreach ($msr_items->result() as $item) :
                                  ?>
                                    <tr>
                                      <td><?=$no++?></td>
                                      <td><?=$item->id_itemtype?></td>
                                      <td><?=$item->semic_no?></td>
                                      <td><?=$item->description?></td>
                                      <td><?=$item->groupcat_desc?></td>
                                      <td><?=$item->sub_groupcat_desc?></td>
                                      <td><?=$item->qty?></td>
                                      <td><?=$item->uom?></td>
                                      <td><?=$item->priceunit?></td>
                                      <td><?=numIndo($item->priceunit*$item->qty,0)?></td>
                                      <td><?=$item->importation_desc?></td>
                                      <td><?=$item->dpoint_desc?></td>
                                      <td><?=$item->costcenter_desc?></td>
                                      <td><?=$item->accsub_desc?></td>
                                    <?php endforeach;
                                    if (!empty($items) && count($items) > 0):
                                      foreach ($items as $i => $item) {
                                        $item_namespace = "items[$i]"; ?>
                                        <input type="hidden" name="<?= $item_namespace.'[msr_no]'?>" value="<?= (!empty($msr_no) ?  $msr_no :  ""); ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[item_type_value]'?>" value="<?= $item->id_itemtype ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[item_type_name]'?>" value="<?= $item->id_itemtype ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[material_id]'?>" value="<?= $item->material_id ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[semic_no_value]'?>" value="<?= $item->semic_no ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[semic_no_name]'?>" value="<?= $item->description ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[group_value]'?>" value="<?= $item->groupcat ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[group_name]'?>" value="<?= $item->groupcat_desc ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[subgroup_value]'?>" value="<?= $item->sub_groupcat ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[subgroup_name]'?>" value="<?= $item->sub_groupcat_desc ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[qty_required_value]'?>" value="<?= $item->qty ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[qty_onhand]'?>" value="<?= 0 ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[qty_ordered]'?>" value="<?= 0 ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[uom_name]'?>" value="<?= $item->uom ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[unit_price_value]'?>" value="<?= $item->priceunit ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[total_value]'?>" value="<?= $item->qty * $item->priceunit ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[currency_value]'?>" value="<?= '' ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[currency_name]'?>" value="<?= '' ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[importation_value]'?>" value="<?= $item->id_importation ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[importation_name]'?>" value="<?= $item->importation_desc ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[delivery_point_value]'?>" value="<?= $item->id_dpoint ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[delivery_point_name]'?>" value="<?= $item->dpoint_desc ?>">

                                        <input type="hidden" name="<?= $item_namespace.'[account_subsidiary_name]'?>" value="<?= $item->accsub_desc ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[account_subsidiary_value]'?>" value="<?= $item->id_accsub ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[cost_center_name]'?>" value="<?= $item->costcenter_desc ?>">
                                        <input type="hidden" name="<?= $item_namespace.'[cost_center_value]'?>" value="<?= $item->id_costcenter ?>">
                                    <?php } endif; ?>
                                    </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 3 -->
                      <h6><i class="step-icon icon-calculator"></i> Budget</h6>
                      <fieldset>
                        <div class="row msr-development-budget-table">
                          <div class="col-md-12">
                            <table id="msr-development-budget"></table>
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 4 -->
                      <?php /* Attachment */ ?>
                      <h6><i class="step-icon icon-paper-clip"></i> Attachment</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">

                            <div id="attachment-alert" class="alert alert-warning" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div id="attachment-list">

                              <div class="row">
                                <div class="col-md-2"><?php /* type */ ?>
                                  <label>Type</label>
                                </div>
                                <div class="col-md-1"><?php /* sequence */ ?>
                                  <label>Seq</label>
                                </div>
                                <div class="col-md-3"><?php /* filename */ ?>
                                  <label>Filename</label>
                                </div>
                                <div class="col-md-3"><?php /* upload time */ ?>
                                  <label>Upload Time</label>
                                </div>
                                <div class="col-md-2"><?php /* upload by */ ?>
                                  <label>Uploader</label>
                                </div>
                                <div class="col-md-1"><?php /* action button */ ?></div>
                              </div>

                              <?php if (isset($attachments) && count($attachments) > 0): ?>

                              <?php foreach($attachments as $attachment): ?>
                              <div class="row form-group">
                                <div class="col-md-2"><?php /* type */ ?>
                                  <?= @$opt_msr_attachment_type[$attachment->tipe] ?>
                                </div>

                                <div class="col-md-1"><?= $attachment->sequence ?> </div>

                                <div class="col-md-3"><?= $attachment->file_name ?>
                                  <span></span>
                                </div>

                                <div class="col-md-3"><?= $attachment->created_at ?> </div>

                                <div class="col-md-2"><?= $attachment->created_by_name ?> </div>

                                <div class="col-md-1">
                                  <?php $href = base_url().$attachment->file_path.$attachment->file_name; ?>
                                  <a href="<?= $href ?>" target="_blank">
                                    <button type="button" class="btn btn-icon btn-sm">
                                      <i class="icon-cloud-download"></i>
                                    </button>
                                  </a>
                                </div>
                              </div>
                              <?php endforeach; ?>
                              <?php endif; ?>
                            </div>  <!-- end repeater attachment -->
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 5 -->
                      <!-- asline note -->
                      <!-- Step 6 -->
                      <h6><i class="step-icon fa fa-history"></i>History</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="table table-condensed">
                                <thead>
                                  <tr>
                                    <th>MSR No</th>
                                    <th><?= lang("Tanggal Dibuat", "Transaction Date")?></th>
                                    <th><?= lang("Keterangan", "Description")?></th>
                                    <th><?= lang("Note", "Note")?></th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $qq = $this->db->query("select a.data_id, b.role_id, a.created_at, c.DESCRIPTION as name, CONCAT(b.module_kode, ' (APRROVE BY ', c.DESCRIPTION, ')') as ket FROM t_approval a
                                    JOIN m_approval b ON b.id=a.m_approval_id
                                    JOIN m_user_roles c ON c.ID_USER_ROLES=b.role_id
                                    WHERE a.data_id='".$msr_no."' and a.status = 1
                                    UNION
                                    SELECT v.data_id, v.created_by, v.created_at, w.NAME as name, CONCAT(v.module_kode, ' (UPLOADED BY ', w.NAME, ')') as ket FROM t_upload v
                                    JOIN m_user w ON w.ID_USER=v.created_by WHERE data_id='".$msr_no."'");
                                    $msrCreate = $this->db->where(['msr_no'=>$msr_no])->get('t_msr')->row();
                                    $list = $this->db->where(['module_kode'=>'msr','data_id'=>$msr_no])->order_by('created_at','asc')->get('log_history')->result();
                                    echo "<tr>
                                      <td>$msr_no</td>
                                      <td>$msrCreate->create_on</td>
                                      <td>Created MSR</td>
                                      <td></td>
                                    </tr>";
                                    foreach ($list as $r) {
                                      $user = user($r->created_by);
                                      $name = $user ? $user->NAME : '';
                                      echo "<tr>
                                      <td>$msr_no</td>
                                      <td>$r->created_at</td>
                                      <td>
                                        $r->description by $name
                                      </td>
                                      <td>
                                        $r->keterangan
                                      </td>
                                    </tr>";
                                    }
                                    // foreach ($qq->result_array() as $value) { 
                                    ?>
                                      <!-- <tr>
                                        <td><?= $value['data_id'] ?></td>
                                        <td><?= $value['name'] ?></td>
                                        <td><?= $value['created_at'] ?></td>
                                        <td><?= $value['ket'] ?></td>
                                      </tr> -->
                                    <?php
                                    // }
                                   ?>

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
                <form method="post" action="<?=base_url('approval/approve')?>" class="form-horizontal" id="frm-issued">
                  <!-- data_id -->
                  <input type="hidden" name="id" id="id" value="<?=$idnya?>">
                  <input type="hidden" name="data_id" value="<?=$msr_no?>">
                  <input type="hidden" name="status" value="1">
                  <input type="hidden" name="module_kode" value="msr_spa">
                  <input type="hidden" name="status_str" value="issued ed">
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
                  <input type="hidden" name="module_kode" value="msr_spa">
                  <!-- m_approval_id -->

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
                    <label>Description</label>
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

                  <div class="row form-group">
                    <div class="col-sm-12">
                      <label>Select Procurement List</label>
                      <?php 
                        $i=1;
                        foreach ($this->db->like('ROLES',28)->get('m_user')->result() as $r) : 
                      ?>
                      <div class="row" style="margin-top: 10px">
                        <div class="col-sm-2">

                        </div>
                        <div class="col-sm-8">
                          <?=$r->NAME?>
                        </div>
                        <div class="col-sm-1">
                          <input type="radio" name="user_id" value="<?=$r->ID_USER?>" <?= $i == 1 ? "checked":"" ?> >
                        </div>
                      </div>
                      <?php 
                          $i++;
                        endforeach;
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>MSR Type</label>
                    <div class="col-sm-12">
                      <select class="form-control" name="msr_type">
                        <?php foreach ($this->db->where(['status'=>1])->get('m_msrtype')->result() as $r) {
                          $selected = $msr->id_msr_type == $r->ID_MSR ? "selected":"";
                          echo '<option '.$selected.' value="'.$r->ID_MSR.'">'.$r->MSR_DESC.'</option>';
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
                          $selected = $msr->id_pmethod == $r->ID_PMETHOD ? "selected":"";
                          echo '<option '.$selected.' value="'.$r->ID_PMETHOD.'">'.$r->PMETHOD_DESC.'</option>';
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
        <?php if(@$approval->role_id == 9): ?>
          <?php if($approval->status == 0): ?>
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal">APPROVE/REJECT</a>
          <?php endif;?>
        <?php endif;?>
        <?php if(@$approval->role_id == 23): ?>
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

  var item_master = [];
  var attachment_list = {};
  var msr_development_budget = {};
  var msr_development_detail_list = {};
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
        beforeSend:function(){
          start($('#myModal'));
        },
        success:function(r){
          var a = eval("("+r+")");
          alert(a.msg);
          stop($('#myModal'));
          // location.reload();
          window.open("<?=base_url('home')?>","_self");
        },
          error:function(){
          stop($('#myModal'));
        }
      })
    }
    function assignSend() {
      url = "<?=base_url('approval/approval/assignment')?>";
      $.ajax({
        type:'post',
        data:$("#frm-assign").serialize(),
        url:url,
        beforeSend:function(){
          start($('#myModal-assign'));
        },
        success:function(r){
          var a = eval("("+r+")");
          alert(a.msg);
          stop($('#myModal-assign'));
          // location.reload();
          window.open("<?=base_url('home')?>","_self");
        },
        error:function(){
            stop($('#myModal-assign'));
        },

      })
    }
    function developeBlEdClick() {
      if(confirm('Are you sure to develope Bidder List & Enquiry Document?'))
      {
        window.open('<?=base_url('approval/approval/devbled/'.$msr_no.'/'.$idnya)?>','_self');
      }
    }

    function calculate_budget() {
      $.post(
        '<?= base_url().'/procurement/msr/calculateBudget' ?>',
        $('#msr-development-detail-list').find('input,select,textarea').serialize()
      )
      .done(function(data) {
        if (data.status == 'error') {
          alert(data.message);
          return false;
        }

        msr_development_budget.clear()
        msr_development_budget.rows.add(data.data).draw()
      })
      .fail(function(error) {
        alert(error)
      })
      .always(function() {
        // e.g. remove waiting animation
      })
    }

    $(document).ready(function() {

    // Validate steps wizard
    // Show form
    var form = $("#msr-development-form"); 
	form.show();
    form.find('.alert').hide();
    setTimeout(function(){
      calculate_budget()
      msr_development_budget = $("#msr-development-budget").DataTable({
        'scrollY': true,
        'scrollX': true,
        "paging":   false,
        "info":     false,
        "searching": false,
        "ordering": false,
        "processing": true,
        "columns":  [
          { 'data': 'cost_center_value', 'title': 'Cost Center' },
          { 'data': 'cost_center_name', 'title': 'Cost Center Description' },
          { 'data': 'account_subsidiary_value', 'title': 'Account Subsidiary' },
          { 'data': 'account_subsidiary_name', 'title': 'Account Subsidiary Description' },
          { 'data': 'msr_booking_amount', 'title': 'MSR Booking Amount' },
          { 'data': 'msr_budget_status', 'title': 'MSR Budget Status' },
          { 'data': 'available_budget', 'title': 'Available Budget' },
          { 'data': 'status_budget', 'title': 'Status Budget' }
        ]
      });
    }, 1000);
    // var str = '<td></td>';
    // $('#msr-development-detail-list tr:last').after('<tr>'++'</tr>');
    // end document ready
	
	$("#msr-development-form").steps({
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
	
    });

  </script>
