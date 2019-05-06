<?php foreach ($rs_users as $r_user) { ?>
    <a href="#" style="color: #666; border-bottom: 1px solid #CCC;" class="media mb-1 border-right-3" data-user_thread_id="<?= $thread_id.'-'.$r_user->id ?>" data-user_id="<?= $r_user->id ?>" onclick="get_clarification('<?= $thread_id ?>', '<?= $r_user->id ?>')">
        <div class="media-body">
            <h6 class="list-group-item-heading text-bold-500">
                <?= $r_user->name ?>
                <span class="float-right">
                    <?php if ($r_user->notification) { ?>
                        <span class="badge badge-danger mr-1"><?= $r_user->notification ?></span> <i class="font-medium-1 ft-star blue-grey lighten-3"></i>
                    <?php } ?>
                </span>
            </h6>
            <p><small><?= $r_user->username ?></small></p>
        </div>
    </a>
<?php } ?>
<script>
    $('.media', $('#users-list')).click(function() {
        $('.border-right-success', $('#users-list')).removeClass('border-right-success');
        $(this).addClass('border-right-success');
        $('.badge', this).remove();
        active_user_thread_id = $(this).data('user_thread_id');
    });
</script>