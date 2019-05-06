<link rel="stylesheet" type="text/css" href="<?=base_url('ast11')?>/app-assets/fonts/simple-line-icons/style.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= lang("Selamat Datang", "Greetings") ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
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
                    <div class="col-xl-3 col-lg-6 col-12">
                      <div class="card">
                        <div class="card-content">
                          <a href="<?=base_url('approval/approval/mylist')?>">
                            <div class="media align-items-stretch">
                              <div class="p-2 text-center bg-success bg-darken-2">
                                <i class="icon-directions font-large-2 white"></i>
                              </div>
                              <div class="p-2 bg-gradient-x-success white media-body">
                                <h6>MSR to be Approve</h6>
                                <h5 class="text-bold-400 mb-0"><i class="ft-arrow-up"></i> <?=$greetings->num_rows()?></h5>
                              </div>
                            </div>
                          </a>
                        </div>
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
</div>