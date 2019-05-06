<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Create Service Receipt", "Create Service Receipt") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Create Service Receipt", "Create Service Receipt") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <?= $this->form->model($model, null, 'id="form-service-receipt"') ?>
                <?php $this->load->view('procurement/V_service_receipt_form') ?>
                <button type="button" id="btn-update" class="btn btn-primary">Resubmit Service Receipt</button>
            <?= $this->form->close() ?>
        </div>
    </div>
</div>

<script>
    $(function() {
        $('#btn-update').click(function() {
            swalConfirm('Service Receipt', 'Are you sure to proceed ?', function() {
                $('#btn-update').prop('disable', true);
                $.ajax({
                    url : '<?= base_url('procurement/service_receipt/update/'.$itp->id_itp.'/'.$model->id) ?>',
                    type : 'post',
                    data : $('#form-service-receipt').serialize(),
                    dataType : 'json',
                    success : function(response) {
                        if (response.success) {
                            setTimeout(function() {
                                swalAlert('Done', 'Data is successfully submitted with No. '+$('#service_receipt_no').val(), '<?= base_url('procurement/service_receipt') ?>');
                            }, swalDelay);
                            /*$.ajax({
                                url : "<?= base_url('procurement/service_receipt/save_attachment/" + response.id_service_receipt + "') ?>",
                                type : 'post',
                                data : {attachment : JSON.stringify(attachment)},
                                dataType : 'json',
                                success : function(response) {
                                    alert(response.message);
                                    if (response.success) {

                                    }
                                }
                            }).done(function() {
                                $('#btn-create').prop('disable', false);
                            });*/
                        } else {
                            setTimeout(function() {
                                swal('Ooopss', response.message, 'warning');
                            }, swalDelay);
                        }
                    }
                }).done(function() {
                    $('#btn-update').prop('disable', false);
                });
            });
        });
    })
</script>