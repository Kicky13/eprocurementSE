<fieldset>
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-condensed table-row-border">
          <thead>
            <tr>
              <th>Type</th>
              <th>Filename</th>
              <th>Uploaded Date</th>
              <th>Uploaded By</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($doc as $key => $value) {
              echo "<tr>
                <td>".biduploadtype($value->tipe, true)."</td>
                <td><a href='".base_url('userfiles/temp/'.$value->file_path)."' target='_blank'>".$value->file_name."</a></td>
                <td>".$value->created_at."</td>
                <td>".user($value->created_by)->NAME."</td>
              </tr>";
            }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</fieldset>