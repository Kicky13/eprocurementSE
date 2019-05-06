
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Daftar Dokumen ITP", "List ITP Document") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="<?= base_url() ?>home">Home</a></li>
                      <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                      <li class="breadcrumb-item active"><?= lang("Daftar Dokumen ITP", "List ITP Document") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-content collapse show list_progress">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tbl_list_itp" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                                <tfoot>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                        <th><center>Agrement No</center></th>
                                                        <th><center>ITP No</center></th>
                                                        <th><center><?= lang("Agrement Title", "Agrement Title") ?></center></th>
                                                        <th><center>Status</center></th>
                                                        <th><center>Action</center></th>
                                                    </tr>
                                                </tfoot>

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

<?php $this->load->view('procurement/V_itp_approval'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<!-- <script src="<?= base_url()?>ast11/app-assets/js/scripts/forms/wizard-steps.js" type="text/javascript"></script> -->

<script type="text/javascript">
  $(document).ready(function() {
    $(".itp_approval").hide();
    $("#prosesreject").remove();
    $("#save").remove();
    $(".divupload").remove();

    $("#myModal :input").prop("disabled", true);
    $(".closemodal").attr("disabled", false);

    // show data
    $('#tbl_list_itp tfoot th').each(function (i) {
        var title = $('#tbl_list_itp thead th').eq($(this).index()).text();
        if ($(this).text() == 'No') {
          $(this).html('');
        } else if ($(this).text() == 'Action') {
          $(this).html('');
        } else {
          $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
        }
    });
    var table=$('#tbl_list_itp').DataTable({
        "ajax": {
            "url": "<?= base_url('procurement/Itp_onclosed/datatable_list_itp_on_progress') ?>",
            "dataSrc": ""
        },
        "data": null,
        "searching": true,
        "paging": true,
        fixedColumns: {
            leftColumns: 0,
            rightColumns: 1
        },
        "columns": [
          {title: "<center>No</center>"},
          {title: "<center><?= lang("Agrement No", "Agrement No") ?></center>"},
          {title: "<center><?= lang("No ITP", "ITP No") ?></center>"},
          {title: "<center><?= lang("Agrement Title", "Agrement Title") ?></center>"},
          {title: "<center><?= lang("Status", "Status") ?></center>"},
          {title: "<center>Action</center>"}
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},
            {"className": "dt-center", "targets": [5]},
        ]
    });
    $(table.table().container()).on('keyup', 'tfoot input', function () {
      table.column($(this).data('index')).search(this.value).draw();
    });

    $(document).on('click', '#btn_is_closed', function(e){
      var resultx;
      var idnya = $(this).data("idx");

      console.log(idnya);
      swal({
        title: "Close ITP Document",
        text: "You will close this ITP ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Yes",
        closeOnConfirm: true
      },function () {
        // console.log($("#btn_is_closed").data("id"));
        $.ajax({
          url: '<?= base_url('procurement/Itp_onclosed/update_is_closed')?>',
          type: 'POST',
          dataType: 'JSON',
          data: {id_itp : idnya, },
        })
        .done(function() {
          resultx = true;
        })
        .fail(function() {
          resultx = false;
        })
        .always(function(res) {
          if (resultx == true) {
            if (res == true) {
              window.location.href = "<?= base_url()?>/procurement/itp_onclosed";
            } else {
              window.location.href = "<?= base_url()?>/procurement/itp_onclosed";
            }
          }
        })

      })
    })
  });

</script>
