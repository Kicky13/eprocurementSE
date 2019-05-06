<?php
include "header.php";
?>
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-body">
        <!-- Ajax sourced data -->
        <section id="ajax">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Data Penambahan</h4>
                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <button type="button" onClick="filter()" class="btn btn-success btn-min-width mr-1 mb-1"><i class="fa fa-filter"></i> Filter</button>
                    <button type="button" onClick="daftar()" class="btn btn-success btn-min-width mr-1 mb-1"><i class="fa fa-edit"></i> Buka pendaftaran</button>
                  </div>
                </div>
                <div class="card-content collpase show">
                  <div class="card-body card-dashboard">
                    <table id="javascript_sourced" class="table table-striped table-bordered ajax-sourced">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Office</th>
                          <th>Extn.</th>
                          <th>Start date</th>
                          <th>Salary</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!--/ Ajax sourced data -->

        <!--/ Modal data -->
<!--/ Modal data -->
              <div class="modal fade text-left " id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel8">Data Filter</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form">
                     
                      <div class="form-body col-md-12">
                         <div class="form-group ">
                            <select data-placeholder="Select a state..." class="select2-icons form-control" id=""  style="width:100%"            multiple="multiple">
                                  <optgroup label="Services">
                                  <option value="wordpress2" data-icon="wordpress2" >WordPress</option>
                                  <option value="codepen" data-icon="codepen">Codepen</option>
                                  <option value="drupal" data-icon="drupal">Drupal</option>
                                  <option value="pinterest2" data-icon="social-css3">CSS3</option>
                                  <option value="html5" data-icon="html-five">HTML5</option>
                                </optgroup>
                                <optgroup label="File types">
                                  <option value="pdf" data-icon="file-pdf">PDF</option>
                                  <option value="word" data-icon="file-word">Word</option>
                                  <option value="excel" data-icon="file-excel">Excel</option>
                                  <option value="openoffice" data-icon="file-openoffice">Open office</option>
                                </optgroup>
                                <optgroup label="Browsers">
                                  <option value="chrome" data-icon="chrome">Chrome</option>
                                  <option value="firefox" data-icon="firefox">Firefox</option>
                                  <option value="safari" data-icon="safari" >Safari</option>
                                  <option value="opera" data-icon="opera">Opera</option>
                                  <option value="IE" data-icon="IE">IE</option>
                                </optgroup>
                          </select>
                        </div>
                        <div class="form-group">
                            <div class="skin skin-square">
                              <input type="checkbox" value="" id="single_checkbox" required>
                              <label for="single_checkbox">I am unchecked Checkbox</label>
                            </div>
                            <div class="skin skin-square">
                              <input type="checkbox" value="" id="single_checkbox" required>
                              <label for="single_checkbox">I am unchecked Checkbox</label>
                            </div>
                        </div>
                        <div class="form-group">
                          <label for="complaintinput2">Employee Name</label>
                          <input type="text" data-tags-input-name="case-sensitive" id="complaintinput2" class="form-control " placeholder="employee name"
                          name="employeename">
                        </div>
                        <div class="form-group">
                          <label for="complaintinput3">Date of Complaint</label>
                          <input type="date" id="complaintinput3" class="form-control " name="complaintdate">
                        </div>
                        <div class="form-group">
                          <label for="complaintinput4">Supervisor's Name</label>
                          <input type="text" id="complaintinput4" class="form-control " placeholder="supervisor name"
                          name="supervisorname">
                        </div>
                        <div class="form-group">
                          <label for="complaintinput5">Complaint Details</label>
                          <textarea id="complaintinput5" rows="5" class="form-control " name="complaintdetails"
                          placeholder="details"></textarea>
                        </div>
                        <div class="form-group">
                           <input type="checkbox" class="skin skin-square" id="input-11">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Save changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
<!--/ Modal data -->

<!--/ Modal data -->
            <div class="modal fade text-left " id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-primary white">
                    <h4 class="modal-title" id="myModalLabel8">Basic Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form">
                      <div class="form-body">
                        <div class="form-group">
                          <label for="complaintinput1">Company Name</label>
                          <input type="date" class="form-control " placeholder="company name" name="companyname">
                        </div>
                        <div class="form-group">
                          <label for="complaintinput2">Employee Name</label>
                          <input type="date" class="form-control " placeholder="employee name" name="employeename">
                        </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Save changes</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
      </div>
    </div>
  </div>
<!--/ Modal data -->

<script type="text/javascript">

console.log(document.getElementById('tag').value);

  function filter() {
    // body...
    $('#filter').modal('show'); 
    
  }
  function daftar() {
    // body...
    $('#primary').modal('show');  
  }
</script>
<?php
include "footer.php";
?>
