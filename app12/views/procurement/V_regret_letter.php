<style>
body {
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    font-weight: normal;
}
</style>
<div class="app-content content">
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
      <h3 class="content-header-title mb-0"><?=$letter->company_desc?></h3>
    </div>
    <div class="content-header-left col-md-6 col-12 mb-2">
      REGRET LETTER NOTIFICATION For <?=$letter->title?>
    </div>
    <div class="content-header-right col-md-6 col-12 mb-2 text-right">
      Reference No : <?=$letter->bled_no?>
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
                <form action="<?= base_url('procurement/regretLetter/send/'.$letter->bl_detail_id)?>" method="POST" id="regret-letter-form" class="steps-validation wizard-circle">
                  <input type="hidden" name="bl_detail_id" value="<?= $letter->bl_detail_id?>">
                  <!-- Step 1 -->
                  <h6><i class="step-icon icon-info"></i> Notification</h6>
                  <fieldset>
                    <center><strong>UNSUCCESSFULL NOTIFICATION</strong></center>
                    <br>
                    <br>
                    <table width="100%">
                      <tr>
                        <td width="150">Date</td>
                        <td width="15">:</td>
                        <td><?=dateToIndo($letter->regret_date)?></td>
                      </tr>
                      <tr>
                        <td>Subject</td>
                        <td>:</td>
                        <td><?=$letter->title?></td>
                      </tr>
                      <tr>
                        <td>Ref Number</td>
                        <td>:</td>
                        <td><?=$letter->bled_no?></td>
                      </tr>
                      <tr>
                        <td>Closing Date</td>
                        <td>:</td>
                        <td><?=dateToIndo($letter->closing_date, false, true)?></td>
                      </tr>
                    </table>
                    <br>
                    <br>
                    <p>
                      << Default di unsuccessful form >>
                    </p>
                    <p>
                      <?=nl2br(@$letter->body)?>
                    </p>
                    <br>
                    <br>
                    Regards,
                    <br>
                    <br>
                    <br>
                    Procurement Committee
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
<script>
$(document).ready(function() {

var regret_letter_form = $('#regret-letter-form')

$(".steps-validation").steps({
  headerTag: "h6",
  bodyTag: "fieldset",
  transitionEffect: "fade",
  titleTemplate: '#title#',
  enablePagination: true,
  enableFinishButton: <?= $letter->regret_letter_id ? 'false': 'true' ?>,
  labels: {
    finish: 'Send'
  },
  onFinished: function() {
    regret_letter_form.submit() 
  }
})

})
</script>
