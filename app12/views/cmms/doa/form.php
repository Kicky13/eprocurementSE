<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.full.js"></script>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title"><?= $title ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
          </ol>
        </div>
      </div>
    </div>
    <div class="content-body">
      <section id="icon-tabs">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-content collapse show">
                <div class="card-body card-scroll">
                  <form action="#" class="wizard-circle frm-bled" id="frm-bled" enctype="multipart/form-data">
                    <h6> <?= $title ?></h6>
                    <fieldset>
                      <div class="row">
                        <div class="col-md-6">
						              <div class="form-group">
                            <label>Delegating Official</label>
                            <input class="form-control" disabled="" value="<?= $this->session->userdata('NAME') ?>">
                            <input type="hidden" name="creator_id" readonly="" value="<?= $this->session->userdata('ID_USER') ?>">
                            <input type="hidden" name="id" readonly="" value="<?= @$row->id ?>">
                          </div>
                          <div class="form-group">
                            <label>Delegate to</label>
                            <select class="form-control" name="assign_id">
                              <?php foreach ($assign_to as $assign) {
                                $selected = '';
                                if($row)
                                {
                                  $selected = $row->assign_id == $assign->user_id ? "selected=''":'';
                                }
                                echo "<option $selected value='$assign->user_id'>$assign->user_nama</option>";
                              }?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Start Date</label>
                            <input class="form-control" required="" id="start_date" name="start_date" value="<?= date('Y-m-d') ?>">
                          </div>
                          <div class="form-group">
                            <label>End Date</label>
                            <input class="form-control" required="" id="end_date" name="end_date" value="<?= @$row->end_date ?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <?php if($row): ?>
                              <?php if(strtotime(date("Y-m-d")) < strtotime($row->end_date)): ?>
                              <label>Note : </label>
                              <input class="form-control" disabled="" value="Delegate to <?= user($row->assign_id)->NAME ?>  from <?= dateToIndo($row->start_date) ?> to <?= dateToIndo($row->end_date) ?>">
                              <?php endif;?>
                            <?php endif;?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <button class="btn btn-primary" type="button" onclick="submitClick()">Submit</button>
                          <?php if($row): ?>
                              <?php if(strtotime(date("Y-m-d")) < strtotime($row->end_date)): ?>
                                <a href="#" class="btn btn-danger" oncancel="resetClick()">Reset</a>
                              <?php endif;?>
                          <?php endif;?>
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
      },
      onStepChanged: function (event, currentIndex, priorIndex) {

      }
    });
    $('#req_finish_date').datepicker({
      dateFormat:'yy-mm-dd',
    });
    //hide next and previous button
    $('a[href="#next"]').hide();
    $('a[href="#previous"]').hide();
    $('#end_date').datepicker({
      dateFormat:'yy-mm-dd',
    });
    $('#start_date').datepicker({
      dateFormat:'yy-mm-dd',
      minDate:new Date()
    });
	});
  function submitClick(argument) {
    if(validation())
    {
      var url = "<?=base_url('cmms/doa/store');?>";
      <?php if(@$row->id): ?>
      var url = "<?=base_url('cmms/doa/update');?>";
      <?php endif;?>
      $.ajax({
        url:url,
        type:'post',
        data:$("#frm-bled").serialize(),
        beforeSend:function(){
            start($('#icon-tabs'));
          },
          success: function (e) {
            var r = eval("("+e+")");
            if(r.status){
              swal({ 
                title: "Success",
                text: r.msg,
                type: "success",
                },
                function(){
                  location = "<?= base_url('cmms/doa') ?>";
              });
            }else{
              swal('<?= __('warning') ?>',r.msg,'warning')
            }
            stop($('#icon-tabs'));
          },
          error: function (e) {
            swal('<?= __('warning') ?>','Something went wrong!','warning')
            stop($('#icon-tabs'));
          }
      })
    }
  }
  function validation() {
    var a = $("#start_date").val();
    var b = $("#end_date").val();
    if(a && b)
    {
      return true
    }
    else
    {
      return false;
    }
  }
  function resetClick() {
    if(confirm('Are you sure?'))
    {
      var id = <?= @$row->id ?>;
      var url = "<?=base_url('cmms/doa/delete');?>/"+id;
      $.ajax({
        url:url,
        type:'post',
        beforeSend:function(){
          start($('#icon-tabs'));
        },
        success: function (e) {
          var r = eval("("+e+")");
          if(r.status){
            swal({ 
              title: "Success",
              text: r.msg,
              type: "success",
              },
              function(){
                location = "<?= base_url('cmms/doa') ?>";
            });
          }else{
            swal('<?= __('warning') ?>',r.msg,'warning')
          }
          stop($('#icon-tabs'));
        },
        error: function (e) {
          swal('<?= __('warning') ?>','Something went wrong!','warning')
          stop($('#icon-tabs'));
        }
      })
    }
  }
</script>