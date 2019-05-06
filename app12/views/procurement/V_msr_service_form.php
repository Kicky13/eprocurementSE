<div class="ibox-content">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                          
            <form id="myForm" action="" method="post" class="form-horizontal">      
                <input name="id" id="id" hidden>                            
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <h3><b><u><?= lang('SERVICES DETAIL', 'Main Grub') ?></u></b></h3>
                    <div class="form-group">
                        <label for="name" class="label-control col-md-4"><?= lang('Brief of Scope of Work', 'Model') ?></label>
                        <div class="col-md-8">
                            <textarea name="" id="input" class="form-control" rows="3" required="required"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="label-control col-md-4"><?= lang('Location', 'Model') ?></label>
                        <div class="col-md-8">
                            <select type="text" name="indic_matrials" id="model" class="form-control" required>
                                <option>Muara Laboh</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="label-control col-md-4"><?= lang('Work Duration', 'Model') ?></label>
                        <div class="col-md-5">
                            <input type="text" name="equipement_no" id="equipment_no" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="label-control col-md-4"><?= lang('Remarks', 'Model') ?></label>
                        <div class="col-md-8">
                            <select type="text" name="indic_matrials" id="model" class="form-control" required></select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>