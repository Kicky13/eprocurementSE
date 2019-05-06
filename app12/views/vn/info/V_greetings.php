<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">Greetings...</h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">

          </ol>
        </div>
      </div>
    </div>
    <?php $this->load->view('V_message_section') ?>
    <div class="row">
      <div class="col-md-12">
          <h4><?= lang("Supplier Management", "Supplier Management"); ?></h4>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/general_data')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="fa fa-file-o primary icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Supplier Data</b></h6>
                              <h5> &nbsp; </h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/document_expired')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-close danger icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Expiry Document</b></h6>
                              <?php
                                $un   = $this->vendor_lib->getDocExpired()->num_rows();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/document_expired')."'>" :  "<a href='".base_url('vn/info/document_expired')."'>";
                                $aend = $un > 0 ? "</a>" : "</a>";
                                if ($un<=0) {
                                  $un = "0";
                                }
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/supplier_account')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-user primary icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Supplier Account</b></h6>
                              <h5> &nbsp; </h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="#" class="card user_guide">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="fa fa-address-book primary icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>User Guide</b></h6>
                              <h5> &nbsp; </h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>


    </div>

    <div class="row">
      <div class="col-md-12">
          <h4><?= lang("Enquiry Document", "Enquiry Document"); ?></h4>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/greetings/list/0')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-close danger icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Unconfirmed Participation</b></h6>
                              <?php
                                $un   = $this->vendor_lib->greeting_list_uncorfimed()->num_rows();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/list/0')."'>" : "";
                                $aend = $un > 0 ? "</a>" : "";
                                // echo $a.$un.$aend;
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/greetings/list/1')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-check success icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Confirmed Participation</b></h6>
                              <h5>
                              <?php
                                $un   = $this->vendor_lib->greeting_list_confirmed()->num_rows();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/list/1')."'>" : "";
                                $aend = $un > 0 ? "</a>" : "";
                                echo '<span class="badge badge badge-info badge-pill float-right ">'.$un.'</span>';
                                $unread_message = $this->vendor_lib->count_unread_message(1);
                                if ($unread_message) {
                                  if ($unread_message->unread_message <> 0) {
                                    echo ' <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="'.$unread_message->unread_message.' Clarification"><i class="fa fa-bell fa-fw"></i> '.$unread_message->unread_message.'</span>';
                                  }
                                  if ($unread_message->addendum <> 0) {
                                    echo ' <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="'.$unread_message->addendum.' Addendum"><i class="fa fa-exclamation fa-fw"></i> '.$unread_message->addendum.'</span>';
                                  } else {
                                    echo '&nbsp;';
                                  }
                                }
                              ?>
                              </h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/greetings/list/10')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-close danger icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Decline Participation</b></h6>
                              <h5>
                              <?php
                                 $un   = $this->vendor_lib->greeting_list(10)->num_rows();
                                 $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/list/10')."'>" : "";
                                 $aend = $un > 0 ? "</a>" : "";

                                $unread_message = $this->vendor_lib->count_unread_message(10);
                                echo '<span class="badge badge badge-info badge-pill float-right ">'.$un.'</span>';

                                if ($unread_message) {
                                  if ($unread_message->unread_message <> 0) {
                                    echo ' <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="'.$unread_message->unread_message.' Clarification"><i class="fa fa-bell fa-fw"></i> '.$unread_message->unread_message.'</span>';
                                  }
                                  if ($unread_message->addendum <> 0) {
                                    echo ' <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="'.$unread_message->addendum.' Addendum"><i class="fa fa-exclamation fa-fw"></i> '.$unread_message->addendum.'</span>';
                                  }
                                } else {
                                  echo '&nbsp;';
                                }
                              ?>
                              </h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/greetings/list/11')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-doc primary icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Bid Proposal Submitted</b></h6>
                              <h5>
                              <?php
                              $un   = $this->vendor_lib->greeting_list(11)->num_rows();
                               $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/list/11')."'>" : "";
                               $aend = $un > 0 ? "</a>" : "";
                               echo '<span class="badge badge badge-info badge-pill float-right ">'.$un.'</span>';
                               $unread_message = $this->vendor_lib->count_unread_message(11);
                               if ($unread_message) {
                                if ($unread_message->unread_message <> 0) {
                                  echo ' <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="'.$unread_message->unread_message.' Clarification"><i class="fa fa-bell fa-fw"></i> '.$unread_message->unread_message.'</span>';
                                }
                                if ($unread_message->addendum <> 0) {
                                  echo ' <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="'.$unread_message->addendum.' Addendum"><i class="fa fa-exclamation fa-fw"></i> '.$unread_message->addendum.'</span>';
                                }
                              } else {
                                echo '%nbsp;';
                              }
                              ?>
                              </h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/greetings/negotiation')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-doc primary icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Negotiation</b></h6>
                              <?php
                                $un   = count($this->vendor_lib->get_negotiation('open'));
                                $a    = "<a href='".base_url('vn/info/greetings/negotiation')."'>";
                                $aend = "</a>";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12">
          <h4><?= lang("Award", "Award"); ?></h4>
      </div>

      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/greetings/loi')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-doc primary icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Letter of Intent</b></h6>
                              <?php
                                $un   = $this->vendor_lib->getIssuedLoI()->num_rows();
                                $a    = "<a href='".base_url('vn/info/greetings/loi')."'>" ;
                                $aend = "</a>";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/greetings/agreement')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-doc primary icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Agreement</b></h6>
                              <?php
                                $un   = $this->vendor_lib->getToBeCompletedByVendor()->num_rows();
                                $a    = "<a href='".base_url('vn/info/greetings/agreement')."'>";
                                $aend = "</a>";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/greetings/award/1')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-doc primary icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Acceptance Award Nomination</b></h6>
                              <?php
                                $un   = $this->vendor_lib->accept_award_nomination(1)->num_rows();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/award/1')."'>" : "";
                                $aend = $un > 0 ? "</a>" : "";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/greetings/regretLetterList')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-bell warning icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Regret Letter Notification</b></h6>
                              <?php
                                $un   = $this->M_regret_letter->vendorInquiry($this->session->userdata('ID'), ['resource' => true])->num_rows();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/regretLetterList')."'>" : "";
                                $aend = $un > 0 ? "</a>" : "";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12">
          <h4><?= lang("Amendment", "Amendment"); ?></h4>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/arf_notification')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-bell warning icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Amendment Notification</b></h6>
                              <?php
                                $un   = $this->m_arf_notification->view('arf_notification')->scope(array('auth_vendor', 'unresponse'))->count_all_results();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/arf_notification')."'>" : "";
                                $aend = $un > 0 ? "</a>" : "";
                                // echo $a.$un.$aend;
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/amendment_acceptance')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-check success icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Acceptance Amendment</b></h6>
                              <?php
                                $un   = $this->T_approval_arf_recom->arf_response_done()->num_rows();
                                $a    = "<a href='".base_url('vn/info/amendment_acceptance')."'>";
                                $aend = "</a>";
                                // echo $a.$un.$aend;
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <!-- <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/greetings/acceptance_amendment')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-check success icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Amendment Agreement</b></h6>
                              <?php
                                $un   = $this->vendor_lib->acceptanceAmendment()->num_rows();
                                $a    = "<a href='".base_url('vn/info/greetings/acceptance_amendment')."'>";
                                $aend = "</a>";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div> -->
      <!--<div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/arf_notification/closed')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-close danger icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Decline Participation</b></h6>
                              <?php
                                $un   = $this->m_arf_notification->view('arf_notification')->scope(array('auth_vendor', 'unresponse', 'close'))->count_all_results();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/arf_notification/closed')."'>" : "";
                                $aend = $un > 0 ? "</a>" : "";
                                // echo $a.$un.$aend;
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>-->
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/arf_notification/submitted')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-check success icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Accepted</b></h6>
                              <?php
                                $un   = $this->m_arf_notification->view('arf_notification')->scope(array('auth_vendor', 'responsed'))->count_all_results();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/arf_notification/submitted')."'>" : "";
                                $aend = $un > 0 ? "</a>" : "";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <!-- <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/arf_notification/closed')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-close success icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Rejected</b></h6>
                              <?php
                                $un   = $this->m_arf_notification->view('arf_notification')->scope(array('auth_vendor', 'unresponse', 'close'))->count_all_results();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/arf_notification/closed')."'>" : "";
                                $aend = $un > 0 ? "</a>" : "";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div> -->

      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/negotiation_amendment')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-check danger icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>Negotiation Amendent</b></h6>
                              <?php
                                $un   = $this->m_arf_nego->with_vendor()->num_rows();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/negotiation_amendment')."'>" : "";
                                $aend = $un > 0 ? "</a>" : "";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12">
          <h4><?= lang("Agreement Excecution", "Agreement Excecution"); ?></h4>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/perform_itp/itp_acceptance')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-check success icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>ITP Acceptance</b></h6>
                              <?php
                                $un   = $this->vendor_lib->getITPSession()->num_rows();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/perform_itp/itp_acceptance')."'>" :  "<a href='".base_url('vn/info/perform_itp/itp_acceptance')."'>";
                                $aend = $un > 0 ? "</a>" : "</a>";
                                if ($un<=0) {
                                  $un = "0";
                                }
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/perform_itp/itp_accepted')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-check success icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>ITP Accepted</b></h6>
                              <?php
                                $un   = $this->vendor_lib->getITPSessionAccepted()->num_rows();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/perform_itp/itp_accepted')."'>" :  "<a href='".base_url('vn/info/perform_itp/itp_accepted')."'>";
                                $aend = $un > 0 ? "</a>" : "</a>";
                                if ($un<=0) {
                                  $un = "0";
                                }
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/service_receipt/acceptance')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-check success icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>SR Acceptance</b></h6>
                              <?php
                                $un   = $this->m_service_receipt->view('service_receipt')->scope(array('approval_completed', 'auth_vendor', 'unaccepted'))->count_all_results();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/service_receipt/acceptance')."'>" :  "";
                                $aend = $un > 0 ? "</a>" : "";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/service_receipt/accepted')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-check success icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>SR Accepted</b></h6>
                              <?php
                                $un   = $this->m_service_receipt->view('service_receipt')->scope(array('approval_completed', 'auth_vendor', 'accepted'))->count_all_results();
                                $a    = $un > 0 ? "<a href='".base_url('vn/info/service_receipt/accepted')."'>" :  "";
                                $aend = $un > 0 ? "</a>" : "";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>

    </div>

    <div class="row">
      <div class="col-md-12">
          <h4><?= lang("Contractor Performance Management", "Contractor Performance Management"); ?></h4>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/cpm_scoring/')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-doc primary icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>CPM Scoring</b></h6>
                              <?php
                                $list = $this->vendor_lib->get_cpm_list();
                                $dt = $list->result();
                                $un = 0;
                                $un = count($dt);
                                $a = empty($dt[0]->po) ? "" : "<a href='".base_url('vn/info/cpm_scoring/')."'>";
                                $aend = empty($dt[0]->po) ? "" : "</a>";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>
      <div class="col-xl-3 col-lg-6 col-12">
          <a href="<?= base_url('vn/info/cpm_acceptance/')?>" class="card">
              <div class="card-content">
                  <div class="card-body">
                      <div class="media d-flex">
                          <div class="align-self-center">
                              <i class="icon-check success icons font-large-3 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                              <h6><b>CPM Acceptance</b></h6>
                              <?php
                                $list = $this->vendor_lib->get_cpm_accepted();
                                $dt = $list->result();
                                $un = count($dt);
                                $a = empty($dt[0]->po) ? "" : "<a href='".base_url('vn/info/cpm_acceptance/')."'>";
                                $aend = empty($dt[0]->po) ? "" : "</a>";
                              ?>
                              <h5><span class="badge badge badge-info badge-pill float-right "><?= $un; ?></span></h5>
                          </div>
                      </div>
                  </div>
              </div>
          </a>
      </div>

    </div>

  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $(".user_guide").on('click', function(e){
      e.preventDefault();  //stop the browser from following
      swal({
        title: "User Guide",
        text: "Continue to download User Guide ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Yes",
        closeOnConfirm: true
      },function () {
        $.ajax({
          url: '<?= base_url('vn/info/user_guide/get_user_guide')?>',
          type: 'POST',
          dataType: 'JSON',
          data: {param: ''},
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function(res) {
          window.location.href = '<?= base_url('upload/')?>'+res.file;
        });

      })
    })
  });
