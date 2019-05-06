<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>

<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-1">
          <h3 class="content-header-title"><?= lang('Tema Persetujuan Email', 'The Email Approval theme') ?></h3>
        </div>
        <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?=base_url()?>/home/">Home</a>
              </li>
              <li class="breadcrumb-item"><a href="#"><?= lang("Managemen Supplier", "Supplier Management") ?></a>
              </li>
              <li class="breadcrumb-item active"><?= lang("Tema Persetujuan Email", "Email Approval Theme") ?>
              </li>
            </ol>
          </div>
        </div>
      </div>
      <div class="content-body">
        <section id="description" class="card">
            <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-titlea"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-email" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="form-label" for="formfield2"><?= lang('Judul', 'Title') ?></label>
                                    <div class="controls">
                                        <input name="title_edit" id="TitleEdit" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="formfield2"><?= lang('Content', 'Content') ?></label>
                                    <div class="controls">
                                        <textarea class="ckeditor" type="text" id="ckeditor" name="ckeditor" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnSave" class="btn btn-primary" onclick="save_email()"><?= lang('Simpan', 'Save') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </section>
      </div>
    </div>
</div>

<script>
    lang();
</script>
