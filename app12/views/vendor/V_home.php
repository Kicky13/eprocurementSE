<script>
    $(document).ready(function() {
        $('.collapse').on('show.bs.collapse', function () {
            $(this).prev().css("height", "4em");
        });

        $('.collapse').on('hide.bs.collapse', function () {
            $(this).prev().css("height", "6em");
        });

    });
</script>
<link rel="stylesheet" type="text/css" href="<?=base_url('ast11')?>/app-assets/fonts/simple-line-icons/style.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom-home.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Selamat Datang", "Greetings") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Task</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <?php $this->load->view('V_message_section') ?>
            <?php $colors=['primary','warning','danger','success']; ?>
            <?php $counter_color = 0 ?>
            <?php foreach ($menu_task as $group_menu) { ?>
                <?php if (count($group_menu['menus']) <> 0) { ?>
                    <h4><?= lang($group_menu['desc_ind'], $group_menu['desc_eng']) ?></h4>
                    <div class="row">
                        <?php
                            $no = 0;
                            $row_type = 'odd';
                            $counter = 0;
                            $key = array();
                        ?>
                        <?php foreach ($group_menu['menus'] as $idx => $row) { ?>
                            <?php if (count($row['menus']) <> 0) { ?>
                                <div class="col-md-3">
                                    <a href="javascript:void(0)" class="subgroup-menu card" data-i="<?= $idx ?>">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="media d-flex">
                                                    <div class="align-self-center">
                                                        <i class="<?= $row['icon'] ?> <?= $colors[($counter_color%4)] ?> icons font-large-2 float-left"></i>
                                                    </div>
                                                    <div class="media-body text-right">
                                                        <span class="<?= $colors[($counter_color%4)] ?>"><?= lang($row['desc_ind'], $row['desc_eng']) ?> <?= ($row['count'] <> 0 ) ? '<span class="badge badge-danger">'.$row['count'].'</span>' : '' ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php $key[] = $idx ?>
                                <?php $counter++ ?>
                                <?php $no++ ?>
                                <?php if ($counter == 4 || $no == count($group_menu['menus'])) { ?>
                                    <?php foreach ($key as $k) { ?>
                                        <div data-i="<?= $k ?>" class="col-md-12 task-menu" style="display: none;">
                                            <div class="row">
                                            <?php if(isset($group_menu['menus'][$k]['menus'])) { ?>
                                                <?php foreach ($group_menu['menus'][$k]['menus'] as $menu) { ?>
                                                    <?php if (isset($msr_verify[$menu->key])) { ?>
                                                        <?php if ($menu->key == 'msr_draft') { ?>
                                                            <?php if(!isset($msr_verify[$menu->key]) || !can_edit_msr_draft()): ?>
                                                                <?php continue; ?>
                                                            <?php endif; ?>
                                                            <?php $task = $msr_verify[$menu->key]->num_rows() ?>
                                                        <?php } elseif ($menu->key == 'reject') { ?>
                                                            <?php $task = $msr_verify['reject']?>
                                                        <?php } else { ?>
                                                            <?php $task = $msr_verify[$menu->key] ?>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php $task = 0 ?>
                                                    <?php } ?>
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <div class="card-content">
                                                                <?php if($task > 0 || $menu->open_on_zero == 1): ?>
                                                                    <a href="<?= base_url($menu->url) ?>" data-toggle="tooltip" data-placement="top" title="<?= $menu->desc_eng ?>">
                                                                <?php else: ?>
                                                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="<?= $menu->desc_eng ?>">
                                                                <?php endif;?>
                                                                    <div class="media align-items-stretch">
                                                                        <div class="text-center" style="padding: 20px 0px 20px 20px;">
                                                                            <?= $task ?>
                                                                        </div>
                                                                        <div class="p-2 media-body menu-task-title">
                                                                            <?= lang($menu->desc_ind,  $menu->desc_eng) ?>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php $key = array() ?>
                                    <?php $counter = 0 ?>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <?php $counter_color++ ?>
                <?php } ?>
            <?php } ?>
            <!--<section id="configuration">
                <?php $this->load->view('V_message_section') ?>
                <div class="card">
                    <?php
                        $row_type = 'odd';
                        foreach ($menu_task as $row) { ?>
                        <?php if (count($row['menus']) <> 0) { ?>
                            <div class="card-header <?= $row_type ?>" style="border-bottom: 1px solid #f5f5f5; padding: 0px;">
                                <?php
                                    if($row_type == 'odd'){
                                        $row_type="even";
                                    }else{
                                        $row_type="odd";
                                    }
                                ?>
                                <a data-toggle="collapse" data-parent="#accordion-task" href="#<?= $row['key'] ?>" aria-expanded="false" aria-controls="<?= $row['key'] ?>" class="card-title lead collapsed" style="padding:15px ;display: block;"><i class="fa fa-chevron-up fa-fw"></i><i class="fa fa-chevron-down fa-fw"></i> <?= lang($row['desc_ind'], $row['desc_eng']) ?> <?= ($row['count'] <> 0 ) ? '<span class="badge badge-danger">'.$row['count'].'</span>' : '' ?></a>
                            </div>
                            <div id="<?= $row['key'] ?>" role="tabpanel" class="collapse">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <?php foreach ($row['menus'] as $menu) { ?>
                                                <?php if (isset($msr_verify[$menu->key])) { ?>
                                                    <?php if ($menu->key == 'msr_draft') { ?>
                                                        <?php if(isset($msr_verify[$menu->key]) && can_edit_msr_draft()): ?>
                                                        <div class="col-xl-3 col-lg-6 col-12">
                                                            <div class="card">
                                                                <div class="card-content">
                                                                    <a href="<?=base_url('procurement/msr/draftInquiry')?>">
                                                                        <div class="media align-items-stretch" style="height: 120px;">
                                                                            <div class="text-center bg-red bg-lighten-2" style="padding: 20px 0px 20px 20px;">
                                                                                <h5 class="text-bold-400 mb-0" style="color: #fff;"><i class="ft-arrow-up"></i> <?=$msr_verify[$menu->key]->num_rows()?></h5>
                                                                            </div>
                                                                            <div class="p-2 bg-red bg-lighten-2 white media-body">
                                                                                <h6><?= lang($menu->desc_ind,  $menu->desc_eng) ?></h6>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif;?>
                                                <?php } elseif ($menu->key == 'reject') { ?>
                                                    <div class="col-xl-3 col-lg-6 col-12">
                                                        <div class="card">
                                                            <div class="card-content">
                                                                <a href="<?=base_url($menu->url)?>">
                                                                    <div class="media align-items-stretch" style="height: 120px">
                                                                        <div class="text-center bg-red bg-lighten-2" style="padding: 20px 0px 20px 20px;">
                                                                            <h5 class="text-bold-400 mb-0" style="color: #fff;"><i class="ft-arrow-up"></i> <?=$msr_verify['reject']?></h5>
                                                                        </div>
                                                                        <div class="p-2 bg-red bg-lighten-2 white media-body">
                                                                            <h6><?= lang($menu->desc_ind,  $menu->desc_eng) ?></h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <?php
                                                    $task = $msr_verify[$menu->key];
                                                    ?>
                                                    <div class="col-xl-3 col-lg-6 col-12">
                                                        <div class="card">
                                                            <div class="card-content">
                                                                <?php if($task > 0 || $menu->open_on_zero == 1): ?>
                                                                    <a href="<?=base_url($menu->url)?>">
                                                                    <?php endif;?>
                                                                    <div class="media align-items-stretch" style="height: 120px;">
                                                                        <div class="text-center bg-red bg-lighten-2" style="padding: 20px 0px 20px 20px;">
                                                                            <h5 class="text-bold-400 mb-0" style="color: #fff;"><i class="ft-arrow-up"></i> <?=$task?></h5>
                                                                        </div>
                                                                        <div class="p-2 bg-red bg-lighten-2 white media-body">
                                                                            <h6><?= lang($menu->desc_ind,  $menu->desc_eng) ?></h6>
                                                                        </div>
                                                                    </div>
                                                                    <?php if($task > 0 || $menu->open_on_zero == 1): ?>
                                                                    </a>
                                                                <?php endif;?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <?php if (is_null($menu->key)) { ?>
                                                    <div class="col-xl-3 col-lg-6 col-12">
                                                        <div class="card">
                                                            <div class="card-content">
                                                                <div class="media align-items-stretch" style="height: 120px;">
                                                                    <div class="text-center bg-red bg-lighten-2" style="padding: 20px 0px 20px 20px;">
                                                                        <h5 class="text-bold-400 mb-0" style="color: #fff;"><i class="ft-arrow-up"></i> 0</h5>
                                                                    </div>
                                                                    <div class="p-2 bg-red bg-lighten-2 white media-body">
                                                                        <h6><?= lang($menu->desc_ind,  $menu->desc_eng) ?></h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>-->
        </section>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.subgroup-menu').click(function() {
            if ($(this).hasClass('active')) {
                $('.subgroup-menu.active').removeClass('active');
            } else {
                $('.subgroup-menu.active').removeClass('active');
                $(this).addClass('active');
            }
            var idx = $(this).data('i');
            showTask(idx);
        });
    });
    function showTask(i) {
        if ($('.task-menu[data-i="'+i+'"]').hasClass('active')) {
            $('.task-menu').removeClass('active').slideUp(200);
        } else {
            $('.task-menu').removeClass('active').slideUp(200);
            setTimeout(function() {
                $('.task-menu[data-i="'+i+'"]').addClass('active').slideDown();
            }, 200);
        }
    }
</script>