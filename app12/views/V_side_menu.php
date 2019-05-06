<div class="sidebar-detached sidebar-right sidebar-sticky">
    <div class="sidebar">
        <div class="sidebar-content card d-none d-lg-block">
            <div class="card-title">
                <div class="col-12">
                    <h6 class="pt-1">
                        Menu
                    </h6>
                </div>
                <div class="col-12">
                <span class="form-group row pull-right">
                    <div class="col-5 verif_rej" style="padding-right:0px">
                        <button id="rej_list" class="nav-link btn btn-primary mr-1 mt-1 white verif_rej" onclick='list_rejected()'><?=lang("List Revisi","Rev. List")?></button>
                    </div>
                    <div class="col-5 update-btn">
                        <button class="nav-link btn btn-primary mr-1 mt-1 white update-btn" onclick='update_data()'>Update Data</button>
                    </div>
                    <div class="col-5 checklist">
                        <button class="nav-link btn btn-success mr-1 mt-1 white" onclick='check_list()'>Checklist</button>
                    </div>

                </span>
                </div>
            </div>
            <div class="card-body">

                <hr>
                <div class="list-group">
                    <?php
                    $url = strtolower($_SERVER['PATH_INFO']);
                    $arr_url = explode("/", $url);
                    $url_min1 = str_replace("#", "", substr($url, 1));
                    // echopre($menu[0]);
                    // foreach ($menu[0] as $k => $v) {
                        //  echopre($menu[$k]);
                        foreach ($menu[1] as $kk => $vv) {

                            $active = "";
                            if ($vv['URL'] == $url_min1) {
                                $active = "active";
                            }
                            echo '<a href="' . base_url($vv['URL']) . '">
                                        <button type="button" class="list-group-item list-group-item-action ' . $active . '" id="'.strtolower($vv["DESKRIPSI_IND"]).'">
                                            <span class="IDN">' . $vv["DESKRIPSI_IND"] . '</span>
                                            <span class="ENG">' . $vv["DESKRIPSI_ENG"] . '</span>
                                        </button>
                                    </a>';
                        }
                    //  }
                    ?>
                    <!--                        <a href="index.php"><button type="button" class="list-group-item list-group-item-action active">Cras justo odio</button></a>
                                            <button type="button" class="list-group-item list-group-item-action">Dapibus ac facilisis in</button>-->
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>
</div>
