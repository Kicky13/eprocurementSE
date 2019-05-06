<?php if ($this->session->flashdata('success_message')) { ?>
    <div class="alert alert-success"><h4><?= $this->session->flashdata('success_message') ?></h4></div>
<?php } ?>
<?php if ($this->session->flashdata('error_message')) { ?>
    <div class="alert alert-danger"><h4><?= $this->session->flashdata('error_message') ?></h4></div>
<?php } ?>