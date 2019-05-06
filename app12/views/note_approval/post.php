<h2>Post Note</h2>
<form id="form-note">
    <div class="form-group">
        <?= $this->form->textarea('description', null, 'id="form-note-description" class="form-control" placeholder="Enter your note here..."') ?>
    </div>
    <div class="form-group text-right">
        <button type="button" id="btn-post" class="btn btn-success">Post</button>
    </div>
</div>

<script>
    $(function() {        
        $('#btn-post').click(function() {
            $('#btn-post').prop('disabled', true);
            $.ajax({
                url : '<?= base_url('note_approval/note/store/'.$module_kode.'/'.$data_id) ?>',
                type : 'post',
                data : $('#form-note').serialize(),                
                success : function(response) {
                    if (response.success) {
                        $('#form-note-description').val('');
                        getNoteList();
                    }
                    alert(response.message);                    
                }                
            }).done(function() {
                $('#btn-post').prop('disabled', false);
            });
        });        
    });

    function 
    getNoteList() {
        $.ajax({
            url : '<?= base_url('note_approval/note/get/'.$module_kode.'/'.$data_id) ?>',
            success : function(response) {
                $('#note-list').html(response);
            }
        })
    }
</script>