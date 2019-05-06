<?php $this->load->helper('global_helper'); ?>
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-1">
              <h3 class="content-header-title"><?= lang("Expiry Document", "Expiry Document") ?></h3>
          </div>
          <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
              <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="<?= base_url() ?>vn/info/greetings">Home</a></li>
                      <li class="breadcrumb-item active"><?= lang("Supplier Management", "Supplier Management") ?></li>
                      <li class="breadcrumb-item active"><?= lang("Expiry Document", "Expiry Document") ?></li>
                  </ol>
              </div>
          </div>
      </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-header">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <div class="heading-elements">
                                            <h5 class="title pull-right">

                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-content collapse show list_progress">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
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
                                                   foreach ($data_expiriy as $row) {
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
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $(".table_expired").DataTable();
  });
</script>
