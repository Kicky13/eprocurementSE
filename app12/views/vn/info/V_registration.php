<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Supreme Energy</title>
        <link rel="shortcut icon" href="<?= base_url() ?>ast11/img/supreme.png" />
        <link href="<?= base_url() ?>ast11/css/bootstrap.min.css" rel="stylesheet">                
        <link href="<?= base_url() ?>ast11/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?= base_url() ?>ast11/css/plugins/chosen/chosen.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/plugins/dataTables/dataTables.bootstrap.min.css"/>        
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/plugins/dataTables/fixedColumns.bootstrap.min.css"/>        
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/plugins/dataTables/jquery.dataTables.min.css"/>                
        <link href="<?= base_url() ?>ast11/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
        <link href="<?= base_url() ?>ast11/css/animate.css" rel="stylesheet">
        <link href="<?= base_url() ?>ast11/css/style.css" rel="stylesheet">
        <link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
        <link href="<?= base_url() ?>ast11/css/plugins/toastr/toastr.min.css" rel="stylesheet">        
        <style>
            th, td { white-space: nowrap; }
            div.dataTables_wrapper {
                width: 100%;
                margin: 0 auto;
            }                     

            .note-editable{
                height:300px;
            }
            label{
                font-weight:500px;
            }    
            .number{
                display:none;
            }
            .wizard-big.wizard > .content{
                min-height:600px;
                overflow:auto;
            }
            .form-label,span{
                font-weight:500;
            }

        </style>

        <!-- Mainly scripts -->
        <script src="<?= base_url() ?>ast11/js/jquery-2.1.1.js"></script>        
        <script src="<?= base_url() ?>ast11/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>ast11/js/plugins/dataTables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>ast11/js/plugins/dataTables/dataTables.bootstrap.min.js"></script>        

        <script type="text/javascript" src="<?= base_url() ?>ast11/js/plugins/dataTables/dataTables.fixedColumns.min.js"></script>        
        <script src="<?= base_url() ?>ast11/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/chosen/chosen.jquery.js"></script>        
        <!-- Custom and plugin javascript -->
        <script src="<?= base_url() ?>ast11/js/inspinia.js"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/pace/pace.min.js"></script>

        <!-- jQuery UI -->
        <script src="<?= base_url() ?>ast11/js/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/datapicker/bootstrap-datepicker.js"></script>        
        <script>
            function lang() {
                $('.ENG').hide();
            }
            lang();
        </script>
    </head>

    <body class="top-navigation">

        <div id="wrapper">
            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom white-bg">
                    <nav class="navbar navbar-static-top" role="navigation">                      
                        <div class="col-md-12">
                            <div class="row" style="border-bottom: 1px solid #f1f1f1;padding: 5px;">                                
                                <div class="col-md-3">
                                    <img style="width:80%;height:80%" src="<?php echo base_url(); ?>ast11/img/logo-supreme2.png" alt="logo supreme"/>
                                </div>                                    
                                <div class="col-sm-2 pull-right" style="padding-top:10px">                                    
                                    <select id="Bahasa" class="form-control">
                                        <option><a href="#">Bahasa Indonesia</a></option>
                                        <option><a href="#">English</a></option>
                                    </select>
                                </div>
                            </div>                            
                        </div>
                        <div class="navbar-header">
                            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                                <i class="fa fa-reorder"></i>
                            </button>
                            <a href="#" class="navbar-brand" style="background-color:#337ab7">Portal Procurement</a>
                        </div>                        
                        <div class="navbar-collapse collapse" id="navbar">
                            <ul class="nav navbar-nav">
                                <ul role="menu" class="dropdown-menu">
                                    <li><a href="">Menu item</a></li>
                                    <li><a href="">Menu item</a></li>
                                    <li><a href="">Menu item</a></li>
                                    <li><a href="">Menu item</a></li>
                                </ul>                                                                
                            </ul>
                            <ul class="nav navbar-top-links navbar-right">
                                <li>
                                    <a href="<?= base_url() ?>">
                                        <i class="fa fa-sign-out"></i> Log out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>

                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-12 text-center">
                        <h2><strong><?= lang("Pendaftaran Vendor","Vendor registration")?></strong></h2>   
                        <h2><i class="fa fa-university"></i></h2>
                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">            
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><?= lang("Info Perusahaan", "Company Info"); ?></h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>                                            
                                    </div>
                                </div>                
                                <div class="ibox-content">                    
                                    <form id="company_info" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="PREFIX">
                                                <?= lang("Awalan", "Prefix"); ?>
                                            </label>                                    
                                            <div class="col-sm-3">
                                                <select class="form-control " id="prefix" name="PREFIX">                                    
                                                    <?php
                                                    $data = $this->db->select("DESKRIPSI_IND,DESKRIPSI_ENG")
                                                            ->from("m_prefix")
                                                            ->where("status=", 1)
                                                            ->get()
                                                            ->result();
                                                    foreach ($data as $k => $v) {
                                                        echo'<option class="IDN" value="' . $v->DESKRIPSI_IND . '"';
                                                        echo (isset($all[0]->PREFIX) != false ? ($all[0]->PREFIX == $v->DESKRIPSI_IND ? 'selected' : '') : '');
                                                        echo '>' . $v->DESKRIPSI_IND . '</option>';
                                                        echo'<option class="ENG" value="' . $v->DESKRIPSI_ENG . '"';
                                                        echo (isset($all[0]->PREFIX) != false ? ($all[0]->PREFIX == $v->DESKRIPSI_ENG ? 'selected' : '') : '');
                                                        echo '>' . $v->DESKRIPSI_ENG . '</option>';
                                                    }
                                                    ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="NAMA">
                                                <?= lang("Nama Perusahaan", "Company Name"); ?>
                                            </label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="nama" name="NAMA" value="<?php echo(isset($all[0]->NAMA) != false ? $all[0]->NAMA : '') ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="klasifikasi">
                                                <?= lang("Klasifikasi Perusahaan", "Company Classification"); ?>
                                            </label>                                    
                                            <div class="col-sm-10"> 
                                                <?php
                                                $data = $this->db->select("DESKRIPSI_IND,DESKRIPSI_ENG")
                                                        ->from("m_supp_category")
                                                        ->where("status=", 1)
                                                        ->get()
                                                        ->result();
                                                foreach ($data as $k => $v) {
                                                    echo'<div class="i-checks col-md-3">
                                    <label><input type="radio" value="' . $v->DESKRIPSI_IND . '" id="SUFFIX" name="SUFFIX"> <i></i>' . lang($v->DESKRIPSI_IND, $v->DESKRIPSI_ENG) . ' </label>
                                </div>';
                                                }
                                                ?>                                
                                            </div>
                                        </div>                                
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="KATEGORI">
                                                <?= lang("Kualifikasi Perusahaan", "Company qualifications"); ?>
                                            </label>                                    
                                            <div class="col-sm-10">
                                                <?php
                                                $data = $this->db->select("DESKRIPSI_IND,DESKRIPSI_ENG")
                                                        ->from("m_supp_cualification")
                                                        ->where("status=", 1)
                                                        ->get()
                                                        ->result();
                                                foreach ($data as $k => $v) {
                                                    echo'<div class="i-checks col-md-3">
                                    <label><input type="radio" value="' . $v->DESKRIPSI_IND . '" id="KATEGORI" name="KATEGORI"> <i></i>' . lang($v->DESKRIPSI_IND, $v->DESKRIPSI_ENG) . ' </label>
                                </div>';
                                                }
                                                ?>                                                                
                                            </div>
                                        </div>      
                                    </form>
                                </div>
                            </div>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">                    
                                    <h5><?= lang("Alamat Perusahaan", "Company Address"); ?></h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>                                                
                                    </div>
                                </div>
                                <div class="ibox-content">     
                                    <form id="company_address" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label " for="BRANCH_TYPE"><?= lang("Tipe Kantor", "Branch Type"); ?></label>                                    
                                                <div class="col-sm-5">
                                                    <select class="form-control" id="BRANCH_TYPE" name="BRANCH_TYPE">
                                                        <?php
                                                        $data = $this->db->select("DESKRIPSI_IND,DESKRIPSI_ENG")
                                                                ->from("m_office_category")
                                                                ->where("status=", 1)
                                                                ->get()
                                                                ->result();
                                                        foreach ($data as $k => $v) {
                                                            echo'<option class="IDN" value="' . $v->DESKRIPSI_IND . '"';
                                                            echo '>' . $v->DESKRIPSI_IND . '</option>';
                                                            echo'<option class="ENG" value="' . $v->DESKRIPSI_ENG . '"';
                                                            echo '>' . $v->DESKRIPSI_ENG . '</option>';
                                                        }
                                                        ?>                                    
                                                    </select>
                                                </div>
                                            </div>                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="hp"><?= lang("Alamat", "Address") ?></label> 
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="ADDRESS" name="ADDRESS" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="COUNTRY"><?= lang("Negara", "Country"); ?></label>
                                                <div class="col-sm-6">
                                                    <select class="chosen-select form-control m-b" id="COUNTRY" name="COUNTRY" style="width:320px;" tabindex="2">
                                                        <?= opcountry() ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="PROVINCE"><?= lang("Provinsi", "Province"); ?></label>
                                                <div class="col-sm-6">
                                                    <select class="chosen-select form-control m-b" id="PROVINCE" name="PROVINCE"  style="width:320px;" tabindex="2">
                                                        <?= opprovinsi() ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="CITY"><?= lang("Kota", "City"); ?></label>                                    
                                                <div class="col-sm-7" style="">
                                                    <input type="text" class="form-control " id="CITY" name="CITY" >
                                                </div>
                                            </div>    
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="POSTAL_CODE"><?= lang("Kode POS", "Postal Code"); ?></label>                                    
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="POSTAL_CODE" name="POSTAL_CODE" >
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="TELP"><span>Telp</span></label>                                    
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="TELP" name="TELP" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="HP"><span>No HP</span></label>                                    
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="HP" name="HP" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="FAX"><span>Fax</span></label>                                    
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="FAX" name="FAX" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="WEBSITE"><span>Website</span></label>                                    
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="WEBSITE" name="WEBSITE" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="email"><span>Email</span></label>                                    
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="email" name="email" >
                                                </div>
                                            </div>
                                        </div>                        
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary" id="keys1" name="keys" value=0><?= lang("Tambah data", "Add data") ?></button>                                    
                                        </div>                         
                                    </form>
                                    <hr class="m-b"/>                                            
                                    <table id="dataalamat" class="table table-striped table-bordered table-hover display" width="100%">  
                                        <thead>
                                            <tr>
                                                <th><span>No</span></th>
                                                <th><?= lang("Tipe Kantor", "Branch Office") ?></th>
                                                <th><?= lang("Alamat", "Address") ?></th>
                                                <th><?= lang("Negara", "Country") ?></th>
                                                <th><?= lang("Provinsi", "Province") ?></th>
                                                <th><?= lang("Kota", "Country") ?></th>
                                                <th><?= lang("Kode Pos", "Postal Code") ?></th>
                                                <th><?= lang("Telp", "Telp") ?></th>
                                                <th><span>No.HP</span></th>
                                                <th><span>Fax</span></th>
                                                <th><span>Website</span></th>
                                                <th><?= lang("&nbsp&nbsp&nbsp   Aksi   &nbsp&nbsp&nbsp", "&nbspAction&nbsp") ?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>             
                            </div>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><?= lang("Kontak Perusahaan", "Contact Person") ?></h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>                                               
                                    </div>
                                </div>
                                <div class="ibox-content" id="form3">   
                                    <form id="company_contact" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="kontak_nama"><?= lang("Nama Lengkap", "Full Name"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kontak_nama" name="kontak_nama">
                                            </div>                            
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="kontak_jabatan"><?= lang("Jabatan", "Department"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kontak_jabatan" name="kontak_jabatan" value="<?php echo(isset($all[0]->jabatan) != false ? $all[0]->jabatan : '') ?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="kontak_telp"><?= lang("Telp-Ekstensi", "Telp-Extention"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kontak_telp" name="kontak_telp" value="<?php echo(isset($all[0]->telp) != false ? $all[0]->telp : '') ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="kontak_email"><span>Email</span></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kontak_email" name="kontak_email" value="<?php echo(isset($all[0]->email) != false ? $all[0]->email : '') ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="kontak_hp"><?= lang("No.HP", "Mobile Number"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kontak_hp" name="kontak_hp"value="<?php echo(isset($all[0]->hp) != false ? $all[0]->hp : '') ?>">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="keys" name="keys" value="0" class="btn btn-primary"><?= lang("Tambah data", "Add data") ?></button>                                    
                                        </div>                        
                                    </form>
                                    <hr/>
                                    <table id="datakontak" class="table table-striped table-bordered table-hover display" width="100%">                        
                                        <thead>
                                        <th><span>No</span></th>
                                        <th><?= lang("Nama Pegawai", "Employee Name") ?></th>
                                        <th><?= lang("Jabatan", "Position") ?></th>
                                        <th><?= lang("Telp - Ekstensi", "Telp - Extention") ?></th>
                                        <th><?= lang("Email", "Email") ?></th>
                                        <th><span>Hp</span></th>
                                        <th><?= lang("&nbspAksi&nbsp", "Action") ?></th>
                                        </thead>
                                    </table>                    
                                </div>            
                            </div>            
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5><?= lang("Daftar Rekening Bank", "Bank Account List") ?></h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>                                               
                                    </div>
                                </div>
                                <div class="ibox-content" id="form3">   
                                    <form id="company_bank" class="form-horizontal" action="javascript:;" enctype="multipart/form-data" novalidate="novalidate">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="bank"><?= lang("Bank", "Bank"); ?></label>                                    
                                            <div class="col-sm-3">                                
                                                <select name="bank" id="bank" class="form-control">
                                                    <?php
                                                    $data = $this->db->select("NAMA_BANK")
                                                            ->from("m_bank")
                                                            ->where("status=", 1)
                                                            ->get()
                                                            ->result();
                                                    foreach ($data as $k => $v) {
                                                        echo'<option value="' . $v->NAMA_BANK . '"';
                                                        echo '>' . $v->NAMA_BANK . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>                            
                                            <div class="col-sm-2">
                                                <label title="Upload file" for="file_tabungan" class="btn btn-default">
                                                    Upload File
                                                    <input type="file"  id="file_tabungan" name="file_tabungan" class="hide">
                                                </label>
                                            </div>                            

                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="alamat_bank"><?= lang("Alamat", "Address"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="alamat_bank" name="alamat_bank" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="cabang_bank"><?= lang("Cabang", "Branch"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="cabang_bank" name="cabang_bank" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="bank_no_acount"><?= lang("Nomor Rekening", "Account No"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="bank_no_acount" name="bank_no_acount">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="bank_name_acount"><?= lang("Nama Akun", "Account Name") ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="bank_name_acount" name="bank_name_acount" value="<?php echo(isset($all[0]->email) != false ? $all[0]->email : '') ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="currency"><?= lang("Mata Uang", "Currency"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <select name="currency" id="currency" class="form-control">
                                                    <?php
                                                    $data = $this->db->select("CURRENCY")
                                                            ->from("m_currency")
                                                            ->where("status=", 1)
                                                            ->get()
                                                            ->result();
                                                    foreach ($data as $k => $v) {
                                                        echo'<option value="' . $v->CURRENCY . '"';
                                                        echo '>' . $v->CURRENCY . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" id="keys" name="keys" value="0" class="btn btn-primary"><?= lang("Tambah data", "Add data") ?></button>                                    
                                        </div>                        
                                    </form>
                                    <hr/>
                                    <table id="databank" class="table table-striped table-bordered table-hover display" width="100%">                                                
                                    </table>
                                    <div class="text-right">                                        
                                        <button class="btn btn-success btn-md demo3"><?= lang("Simpan dan Daftar", "Save and Register") ?></button>
                                    </div>                                           
                                </div>            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade bs-example-modal-lg" data-backdrop="static" id="modal_address" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><?= lang("Perbarui Data Alamat", "Update Data Address") ?></h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form id="company_address_update" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label " for="BRANCH_TYPE"><?= lang("Tipe Kantor", "Branch Type"); ?></label>                                    
                                                <div class="col-sm-5">
                                                    <select class="form-control" id="BRANCH_TYPE" name="BRANCH_TYPE">
                                                        <?= langoption("KANTOR PUSAT", "HEADQUARTERS"); ?>                                    
                                                        <?= langoption("KANTOR CABANG", "BRANCH OFFICE"); ?>                                    
                                                    </select>
                                                </div>
                                            </div>                            
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="hp"><?= lang("Alamat", "Address") ?></label> 
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="ADDRESS" name="ADDRESS" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="COUNTRY"><?= lang("Negara", "Country"); ?></label>
                                                <div class="col-sm-6">
                                                    <select class="chzn_a chosen-select form-control m-b" id="COUNTRY" name="COUNTRY" style="width:285px;" tabindex="2">
                                                        <?= opcountry() ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="PROVINCE"><?= lang("Provinsi", "Province"); ?></label>
                                                <div class="col-sm-6">
                                                    <select class="chosen-select form-control m-b" id="PROVINCE" name="PROVINCE"  style="width:285px;" tabindex="2">
                                                        <?= opprovinsi() ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="CITY"><?= lang("Kota", "City"); ?></label>                                    
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control m-b" id="CITY" name="CITY" >
                                                </div>
                                            </div>    
                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" for="POSTAL_CODE"><?= lang("Kode POS", "Postal Code"); ?></label>                                    
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="POSTAL_CODE" name="POSTAL_CODE" >
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="TELP">Telp</label>                                    
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="TELP" name="TELP" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="HP"><span>No HP</span></label>                                    
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="HP" name="HP" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="FAX"><span>Fax</span></label>                                    
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="FAX" name="FAX" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" for="WEBSITE"><span>Website</span></label>                                    
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="WEBSITE" name="WEBSITE" >
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="margin-bottom:10px;border-color:#d5d5d5"></hr>
                                        <div class=" col-sm-12 text-right">                                                                
                                            <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>                                                                    
                                            <button type="submit" id="keys1" name="keys" value="0" style="width:115px" class="btn btn-primary"><?= lang("Perbarui data", "Update data") ?></button>                                                                    
                                        </div>                                                    
                                    </form>
                                </div>
                            </div>                
                        </div>
                    </div>
                </div>

                <div class="modal fade bs-example-modal-lg" data-backdrop="static" id="modal_kontak" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Update Data Kontak</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <form id="company_contact_update" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="kontak_nama"><?= lang("Nama Lengkap", "Full Name"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kontak_nama" name="kontak_nama">
                                            </div>                            
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="kontak_jabatan"><?= lang("Jabatan", "Department"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kontak_jabatan" name="kontak_jabatan" value="<?php echo(isset($all[0]->jabatan) != false ? $all[0]->jabatan : '') ?>" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="kontak_telp"><?= lang("Telp-Ekstensi", "Telp-Extention"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kontak_telp" name="kontak_telp" value="<?php echo(isset($all[0]->telp) != false ? $all[0]->telp : '') ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="kontak_email">Email</label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kontak_email" name="kontak_email" value="<?php echo(isset($all[0]->email) != false ? $all[0]->email : '') ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label" for="kontak_hp"><?= lang("No.HP", "Mobile Number"); ?></label>                                    
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="kontak_hp" name="kontak_hp"value="<?php echo(isset($all[0]->hp) != false ? $all[0]->hp : '') ?>">
                                            </div>
                                        </div>
                                        <hr style="margin-bottom:10px;border-color:#d5d5d5"></hr>
                                        <div class=" col-sm-12 text-right">                                                                
                                            <button type="button" data-dismiss="modal" style="width:115px"  value="0" class="btn btn-danger"><?= lang("Batal", "Cancel") ?></button>                                                                    
                                            <button type="submit" id="keys" name="keys" value="0" style="width:115px" class="btn btn-primary"><?= lang("Perbarui data", "Update data") ?></button>                                                                    
                                        </div>                        
                                    </form>
                                </div>
                            </div>                
                        </div>
                    </div>
                </div>
                <div class="footer">    
                    <div>
                        <strong>Copyright</strong> Supreme Energy &copy; 2017
                    </div>
                </div>

            </div>
        </div>

        <script src="<?= base_url() ?>ast11/js/plugins/toastr/toastr.min.js"></script>        
        <script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script>        
        <script src="<?= base_url() ?>ast11/js/validation/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/validation/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/validation/form-validation.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/sweetalert/sweetalert.min.js"></script>        

        <script src="<?= base_url() ?>ast11/js/plugins/toastr/toastr.min.js"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/sweetalert/sweetalert.min.js"></script>

        <script>
            lang();
            function msg_info(title, msg)
            {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": true,
                    "preventDuplicates": false,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "7000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                $("#toastrOptions").text("Command: toastr["
                        + "info"
                        + "](\""
                        + msg
                        + (title ? "\", \"" + title : '')
                        + "\")\n\ntoastr.options = "
                        + JSON.stringify(toastr.options, null, 2)
                        );
                var $toast = toastr["success"](msg, title);
            }
            function msg_danger(title, msg)
            {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": true,
                    "preventDuplicates": false,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "showDuration": "400",
                    "hideDuration": "1000",
                    "timeOut": "7000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                $("#toastrOptions").text("Command: toastr["
                        + "warning"
                        + "](\""
                        + msg
                        + (title ? "\", \"" + title : '')
                        + "\")\n\ntoastr.options = "
                        + JSON.stringify(toastr.options, null, 2)
                        );
                var $toast = toastr["warning"](msg, title);
            }
            function msg_default(title, msg)
            {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": true,
                    "preventDuplicates": false,
                    "positionClass": "toast-top-right",
                    "onclick": null,
                    "showDuration": "250",
                    "hideDuration": "1000",
                    "timeOut": "7000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                $("#toastrOptions").text("Command: toastr["
                        + "info"
                        + "](\""
                        + msg
                        + (title ? "\", \"" + title : '')
                        + "\")\n\ntoastr.options = "
                        + JSON.stringify(toastr.options, null, 2)
                        );
                var $toast = toastr["info"](msg, title);
            }
        </script>
    </body>
</html>
