

<?php
include 'V_header.php';
?>
<link rel="stylesheet" type="text/css" href="../assets/vendors/css/forms/icheck/icheck.css">
<link rel="stylesheet" type="text/css" href="../assets/vendors/css/forms/selects/select2.min.css">


<div class="app-content container center-layout mt-2">
    <div class="content-wrapper">

        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">2 Columns</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Page Layouts</a>
                        </li>
                        <li class="breadcrumb-item active">2 Columns
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content-body">

            <!--include side menu -->
            <?php
            include 'V_side_menu.php';
            ?>


            <div class="content-left">
                <section id="description">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Card Heading 1</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!--<button type="button" class="btn btn-outline-primary block btn-lg" >-->
                                <button type="button" class="btn btn-success btn-min-width mr-1 mb-1" data-toggle="modal"
                                        data-show="false" data-target="#show">Success</button>
                                <button id="select-files" class="btn btn-primary mb-1"><i class="icon-file2"></i> Click me to select files</button>
                            </div>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Card Heading 1</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">




                                <form class="form form-horizontal" novalidate>
                                    <div class="form-body">
                                        <h4 class="form-section"><i class="ft-user"></i> Personal Info</h4>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Nama</label>
                                            <div class="col-md-7">
                                                <select name="select" id="select" required class="form-control">
                                                    <option value="">Select Your City</option>
                                                    <option value="1">Amsterdam</option>
                                                    <option value="2">Antwerp</option>
                                                    <option value="3">Athens</option>
                                                    <option value="4">Barcelona</option>
                                                    <option value="5">Berlin</option>
                                                    <option value="6">Birmingham</option>
                                                    <option value="7">Bradford</option>
                                                    <option value="8">Bremen</option>
                                                    <option value="9">Brussels</option>
                                                    <option value="10">Bucharest</option>
                                                    <option value="11">Budapest</option>
                                                    <option value="12">Cologne</option>
                                                    <option value="13">Copenhagen</option>
                                                    <option value="14">Dortmund</option>
                                                    <option value="15">Dresden</option>
                                                    <option value="16">Dublin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Nama Perusahaan</label>
                                            <div class="col-md-7">
                                                <input type="text" id="projectinput4" class="form-control" placeholder="Phone" name="phone">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control">Kualifikasi Perusahaan</label>
                                            <div class="col-md-7">

                                                <div class="form-group">

                                                    <div class="controls">
                                                        <div class="skin skin-square">
                                                            <input type="checkbox"  id="single_checkbox" required>
                                                            <label for="single_checkbox">I am unchecked Checkbox</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 label-control">Kualifikasi Perusahaan</label>
                                        <div class="col-md-7">
                                            <div class="controls">
                                                <div class="skin skin-square">
                                                    <input type="radio" value="Yes" name="inline_radio" required id="radio_inline1">
                                                    <label for="radio_inline1">Check Me</label>
                                                </div>
                                                <div class="skin skin-square">
                                                    <input type="radio" value="No" name="inline_radio" id="radio_inline2">
                                                    <label for="radio_inline2">Or Me</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="button" class="btn btn-warning mr-1">
                                            <i class="ft-x"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-check-square-o"></i> Save
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </section>

                <section id="validation">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Validation Example</h4>
                                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form action="#" class="steps-validation wizard-circle">
                                            <!-- Step 1 -->
                                            <h6>Step 1</h6>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="firstName3">
                                                                First Name :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control required" id="firstName3" name="firstName">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="fileInput">
                                                                Input File :
                                                                <span class="required">*</span>
                                                            </label>
                                                            <input type="file" name="file" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="emailAddress5">
                                                                Email Address :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <input type="email" class="form-control required" id="emailAddress5" name="emailAddress">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="location">
                                                                Select City :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <select class="custom-select form-control required" id="location" name="location">
                                                                <option value="">Select City</option>
                                                                <option value="Amsterdam">Amsterdam</option>
                                                                <option value="Berlin">Berlin</option>
                                                                <option value="Frankfurt">Frankfurt</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">

                                                        <div class="form-group">
                                                            <label>No Characters, Only Numbers
                                                                <span class="required">*</span>
                                                            </label>
                                                            <div class="controls">
                                                                <input type="text" name="noChar" class="form-control" required data-validation-containsnumber-regex="(\d)+"
                                                                       data-validation-containsnumber-message="No Characters Allowed, Only Numbers">
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="date3">Date of Birth :</label>
                                                            <input type="date" class="form-control pickadate" id="date3">
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <!-- Step 2 -->

                                            <!-- Step 4 -->
                                            <h6>Step 2</h6>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="meetingName3">
                                                                Name of Meeting :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control required" id="meetingName3" name="meetingName">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="meetingLocation3">
                                                                Location :
                                                                <span class="danger">*</span>
                                                            </label>
                                                            <input type="text" class="form-control required" id="meetingLocation3" name="meetingLocation">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="participants3">Names of Participants</label>
                                                            <textarea name="participants" id="participants3" rows="4" class="form-control"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="decisions3">Decisions Reached</label>
                                                            <textarea name="decisions" id="decisions3" rows="4" class="form-control"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Agenda Items :</label>
                                                            <div class="c-inputs-stacked">
                                                                <label class="inline custom-control custom-checkbox block">
                                                                    <input type="checkbox" class="custom-control-input">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description ml-0">1st item</span>
                                                                </label>
                                                                <label class="inline custom-control custom-checkbox block">
                                                                    <input type="checkbox" class="custom-control-input">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description ml-0">2nd item</span>
                                                                </label>
                                                                <label class="inline custom-control custom-checkbox block">
                                                                    <input type="checkbox" class="custom-control-input">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description ml-0">3rd item</span>
                                                                </label>
                                                                <label class="inline custom-control custom-checkbox block">
                                                                    <input type="checkbox" class="custom-control-input">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description ml-0">4th item</span>
                                                                </label>
                                                                <label class="inline custom-control custom-checkbox block">
                                                                    <input type="checkbox" class="custom-control-input">
                                                                    <span class="custom-control-indicator"></span>
                                                                    <span class="custom-control-description ml-0">5th item</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="description">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Card Heading 1</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table id="tbl" name="tbl" class="table table-striped table-bordered multi-ordering"> </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!--/ Basic Horizontal Timeline -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade text-left" id="show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel5">Basic Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" novalidate>
                    <div class="form-group">
                        <label>Basic Text Input
                            <span class="required">*</span>
                        </label>
                        <div class="controls">
                            <input type="text" name="text" class="form-control" required data-validation-required-message="This field is required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fileInput">
                            Input File :
                            <span class="required">*</span>
                        </label>
                        <input type="file" name="file" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <div class="">
                            Basic Multi Select
                        </div>
                        <select class="select2 form-control" multiple="multiple">
                            <optgroup label="Alaskan/Hawaiian Time Zone">
                                <option value="AK">Alaska</option>
                                <option value="HI">Hawaii</option>
                            </optgroup>
                            <optgroup label="Pacific Time Zone">
                                <option value="CA" selected>California</option>
                                <option value="NV">Nevada</option>
                                <option value="OR">Oregon</option>
                                <option value="WA">Washington</option>
                            </optgroup>
                            <optgroup label="Mountain Time Zone">
                                <option value="AZ">Arizona</option>
                                <option value="CO" selected>Colorado</option>
                                <option value="ID">Idaho</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NM">New Mexico</option>
                                <option value="ND">North Dakota</option>
                                <option value="UT">Utah</option>
                                <option value="WY">Wyoming</option>
                            </optgroup>
                        </select>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!--footter-->

<?php
include 'V_footer.php';
?>

<script src="../assets/vendors/js/forms/select/select2.full.min.js" type="text/javascript"></script>
<script src="../assets/js/scripts/forms/select/form-select2.js" type="text/javascript"></script>
<script src="../assets/vendors/js/forms/icheck/icheck.min.js" type="text/javascript"></script>
