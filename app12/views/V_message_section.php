<?php if (isset($message) && !empty($message['message'])): ?>

<div class="alert alert-dismissible alert-<?= @$message['type'] ?: 'success'?>" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<?php if (is_array($message['message'])): ?>
<ul>
  <li>
  <?= implode('</li><li>', $message['message']) ?>
  </li>
</ul>
<?php else: ?>
    <?= $message['message'] ?>
<?php endif; ?>
</div>
  
<?php endif; ?>

<?php if ($validation_errors = validation_errors('<li>', '</li>')): ?>

<div class="alert alert-dismissible alert-<?= @$message['type'] ?: 'success' ?>" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<?= '<ul>' . $validation_errors . '</ul>' ?>
</div>

<?php endif; ?>

<?php if ($this->session->flashdata('message')): ?>

<?php $message = $this->session->flashdata('message') ?>
<div class="alert alert-dismissible alert-<?= @$message['type'] ?: 'success'?>" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<?= $message['message'] ?>
</div>

<?php endif; ?>
