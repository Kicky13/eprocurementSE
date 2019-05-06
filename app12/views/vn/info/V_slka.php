<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
            </div>
        </div>
        <div class="content-detached content-left">
            <div class="content-body">
                <section id="description">
                    <div class="card">
                        <div class="card-header" id="GENERAL1">
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="fa fa-expand"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content GENERAL1">
                            <div class="card-header text-center">
                                <h3 class="content-header-title mb-0"><?= lang("SLKA", "SLKA") ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <table>
                                                    <tr>
                                                        <td>To</td>
                                                        <td>: <?= $slka[0]["GEN"][0] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>NPWP</td>
                                                        <td>: <?= $slka[0]["GEN"][4] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Adress</td>
                                                        <td>: <?=  $slka[0]["GEN"][1] ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="tulisan">
                                                    <table>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fax No.</td>
                                                            <td>: <?= $slka[0]["GEN"][2] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><p>Phone No.</td>
                                                            <td>: <?= $slka[0]["GEN"][3]?></p></td>
                                                        </tr>
                                                    </table>
                                                    <br/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tulisan">
                                            <table>
                                                <tr>
                                                    <td><p>Subject</td>
                                                    <td>: Company’s Letter of Administration Qualification / Surat Lulus Kualifikasi Administrasi Perusahaan (SLKA)</p></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div id="open" class="tulisan">
                                                    <?= $slka[0]["GEN"][6]?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div id="close" class="tulisan">
                                                    <?= $slka[0]["GEN"][7]?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="text-left col-6" id="qr">
                                        <img id="qr_slka" style="max-width:150px" src="<?=base_url()?>vn/info/slka/get_qr" />
                                    </div>
                                    <div class="text-right col-6 mt-1">
                                        <div class="col-12 text-center mb-5">
                                            <p id="app_date">Jakarta, <?=$slka[0]["GEN"][8]?></p>
                                        </div>
                                        <div class="col-12 text-center"> Sally Edwina Prajoga</div>
                                        <div class="col-12 text-center"> Head of Performance & Support SCM</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>
        <?php
         $this->load->view('V_side_menu', $menu);
        ?>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        lang();
       // var elm=start($('#description').find('.card'));
       // $.ajax({
       //     type: "POST",
       //     url: "<?php echo site_url('vn/info/slka/get_qr'); ?>",
       //     cache: false,
       //     success: function (res)
       //     {
       //         stop(elm);
       //         $('#qr').html(res);
       //     },
       //     error: function (XMLHttpRequest, textStatus, errorThrown) {
       //         stop(elm);
       //         msg_danger("Gagal", "Oops,Terjadi kesalahan");
       //     }
       // });
       var id = '<?= $this->session->ID; ?>';
       $('#qr_slka').attr('src','<?=base_url()?>vendor/registered_supplier/get_qr/'+id);
    });
</script>
