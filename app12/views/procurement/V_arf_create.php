<?php $this->load->view('procurement/partials/script') ?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("ARF Preparation", "ARF Preparation") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Create ARF", "Create ARF") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <?= $this->form->open(null, 'id="form-arf" enctype="multipart/form-data"') ?>
                <?php $this->load->view('procurement/V_arf_form') ?>
                <div class="form-group text-right">
                    <!-- <button type="button" id="btn-save-draft" class="btn btn-primary">Save Draft</button> -->
                    <button type="button" id="btn-validate-submit" class="btn btn-success">Submit</button>
                </div>
            <?= $this->form->close() ?>
        </div>
    </div>
</div>

<?php $this->load->view('procurement/partials/script_arf_form') ?>

<script>
    $(function() {
        /*$('#btn-validate-save-draft').click(function() {
            $('.card-body #error-message').remove();
            if (validate()) {
                $('#btn-save-draft').show();
            }
        });*/

        $('#btn-validate-submit').click(function() {
            $('.card-body #error-message').remove();
            if (validate()) {
                $('#btn-submit').show();
            }
        });

        $('#btn-save-draft').click(function() {
            if (!$('#po_id').val()) {
                swal('<?= __('warning') ?>', 'You have to select PO', 'warning');
                return false;
            }
            var data = $('#form-arf').serialize();
            $.ajax({
                url : '<?= base_url('procurement/arf/store') ?>',
                type : 'post',
                data : data+'&'+$.param({item : arf_item, budget : budget_item}),
                dataType : 'json',
                success : function(response) {
                    if (response.success) {
                        setTimeout(function() {
                            swalAlert('<?= __('success') ?>', '<?=  __('success_submit') ?>', '<?= base_url('procurement/arf/edit') ?>/'+response.data.id);
                        }, swalDelay);
                    } else {
                        $('.card-body').prepend('<div id="error-message" class="alert alert-danger">'+response.message+'</div>');
                    }
                }
            })
        });

        $('#btn-submit').click(function() {
            swalConfirm('ARF Preparation', '<?= __('confirm_submit') ?>', function() {
                var data = $('#form-arf').serialize();
                $.ajax({
                    url : '<?= base_url('procurement/arf/store') ?>',
                    type : 'post',
                    data : data+'&'+$.param({item : arf_item, budget : budget_item})+'&submit=1',
                    dataType : 'json',
                    success : function(response) {
                        if (response.success) {
                            document.location.href = '<?= base_url('home') ?>';
                        } else {
                            $('.card-body').prepend('<div id="error-message" class="alert alert-danger">'+response.message+'</div>');
                            $('#validation-modal').modal('hide');
                        }
                    }
                });
            });
        });
    });
</script>