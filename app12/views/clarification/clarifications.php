<div id="clarifications-content" data-active-thread_id="<?= $thread_id ?>" data-active-user_id="<?= $user_id ?>">
    <div class="form-group text-right">
        <button type="button" class="btn btn-primary btn-sm" onclick="reply('<?= $thread_id ?>', '<?= $user_id ?>')"><i class="fa fa-reply"></i> Reply</button>
        <button type="button" class="btn btn-info btn-sm" onclick="get_clarification('<?= $thread_id ?>', '<?= $user_id ?>')"><i class="fa fa-refresh"></i> Refresh</button>
    </div>
    <?php foreach($rs_clarifications as $r_clarification) { ?>
        <h6 class="list-group-item-heading">
            <?= $r_clarification->created_by ?><br>
            <small><?= dateToIndo($r_clarification->created_at, false, true) ?></small>
        </h6>
        <p><?= nl2br($r_clarification->description) ?></p>
        <?php if ($r_clarification->attachment) { ?>
            <a href="<?= base_url('upload/CLARIFICATION/'.$r_clarification->attachment) ?>" target="_blank" class="btn btn-info btn-sm">Download</a>
        <?php } ?>
        <hr>
    <?php } ?>
</div>