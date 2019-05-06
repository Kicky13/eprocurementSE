<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Item Availability", "Item Availability") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Cataloug No Request", "Cataloug No Request") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Item Availability", "Item Availability") ?></li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- section tabel -->
        <div class="table_mreq" id="">
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
                                                  <!-- <button aria-expanded="false" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("TAMBAH PERMINTAAN MATERIAL", "ADD MATERIAL REQUEST") ?></button> -->
                                              </h5>
                                          </div>
                                      </div>
                                  </div>
                              </div>


                              <div class="card-content collapse show">
                                  <div class="card-body card-dashboard">
                                    <form id="form_filter">
                                      <div class="row">
                                        <div class="col-xl-5 col-lg-12">
                                          <fieldset>
                                            <h5>Item</h5>
                                            <div class="form-group">
                                              <select class="form-control" name="item" id="item">
                                                <option value="">Select All</option>
                                                <?php
                                                  foreach ($material as $key => $value) { ?>
                                                    <option value="<?= $value['MATERIAL'] ?>"> <?= $value['MATERIAL_CODE'].' - '.$value['MATERIAL_NAME'] ?> </option>
                                                  <?php
                                                  }
                                                 ?>
                                              </select>
                                            </div>
                                          </fieldset>
                                        </div>
                                        <!-- <div class="col-xl-2 col-lg-12">
                                          <fieldset>
                                            <h5>Description</h5>
                                            <div class="form-group">
                                              <input type="text" name="desc" id="desc" class="datepicker form-control" value="">
                                            </div>
                                          </fieldset>
                                        </div> -->
                                        <div class="col-xl-3 col-lg-12">
                                          <fieldset>
                                            <h5>Branch/Plant</h5>
                                            <div class="form-group">
                                              <select class="form-control" name="branch_plant" id="branch_plant">
                                                <option value="">Select All</option>
                                                <?php
                                                  foreach ($bplant as $key => $value) { ?>
                                                    <option value="<?= $value['ID_BPLANT'] ?>"> <?= $value['ID_BPLANT'].' - '.$value['BPLANT_DESC'] ?> </option>
                                                  <?php
                                                  }
                                                 ?>
                                              </select>
                                            </div>
                                          </fieldset>
                                        </div>
                                        <div class="col-xl-2 col-lg-12">
                                          <fieldset>
                                            <h5>Location</h5>
                                            <div class="form-group">
                                              <input type="text" name="item_location" id="item_location" class="form-control" value="">
                                            </div>
                                          </fieldset>
                                        </div>
                                        <div class="col-xl-2 col-lg-12">
                                          <fieldset>
                                            <h5>&nbsp;</h5>
                                            <div class="form-group">
                                              <button type="submit" name="button" class="form-control btn btn-info btn-flat"> <i class="fa fa-search-plus"></i> Search</button>
                                            </div>
                                          </fieldset>
                                        </div>
                                      </div>
                                    </form>

                                      <div class="row">
                                          <div class="col-md-12">
                                              <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                                  <thead>
                                                      <tr>
                                                          <th><center>No</center></th>
                                                          <th><center>P S</center></th>
                                                          <th><center>Location</center></th>
                                                          <th><center>Branch/Plant</center></th>
                                                          <th><center>On Hand</center></th>
                                                          <th><center>Available</center></th>
                                                      </tr>
                                                  </thead>
                                                  <tbody id="tbl_item_avl">

                                                  </tbody>

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
</div>

<script src="<?= base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function(){
    $('select').select2({ width: '100%' });
    $("#form_filter").submit(function(e){
      e.preventDefault();
      var data = $(this).serialize();
      var resultx;

      var allBlank = true; //assume they're all blank until we discover otherwise
      //loop through each of the inputs matched
      $('#form_filter :input').each(function(index, el)
      {
        if ($(el).val().length != 0) allBlank = false; //they're not all blank anymore
      });

      if (allBlank == true) {
        msg_danger("Please fill input data at least one", "Oops");
      } else {
        $.ajax({
          url: '<?= base_url('material/Item_availability/search_Item_availability')?>',
          type: 'POST',
          dataType: 'html',
          data: data
        })
        .done(function() {
          resultx = true;
        })
        .fail(function() {
          resultx = false;
        })
        .always(function(res) {
          if (resultx == true) {
            // console.log(res);
            $("#tbl_item_avl").html(res);
          }
        });
      }


    })
  })
</script>
