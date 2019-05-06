<!-- <link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet"> -->
<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Usulan Material", "Catalogue Number Request") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Master Material", "Master Material") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Usulan Material", "Catalogue Number Request") ?></li>
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
                                                <button aria-expanded="false" onclick="add()" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "CREATE") ?></button>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tbl" class="table nowrap table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                                <tfoot>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Request No</th>
                                                        <th>Description of Unit</th>
                                                        <th>UoM</th>
                                                        <th>Position</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <!-- <label class="form-group" style="font-weight:300" id="info">Showing 1 to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label> -->
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

<!--change data-->

<div id="modal-filter" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class=" modal-content">
            <form id="form" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-filter"></h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label col-md-6" for="field-1">Material Name</label>
                                <label class="form-label col-md-6" for="field-1"><?= lang("Description", "Description") ?></label>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_matr" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_desc" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <label class="form-label col-md-6" for="field-1"><?= lang("UOM", "Long Description") ?></label>
                                <label class="form-label col-md-6" for="field-1">Model/Type</label>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_long" multiple data-role="tagsinput">
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_group" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <label class="form-label col-md-6" for="field-1"><?= lang("Grup Material", "Material Group") ?></label>
                                <label class="form-label col-md-6" for="field-1"><?= lang("Tipe Material", "Material Type") ?></label>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_type" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_uom" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <label class="form-label col-md-6" for="field-1"><?= lang("Manufacturer", "Material Type") ?></label>
                                <label class="form-label col-md-6" for="field-1">Part No</label>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_type" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_uom" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <label class="form-label col-md-6" for="field-1"><?= lang("Sequence Grup", "Material Type") ?></label>
                                <label class="form-label col-md-6" for="field-1">Indicator Materials</label>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_type" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select style="width:100%" class="col-md-12" id="search_uom" multiple data-role="tagsinput">
                                    </select>
                                </div>
                                <label class="form-label col-md-12" for="field-1"><?= lang("Batas Data", "Limit Data") ?></label>
                                <div class="col-md-12 m-b">
                                    <div class="input-group">
                                        <input class="touchspin3" type="text" value="10" id="limit" name="demo3">
                                        <span class="input-group-addon" id="total"></span>
                                    </div>
                                </div>
                                <label class="form-label col-md-12" for="field-1">Status</label>
                                <div class="col-md-12">
                                    <div class="i-checks col-md-6">
                                        <label><input type="checkbox" value="aktif" id="status1"> <i></i> <?= lang("Aktif", "Active") ?> </label>
                                    </div>
                                    <div class="i-checks col-md-6">
                                        <label><input type="checkbox" value="tidak" id="status2"> <i></i> <?= lang("Tidak Aktif", "NotActive") ?> </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="button" onclick="get()" data-dismiss="modal" class="btn btn-info" id="save"><?= lang('Filter', 'Filter') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class=" modal-content">
            <form class="form-horizontal m_registration" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style=" height:600px; overflow-y : auto;">
                    <input type="hidden" id="material" name="material" value="">
                    <input type="hidden" id="sequence_id" name="sequence_id" value="">
                    <input type="hidden" id="email_approve" name="email_approve" value="">
                    <input type="hidden" id="email_reject" name="email_reject" value="">
                    <input type="hidden" id="edit_content" name="edit_content" value="">
                    <input type="hidden" id="material_id" name="material_id" value="">
                    <div class="card-footer border-2 text-muted mt-2">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Desk. Pendek Material*", "Item Short Desc*") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="m_name" name="m_name" class="form-control" rows="3" maxlength="30" required/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Teks Pencarian*", "Search Text*") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="search_text" name="search_text" class="form-control" rows="3" maxlength="30" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Desk. Pendek Material 2", "Item Short Desc 2") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="m_short_desc" name="m_short_desc" class="form-control" rows="3" maxlength="30"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Nama Tidak Resmi", "Colloquials") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="colluquials" name="colluquials" class="form-control" rows="3" maxlength="30"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Desk. Panjang Material *", "Item Long Desc *") ?>
                            </label>
                            <div class="col-md-10">
                                <textarea id="m_desc" name="m_desc" class="form-control" rows="5" maxlength="500" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Klasifikasi SEMIC*", "SEMIC Classification*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="classification" name="classification" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                        foreach ($material_group as $arr) { ?>
                                    <option value="<?= $arr['material_group']; ?>"><?= $arr['material_group'].". ".$arr['material_desc'].", (".$arr['type'].")"; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("No SEMIC", "SEMIC Number") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="semic_no" name="semic_no" class="form-control" minlength="14" maxlength="14"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Grup Utama SEMIC*", "SEMIC Main Group*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="semic_group" name="semic_group" class="form-control" disabled required>
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Penggunaan Bulanan", "Monthly Usage") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="monthly_usage" name="monthly_usage" maxlength="11" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Unit Satuan*", "UOM Primary/Issue*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="m_uom" name="m_uom" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                        foreach ($material_uom as $arr) { ?>
                                    <option value="<?= $arr['material_uom']; ?>"><?= $arr['material_uom'].' - '.$arr['uom_desc']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Perk. Penggunaan Tahunan", "Est. Annual Usage") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="annual_usage" name="annual_usage" maxlength="11" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Pabrikan*", "Manufacturer*") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="hidden" id="no_manufacturer" name="no_manufacturer" maxlength="2" value=""/>
                                <input type="text" id="name_manufacturer" name="name_manufacturer" maxlength="30" class="form-control" required/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Jumlah Pesanan Awal", "Initial Order Qty") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="initial_order_qty" name="initial_order_qty" maxlength="11" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("No. Bagian*", "Part Number*") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="part_no" name="part_no" class="form-control" maxlength="30" required/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Expl. Element", "Expl. Element") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="expl_element" name="expl_element" maxlength="30" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Model", "Model") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="hidden" id="model_type_no" name="model_type_no" value=""/>
                                <input type="text" id="model_type_name" name="model_type_name" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Satuan Isu", "UOM Purchase *") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="unit_of_issue" name="unit_of_issue" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach ($material_uom as $arr) { ?>
                                        <option value="<?= $arr['material_uom']; ?>"><?= $arr['material_uom'].' - '.$arr['uom_desc']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Tipe", "Type") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="m_type" name="m_type" maxlength="40" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Perkiraan Nilai", "Estimated Value") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="estimate_value" name="estimate_value" maxlength="11" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("No. Serial", "Serial Number") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="serial_number" name="serial_number" maxlength="40" class="form-control" />
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Masa Rak", "Shelf Life") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="shelf_life" name="shelf_life" maxlength="11" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("ID Grup Perlengkapan", "Equipment Group ID") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="equipment_id" name="equipment_id" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Berbahaya", "Hazardous") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="hazardous" name="hazardous" class="form-control">
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach ($hazardous as $arr) { ?>
                                        <option value="<?= $arr['id']; ?>"><?= $arr['description']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("No. Perlengkapan", "Equipment Number") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="equipment_no" name="equipment_no" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2" style="text-align: right;">
                                <?= lang("Kode Stok</br>Referensi Silang", "Cross Reference</br>Stock Code") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="cross_rererence" name="cross_rererence" maxlength="40" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Kelas G/L*", "G/L Class*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="gl_class" name="gl_class" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach ($gl_class as $arr) { ?>
                                        <option value="<?= $arr['id']; ?>"><?= $arr['code'] . ' - ' . $arr['description']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Tipe Barang*", "Inventory Type*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="inventory_type" name="inventory_type" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach ($inventory_type as $arr) { ?>
                                        <option value="<?= $arr['id']; ?>"><?= $arr['description']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Tipe Garis*", "Line Type*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="line_type" name="line_type" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach ($line_type as $arr) { ?>
                                        <option value="<?= $arr['id']; ?>"><?= $arr['code'] . ' - ' . $arr['description']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Fase Proyek*", "Project Phase*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="project_phase" name="project_phase" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach ($project_phase as $arr) { ?>
                                        <option value="<?= $arr['id']; ?>"><?= $arr['description']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Tipe Stok*", "Stocking Type*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="stocking_type" name="stocking_type" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach ($stocking_type as $arr) { ?>
                                        <option value="<?= $arr['id']; ?>"><?= $arr['code'] . ' - ' . $arr['description']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Ketersediaan*", "Availability*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="available" name="available" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach ($material_avalable as $arr) { ?>
                                        <option value="<?= $arr['id']; ?>"><?= $arr['desc_en']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Kelas Stok*", "Stock Class*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="stock_class" name="stock_class" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach ($stock_class as $arr) { ?>
                                        <option value="<?= $arr['id']; ?>"><?= $arr['description']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Kekritisan", "Criticality *") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="critical" name="critical" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach ($material_criticaly as $arr) { ?>
                                        <option value="<?= $arr['id']; ?>"><?= $arr['desc_en']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">Material Image</label>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-1">
                                        <a href="#" id="img_material" data-lightbox="lightbox" data-title="MATERIAL DRAWING"><img id="image_upload" src="<?= base_url() ?>ast11/img/showimg.png" alt="your image" style="height:60px;width:60px;" /></a>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <input type="file" id="material_image" name="material_image" class="ff" accept="image/jpeg, image/png"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">Material Drawing</label>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-1">
                                        <a href="#" id="img_mdrawing" data-lightbox="lightbox" data-title="MATERIAL DRAWING"><img id="image_upload2" src="<?= base_url() ?>ast11/img/showimg.png" alt="your image" style="height:60px;width:60px;" /></a>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <input type="file" id="material_drawing" name="material_drawing" class="ff" accept="image/jpeg, image/png"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">Other</label>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-1">
                                        <a href="#" id="image_upload_location" target="_blank"><img id="image_upload3" src="<?= base_url() ?>ast11/img/showimg.png" alt="other file" style="height:60px;width:60px;" /></a>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <input type="file" id="material_other" name="material_other" value="" class="ff" accept="application/pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/msword"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="submit" onclick="" class="btn btn-success" id="save"><?= lang('Submit', 'Submit') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<script src="<?= base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        input_numberic('#semic_no', true);
        input_numberic('#monthly_usage', true);
        input_numberic('#annual_usage', true);
        input_numberic('#initial_order_qty', true);
        //input_numberic('#m_type', true);
        input_numberic('#estimate_value', true);
        //input_numberic('#serial_number', true);
        input_numberic('#shelf_life', true);
        //input_numberic('#cross_rererence', true);

        $('select').select2({ width: '100%', dropdownParent: $('#myModal') });

        $("#classification").on('change', function() {
            var classification = $(this).val();
            $.ajax({
                url: '<?= base_url('material/Mregist_approval/material_equipment_group') ?>',
                type: 'GET',
                data: {idx: classification},
                success: function(res) {
                    $("#semic_group").attr('disabled', false);
                    $("#semic_group").html(res);
                }
            });
        });

        //select2
        if ($.isFunction($.fn.select2)) {
            $("#optmaterial_uom").select2({
                placeholder: 'select',
                required : true,
                allowClear: true
            }).on('select2-open', function() {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                // $('#tbl').DataTable().ajax.reload();
            });
        }

        function readURL(input, idorclass) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(idorclass).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // validasi file_uploads
        $("#material_image").change(function () {
            var fileExtension = ['jpeg', 'jpg', 'png'];
              if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                swal('<?= __('warning') ?>', "Format allowed : "+fileExtension.join(', '), 'warning');
                // alert("Format allowed : "+fileExtension.join(', '));
                $(this).val("")
              } else {
                readURL(this, '#image_upload');
              }
        });
        $("#material_drawing").change(function () {
          var fileExtension = ['jpeg', 'jpg', 'png'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
              swal('<?= __('warning') ?>', "Format allowed : "+fileExtension.join(', '), 'warning');
              // alert("Format allowed : "+fileExtension.join(', '));
              $(this).val("")
            } else {
              readURL(this, '#image_upload2');
            }
        });

        $("#material_other").change(function () {
          var fileExtension = ['jpeg', 'jpg', 'png', 'pdf', 'docx', 'xlsx', 'doc'];
            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
              swal('<?= __('warning') ?>', "Format allowed : "+fileExtension.join(', '), 'warning');
              // alert("Format allowed : "+fileExtension.join(', '));
              $(this).val("")
            } else {
              readURL(this, '#image_upload3');
            }
        });

        // CKEDITOR.replace("m_desc");
        // ajax_loader();
        CKEDITOR.replace('m_desc', {
            toolbar: [
                {name: 'document', items: ['-', 'NewPage', 'Preview', '-', 'Templates', 'Bold', 'Italic']}, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
                ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
            ]
        });

        // $('#myModal').modal('show');
        $(".touchspin3").TouchSpin({
            verticalbuttons: true,
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });

        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // delete
        $(document).on('click', '#delete', function (e) {
            e.preventDefault();
            // var idnya = $(e.relatedTarget).data("id");
            var idnya = $(this).data("id");
            // alert(idnya)
            if (idnya != "") {
              swalConfirm('Catalogue Number Request', '<?= __('confirm_submit') ?>', function() {
                var elm = modal_start($('.sweet-alert'));
                $.ajax({
                  url: '<?= base_url('material/Registration_material/delete_material') ?>',
                  type: 'post',
                  dataType: 'json',
                  data: {idnya: idnya},
                  success: function(res){
                    window.location.href = "<?= base_url() ?>material/registration_material";
                  }
                });
              });
            }
        });

        // $('select').select2({ width: '100%' });

        $('.m_registration').submit(function (e) {
            e.preventDefault();
            var data = new FormData(this);
            data.append('m_desc', CKEDITOR.instances['m_desc'].getData());
            var material_other = $("#material_other").val();
            var material_id = $("#material_id").val();
            var messageLength = $('<textarea />').html(CKEDITOR.instances['m_desc'].getData().replace(/<[^>]*>/gi, '')).text();
            console.log(messageLength.length);
            if( !messageLength.length ) {
              swal('<?= __('warning') ?>', "Empty item Long Desc !", 'warning')
            } else if (messageLength.length > 500){
              swal('<?= __('warning') ?>', "Item Long Desc maximum length is 500 character !", 'warning')
            } else {
              if (document.getElementById("material_image").files.length == 0 || document.getElementById("material_drawing").files.length == 0) {
                  var xmodalx = modal_start($("#myModal").find(".modal-content"));
                  save_material(data);
                  // modal_stop(xmodalx);
              } else {
                  if (fileSize("#material_image") > 1048576) {
                      swal('<?= __('warning') ?>', 'File size limit is 1Mb', 'warning');
                  } else if (fileSize("#material_drawing") > 1048576) {
                      swal('<?= __('warning') ?>', 'File size limit is 1Mb', 'warning');
                  } else if (material_other != "") {
                      if (fileSize("#material_other") > 1048576) {
                          swal('<?= __('warning') ?>', 'File size limit is 1Mb', 'warning');
                      } else {
                          var xmodalx = modal_start($("#myModal").find(".modal-content"));
                          save_material(data);
                      }
                  } else {
                      var xmodalx = modal_start($("#myModal").find(".modal-content"));
                      save_material(data);
                  }
              }
            }

        });

        $("#myModal").on('shown.bs.modal', function (e) {
            var xmodalx = modal_start($("#myModal").find(".modal-content"));
            // var idnya = $(e.relatedTarget).data("id");
            var idnya = $("#material_id").val();
            var semicx = '';
            $("#image_upload").attr('src', '<?= base_url() ?>ast11/img/showimg.png')
            $("#image_upload2").attr('src', '<?= base_url() ?>ast11/img/showimg.png')
            $("#image_upload3").attr('src', '<?= base_url() ?>ast11/img/showimg.png')
            $("#img_material").attr('href', '<?= base_url() ?>ast11/img/showimg.png');
            $("#img_mdrawing").attr('href', '<?= base_url() ?>ast11/img/showimg.png');
            $("#image_upload_location").attr('href', '#')
            $("#optmaterial_uom").select2('val', '0');
            $("#email_approve").val("")
            $('input').val('');
            $('select').val('').select2({ width: '100%' });
            $('#m_uom').val('').select2({ width: '100%', dropdownParent: $('#myModal') });
            $('#unit_of_issue').val('').select2({ width: '100%', dropdownParent: $('#myModal') });
            $('#semic_group').attr('disabled', true);

            // $.ajax({
            //   url: '<?= base_url('material/Registration_material/get_tapproval_material')?>',
            //   type: 'GET',
            //   dataType: 'JSON',
            //   success: function(res){
            //     // console.log();
            //     $("#email_approve").val(res[0].email_approve)
            //     $("#sequence_id").val(res[0].sequence_id)
            //   }
            // })

            // alert(idnya)
            if (idnya != 0) {
                $.ajax({
                    url: '<?= base_url('material/Registration_material/get_data_requestor') ?>',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        idnya: idnya
                    },
                    success: function (res) {
                        // var res = res.replace("[", "");
                        // var res = res.replace("]", "");
                        // var sel = JSON.parse(res);
                        modal_stop(xmodalx);
                        $.each(res, function (index, el) {
                            // console.log(el.uom);
                            $('#optmaterial_uom2').val(el.data2.UOM1).select2({ width: '100%' });
                            $('#classification').val();

                            console.log(el.data2.SEMIC_MAIN_GROUP);
                                $.ajax({
                                    url: '<?= base_url('material/Mregist_approval/material_classification_group') ?>',
                                    type: 'GET',
                                    data: {idx: el.data2.SEMIC_MAIN_GROUP},
                                    dataType: 'json',
                                    success: function(res) {
                                      // console.log(res.mgroup.PARENT);
                                      $("#classification").val(res.mgroup.PARENT).trigger('change').select2();
                                      // console.log(res);
                                  },
                                  complete: function(res){
                                    setTimeout(function() {
                                      $('#semic_group').val(el.data2.SEMIC_MAIN_GROUP).select2({ width: '100%' });
                                    }, 1000);
                                  }
                            });

                            var content = CKEDITOR.instances['m_desc'].setData(el.description);
                            $('#m_name').val(el.data2.MATERIAL_NAME);
                            $("#material_id").val(el.material);
                            $('#m_short_desc').val(el.data2.SHORTDESC);
                            $('#m_uom').val(el.data2.UOM).select2({ width: '100%', dropdownParent: $('#myModal') });
                            $('#optmaterial_uom').val(el.uom).select2({ width: '100%' });

                            $('#search_text').val(el.data2.SEARCH_TEXT);
                            $('#semic_no').val(el.data2.MATERIAL_CODE);
                            semicx += el.data2.MATERIAL_CODE;

                            $('#no_manufacturer').val(el.data2.MANUFACTURER);
                            $('#name_manufacturer').val(el.data2.MANUFACTURER_DESCRIPTION);
                            $('#part_no').val(el.data2.PART_NO);
                            $('#model_type_no').val(el.data2.MATERIAL_TYPE);
                            $('#model_type_name').val(el.data2.MATERIAL_TYPE_DESCRIPTION);
                            // $('#squence_group_no').val(el.data2.SEQUENCE_GROUP);
                            // $('#squence_group_name').val(el.data2.SEQUENCE_GROUP_DESCRIPTION);
                            $('#material_indicator').val(el.data2.INDICATOR).select2({ width: '100%' });
                            $('#stock_class').val(el.data2.STOCK_CLASS).select2({ width: '100%' });
                            $('#available').val(el.data2.AVAILABILITY).select2({ width: '100%' });
                            $('#critical').val(el.data2.CRITICALITY).select2({ width: '100%' });
                            $('#unit_of_issue').val(el.data2.UNIT_OF_ISSUE).select2({ width: '100%' });

                            $('#colluquials').val(el.data2.COLLUQUIALS);
                            $('#equipment_id').val(el.data2.EQPMENT_ID);
                            $('#equipment_no').val(el.data2.EQPMENT_NO);
                            $('#m_type').val(el.data2.TYPE);
                            $('#serial_number').val(el.data2.SERIAL_NUMBER);
                            $('#gl_class').val(el.data2.GL_CLASS).select2({ width: '100%' });
                            $('#line_type').val(el.data2.LINE_TYPE).select2({ width: '100%' });
                            $('#stocking_type').val(el.data2.STOCKING_TYPE).select2({ width: '100%' });
                            $('#project_phase').val(el.data2.PROJECT_PHASE).select2({ width: '100%' });
                            $('#inventory_type').val(el.data2.INVENTORY_TYPE).select2({ width: '100%' });
                            $('#hazardous').val(el.data2.HAZARDOUS).select2({ width: '100%' });
                            $('#monthly_usage').val(el.data2.MONTHLY_USAGE);
                            $('#annual_usage').val(el.data2.ANNUAL_USAGE);
                            $('#initial_order_qty').val(el.data2.INITIAL_ORDER_QTY);
                            $('#expl_element').val(el.data2.EXPL_ELEMENT);
                            $('#estimate_value').val(el.data2.ESTIMATE_VALUE);
                            $('#shelf_life').val(el.data2.SHELF_LIFE);
                            $('#cross_rererence').val(el.data2.CROSS_RERERENCE);

                            $("#image_upload").attr('src', '<?= base_url(); ?>upload/MATERIAL/img/small/small_' + el.img1_url)
                            $("#image_upload2").attr('src', '<?= base_url(); ?>upload/MATERIAL/img/small/small_' + el.img2_url)
                            $("#img_material").attr('href', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.img1_url);
                            $("#img_mdrawing").attr('href', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.img2_url);
                            $("#material_image").prop('required', false);
                            $("#material_drawing").prop('required', false);

                            if (el.file_url == "" || el.file_url == "-") {

                            } else {
                              var formatid = el.file_url.split(".").pop();
                              if (formatid == 'jpg' || formatid == 'png' || formatid == 'gif') {
                                  $("#image_upload3").attr('src', '<?= base_url(); ?>upload/MATERIAL/files/' + el.file_url)
                                  $("#image_upload_location").attr('href', '<?= base_url(); ?>upload/MATERIAL/files/' + el.file_url)
                                  $("#image_upload_location").attr('data-lightbox', 'lightbox')
                                  // data-lightbox="lightbox" data-title="MATERIAL DRAWING"
                              } else {
                                  $("#image_upload3").attr('src', '<?= base_url() ?>ast11/img/document-file-icon.png')
                                  $("#image_upload_location").attr('href', '<?= base_url(); ?>upload/MATERIAL/files/' + el.file_url)
                              }
                            }
                            // $("#material_other").val(el.file_url)

                        });
                    }
                });
            } else {
                modal_stop(xmodalx);
            }

            $('#semic_no').keyup(function(e){
                var code = this.value.replace(/\D/g,'').substring(0,10);
                var delKey = (e.keyCode == 8 || e.keyCode == 46);
                var len = code.length;
                if (len < 2) {
                    code = code;
                } else if (len == 2) {
                    code = code.substring(0, 2) + (delKey ? '' : '.');
                } else if (len < 4) {
                    code = code.substring(0, 2) + '.' + code.substring(2, 4);
                } else if (len == 4) {
                    code = code.substring(0, 2) + '.' + code.substring(2, 4) + (delKey ? '' : '.');
                } else if (len < 6) {
                    code = code.substring(0, 2) + '.' + code.substring(2, 4) + '.' + code.substring(4, 6);
                } else if (len == 6) {
                    code = code.substring(0, 2) + '.' + code.substring(2, 4) + '.' + code.substring(4, 6) + (delKey ? '' : '.');
                } else if (len < 9) {
                    code = code.substring(0, 2) + '.' + code.substring(2, 4) + '.' + code.substring(4, 6) + '.' + code.substring(6, 9);
                } else if (len == 9) {
                    code = code.substring(0, 2) + '.' + code.substring(2, 4) + '.' + code.substring(4, 6) + '.' + code.substring(6, 9) + (delKey ? '' : '.');
                } else {
                    code = code.substring(0, 2) + '.' + code.substring(2, 4) + '.' + code.substring(4, 6) + '.' + code.substring(6, 9) + '.' + code.substring(9, 10);
                }
                this.value = code;
            });

            // check SEMIC if EXISTS
            // $("#semic_group").on('change', function() {
            //     if ($("#semic_no").val() != '') {
            //       $("#semic_no").val('')
            //     }
            //     console.log('haha');
            // });
            $("#semic_no").focusout(function(e) {
              var result;
              if ($(this).val() != '') {
                if (semicx === $("#semic_no").val() && idnya != '') {
                  console.log("No Need Checking SEMIC");
                } else {
                  $.ajax({
                    url: '<?= base_url('material/Registration_material/check_semic') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {semic_id: $(this).val()}
                  })
                  .done(function() {
                    result = true;
                  })
                  .fail(function() {
                    result = false;
                  })
                  .always(function(res) {
                    if (result) {
                      // console.log(res);
                      if (res.count > 0) {
                        $("#semic_no").val('');
                        swal("Oops!", "SEMIC "+res.data[0].MATERIAL_CODE+" ALREADY USED BY "+res.data[0].MATERIAL_NAME.toUpperCase(), "warning");
                      }
                    }
                  });
                  // console.log("Checking Semic : "+$("#semic_no").val());
                }
              }

              if ($("#semic_group").val() != "") {
                var semicgroup = $( "#semic_group option:selected" ).text();
                semicgroup = semicgroup=parseInt(semicgroup);
                var semic_no = $("#semic_no").val();
                var split_semic = semic_no.split('.');
                if (semicgroup.toString().length <= 1) {
                  semicgroup = '0'+semicgroup.toString();
                }
                split_semic[0] = semicgroup;
                console.log(semicgroup);

                var replace_semic_no = split_semic.join('.').toString();
                $("#semic_no").val(replace_semic_no);
                // console.log(replace_semic_no);
                // alert($("#classification").val())
              } else {
                var semic_no = $("#semic_no").val();
                var split_semic = semic_no.split('.');
                $.ajax({
                  url: '<?= base_url('material/Registration_material/check_semic_group') ?>',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    parent: $("#classification").val(),
                    mgroup: parseInt(split_semic[0]),
                }
                })
                .done(function() {
                  result = true;
                })
                .fail(function() {
                  result = false;
                })
                .always(function(res) {
                  if (result) {
                    if (res.count > 0) {
                      $("#semic_group").val(res.data.ID).trigger('change').select2();
                    } else {
                      $("#semic_no").val('');
                      swal("Oops!", "SEMIC Main Group Not Exist", "warning");
                    }
                    // console.log(res);
                  }
                });
              }
            });

            $('#form').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('material/Registration_material/change') ?>',
                    data: $('#form').serialize(),
                    success: function (m) {
                        if (m == 'sukses') {
                            $('#modal').modal('hide');
                            $('#tbl').DataTable().ajax.reload();
                            msg_info('Sukses tersimpan');
                        } else {
                            msg_danger(m);
                        }
                    }
                });
            });
        });

        lang();
        $('#tbl tfoot th').each(function (i) {
            var title = $('#tbl tfoot th').eq($(this).index()).text();
            if ($(this).text() == 'No') {
              $(this).html('');
            } else if ($(this).text() == 'Action') {
              $(this).html('');
            } else {
              $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
            }
        });
        var table = $('#tbl').DataTable({
            "ajax": {
                "url": "<?= base_url('material/Registration_material/datatable_registrasi_material') ?>",
                "dataSrc": ""
            },
            "scrollX": true,
            "paging": true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            },
            "columns": [
                {title: "No"},
                {title: "<?= lang("No Permintaan", "Request No") ?>"},
                {title: "<?= lang("Deskripsi Material", "Description of Unit") ?>"},
                {title: "UoM"},
                {title: "<?= lang("Jabatan", "Position") ?>"},
                {title: "Status"},
                {title: "Action"}
            ],
            "columnDefs": [
                {targets:[3,6], class:'text-center'}
            ]
        });
        $(table.table().container()).on('keyup', 'tfoot input', function () {
            table.column($(this).data('index'))
                    .search(this.value)
                    .draw();
        });
    });

    function reject() {
        swal({
            title: "Are you sure?",
            text: "Data cannot be recover",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya",
            closeOnConfirm: false
        }, function () {

        });
    }

    function add() {
        document.getElementById("form").reset();
        var content = CKEDITOR.instances['m_desc'].setData("");
        $('.modal-title').html("<?= lang("Formulir Pendaftaran", "Form Catalogue Number Request") ?>");
        $('#myModal .modal-header').css('background-color', "#1c84c6");
        $('#myModal .modal-header').css('color', "#fff");
        $('#myModal').modal('show');
        $('#material_id').val(0);
        // document.getElementById("aktif").checked = true;
        lang();
    }

    function update(idmat) {
        var content = CKEDITOR.instances['m_desc'].setData("");
        $('.modal-title').html("<?= lang("Formulir Pendaftaran", "Form Update Material") ?>");
        $('#myModal .modal-header').css('background-color', "#1c84c6");
        $('#myModal .modal-header').css('color', "#fff");
        $('#myModal').modal('show');
        $('#material_id').val(idmat);
        // document.getElementById("aktif").checked = true;
        lang();
    }

    function save_material(data) {
        swalConfirm("Catalogue Number Request", "<?= __('confirm_submit') ?>", function() {
            $.ajax({
                url: '<?= base_url('material/Registration_material/save_material_requestor') ?>',
                type: 'POST',
                dataType: 'JSON',
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.status === "success") {
                        window.location.href = "<?= base_url() ?>home";
                    } else {
                        setTimeout(function() {
                            swal('<?= __('warning') ?>', '<?= __('failed_submit') ?>', 'failed');
                        }, swalDelay);
                    }
                },
                fail: function (res) {
                    setTimeout(function() {
                        swal('<?= __('warning') ?>', 'Processing has failed', 'failed');
                    }, swalDelay);
                }
            });
        });
    }

</script>