</script>

<!-- <div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">Greetings...</h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">

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
              </div>
              <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table class="table table-condensed table-striped">
                          <thead>
                            <tr>
                              <th>EVENT</th>
                              <th>DETAIL</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th>Supplier - General Data</th>
                              <th>
                                <a href="<?= base_url('vn/info/general_data')?>">View More</a>
                              </th>
                            </tr>
                            <tr>
                              <th>Amendment Acceptance</th>
                              <th>
                                <?php
                                  $un   = $this->m_arf_recommendation_preparation->view('amendment_recommendation')->scope(array('auth_vendor', 'unresponse'))->count_all_results();
                                  $a    = "<a href='".base_url('vn/info/amendment_acceptance')."'>";
                                  $aend = "</a>";
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Amendment Notification</th>
                              <th>
                                <?php
                                  $un   = $this->m_arf_notification->view('arf_notification')->scope(array('auth_vendor', 'unresponse', 'open'))->count_all_results();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/arf_notification')."'>" : "";
                                  $aend = $un > 0 ? "</a>" : "";
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Enquiry Document - Unconfirmed Participation</th>
                              <th>
                                <?php
                                  $un   = $this->vendor_lib->greeting_list_uncorfimed()->num_rows();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/list/0')."'>" : "";
                                  $aend = $un > 0 ? "</a>" : "";
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Enquiry Document - Confirmed Participation</th>
                              <th>
                                <?php
                                  $un   = $this->vendor_lib->greeting_list_confirmed()->num_rows();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/list/1')."'>" : "";
                                  $aend = $un > 0 ? "</a>" : "";
                                  echo $a.$un.$aend;
                                  $unread_message = $this->vendor_lib->count_unread_message(1);
                                  if ($unread_message) {
                                    if ($unread_message->unread_message <> 0) {
                                      echo ' <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="'.$unread_message->unread_message.' Clarification"><i class="fa fa-bell fa-fw"></i> '.$unread_message->unread_message.'</span>';
                                    }
                                    if ($unread_message->addendum <> 0) {
                                      echo ' <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="'.$unread_message->addendum.' Addendum"><i class="fa fa-exclamation fa-fw"></i> '.$unread_message->addendum.'</span>';
                                    }
                                  }
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Enquiry Document - Decline Participation</th>
                              <th>
                                <?php
                                  $un   = $this->vendor_lib->greeting_list(10)->num_rows();
                                   $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/list/10')."'>" : "";
                                   $aend = $un > 0 ? "</a>" : "";
                                   echo $a.$un.$aend;
                                  // $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/list/2')."'>" : "";
                                  // $aend = $un > 0 ? "</a>" : "";
                                  // echo $a.$un.$aend;
                                  $unread_message = $this->vendor_lib->count_unread_message(10);
                                  if ($unread_message) {
                                    if ($unread_message->unread_message <> 0) {
                                      echo ' <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="'.$unread_message->unread_message.' Clarification"><i class="fa fa-bell fa-fw"></i> '.$unread_message->unread_message.'</span>';
                                    }
                                    if ($unread_message->addendum <> 0) {
                                      echo ' <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="'.$unread_message->addendum.' Addendum"><i class="fa fa-exclamation fa-fw"></i> '.$unread_message->addendum.'</span>';
                                    }
                                  }
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Amendment Notification - Unconfirmed</th>
                              <th>
                                <?php
                                  $un   = $this->m_arf_notification->view('arf_notification')->scope(array('auth_vendor', 'unresponse', 'close'))->count_all_results();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/arf_notification/closed')."'>" : "";
                                  $aend = $un > 0 ? "</a>" : "";
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Amendment Notification - Accepted</th>
                              <th>
                                <?php
                                  $un   = $this->m_arf_notification->view('arf_notification')->scope(array('auth_vendor', 'responsed'))->count_all_results();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/arf_notification/submitted')."'>" : "";
                                  $aend = $un > 0 ? "</a>" : "";
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Amendment Notification - Rejected</th>
                              <th>
                                <?php
                                  $un   = $this->m_arf_notification->view('arf_notification')->scope(array('auth_vendor', 'unresponse', 'close'))->count_all_results();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/arf_notification/closed')."'>" : "";
                                  $aend = $un > 0 ? "</a>" : "";
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Bid Submitted</th>
                              <th>
                                <?php
                                  $un   = $this->vendor_lib->greeting_list(11)->num_rows();
                                   $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/list/11')."'>" : "";
                                   $aend = $un > 0 ? "</a>" : "";
                                   echo $a.$un.$aend;
                                   $unread_message = $this->vendor_lib->count_unread_message(11);
                                   if ($unread_message) {
                                    if ($unread_message->unread_message <> 0) {
                                      echo ' <span class="badge badge-warning" data-toggle="tooltip" data-placement="top" title="'.$unread_message->unread_message.' Clarification"><i class="fa fa-bell fa-fw"></i> '.$unread_message->unread_message.'</span>';
                                    }
                                    if ($unread_message->addendum <> 0) {
                                      echo ' <span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="'.$unread_message->addendum.' Addendum"><i class="fa fa-exclamation fa-fw"></i> '.$unread_message->addendum.'</span>';
                                    }
                                   }
                                  // $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/list/2')."'>" : "";
                                  // $aend = $un > 0 ? "</a>" : "";
                                  // echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Negotiation</th>
                              <th>
                                <?php
                                  $un   = count($this->vendor_lib->get_negotiation('open'));
                                  $a    = "<a href='".base_url('vn/info/greetings/negotiation')."'>";
                                  $aend = "</a>";
                                  echo $a.$un.$aend;
                                ?>
                            </tr>
                            <tr>
                              <th>ITP Acceptance</th>
                              <th>
                                <?php
                                  $un   = $this->vendor_lib->getITPSession()->num_rows();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/perform_itp/itp_acceptance')."'>" :  "<a href='".base_url('vn/info/perform_itp/itp_acceptance')."'>";
                                  $aend = $un > 0 ? "</a>" : "</a>";
                                  if ($un<=0) {
                                    $un = "Show Detail";
                                  }
                                  echo $a.$un.$aend;
                                ?>
                            </tr>
                            <tr>
                              <th>ITP Accepted</th>
                              <th>
                                <?php
                                  $un   = $this->vendor_lib->getITPSessionAccepted()->num_rows();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/perform_itp/itp_accepted')."'>" :  "<a href='".base_url('vn/info/perform_itp/itp_accepted')."'>";
                                  $aend = $un > 0 ? "</a>" : "</a>";
                                  if ($un<=0) {
                                    $un = "Show Detail";
                                  }
                                  echo $a.$un.$aend;
                                ?>
                            </tr>
                            <tr>
                              <th>SR Acceptance</th>
                              <th>
                                <?php
                                  $un   = $this->m_service_receipt->view('service_receipt')->scope(array('approval_completed', 'auth_vendor', 'unaccepted'))->count_all_results();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/service_receipt/acceptance')."'>" :  "";
                                  $aend = $un > 0 ? "</a>" : "";
                                  echo $a.$un.$aend;
                                ?>
                            </tr>
                            <tr>
                              <th>SR Accepted</th>
                              <th>
                                <?php
                                  $un   = $this->m_service_receipt->view('service_receipt')->scope(array('approval_completed', 'auth_vendor', 'accepted'))->count_all_results();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/service_receipt/accepted')."'>" :  "";
                                  $aend = $un > 0 ? "</a>" : "";
                                  echo $a.$un.$aend;
                                ?>
                            </tr>
                            </tr>
                            <tr>
                              <?php
                                $list = $this->vendor_lib->get_cpm_list();
                                $dt = $list->result();
                                $un = 0;
                                $un = count($dt);
                                $a = empty($dt[0]->po) ? "" : "<a href='".base_url('vn/info/cpm_scoring/')."'>";
                                $aend = empty($dt[0]->po) ? "" : "</a>";
                              ?>
                              <th><?= $a."CPM Scoring".$aend ?></th>
                              <th>
                                <?php
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <?php
                                $list = $this->vendor_lib->get_cpm_accepted();
                                $dt = $list->result();
                                $un = count($dt);
                                $a = empty($dt[0]->po) ? "" : "<a href='".base_url('vn/info/cpm_acceptance/')."'>";
                                $aend = empty($dt[0]->po) ? "" : "</a>";
                              ?>
                              <th><?= $a."CPM Acceptance".$aend ?></th>
                              <th>
                                <?php
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Acceptance Award Nomination</th>
                              <th>
                                <?php
                                  $un   = $this->vendor_lib->accept_award_nomination(1)->num_rows();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/award/1')."'>" : "";
                                  $aend = $un > 0 ? "</a>" : "";
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Regret Letter Notification</th>
                              <th>
                                <?php
                                  $un   = $this->M_regret_letter->vendorInquiry($this->session->userdata('ID'), ['resource' => true])->num_rows();
                                  $a    = $un > 0 ? "<a href='".base_url('vn/info/greetings/regretLetterList')."'>" : "";
                                  $aend = $un > 0 ? "</a>" : "";
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>

                            <tr>
                              <th>Letter of Intent</th>
                              <th>
                                <?php
                                  $un   = $this->vendor_lib->getIssuedLoI()->num_rows();
                                  $a    = "<a href='".base_url('vn/info/greetings/loi')."'>" ;
                                  $aend = "</a>";
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Agreement</th>
                              <th>
                                <?php
                                  $un   = $this->vendor_lib->getToBeCompletedByVendor()->num_rows();
                                  $a    = "<a href='".base_url('vn/info/greetings/agreement')."'>";
                                  $aend = "</a>";
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                            <tr>
                              <th>Acceptance Amendment</th>
                              <th>
                                <?php
                                  $un   = $this->vendor_lib->acceptanceAmendment()->num_rows();
                                  $a    = "<a href='".base_url('vn/info/greetings/acceptance_amendment')."'>";
                                  $aend = "</a>";
                                  echo $a.$un.$aend;
                                ?>
                              </th>
                            </tr>
                          </tbody>
                        </table>
                      </div>
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
</div> -->
