<?php
  $msr = $this->uri->rsegment(4);
  $q = $this->vendor_lib->sqlUtama(['bled_no'=>$msr])->row();
  $row      = $this->vendor_lib->greeting_list(1,$msr)->row();
?>
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
          <h3 class="content-header-title mb-0"><?=$q->company_name?></h3>
        </div>
        <div class="content-header-left col-md-6 col-12 mb-2">
          NEGOTIATION REQUISITION For <?=$q->title?>
        </div>
        <div class="content-header-right col-md-6 col-12 mb-2 text-right">
          Reference No : <?=$q->bled_no?>
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
                      <h6><i class="step-icon fa fa-info"></i> Invitation</h6>
                      <fieldset>
                        <center>
                          NEGOTIOATION REQUSITION
                        </center>
                        <table width="100%">
                          <tr>
                            <td width="150">Date</td>
                            <td width="15">:</td>
                            <td><?=dateToIndo($q->nego_date)?></td>
                          </tr>
                          <tr>
                            <td>Subject</td>
                            <td>:</td>
                            <td><?=$q->title?></td>
                          </tr>
                          <tr>
                            <td>Ref Number</td>
                            <td>:</td>
                            <td><?=$q->bled_no?></td>
                          </tr>
                          <tr>
                            <td>Closing Date</td>
                            <td>:</td>
                            <td><?=dateToIndo($q->closing_date, false, true)?></td>
                          </tr>
                        </table>
                        <br>
                        <br>
                        <p>
                          << Information accroding to the Note >>
                        </p>
                        <p>
                          <?=nl2br($q->nego_desc)?>
                        </p>
                        <br>
                        <br>
                        Regrads,
                        <br>
                        <br>
                        <br>
                        Procurement Committee
                      </fieldset>
                      <!-- Step 2 -->
                      <h6><i class="step-icon fa fa-th-list"></i>Negotiation</h6>
                      <fieldset>
                        <div class="col-md-12" style="margin-bottom: 10px">
                          Price Evaluation Quotation
                        </div>
                        <div class="col-md-12">
                          <form action="" method="" id="" name=""></form>
                          <form id="frm-nego" class="open-this">
                            <input type="hidden" name="bled_no" value="<?=$msr?>">
                            <input type="hidden" name="msr_no" value="<?=str_replace('OQ', 'OR', $msr)?>">
                            <input type="hidden" name="id_currency" value="<?=$row->id_currency?>">
                            <input type="hidden" name="id_currency_base" value="<?=$row->id_currency_base?>">
                          <?php 
                              $this->load->view('approval/priceevaluationnegotiation', [
                                'ed'=>$q, 
                                'isi'=>'quotation', 
                                'nego'=>1, 
                                'bled_no'=>$bled_no,
                                'vendor_id'=>$this->session->userdata('ID'),
                              ]);
                          ?>
                          <a href="#" class="btn btn-success submit-negotiation">Submit</a>
                          </form>
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
        
      </div>
    </div>
  </div>
  
  <script src="<?=base_url('ast11/app-assets/js/scripts/forms/wizard-steps.js')?>" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
<script type="text/javascript">
  $(".submit-negotiation").click(function(){
    $.ajax({
      type:'post',
      data:$("#frm-nego").serialize(),
      url:"<?=base_url('vn/info/greetings/submit_negotiation')?>",
      beforeSend:function(){
            start($('#icon-tabs'));
          },
          success: function (data) {
            // alert(data);
              stop($('#icon-tabs'));
          },
          error: function (e) {
            alert('Fail, Try Again');
            stop($('#icon-tabs'));
          }
    })
  });
</script>