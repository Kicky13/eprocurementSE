<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>
<script src="<?= base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
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
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div id="clarification-wrapper" class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" id="btn-compose" class="btn btn-danger btn-block mb-1"><i class="fa fa-envelope"></i> Compose</button>
                                        <fieldset class="form-group position-relative has-icon-left m-0 pb-1">
                                            <input type="text" class="form-control" id="search-thread" placeholder="Search thread">
                                            <div class="form-control-position">
                                                <i class="fa fa-search"></i>
                                            </div>
                                        </fieldset>
                                        <div id="threads-list" class="list-group list-group-messages mb-1" style="overflow-y: auto; font-size: 14px;"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="users-list" class="list-group" style="overflow-y: auto; overflow-x: hidden;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="clarifications-list" style="overflow-y: auto; overflow-x: hidden;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-compose" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Compose Clarification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-compose">
                    <input type="hidden" name="thread_id" id="thread_id">
                    <div class="form-group">
                        <label>To</label>
                        <select name="to[]" id="to" class="form-control" style="width: 100%;" data-placeholder="Send to all" multiple></select>
                    </div>
                    <div class="form-group">
                        <textarea name="message" id="message" class="form-control" placeholder="Type your message here..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Attachment</label><br>
                        <input type="file" name="attachment" id="attachment">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="send()">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
    var active_thread_id;
    var active_user_thread_id;

    $(function() {
        $('#to').select2();
        $('#modal-compose').on('hidden.bs.modal', function() {
            $('#error-message', $('#form-compose')).remove();
            $('#to').val('').change();
            $('#message').val('');
            $('#attachment').val('');
        });

        $('#btn-compose').click(function() {
            compose();
        });

        $('#search-thread').keyup(function() {
            get_threads();
        });

        get_threads();
        $('#clarification-wrapper').css('height', $(window).height() - 210);
        $('#threads-list').css('max-height', $('#clarification-wrapper').height() - 120);
        $('#users-list').css('max-height', $('#clarification-wrapper').height());
        $('#clarifications-list').css('max-height', $('#clarification-wrapper').height());
    });

    function get_threads() {
        $.ajax({
            url: '<?= base_url('clarification/get_threads') ?>?module_kode=<?= $module_kode ?>&search='+$('#search-thread').val(),
            success : function(response) {
                $('#threads-list').html(response);
                $('[data-thread_id="'+active_thread_id+'"]').addClass('active');
            }
        })
    }

    function get_users(thread_id) {
        $('#thread_id').val(thread_id);
        $.ajax({
            url: '<?= base_url('clarification/get_users') ?>?module_kode=<?= $module_kode ?>&thread_id='+thread_id,
            success : function(response) {
                $('#users-list').html(response);
                $('#clarifications-list').html('');
                $('[data-user_thread_id="'+active_user_thread_id+'"]').addClass('border-right-success');
            }
        });

        $.ajax({
            url: '<?= base_url('clarification/get_users_json') ?>?module_kode=<?= $module_kode ?>&thread_id='+thread_id,
            dataType : 'json',
            success : function(response) {
                var data = [];
                $.each(response, function(i, row) {
                    data[i] = {
                        id : row.id,
                        text : row.name
                    }
                });
                $('#to').html('').select2({
                    data : data
                }).trigger('change');
            }
        });
    }

    function get_clarification(thread_id, user_id) {
        $.ajax({
            url: '<?= base_url('clarification/get_clarifications') ?>?module_kode=<?= $module_kode ?>&thread_id='+thread_id+'&user_id='+user_id,
            success : function(response) {
                $('#clarifications-list').html(response);
                get_threads(active_thread_id);
            }
        });
    }

    function compose() {
        if (!active_thread_id) {
            setTimeout(function() {
                swal('<?= __('warning') ?>', 'You have to selected thread', 'warning');
                return false;
            }, swalDelay)
        }
        if ($('[data-thread_id="'+active_thread_id+'"').data('open') == '0') {
            setTimeout(function() {
                swal('<?= __('warning') ?>', 'This thread has been closed', 'warning');
            }, swalDelay);
            return false;
        }
        $('#modal-compose').modal('show');
    }

    function reply(thread_id, user_id) {
        $('#thread_id').val(thread_id);
        $('#to').val([user_id]).change();
        compose();
    }

    function send() {
        swalConfirm('Clarification', '<?= __('confirm_submit') ?>', function() {
            $('#error-message', $('#form-compose')).remove();
            var form = $('#form-compose')[0];
            var formData = new FormData(form);
            $.ajax({
                url: '<?= base_url('clarification/send') ?>?module_kode=<?= $module_kode ?>',
                type: 'post',
                data: formData,
                enctype:'multipart/form-data',
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        setTimeout(function() {
                            swal('Done', response.message, 'success');
                            $('#modal-compose').modal('hide');
                            if ($('#clarifications-content')) {
                                var thread_id = $('#clarifications-content').data('thread_id');
                                var user_id = $('#clarifications-content').data('user_id');
                                get_clarifications(thread_id, user_id);
                            }
                        }, swalDelay);
                    } else {
                        $('#form-compose').prepend('<div id="error-message" class="alert alert-danger">'+response.message+'</div>');
                    }
                }
            });
        });
    }
</script>