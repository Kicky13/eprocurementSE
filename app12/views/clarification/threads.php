<?php foreach ($rs_threads as $r_thread) { ?>
    <a href="#" class="list-group-item list-group-item-action border-0" data-thread_id="<?= $r_thread->id ?>" data-open="<?= $r_thread->open ?>" onclick="get_users('<?= $r_thread->id ?>')">
        <?= $r_thread->thread ?>
        <?php if ($r_thread->notification) { ?>
            <span class="badge badge-danger"><?= $r_thread->notification ?></span>
        <?php } ?>
        <?php if (!$r_thread->open) { ?>
            <span class="badge badge-secondary pull-right"><i class="fa fa-lock"></i></span>
        <?php } ?>
    </a>
<?php } ?>

<script>
    $('.list-group-item', $('#threads-list')).click(function() {
        $('.active', $('#threads-list')).removeClass('active');
        $(this).addClass('active');
        active_thread_id = $(this).data('thread_id');
    });
</script>