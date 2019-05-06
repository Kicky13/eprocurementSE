<?php
  $row = $this->vendor_lib->greeting_list($type,$bled_no)->row();
  $doc = $this->db->where(['module_kode'=>'bled','data_id'=>$row->msr_no])->get('t_upload')->result();

?>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">Bid Proposal For <?=$bled_no?></h3>
      </div>
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
                                      <h6><i class="step-icon fa fa-info"></i> Invitation</h6>
                                      <fieldset>
                                        <div class="row">
                                          <div class="col-md-12">
                                              <table class="table table-condensed table-striped">
                                                <tbody>
                                                  <tr>
                                                    <td>Company</td>
                                                    <td><?=$row->company_name?></td>
                                                    <td>Currency</td>
                                                    <td><?=$row->currency?></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Enquiry No</td>
                                                    <td><?=$row->bled_no?></td>
                                                    <td>Procurement Metdod</td>
                                                    <td><?=$row->pmethod_name?></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Subject Title</td>
                                                    <td><?=$row->title?></td>
                                                    <td>Envelope System</td>
                                                    <td></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Invitation Date</td>
                                                    <td><?=dateToIndo($row->invitation_date)?></td>
                                                    <td>Packet/Itemize</td>
                                                    <td></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Pre Bid Meeting</td>
                                                    <td><?=dateToIndo($row->prebiddate, false, true)?></td>
                                                    <td>Incoterm</td>
                                                    <td></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Meeting Location</td>
                                                    <td><?=$row->prebid_address?></td>
                                                    <td>Delivery Point Loc</td>
                                                    <td><?=$row->loc?></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Closing Date</td>
                                                    <td><?=dateToIndo($row->closing_date, false, true)?></td>
                                                    <td>Bid Validity</td>
                                                    <td><?=dateToIndo($row->bid_validity, false, true)?></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Bid Bond</td>
                                                    <td><?=$row->bid_bond?></td>
                                                    <td>Bid Bond Validity</td>
                                                    <td><?=dateToIndo($row->bid_bond_validity, false, true)?></td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                          </div>
                                        </div>
                                      </fieldset>
                                      <!-- Step 2 -->
                                      <h6><i class="step-icon fa fa-download"></i>Attachment</h6>
                                      <fieldset>
                                        <div class="row">
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
                                                <tbody>
                                                  <?php foreach ($doc as $key => $value) {
                                                    echo "<tr>
                                                      <td>".biduploadtype($value->tipe, true)."</td>
                                                      <td>".$value->file_name."</td>
                                                      <td>".$value->created_at."</td>
                                                      <td>".user($value->created_by)->NAME."</td>
                                                      <td>
                                                        <a href='".base_url('userfiles/temp/'.$value->file_path)."' target='_blank' class='btn btn-sm btn-primary'>Download</a>
                                                      </td>
                                                    </tr>";
                                                  }?>
                                                </tbody>
                                              </table>
                                            </div>
                                          </div>
                                        </div>
                                      </fieldset>
                                      <!-- Step 3 -->
                                      <h6><i class="step-icon fa fa-info"></i>Clraification</h6>
                                      <fieldset>
                                        <?php $this->load->view('V_note',['module_kode'=>'bidnote','data_id'=>$bled_no])?>
                                      </fieldset>
                                      <!-- Step 4 -->
                                      <h6><i class="step-icon fa fa-info"></i>Quotation</h6>
                                      <fieldset></fieldset>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </section>
                        <!-- Form wizard with icon tabs section end -->
                      </div>
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
<script src="<?=base_url('ast11/app-assets/js/scripts/forms/wizard-steps.js')?>" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>