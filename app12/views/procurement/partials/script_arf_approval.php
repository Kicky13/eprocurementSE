<script>
    $(function() {
        $('#approve-modal').on('hidden.bs.modal', function() {
            $('#form-approve-id').val('');
            $('#form-approve-status').val(1);
            $('#form-approve-description').val('');
        });

        $('#btn-approve').click(function() {
            if ($('#form-approve-status').val() == 2 && $('#form-approve-description').val() == '') {
                swal('<?= __('warning') ?>', '<?= __('field_required', array('field' => 'Comment')) ?>', 'warning');
                return false;
            }
            swalConfirm('ARF Preparation', '<?= __('confirm_submit') ?>', function() {
                $.ajax({
                    url : '<?= base_url('procurement/arf/approve/'.$arf->id) ?>',
                    type : 'post',
                    data : $.param({
                        id : $('#form-approve-id').val(),
                        status : $('#form-approve-status').val(),
                        description : $('#form-approve-description').val(),
                        review_bod : $('#review_bod').prop('checked') ? '1' : '0',
                        bod_review_meeting : $('[name="bod_review_meeting['+$('#form-approve-id').val()+']"]:checked') ? $('[name="bod_review_meeting['+$('#form-approve-id').val()+']"]:checked').val() : ''
                    })+'&'+$('[name*="budget"]').serialize(),
                    dataType : 'json',
                    success : function(response) {
                        var id = $('#form-approve-id').val();
                        var status = $('#form-approve-status').val();
                        var description = $('#form-approve-description').val();
                        var review_metting_bod =  $('[name="bod_review_meeting['+$('#form-approve-id').val()+']"]:checked') ? $('[name="bod_review_meeting['+$('#form-approve-id').val()+']"]:checked').val() : '';
                        if (response.success) {
                            $('#btn-approve-'+id).remove();
                            $('#btn-approval-save-'+id).remove();
                            if (status == 1) {
                                $('[data-m="status"]', $('#approval-'+id)).html('Approved');
                            } else {
                                $('[data-m="status"]', $('#approval-'+id)).html('Rejected')
                            }
                            $('[data-m="note"]', $('#approval-'+id)).html(description.replace(/(\r\n|\n\r|\r|\n)/g, "<br>") + " by <?= $this->session->userdata('NAME') ?>");
                            $('[data-m="approved_at"]', $('#approval-'+id)).html(Localization.humanDatetime(new Date()));
                            $('#approve-modal').modal('hide');
                            if (review_metting_bod !== '' && typeof(review_metting_bod) != 'undefined') {
                                if (review_metting_bod == '1') {
                                    $('[data-m="bod_review_metting"]', $('#approval-'+id)).html('Required');
                                } else {
                                    $('[data-m="bod_review_metting"]', $('#approval-'+id)).html('Not Required');
                                }
                            }
                            /*swalAlert('Done', 'Data is successfully submitted', function() {
                                if ($('[data-button-type="approve"]').length == 0) {
                                    document.location.href = '<?=  base_url('home') ?>';
                                }
                            });*/
                            if ($('[data-button-type="approve"]').length == 0) {
                                document.location.href = '<?=  base_url('home') ?>';
                            }
                        } else {
                            setTimeout(function(){ swal('<?= __('warning') ?>', response.message, 'warning'); }, swalDelay)
                        }
                    }
                });
            });
            //var conf = confirm('Are you sure want to proceed ');
            /*if (conf) {

            } else {
                return false;
            }*/
        });

        $.each($('[name*="bod_review_meeting"]'), function(key, elem) {
            var approval_id = $(elem).data('bod_review_metting');
            if ($(elem).val() == 1) {
                $('#btn-approve-'+approval_id).hide();
                $('#btn-approval-save-'+approval_id).show();
            } else {
                $('#btn-approve-'+approval_id).show();
                $('#btn-approval-save-'+approval_id).hide();
            }
        });

        $("#bod-review-meeting-btn").click(function(){
            var id = $("#bod-review-meeting-id").val();
            $.ajax({
                url : '<?= base_url('procurement/arf/approval_save/'.$arf->id) ?>',
                type : 'post',
                beforeSend:function(){
                    start($('#bod-review-meeting-modal'));
                },
                data : {
                    id : id,
                    bod_review_meeting : $('[name="bod_review_meeting['+id+']"]:checked').val(),
                    bod_review_meeting_desc: $("#bod_review_meeting_desc").val()
                },
                dataType : 'json',
                success : function(response) {
                    if (response.success) {
                        $('#btn-approve-'+id).remove();
                        $('#btn-approval-save-'+id).remove();
                        var bod_review_metting =  $('[name="bod_review_meeting['+id+']"]:checked').val();
                        if (bod_review_metting == '1') {
                            $('[data-m="bod_review_metting"]', $('#approval-'+id)).html('Required');
                        } else {
                            $('[data-m="bod_review_metting"]', $('#approval-'+id)).html('Not Required');
                        }
                        pnotifyAlert('Success', response.message, 'success', function() {
                            if ($('[data-button-type="approve"]').length == 0) {
                                document.location.href = '<?=  base_url('procurement/arf/approval') ?>';
                            }
                        });
                    }
                    stop($('#bod-review-meeting-modal'));
                }
            });
        })
    });

    function approve(id) {
        var budget_status = true;
        if ($('[name*="budget"]').length != 0) {
            $.each($('[name*="budget"]'), function(key, elem) {
                if ($(elem).val() == '') {
                    budget_status = false;
                }
            });
        }
        if (!budget_status) {
            swal('<?= __('warning') ?>', 'You have to set all budget status', 'warning');
        } else {
            $('#form-approve-id').val(id);
            $('#approve-modal').modal('show');
        }
    }

    function update_approve(id) {
        $('.card-body #error-message').remove();
        if (validate()) {
            $('#btn-update-approve').show();
        }
    }

    function bod_review_meeting(id) {
        if ($('[name="bod_review_meeting['+id+']"]:checked').val() == 1) {
            $('#btn-approve-'+id).hide();
            $('#btn-update-approve-'+id).hide();
            $('#btn-approval-save-'+id).show();
        } else {
            $('#btn-approve-'+id).show();
            $('#btn-update-approve-'+id).show();
            $('#btn-approval-save-'+id).hide();
        }
    }

    function approval_save(id) {
        $("#bod-review-meeting-modal").modal('show');
        $("#bod-review-meeting-id").val(id);
        /*pnotifyConfirm('Are you sure want to preceed?', function() {
            $.ajax({
                url : '<?= base_url('procurement/arf/approval_save/'.$arf->id) ?>',
                type : 'post',
                data : {
                    id : id,
                    bod_review_meeting : $('[name="bod_review_meeting['+id+']"]:checked').val()
                },
                dataType : 'json',
                success : function(response) {
                    if (response.success) {
                        $('#btn-approve-'+id).remove();
                        $('#btn-approval-save-'+id).remove();
                        var bod_review_metting =  $('[name="bod_review_meeting['+id+']"]:checked').val();
                        if (bod_review_metting == '1') {
                            $('[data-m="bod_review_metting"]', $('#approval-'+id)).html('Required');
                        } else {
                            $('[data-m="bod_review_metting"]', $('#approval-'+id)).html('Not Required');
                        }
                        pnotifyAlert('Success', response.message, 'success', function() {
                            if ($('[data-button-type="approve"]').length == 0) {
                                document.location.href = '<?=  base_url('procurement/arf/approval') ?>';
                            }
                        });
                    }
                }
            });
        });*/
        /*var conf = confirm('Are you sure to save ARF no : <?= $arf->doc_no ?>');
        if (conf) {
            $.ajax({
                url : '<?= base_url('procurement/arf/approval_save/'.$arf->id) ?>',
                type : 'post',
                data : {
                    id : id,
                    bod_review_meeting : $('[name="bod_review_meeting['+id+']"]:checked').val()
                },
                dataType : 'json',
                success : function(response) {
                    if (response.success) {
                        $('#btn-approve-'+id).remove();
                        $('#btn-approval-save-'+id).remove();
                        var bod_review_metting =  $('[name="bod_review_meeting['+id+']"]:checked').val();
                        if (bod_review_metting == '1') {
                            $('[data-m="bod_review_metting"]', $('#approval-'+id)).html('Required');
                        } else {
                            $('[data-m="bod_review_metting"]', $('#approval-'+id)).html('Not Required');
                        }
                        if ($('[data-button-type="approve"]').length == 0) {
                            document.location.href = '<?=  base_url('procurement/arf/approval') ?>';
                        }
                    }
                }
            });
        } else {
            return false;
        }*/
    }
</script>