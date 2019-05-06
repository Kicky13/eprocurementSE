
  <link rel="stylesheet" type="text/css" href="<?=base_url()?>ast11/app-assets/css/pages/error.css">

  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 p-0">
              <div class="card-header bg-transparent border-0">
                <h2 class="error-code text-center mb-2">404</h2>
                <h3 class="text-uppercase text-center">Oops,Page Not Found</h3>
              </div>
              <div class="card-content">
                <fieldset class="row py-2">
                  <div class="input-group col-12">
<!--                    <input type="text" class="form-control form-control-xl input-xl border-grey border-lighten-1 "
                    placeholder="Search..." aria-describedby="button-addon2">-->
<!--                    <span class="input-group-btn" id="button-addon2">
                      <button class="btn btn-lg btn-secondary border-grey border-lighten-1" type="button"><i class="ft-search"></i></button>
                    </span>-->
                  </div>
                </fieldset>
                <div class="row py-2 text-center">               
                    <a href="<?=base_url()?>vn/info/general_data" id="home" class="btn btn-primary btn-block"><i class="fa fa-home"></i> Back to Home</a>               
                </div>
              </div>
              <div class="card-footer bg-transparent">
                <div class="row">
                    <p class="text-muted text-center col-12 py-1">© 2017 Supreme Energy</p>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  
  <script>
      $(function(){
         $('#home').prop('disabled',false);
      });
  </script>
