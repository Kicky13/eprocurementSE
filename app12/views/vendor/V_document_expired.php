<?php $this->load->helper('global_helper'); ?>
<table class="table table_expired" style="font-size: 12px;">
    <thead>
        <tr>
            <th>No</th>
            <th>Document Type</th>
            <th>Document No</th>
            <th>Issued Date</th>
            <th>Expiry Date</th>
            <th>Status</th>
            <th>Last Email Sent</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
         foreach ($result as $row) {

          ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row->CATEGORY ?></td>
                <td><?= $row->NO_DOC ?></td>
                <td><?= dateToIndo($row->VALID_SINCE) ?></td>
                <td><?= dateToIndo($row->VALID_UNTIL) ?></td>
                <td><?= $row->STATUS_DOCUMENT ?></td>
                <td><?php if(!empty($row->last_sent_email)){ echo dateToIndo($row->last_sent_email); } else { echo '-'; } ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script type="text/javascript">
  $(document).ready(function() {
    $(".table_expired").DataTable();
  });
</script>
