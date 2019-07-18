<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">

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
                    <input type="hidden" name="equipment_id" value="<?= $equipment_id ?>">
                	<?php foreach (cmms_settings('eq-detail-tab')->get()->result() as $r) :?>
                	<h6> <?= $r->desc ?></h6>
                  <fieldset>
                    <div class="row">
                    	<?php $this->load->view($view.'/'.$r->desc1);?>
                    </div>
                  </fieldset>
                	<?php endforeach;?>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Upload</h4>
      </div>
      <div class="modal-body">
        <form id="form-attachment-bled" method="post" class="form-horizontal" enctype="multipart/form-data">
          <div class="form-group">
            <label>File</label>
            <input type="file" name="file_path" id="file_path" />
          </div>
          <div class="form-group text-right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" onclick="devbledAttachmentClick()" class="btn btn-primary">Upload</button>
          </div>
        </form>
      </div>
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
		//hide next and previous button
		$('a[href="#next"]').hide();
		$('a[href="#previous"]').hide();

    $('.btn-upload').click(function() {
      var isi;
      var form = $("#frm-bled")[0];
      var data = new FormData(form);
      var url = '<?=base_url('cmms/equipment/store_image')?>';
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: url,
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
          $("#dt-picture").html(data)
        },
        error: function (e) {
          alert('fail, try again')
        }
      });
      return false; // avoid to execute the actual submit of the form.*/
    });
	})
  function deleteImageClick(ud){
    if(confirm('Are you sure?')){
      $.ajax({
        url:"<?=base_url('cmms/equipment/delete_image')?>/"+ud,
        success:function(e){
          $("#dt-picture").html(e)
        }
      })
    }
  }
</script>