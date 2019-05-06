<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title mb-0"><?= $titleApp ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
            <li class="breadcrumb-item active"><?= $titleApp ?></li>
          </ol>
        </div>
      </div>
    </div>
    <div class="row info-header">
      <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
              <td style="width: 105px;">Company</td>
              <td class="no-padding-lr">:</td>
              <td><?=$msr->company_desc?></td>
          </tr>
          <tr>
              <td style="width: 105px;">Department</td>
              <td class="no-padding-lr">:</td>
              <td>
                <?= $msr->department_desc?>
              </td>
            </tr>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
              <td style="width: 105px;">MSR Number</td>
              <td class="no-padding-lr">:</td>
              <td><?=$msr->msr_no?></td>
          </tr>
          <tr>
              <td style="width: 105px;">MSR Value</td>
              <td class="no-padding-lr">:</td>
              <td><?=$cur->CURRENCY?> <?=numIndo($msr->total_amount)?> (<small style="color:red"><i>Exclude VAT</i></small>)</td>
          </tr>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
              <td style="width: 105px;">ED Number</td>
              <td class="no-padding-lr">:</td>
              <td><?=str_replace('OR', 'OQ', $msr->msr_no)?></td>
           </tr>
           <tr>
              <td style="width: 105px;">Title</td>
              <td class="no-padding-lr">:</td>
              <td><?= $ed->subject ?></td>
          </tr>
      </table>
      </div>
    </div>
    <div class="content-body">
      <?php 
        $sum_award_total_value = exchange_rate_by_id(1, 3, 1010000000);
        // echo $sum_award_total_value;
      ?>
      <section id="icon-tabs">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-content collapse show">
                <div class="card-body card-scroll">
                  <form enctype="multipart/form-data" action="<?= base_url('approval/ed/bod_contract_review_store') ?>" class="wizard-circle frm-bled" id="frm-bled" method="post">
                    <input type="hidden" name="msr_no" value="<?=$msr->msr_no?>">
                    <h6><i class="step-icon fa fa-info"></i> <?= $titleApp ?></h6>
                    <fieldset>
                      <div class="form-group row">
                        <label class="col-md-3">
                          <?= lang('Judul File','File Name') ?>
                        </label>
                        <div class="col-md-4">
                          <input class="form-control" name="contract_review_name" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-md-3">
                          File Attachment
                        </label>
                        <div class="col-md-4">
                          <input class="form-control" type="file" name="contract_review_file" required="">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-7">
                          <button class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-md-12">
                          <div class="table-responive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th width="15">No</th>
                                  <th>File Name</th>
                                  <th>Upload At</th>
                                  <th>Uploader</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php 
                                $contract_review = $this->approval_lib->contract_review($msr->msr_no);
                                // print_r($contract_review->result());
                                $n =1;
                                foreach ($contract_review->result() as $cr) {
                                  echo "<tr>
                                  <td>".$n++."</td>
                                  <td>".$cr->file_name."</td>
                                  <td>".dateToIndo($cr->created_at, false, true)."</td>
                                  <td>".user($cr->created_by)->NAME."</td>
                                  <td>
                                    <a href='".base_url('upload/contract_review/'.$cr->file_path)."' target='_blank' clas='btn btn-sm btn-info'><i class='fa fa-download'></i></a>
                                    <a class='btn btn-sm btn-danger' href='#' onclick='deleteClick($cr->id)' title='Delete'><i class='fa fa-trash'></i></a>
                                  </td>
                                  </tr>";
                                }
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
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
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
  });
  function deleteClick(id) {
    if(confirm('Aye you sure want to delete it?'))
    {
      window.open("<?= base_url('approval/ed/bod_contract_review_delete') ?>/"+id,"_self");
    }
  }
</script>