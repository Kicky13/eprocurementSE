<div class="content-header row">
    <div class="content-header-left col-md-6 mb-1">
        <?php if (isset($title)) { ?>
            <h3 class="content-header-title"><?= @$title ?></h3>
        <?php } else { ?>
            <h3 class="content-header-title">Welcome to Supreme Energy Dashboard</h3>
        <?php } ?>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 mb-1">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <?php if (isset($title)) { ?>
                    <li class="breadcrumb-item"><?= $title ?></li>
                <?php } ?>
            </ol>
        </div>
    </div>
</div>
<?php if (isset($dashboard_menu)) { ?>
    <div id="dashboard-menu" class="content-body">
        <div class="row">
            <?php
                $tamp=-1;
                $colors=['primary','warning','danger','success'];
                $count=0;
                if (isset($dashboard_menu[0])) {
                    foreach($dashboard_menu[0] as $k => $v) {
                        echo'<div class="col-md-12 mb-1">
                            <h4><span class="IDN">'.$v["DESCRIPTION_IND"].'</span><span class="ENG">'.$v["DESCRIPTION_ENG"].'</span></h4>
                        </div>';
                        if (isset($dashboard_menu[$k])) {
                            foreach($dashboard_menu[$k] as $k2 => $v2){
                                echo '<div class="col-xl-3 col-lg-6 col-12">
                                    <a href="'.base_url($v2["URL"]).'" class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media d-flex">
                                                    <div class="align-self-center">
                                                        <i class="'.$v2["ICON"].' '.$colors[$count].' icons font-large-2 float-left"></i>
                                                    </div>
                                                    <div class="media-body text-right">
                                                        <span class="IDN">'.$v2["DESCRIPTION_IND"].'</span><span class="ENG">'.$v2["DESCRIPTION_ENG"].'</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>';
                                $count++;
                                if($count>3)
                                    $count=0;
                            }
                        }
                    }
                }
            ?>
        </div>
    </div>
<?php } ?>