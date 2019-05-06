
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">                    
                    <h5><?= lang("Pendaftaran Suplier Baru", "Registrasi New Supplier") ?></h5>
                    <h5 class="title pull-right" style="margin:-10px -5px">
                        <a data-toggle="modal" onclick="add()" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "Add") ?></a>
                    </h5>
                     
                </div>
                <div class="ibox-content" style="height:420px">
                    <table id="tbl_show" name="tbl_show" class="table table-striped table-bordered table-hover display" width="100%">
                        <thead>
                          <tr>
                            <th><span>No.</span></th>
                            <th><?= lang("ID SUPPLIER", "ID SUPPLIER") ?></th>
                            <th><?= lang("NAMA SUPPLIER", "NAMA SUPPLIER") ?></th>
                            <th><?= lang("NO NPWP", "NPWP NUMBER") ?></th>
                            <th><?= lang("Email", "EMAIL") ?></th>
                            <th><?= lang("ALAMAT", "ADDRESS") ?></th>
                            <th><?= lang("Kota", "City") ?></th>
                            <th><?= lang("Projek Description", "Project Name") ?></th>
                            <th><?= lang("&nbspAksi&nbsp", "&nbspAction&nbsp") ?></th>
                          </tr>
                        </thead>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
 
<!--change data-->
<div class="modal fade" id="modal"  tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="row white-bg">

        <form id="formt" name="formt" class="form-horizontal" enctype="multipart/form-data" action="javascript:;" novalidate="novalidate">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="formfield1">ID Suplier</label>                                    
                    <div class="controls">
                        <input type="text" name="id_suplier" id="id_suplier" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield1">Nama Perusahaan</label>                                    
                    <div class="controls">
                        <input type="text" name="nama_suplier" id="nama_suplier" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield1">NPWP</label>                                    
                    <div class="controls">
                        <input type="text" name="npwp_suplier" id="npwp_suplier" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield1">Alamat Email</label> <span class="desc">e.g. "some@example.com"</span>          
                    <div class="controls">
                        <input type="text" name="email_suplier" id="email_suplier" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="formfield1">Alamat</label>                                    
                    <div class="controls">
                        <input type="text" name="addresline1" id="addresline1" class="form-control" placeholder="addresline 1" required>
                        <input type="text" name="addresline2" id="addresline2" class="form-control" placeholder="addresline 2" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield1">Kode Pos</label>                                    
                    <div class="controls">
                        <input type="text" name="kode_pos" id="kode_pos" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield1">Kota</label>                                    
                    <div class="controls">
                        <input type="text" name="kota" id="kota" class="form-control" required>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="form-label" for="formfield1">Kode Negara</label>                                    
                    <div class="controls">
                        <input type="text" name="kode_negara" id="kode_negara" class="form-control" required>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="form-label" for="formfield1">Telephone</label>                                    
                    <div class="controls">
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                <button type="submit" class="btn btn-success" id="save"><?= lang('Simpan', 'Save') ?></button>
            </div>
        </form>
    </div>
    </div>
</div>

<script> 
$( "#formt" ).submit(function( event ) {
  var formData = new FormData($('#formt')[0]);
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('coba/home/add_supplier'); ?>",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (res)
            {
               $('#modal').modal('hide');
            }
        });
});
$(document).ready(function(){

var table=$('#tbl_show').DataTable({
     ajax: {
          url: '<?= base_url('coba/home/show') ?>',
          dataSrc: ''
      },
      "scrollX": true,
      "selected": true,
      "scrollY": "300px",
      "scrollCollapse": true,
      "paging": false,
      fixedColumns: {
          leftColumns: 1,
          rightColumns: 1
      },
      "columnDefs": [
          {"className": "dt-center", "targets": [0]},
          {"className": "dt-center", "targets": [1]},
          {"className": "dt-center", "targets": [2]},
          {"className": "dt-center", "targets": [5]},
          {"className": "dt-center", "targets": [4]},
          {"className": "dt-center", "targets": [5]},
          {"className": "dt-center", "targets": [6]},
          {"className": "dt-center", "targets": [7]},
          {"className": "dt-center", "targets": [8]},
      ]
    });
   });
    function add() {
        $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
        $('#modal').modal('show');
        lang();
    }

    lang();
</script>
<script src="<?= base_url() ?>ast11/select2-master/dist/js/select2.min.js" type="text/javascript"></script> 
<script src="<?= base_url() ?>ast11/filter/select2.min.js" type="text/javascript"></script> 